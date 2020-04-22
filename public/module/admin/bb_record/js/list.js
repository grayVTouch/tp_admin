(function(){
    "use strict";

    var app = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/admin/bb_record/list' ,
            // 删除记录地址，请勿提供 module
            delUrl: '/bb_record/del' ,
            // 更新记录状态地址
            editUrl: '/admin/bb_record/editView?mode=edit&id=' ,
            updateUrl: '/bb_record/update' ,
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
                            title: '用户名' ,
                            // field: 'uid' ,
                            templet (res) {
                                return res.user ? res.user.username : '未知的用户名';
                            } ,
                            // width: 150 ,
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
                            title: '来源币种',
                            templet (res) {
                                return res.from_coin ? res.from_coin.name : '未知币种';
                            } ,
                        } ,
                        {
                            title: '兑换币种',
                            templet (res) {
                                return res.to_coin ? res.to_coin.name : '未知币种';
                            } ,
                        } ,
                        {
                            title: '卖单ID',
                            field: 'sell_id' ,
                        } ,
                        {
                            title: '买单ID',
                            field: 'buy_id' ,
                        } ,
                        {
                            title: '交易币种',
                            templet (res) {
                                return res.coin ? res.coin.name : '未知币种';
                            } ,
                        } ,
                        {
                            title: '购买数量',
                            field: 'amount' ,
                        } ,
                        {
                            title: '单价',
                            field: 'price' ,
                        } ,
                        {
                            title: '总价',
                            field: 'total_price' ,
                        } ,
                        {
                            title: '手续费',
                            field: 'fee' ,
                        } ,
                        {
                            title: '下单日期',
                            field: 'date' ,
                            width: 170
                        } ,
                        // {
                        //     fixed: 'right',
                        //     width: 250 ,
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
             * *********************
             * 表单编辑事件
             * *********************
             */
            layui.table.on('edit(table)', function(res){
                var data = {
                    id: res.data.id ,
                };
                data[res.field] = res.value;
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