(function(){
    "use strict";

    var app = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/admin/user_balance/list' ,
            // 删除记录地址，请勿提供 module
            delUrl: '/user_balance/del' ,
            // 更新记录状态地址
            updateStatusUrl: '/user_balance/updateStatus' ,
            editUrl: '/admin/user_balance/editView?mode=edit&id=' ,
            dom: {} ,
            tableId: 'table' ,
            filter: {} ,
            once: true ,
            // 增加余额的动作
            updateBalanceUrl: '/user_balance/updateBalance' ,
            coinIds: [3,4] ,
        } ,
        initDom: function(){
            this.data.dom.search = $('#search');
            this.data.dom.add = $('#add');
            this.data.dom.deleteSelected = $('#delete-selected');
        } ,

        initFilter () {
            layui.form.val('search-form' , {
                uid: topContext.route.query.uid
            });
            this.data.filter.uid = topContext.route.query.uid;
        } ,

        initTable: function(){
            var self = this;
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
                        // {
                        //     field:'id',
                        //     title: 'id',
                        //     sort: true ,
                        //     width: topContext.layuiTableIdWidth ,
                        // } ,
                        // {
                        //     title: 'uid',
                        //     field: 'uid' ,
                        //     width: 150 ,
                        // } ,
                        {
                            title: '币种名称',
                            width: 180 ,
                            templet (res) {
                                return res.coin ? res.coin.cname : '未知币种' ;
                            } ,
                        } ,
                        {
                            title: '钱包名称',
                            field: 'wallet_name' ,
                            width: 150 ,
                        } ,
                        {
                            title: '用户余额',
                            field: 'balance' ,
                            width: 220 ,
                        } ,
                        //
                        // {
                        //     title: '冻结的金额',
                        //     field: 'freeze_balance' ,
                        //     width: 150 ,
                        // } ,
                        // {
                        //     title: '最低留存',
                        //     field: 'retained' ,
                        //     width: 150 ,
                        // } ,
                        // {
                        //     title: '修改日期',
                        //     field: 'change_date' ,
                        //     width: 170 ,
                        // } ,
                        // {
                        //     title: '创建日期',
                        //     field: 'date' ,
                        //     width: 170 ,
                        // } ,

                        {
                            // fixed: 'right',
                            width: 200 ,
                            title: '操作' ,
                            align:'left',
                            // toolbar: '#operation'
                            templet (res) {
                                // if (self.data.coinIds.indexOf(res.coin_id) >= 0) {
                                    return `<button class="layui-btn layui-btn-xs" lay-event="balance">拨币</button>`;
                                // }
                                // return '';
                            } ,
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
                    case 'balance':
                        layer.prompt({
                            formType: 0 ,
                            value: 0 ,
                        } , function(value, index, elem){
                            // console.log('用户输入的值' , value);
                            request({
                                url: self.data.updateBalanceUrl ,
                                data: {
                                    id: res.data.id ,
                                    amount: value ,
                                } ,
                                tip: false ,
                                success (res) {
                                    self.reload(false);
                                    success(res , {
                                        yes () {
                                            layer.closeAll();
                                        } ,
                                    });
                                } ,
                            });
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

            /**
             * 搜索
             */
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
            this.initFilter();
            this.initTable();
            this.initEvent();
        } ,
    };
    app.run();
})();