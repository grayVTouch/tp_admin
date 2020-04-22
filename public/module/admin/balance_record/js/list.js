(function(){
    "use strict";

    var app = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/admin/balance_record/list' ,
            // 删除记录地址，请勿提供 module
            delUrl: '/balance_record/del' ,
            // 更新记录状态地址
            updateStatusUrl: '/balance_record/updateStatus' ,
            editUrl: '/admin/balance_record/editView?mode=edit&id=' ,
            updateRoleUrl: '/balance_record/updateRole' ,
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
                            fixed: 'left' ,
                            type:'checkbox'
                        } ,
                        {
                            fixed: 'left' ,
                            field:'id',
                            title: 'id',
                            sort: true ,
                            width: topContext.layuiTableIdWidth ,
                        } ,
                        {
                            fixed: 'left' ,
                            title: 'uid',
                            field: 'uid' ,
                            width: 50 ,
                        } ,
                        {
                            fixed: 'left' ,
                            title: '用户名',
                            templet (res) {
                                return res.user ? res.user.username : '尚未设置用户名称';
                            } ,
                            width: 150 ,
                        } ,
                        {
                            fixed: 'left' ,
                            title: '手机号码',
                            templet (res) {
                                return res.user ? res.user.phone : '未知的手机号码';
                            } ,
                            width: 150 ,
                        } ,
                        {
                            title: '钱包名称',
                            field: 'wallet_name' ,
                            width: 150 ,
                        } ,
                        {
                            title: '币种名称',
                            width: 150 ,
                            templet (res) {
                                return res.coin ? res.coin.name : '未知币种' ;
                            } ,
                        } ,
                        {
                            title: '变动之前',
                            field: 'before_balance' ,
                            width: 220 ,
                        } ,
                        {
                            title: '变动之后',
                            field: 'after_balance' ,
                            width: 220 ,
                        } ,
                        {
                            title: '变动金额',
                            // field: 'balance' ,
                            templet (res) {
                                var option = {
                                    value: res.balance ,
                                };
                                if (res.balance > 0) {
                                    option.color = 'font-red';
                                } else {
                                    option.color = 'font-green';
                                }
                                return layui_textTemplate(option);
                            } ,
                            width: 220 ,
                        } ,
                        // {
                        //     title: 'ip',
                        //     field: 'ip' ,
                        //     width: 170 ,
                        // } ,
                        {
                            title: '备注',
                            field: 'remark' ,
                            width: 300 ,
                        } ,
                        {
                            title: '创建日期',
                            field: 'date' ,
                            width: 170 ,
                        } ,

                        // {
                        //     fixed: 'right',
                        //     width: 120 ,
                        //     title: '操作' ,
                        //     align:'left',
                        //     toolbar: '#operation'
                        // }
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
                area: ['600px', '600px'],
                fixed: false, //不固定
                maxmin: true,
                content: link ,
                end: function () {
                    self.reload(false);
                }
            });
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
                        // window.location.href =  self.data.editUrl + res.data.id;
                        self.dialog( self.data.editUrl + res.data.id);
                        break;
                    case 'update_status':
                        layer.alert('请选择' , {
                            btn: ['正常' , '锁定' , '禁用'] ,
                            btn1: function (index) {
                                layer.close(index);
                                layui_setStatus(self.data.tableId , self.data.updateStatusUrl , [res.data.id] , {
                                    status: 1
                                });
                            } ,
                            btn2: function (index) {
                                layer.close(index);
                                layui_setStatus(self.data.tableId , self.data.updateStatusUrl , [res.data.id] , {
                                    status: 2
                                });
                            } ,
                            btn3: function (index) {
                                layer.close(index);
                                layui_setStatus(self.data.tableId , self.data.updateStatusUrl , [res.data.id] , {
                                    status: 3
                                });
                            }
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

            /**
             * 批量删除事件
             */
            this.data.dom.deleteSelected.on('click' , function () {
                layui_deleteSelected('table' , self.data.delUrl);
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

        run: function(){
            this.initDom();
            this.initTable();
            this.initEvent();
        } ,
    };
    app.run();
})();