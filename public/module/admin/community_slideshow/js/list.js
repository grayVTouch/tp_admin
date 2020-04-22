(function(){
    "use strict";

    var app = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/admin/community_slideshow/list' ,
            // 删除记录地址，请勿提供 module
            delUrl: '/community_slideshow/del' ,
            // 更新记录状态地址
            updateStatusUrl: '/community_slideshow/updateStatus' ,
            editUrl: '/admin/community_slideshow/editView?mode=edit&id=' ,
            allocateUrl: '/community_slideshow/privilegeView?id=' ,
            dom: {} ,
            tableId: 'table' ,
            filter: {} ,
        } ,
        initDom: function(){
            this.data.dom.search = $('#search');
            this.data.dom.add = $('#add');
            this.data.dom.deleteSelected = $('#delete-selected');
        } ,
        initTable: function(){
            layui.table.render({
                elem: '#list',
                method: 'post' ,
                where: this.data.filter ,
                url: this.data.listUrl ,
                cellMinWidth: topContext.layuiCellMinWidth ,
                response: topContext.layuiTableResponse ,
                parseData: topContext.layuiTableParseData ,
                page: true ,
                id: this.data.tableId ,
                cols: [
                    [
                        {
                            type:'checkbox'
                        } ,
                        {
                            field:'id',
                            title: 'id',
                            sort: true ,
                            width: topContext.layuiTableIdWidth ,
                        } ,
                        {
                            title: '图片',
                            width: 160 ,
                            templet (res) {
                                return layui_imageTemplate(res.pic_explain);
                            } ,
                        } ,
                        {
                            title:'状态',
                            templet (res) {
                                var option = {
                                    value: res.status_explain ,
                                    weight: true ,
                                };
                                switch (res.status)
                                {
                                    case 0:
                                        option.color = 'font-red';
                                        break;
                                    case 1:
                                        option.color = 'font-green';
                                        break;
                                }
                                return layui_textTemplate(option);
                            } ,
                        } ,
                        {
                            width: 200 ,
                            title: '操作' ,
                            align:'left',
                            toolbar: '#operation'
                        }
                    ]
                ]
            });
        } ,

        addEvent: function(e){
            e.preventDefault();
            var tar = $(e.currentTarget);
            var link = tar.data('link');
            this.dialog(link);
        } ,

        // 对话窗口
        dialog: function(link){
            var self = this;
            layer.open({
                type: 2,
                area: ['600px', '400px'],
                fixed: false, //不固定
                maxmin: true,
                content: link ,
                end: function () {
                    self.reload(false);
                }
            });
        } ,

        // 刷新页面
        reload: function(pageReset){
            pageReset = typeof pageReset == 'boolean' ? pageReset : false;
            var option = {
                where: this.data.filter ,
            };
            if (pageReset) {
                // 充值当前页数为第一页
                option.page = {
                    curr: 1
                };
            }
            layui.table.reload('table' , option);
        } ,

        initEvent: function(){
            var self = this;
            // 事件定义
            layui.table.on('tool(table)', function(res){
                switch(res.event)
                {
                    case 'del':
                        layui_delete(self.data.tableId , self.data.delUrl , res.data.id);
                        break;
                    case 'edit':
                        self.dialog(self.data.editUrl + res.data.id);
                        break;
                    case 'allocate':
                        toLink(self.data.allocateUrl + res.data.id);
                        break;
                }
            });
            /**
             * 查询事件
             */
            this.data.dom.search.on('submit' , function(e){
                e.preventDefault();
            });

            layui.form.on('submit(search)' , function(res){
                self.data.filter = res.field;
                // console.log(res);
                layui.table.reload('table' , {
                    where: self.data.filter ,
                    page: {
                        curr: 1 ,
                    }
                });
            });

            this.data.dom.add.on('click' , this.addEvent.bind(this));

            /**
             * 批量删除事件
             */
            this.data.dom.deleteSelected.on('click' , function () {
                layui_deleteSelected('table' , self.data.delUrl);
            });
        } ,
        run: function(){
            this.initDom();
            this.initTable();
            this.initEvent();
        } ,
    };
    app.run();
})();