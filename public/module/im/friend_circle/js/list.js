(function(){
    "use strict";

    var app = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/im/friend_circle/list' ,
            // layui 调用的地址，请提供完整地址
            editUrl: '/friend_circle/editView?mode=edit&id=' ,
            // 请勿提供 module，删除记录地址
            delUrl: '/friend_circle/del' ,
            dom: {} ,
            tableId: 'table' ,
            filter: {} ,
        } ,
        initDom: function(){
            this.data.dom.search = $('#search');
            this.data.dom.deleteSelected = $('#delete-selected');
            this.data.dom.add = $('#add');
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
                            field: 'content' ,
                            title: '内容',
                        } ,
                        {
                            title: 'uid',
                            field: 'user_id' ,
                        } ,
                        {
                            title: '用户名',
                            templet (res) {
                                return res.user ? res.user.uname : '未知的用户名';
                            } ,
                        } ,
                        {
                            title: '手机号码',
                            templet (res) {
                                return res.user ? res.user.telephone : '未知的手机号码';
                            } ,
                        } ,
                        {
                            title: '图片',
                            templet: function(res){
                                var images = [];
                                res.media.forEach(function(v){
                                    images.push({
                                        value: layui_imageTemplate(v.image)
                                    });
                                });
                                return layui_lineTemplate(images);
                            } ,
                        } ,
                        {
                            title: '创建时间',
                            field: 'create_time' ,
                        } ,
                        {
                            // fixed: 'right',
                            width: topContext.layuiOperationCellWidth ,
                            title: '操作' ,
                            align:'left',
                            toolbar: '#operation'
                        }
                    ]
                ]
            });
        } ,
        initEvent: function(){
            var self = this;


            // 事件定义
            layui.table.on('tool(table)', function(res){
                switch(res.event)
                {
                    case 'del':
                        layui_delete(self.data.tableId , null , self.data.delUrl , res.data.id);
                        break;
                    case 'edit':
                        self.dialog(self.data.editUrl + res.data.id);
                        break;
                    case 'update_status':
                        layer.alert('请选择店铺状态' , {
                            btn: ['正常' , '锁定'] ,
                            btn1: function (index) {
                                layer.close(index);
                                layui_setStatus(self.data.tableId , self.data.updateStatusUrl , [res.data.id] ,  {
                                    status: 1 ,
                                });
                            } ,
                            btn2: function (index) {
                                layer.close(index);
                                layui_setStatus(self.data.tableId , self.data.updateStatusUrl , [res.data.id] , {
                                    status: 2
                                });
                            } ,
                        });
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
                self.reload(true);
            });

            /**
             * 批量删除事件
             */
            this.data.dom.deleteSelected.on('click' , function () {
                layui_deleteSelected('table' , null , self.data.delUrl);
            });

            /**
             * 添加事件
             */
            this.data.dom.add.on('click' , this.addEvent.bind(this));
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
                area: ['500px', '450px'],
                fixed: false, //不固定
                maxmin: true,
                content: link ,
                end: function () {
                    self.reload(false);
                }
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