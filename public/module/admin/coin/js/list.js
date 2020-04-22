(function(){
    "use strict";

    var app = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/admin/coin/list' ,
            // 删除记录地址，请勿提供 module
            updateUrl: '/coin/update' ,
            dom: {} ,
            tableId: 'table' ,
            filter: {} ,
            refreshField: ['price' , 'rmb'] ,
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
                            fixed: 'left',
                            type:'checkbox'
                        } ,
                        {
                            fixed: 'left',
                            field:'id',
                            title: 'id',
                            sort: true ,
                            width: topContext.layuiTableIdWidth ,
                        } ,
                        {
                            fixed: 'left',
                            title: '币种名称',
                            field: 'name' ,
                            width: 150 ,
                        } ,
                        {
                            fixed: 'left',
                            title: '币种显示',
                            field: 'cname' ,
                            width: 200 ,
                        } ,
                        {
                            title: '币种单位',
                            field: 'unit' ,
                            width: 130 ,
                        } ,
                        {
                            title: '币种执行程序种类',
                            field: 'type' ,
                            width: 150 ,
                        } ,
                        {
                            title: '币种对USDT价格【可编辑】',
                            field: 'price' ,
                            edit: true ,
                            width: 240 ,
                        } ,
                        {
                            title: '币种对RMB价格【可编辑】',
                            field: 'rmb' ,
                            edit: true ,
                            width: 240 ,
                        } ,
                        {
                            title: '是否显示',
                            templet: '#can_show',
                            unresize: true ,
                            width: 150 ,
                        } ,
                        {
                            title: '是否可以转账',
                            templet: '#can_transfer',
                            unresize: true ,
                            width: 150 ,
                        } ,
                        {
                            title: '转账最低手续费【可编辑】',
                            field: 'fee_min' ,
                            edit: true ,
                            width: 240 ,
                        } ,
                        {
                            title: '转账最高手续费【可编辑】',
                            field: 'fee_max' ,
                            edit: true ,
                            width: 240 ,
                        } ,
                        {
                            title: '是否可以转出',
                            templet: '#can_transfer_out',
                            unresize: true ,
                            width: 150 ,
                        } ,
                        {
                            title: '提现最低手续费【可编辑】',
                            field: 'out_fee_min' ,
                            edit: true ,
                            width: 240 ,
                        } ,
                        {
                            title: '提现最高手续费【可编辑】',
                            field: 'out_fee_max' ,
                            edit: true ,
                            width: 240 ,
                        } ,
                        {
                            title: '是否显示行情',
                            field: 'can_trend' ,
                            templet: '#can_trend',
                            unresize: true ,
                            width: 150 ,
                        } ,
                        {
                            title: '自动行情价格【可编辑】',
                            field: 'auto_price' ,
                            edit: true ,
                            width: 240 ,
                        } ,
                        {
                            title: '币种状态',
                            templet: '#status',
                            unresize: true ,
                            edit: true ,
                            width: 150 ,
                        } ,
                        {
                            title: '合约',
                            field: 'contract' ,
                            width: 150 ,
                        } ,
                        {
                            title: '钱包自定义',
                            field: 'wallet_id' ,
                            width: 150 ,
                        } ,
                        {
                            title: '钱包名称',
                            field: 'wallet_name' ,
                            width: 150 ,
                        } ,
                        {
                            title: '虚拟钱包？',
                            field: 'is_virtual' ,
                            templet: '#is_virtual',
                            unresize: true ,
                            width: 150 ,
                        } ,
                        {
                            title: '是否实体钱包',
                            templet: '#is_real',
                            unresize: true ,
                            width: 150 ,
                        } ,
                        {
                            title: '注册是否奖励',
                            field: 'is_reward' ,
                            templet: '#is_reward',
                            unresize: true ,
                            width: 150 ,
                        } ,
                        {
                            title: '注册奖励金额',
                            field: 'reward_number' ,
                            edit: true ,
                            width: 240 ,
                        } ,
                        {
                            title: '发红包？',
                            field: 'red_pack' ,
                            templet: '#red_pack',
                            unresize: true ,
                            width: 150 ,
                        } ,
                        {
                            title: '能否用于第三方游戏平台？',
                            field: 'can_use_in_third_game' ,
                            templet: '#can_use_in_third_game',
                            unresize: true ,
                            width: 200 ,
                        } ,
                        {
                            title: '自动转出上限【可编辑】',
                            field: 'auto_out_limit' ,
                            edit: true ,
                            width: 240 ,
                        } ,
                        // {
                        //     fixed: 'right',
                        //     width: 150 ,
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
                if (self.data.refreshField.indexOf(res.field) != -1) {
                    layui_table_update(self.data.tableId , self.data.updateUrl , data , true);
                } else {
                    layui_table_update(self.data.tableId , self.data.updateUrl , data);
                }
            });

            layui.form.on('switch(status)', function(res){
                var data = {
                    id: res.elem.value ,
                };
                data[this.name] = res.elem.checked ? 1 : 0;
                layui_table_update(self.data.tableId , self.data.updateUrl , data);
            });

            layui.form.on('switch(can_show)', function(res){
                var data = {
                    id: res.elem.value ,
                };
                data[this.name] = res.elem.checked ? 1 : 0;
                layui_table_update(self.data.tableId , self.data.updateUrl , data);
            });

            layui.form.on('switch(can_transfer)', function(res){
                var data = {
                    id: res.elem.value ,
                };
                data[this.name] = res.elem.checked ? 1 : 0;
                layui_table_update(self.data.tableId , self.data.updateUrl , data);
            });

            layui.form.on('switch(can_transfer_out)', function(res){
                var data = {
                    id: res.elem.value ,
                };
                data[this.name] = res.elem.checked ? 1 : 0;
                layui_table_update(self.data.tableId , self.data.updateUrl , data);
            });

            layui.form.on('switch(can_trend)', function(res){
                var data = {
                    id: res.elem.value ,
                };
                data[this.name] = res.elem.checked ? 1 : 0;
                layui_table_update(self.data.tableId , self.data.updateUrl , data);
            });

            layui.form.on('switch(is_virtual)', function(res){
                var data = {
                    id: res.elem.value ,
                };
                data[this.name] = res.elem.checked ? 1 : 0;
                layui_table_update(self.data.tableId , self.data.updateUrl , data);
            });

            layui.form.on('switch(is_real)', function(res){
                var data = {
                    id: res.elem.value ,
                };
                data[this.name] = res.elem.checked ? 1 : 0;
                layui_table_update(self.data.tableId , self.data.updateUrl , data);
            });

            layui.form.on('switch(is_reward)', function(res){
                var data = {
                    id: res.elem.value ,
                };
                data[this.name] = res.elem.checked ? 1 : 0;
                layui_table_update(self.data.tableId , self.data.updateUrl , data);
            });

            layui.form.on('switch(red_pack)', function(res){
                var data = {
                    id: res.elem.value ,
                };
                data[this.name] = res.elem.checked ? 1 : 0;
                layui_table_update(self.data.tableId , self.data.updateUrl , data);
            });

            layui.form.on('switch(can_use_in_third_game)', function(res){
                var data = {
                    id: res.elem.value ,
                };
                data[this.name] = res.elem.checked ? 1 : 0;
                layui_table_update(self.data.tableId , self.data.updateUrl , data);
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

        run: function(){
            this.initDom();
            this.initTable();
            this.initEvent();
        } ,
    };
    app.run();
})();