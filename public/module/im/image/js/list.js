(function(){
    "use strict";

    var image = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/admin/image/list' ,
            // layui 调用的地址，请提供完整地址
            editUrl: '/admin/image/editView?mode=edit&id=' ,
            // 请勿提供 module，删除记录地址
            delUrl: '/image/del' ,
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
                            field: 'position' ,
                            title: '位置',
                        } ,
                        {
                            title: '图片',
                            width: 200 ,
                            templet: function (res) {
                                return layui_imageTemplate(res.image);
                            }
                        } ,
                        {
                            title: '链接',
                            field: 'link' ,
                        } ,
                        {
                            title: '权重',
                            field: 'weight' ,
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
                        // toLink(self.data.editUrl + res.data.id);
                        self.dialog(self.data.editUrl + res.data.id);
                        break;
                    case 'update_status':
                        layer.alert('请选择店铺状态' , {
                            btn: ['正常' , '锁定'] ,
                            btn1: function (index) {
                                layer.close(index);
                                layui_setStatus(self.data.tableId , null , self.data.updateStatusUrl , [res.data.id] ,  {
                                    status: 1 ,
                                });
                            } ,
                            btn2: function (index) {
                                layer.close(index);
                                layui_setStatus(self.data.tableId , null , self.data.updateStatusUrl , [res.data.id] , {
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
                    // layer.alert('刷新页面查看效果？' , {
                    //     btn: ['刷新' , '取消'] ,
                    //     btn1: function () {
                    //         window.location.reload();
                    //     } ,
                    //     btn2: function (index) {
                    //         layer.close(index);
                    //     }
                    // });
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
    image.run();
})();