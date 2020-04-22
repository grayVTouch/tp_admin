(function(){
    "use strict";

    var app = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/admin/system_param/list' ,
            // 删除记录地址，请勿提供 module
            delUrl: '/system_param/del' ,
            // 更新记录状态地址
            editUrl: '/admin/system_param/editView?mode=edit&id=' ,
            // 删除记录地址，请勿提供 module
            updateUrl: '/system_param/update' ,
            dom: {} ,
            tableId: 'table' ,
            filter: {} ,
            limit: 30 ,
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
                page: {
                    limit: this.data.limit ,
                },
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
                        // {
                        //     title: '参数',
                        //     field: 'param' ,
                        // } ,
                        {
                            title: '参数值',
                            // field: 'val' ,
                            templet (res) {
                                return res.id != 18 ? res.val :`<input type="checkbox" name="val" value="${res.id}" lay-skin="switch" lay-text="开启|关闭" lay-filter="val" ${res.val == 1 ? 'checked' : '' }>`;
                            } ,
                        } ,
                        {
                            title: '描述',
                            field: 'discript' ,
                        } ,
                        // {
                        //     title: '是否显示？',
                        //     templet (res) {
                        //         var option = {
                        //             value: res.is_show_explain ,
                        //             weight: true
                        //         };
                        //         switch (res.is_show)
                        //         {
                        //             case 0:
                        //                 option.color = 'font-red';
                        //                 break;
                        //             case 1:
                        //                 option.color = 'font-green';
                        //                 break;
                        //         }
                        //         return layui_textTemplate(option);
                        //     } ,
                        // } ,
                        {
                            // fixed: 'right',
                            width: 250 ,
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
                    curr: 1 ,
                    limit: this.data.limit ,
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
                        limit: self.data.limit
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

            // 系统开关
            layui.form.on('switch(val)', function(res){
                var data = {
                    id: res.elem.value ,
                };
                data[this.name] = res.elem.checked ? 1 : 0;
                layui_table_update(self.data.tableId , self.data.updateUrl , data);
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