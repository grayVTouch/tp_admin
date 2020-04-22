(function(){
    "use strict";

    var app = {
        data: {
            roleUrl: '/role/privilege' ,
            routeUrl: '/route/allForMenu' ,
            allocateUrl: '/role/allocate' ,
            roleId: topContext.route.query.id ,
            role: {} ,
            route: [] ,
            dom: {} ,
        } ,

        initDom () {
            this.data.dom.allocate = $('#allocate');
        } ,

        initialize () {
            new Promise((resolve , reject) => {
                loading();
                this.role((res) => {
                    this.data.role = res;
                    resolve();
                });
            }).then(() => {
                return new Promise((resolve , reject) => {
                    this.route((res) => {
                        this.handleRouteData(res);
                        this.data.route = res;
                        this.render();
                    });
                });
            }).finally(() => {
                layer.closeAll();
            });
        } ,

        // 修改可选的路由数据
        handleRouteData (data) {
            var i = 0;
            var cur = null;
            for (; i < data.length; ++i)
            {
                cur = data[i];
                cur.title = cur.cn;
                if (cur.children.length > 0) {
                    cur.spread = true;
                    this.handleRouteData(cur.children);
                } else {
                    // 没有子类的情况下
                    if (this.hasPrivilege(cur.id)) {
                        cur.checked = true;
                    }
                }
            }
        } ,

        // 检查是否角色是否存在该权限
        hasPrivilege (id) {
            var i = 0;
            var cur = null;
            var route = this.data.role ?
                (this.data.role.route ? this.data.role.route : []) :
                [];
            for (; i < route.length; ++i)
            {
                cur = route[i];
                if (cur.id == id) {
                    return true;
                }
            }
            return false;
        } ,

        render () {
            //基本演示
            layui.tree.render({
                elem: '#tree' ,
                data: this.data.route ,
                showCheckbox: true ,
                id: 'tree' ,
                isJump: false ,
            });
        } ,

        // 获取角色（包括其中的权限）
        role (callback) {
            // console.log('你好' , this.roleUrl);
            request({
                url: this.data.roleUrl ,
                data: {
                    id: this.data.roleId ,
                } ,
                tip: false ,
                success (res) {
                    if (typeof callback == 'function') {
                        callback(res);
                    }
                } ,
            });
        } ,

        // 可选的权限列表
        route (callback) {
            request({
                url: this.data.routeUrl ,
                tip: false ,
                success (res) {
                    if (typeof callback == 'function') {
                        callback(res);
                    }
                } ,
            });
        } ,

        // 获取选中项
        getIdListForSelected () {
            var selectedRoute = layui.tree.getChecked('tree');
            var idList = [];
            var get = function(list){
                var i = 0;
                var cur = null;
                for (; i < list.length; ++i)
                {
                    cur = list[i];
                    idList.push(cur.id);
                    if (cur.children.length > 0) {
                        get(cur.children);
                    }
                }
            };
            get(selectedRoute);
            return idList;
        } ,

        // 分配权限
        allocateEvent () {
            var idList = this.getIdListForSelected();
            console.log(idList);
            request({
                url: this.data.allocateUrl ,
                data: {
                    role_id: this.data.role.id ,
                    id_list: JSON.stringify(idList)
                } ,
            });
        } ,

        initEvent () {
            this.data.dom.allocate.on('click' , this.allocateEvent.bind(this));
        } ,

        run () {
            this.initDom();
            this.initEvent();
            this.initialize();
        } ,
    };

    app.run();
})();