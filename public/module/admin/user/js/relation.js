(function(){
    "use strict";

    var app = {
        data: {
            user: null ,
        } ,
        initDom () {

        } ,
        initEvent () {

        } ,

        handleData (res) {
            var i = 0;
            var cur = null;
            for (; i < res.length; ++i)
            {
                cur = res[i];
                cur.parent = cur.pid;
                cur.key = cur.id;
                cur.name = cur.username;
                cur.source = '';
            }
        } ,

        initialize () {
            var self = this;
            new Promise((resolve , reject) => {
                loading();
                request({
                    url: '/user/relation' ,
                    method: 'post' ,
                    data: {
                        id: topContext.route.query.id
                    } ,
                    tip: false ,
                    success (res) {
                        layer.closeAll();
                        self.handleData(res);
                        self.data.user = res;
                        resolve();
                    } ,
                });
            }).then(() => {
                var goMake = go.GraphObject.make;
                var myDiagram =
                    goMake(go.Diagram, "relation",
                        {
                            "undoManager.isEnabled": true, // enable Ctrl-Z to undo and Ctrl-Y to redo
                            layout: goMake(go.TreeLayout, // specify a Diagram.layout that arranges trees
                                { angle: 90, layerSpacing: 35 })
                        });

                // the template we defined earlier
                myDiagram.nodeTemplate =
                    goMake(go.Node, "Horizontal",
                        { background: "#44CCFF" },
                        goMake(go.Picture,
                            { margin: 10, width: 50, height: 50, background: "red" },
                            new go.Binding("source")),
                        goMake(go.TextBlock, "Default Text",
                            { margin: 12, stroke: "white", font: "bold 16px sans-serif" },
                            new go.Binding("text", "name"))
                    );

                var model = goMake(go.TreeModel);
                console.log(self.data.user);
                model.nodeDataArray = self.data.user;
                    // [ // the "key" and "parent" property names are required,
                    //     // but you can add whatever data properties you need for your app
                    //     { key: "1",              name: "Don Meow",   source: "cat1.png" },
                    //     { key: "2", parent: "1", name: "Demeter",    source: "cat2.png" },
                    //     { key: "3", parent: "1", name: "Copricat",   source: "cat3.png" },
                    //     { key: "4", parent: "3", name: "Jellylorum", source: "cat4.png" },
                    //     { key: "5", parent: "3", name: "Alonzo",     source: "cat5.png" },
                    //     { key: "6", parent: "2", name: "Munkustrap", source: "cat6.png" }
                    // ];
                myDiagram.model = model;
            });
        } ,
        run () {
            this.initDom();
            this.initEvent();
            this.initialize();
        } ,
    };

    app.run();
})();
