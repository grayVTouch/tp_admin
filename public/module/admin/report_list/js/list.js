(function(){
    "use strict";

    var app = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/admin/report_list/list' ,
            // 删除记录地址，请勿提供 module
            delUrl: '/report_list/del' ,
            // 更新记录状态地址
            updateUrl: '/report_list/update' ,
            editUrl: '/admin/report_list/editView?mode=edit&id=' ,
            allocateUrl: '/report_list/privilegeView?id=' ,
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
                        // {
                        //     type:'checkbox'
                        // } ,
                        {
                            field:'id',
                            title: 'id',
                            fixed: true ,
                            sort: true ,
                            width: topContext.layuiTableIdWidth ,
                        } ,
                        {
                            title: 'uid',
                            field: 'uid' ,
                            fixed: true ,
                            width: 160 ,
                        } ,
                        {
                            title: '类型',
                            templet (res) {
                                return res.report_type ? res.report_type.name : '';
                            } ,
                            width: 160 ,
                        } ,
                        {
                            title: '标题',
                            field: 'title' ,
                            width: 160 ,
                        } ,
                        {
                            title: '内容',
                            field: 'content' ,
                            width: 160 ,
                        } ,
                        {
                            title: '图片1',
                            width: 160 ,
                            templet (res) {
                                return layui_imageTemplate(res.img1_explain);
                            } ,
                        } ,
                        {
                            title: '图片2',
                            width: 160 ,
                            templet (res) {
                                return layui_imageTemplate(res.img2_explain);
                            } ,
                        } ,
                        {
                            title: '图片3',
                            width: 160 ,
                            templet (res) {
                                return layui_imageTemplate(res.img3_explain);
                            } ,
                        } ,
                        {
                            title:'已解决？',
                            templet (res) {
                                var option = {
                                    value: res.solved_explain ,
                                    weight: true ,
                                };
                                switch (res.solved)
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
                            width: 150 ,
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
                    case 'solved':
                        layer.alert('请选择' , {
                            btn: ['已解决' , '未解决'] , //  , '待验证'] ,
                            btn1: function (index) {
                                layer.close(index);
                                layui_table_update(self.data.tableId , self.data.updateUrl , {
                                    id: res.data.id ,
                                    solved: 1
                                } , true);
                            } ,
                            btn2: function (index) {
                                layer.close(index);
                                layui_table_update(self.data.tableId , self.data.updateUrl , {
                                    id: res.data.id ,
                                    solved: 0
                                } , true);
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