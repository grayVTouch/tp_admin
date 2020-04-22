(function(){
    "use strict";

    var app = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/admin/transfer_out/list' ,
            delUrl: '/transfer_out/del' ,
            statusUrl: '/transfer_out/updateStatusSpecial' ,
            editUrl: '/admin/transfer_out/editView?mode=edit&id=' ,
            completeStatusUrl: '/transfer_out/updateCompleteStatus' ,
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
                        // {
                        //     field:'id',
                        //     title: 'id',
                        //     sort: true ,
                        //     width: topContext.layuiTableIdWidth ,
                        // } ,
                        {
                            fixed: 'left' ,
                            title: '用户名',
                            width: 150 ,
                            templet (res) {
                                return res.user ? res.user.username : '未知的用户名';
                            } ,
                        } ,
                        {
                            fixed: 'left' ,
                            title: 'uid',
                            field: 'uid' ,
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
                            fixed: 'left' ,
                            title: '币种',
                            templet (res) {
                                return res.coin ? res.coin.cname : '未知的币种';
                            } ,
                            width: 150 ,
                        } ,
                        {
                            title: '银行卡id',
                            width: 150 ,
                            field: 'card_id' ,
                        } ,
                        {
                            title: '银行卡名称',
                            width: 150 ,
                            templet (res) {
                                return res.user_card ? res.user_card.bank : '';
                            } ,
                        } ,
                        {
                            title: '持卡人',
                            width: 150 ,
                            templet (res) {
                                return res.user_card ? res.user_card.name : '';
                            } ,
                        } ,
                        {
                            title: '卡号',
                            width: 250 ,
                            templet (res) {
                                return res.user_card ? res.user_card.number : '';
                            } ,
                        } ,
                        {
                            title: '持卡人手机号码',
                            width: 150 ,
                            templet (res) {
                                return res.user_card ? res.user_card.phone : '';
                            } ,
                        } ,
                        {
                            title: '银行卡是否启用',
                            width: 150 ,
                            templet (res) {
                                return res.user_card ? res.user_card.active_explain : '';
                            } ,
                        } ,
                        {
                            title: '订单id',
                            field: 'order_id' ,
                            width: 250 ,
                        } ,
                        {
                            title: '提现金额',
                            field: 'raw_amount' ,
                            width: 150 ,
                        } ,
                        {
                            title: '打款金额',
                            field: 'amount' ,
                            width: 150 ,
                        } ,
                        {
                            title: '是否完成',
                            width: 150 ,
                            templet (res) {
                                var option = {
                                    value: res.complete_explain ,
                                    weight: true ,
                                };
                                switch (res.compelete)
                                {
                                    case 0:
                                        option.color = 'font-red';
                                        break;
                                    case 1:
                                        option.color = 'font-green';
                                        break;
                                    default:
                                        break;
                                }
                                return layui_textTemplate(option);
                            } ,
                        } ,
                        {
                            title: '是否通过',
                            width: 150 ,
                            templet (res) {
                                var option = {
                                    value: res.approve_explain ,
                                    weight: true ,
                                };
                                switch (res.status)
                                {
                                    case -1:
                                        option.color = 'font-green';
                                        break;
                                        break;
                                    case 1:
                                        option.color = 'font-gray';
                                        break;
                                    case 0:
                                        option.color = 'font-red';
                                        break;
                                    default:
                                        break;
                                }
                                return layui_textTemplate(option);
                            } ,
                        } ,
                        {
                            title: '创建时间',
                            field: 'date' ,
                            width: 180 ,
                        } ,
                        {
                            width: 250 ,
                            title: '操作' ,
                            align:'left',
                            templet (res) {
                                // var button = '<button class="layui-btn layui-btn-xs" lay-event="complete_status">到账状态</button>';
                                var button = '';
                                if (res.compelete != 1) {
                                    if ([0].indexOf(res.status) == -1)  {
                                        button += `<button class="layui-btn layui-btn-xs" lay-event="auth">审核</button>`;
                                        return button;
                                    }
                                }
                                return button;
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
                    case 'complete_status':
                        info('请选择状态' , {
                            btn: ['已到账' , '未到账'] ,
                            btn1 () {
                                layui_setStatus(self.data.tableId , self.data.completeStatusUrl , [res.data.id] , {
                                    complete: 1
                                });
                            } ,
                            btn2 () {
                                layui_setStatus(self.data.tableId , self.data.completeStatusUrl , [res.data.id] , {
                                    complete: 0
                                });
                            } ,
                        });
                        break;
                    case 'auth':
                        info('请选择状态' , {
                            btn: ['通过' , '拒绝'] ,
                            btn1 () {
                                layui_setStatus(self.data.tableId , self.data.statusUrl , [res.data.id] , {
                                    status: 1
                                });
                            } ,
                            btn2 () {
                                layui_setStatus(self.data.tableId , self.data.statusUrl , [res.data.id] , {
                                    status: -1
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

            /**
             * **************
             * 日期选择
             * **************
             */
            layui.laydate.render({
                elem: '#date_range' ,
                range: true
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