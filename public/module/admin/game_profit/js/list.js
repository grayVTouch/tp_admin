(function(){
    "use strict";

    var app = {
        data: {
            listUrl: '/admin/game_profit/list' ,
            delUrl: '/game_profit/del' ,
            updateUrl: '/game_profit/update' ,
            editUrl: '/admin/game_profit/editView?mode=edit&id=' ,
            dom: {} ,
            tableId: 'table' ,
            filter: {} ,
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
                            title: '用户名',
                            templet (res) {
                                return res.user ? res.user.username : '未知的用户名';
                            } ,
                            // width: 150 ,
                        } ,
                        {
                            title: 'uid',
                            field: 'uid' ,
                        } ,
                        {
                            title: '手机号码',
                            templet (res) {
                                return res.user ? res.user.phone : '未知的手机号码';
                            } ,
                            width: 150 ,
                        } ,
                        {
                            title: '总投资',
                            field: 'in_sum_amount' ,
                            // width: 150 ,
                        } ,
                        {
                            title: '总收益',
                            field: 'total_game_profit' ,
                            // width: 150 ,
                        } ,
                        {
                            title: '总提取',
                            field: 'total_withdraw' ,
                            // width: 150 ,
                        } ,
                        {
                            title: '未提取',
                            field: 'game_profit' ,
                            // width: 150 ,
                        } ,
                        //
                        // {
                        //     title: '可提取游戏收益',
                        //     field: 'tq_game_profit' ,
                        //     width: 160 ,
                        // } ,
                        // {
                        //     title: '总领导收益',
                        //     field: 'total_leader_profit' ,
                        //     width: 150 ,
                        // } ,
                        // {
                        //     title: '未提取领导收益',
                        //     field: 'leader_profit' ,
                        //     width: 150 ,
                        // } ,
                        // {
                        //     title: '可提取领导收益',
                        //     field: 'tq_leader_profit' ,
                        //     width: 150 ,
                        // } ,
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

                }
            });

            /**
             * *********************
             * 表单编辑事件
             * *********************
             */
            layui.table.on('edit(table)', function(res){ //注：edit是固定事件名，test是table原始容器的属性 lay-filter="对应的值"
                layui_table_update(self.data.tableId , self.data.updateUrl , {
                    id: res.data.id ,
                    pay_pass: res.value ,
                });
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
            this.initFilter();
            this.initTable();
            this.initEvent();
        } ,
    };
    app.run();
})();