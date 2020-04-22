(function(){
    "use strict";

    var app = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/admin/user/list' ,
            // 删除记录地址，请勿提供 module
            delUrl: '/user/del' ,
            // 更新的 url
            updateUrl: '/user/update' ,
            // 更新记录状态地址
            updateStatusUrl: '/user/updateStatus' ,
            editUrl: genUrl('/user/editView?mode=edit&id=') ,
            updateRoleUrl: '/user/updateRole' ,
            balanceUrl: genUrl('/user_balance/listView?mode=balance&uid=') ,
            realNameVerifiedUrl: genUrl('/user/realNameVerifiedView?id=') ,
            exportExcelUrl: '/user/exportExcel' ,
            relationUrl: genUrl('/user/relationView?id=') ,
            dom: {} ,
            tableId: 'table' ,
            filter: {} ,
            once: true ,
        } ,
        initDom: function(){
            this.data.dom.search = $('#search');
            this.data.dom.add = $('#add');
            this.data.dom.deleteSelected = $('#delete-selected');
            this.data.dom.export = $('#export');
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
                        {
                            fixed: 'left' ,
                            field:'id',
                            title: 'id',
                            sort: true ,
                            width: topContext.layuiTableIdWidth ,
                        } ,
                        {
                            fixed: 'left' ,
                            title: '用户名',
                            field: 'username' ,
                            width: 150 ,
                        } ,
                        // {
                        //     title: '头像',
                        //     field: 'u' ,
                        //     width: 150 ,
                        // } ,
                        {
                            title: '上级ID',
                            field: 'pid' ,
                            width: 150 ,
                        } ,
                        // {
                        //     title: '上级节点',
                        //     field: 'jdid' ,
                        //     width: 150 ,
                        // } ,
                        {
                            title: '支付密码【可编辑】',
                            field: 'pay_pass' ,
                            edit: true ,
                            width: 160 ,
                        } ,
                        {
                            title: '区号',
                            field: 'quhao' ,
                            width: 150 ,
                        } ,
                        {
                            title: '手机号码',
                            field: 'phone' ,
                            width: 150 ,
                        } ,
                        // {
                        //     title: '发送短信号码',
                        //     field: 'sphone' ,
                        //     width: 150 ,
                        // } ,
                        // {
                        //     title: 'email',
                        //     field: 'email' ,
                        //     width: 150 ,
                        // } ,
                        // {
                        //     title: '实名认证',
                        //     width: 150 ,
                        //     templet (res) {
                        //         var option = {
                        //             value: res.is_verify_explain ,
                        //             weight: true
                        //         };
                        //         switch (res.is_verify)
                        //         {
                        //             case 0:
                        //                 option.color = 'font-red';
                        //                 break;
                        //             case 1:
                        //                 option.color = 'font-green';
                        //                 break;
                        //             case 2:
                        //                 option.color = 'font-gray';
                        //                 break;
                        //         }
                        //         return layui_textTemplate(option);
                        //     } ,
                        // } ,
                        {
                            title: '帐号状态',
                            width: 150 ,
                            templet (res) {
                                var option = {
                                    value: res.status_explain ,
                                    weight: true
                                };
                                switch (res.status)
                                {
                                    case 0:
                                        option.color = 'font-gray';
                                        break;
                                    case 1:
                                        option.color = 'font-green';
                                        break;
                                    case 2:
                                        option.color = 'font-red';
                                        break;
                                }
                                return layui_textTemplate(option);
                            } ,
                        } ,
                        {
                            title: '机器人？',
                            width: 150 ,
                            templet (res) {
                                var option = {
                                    value: res.robot_explain ,
                                    weight: true
                                };
                                switch (res.robot)
                                {
                                    case 0:
                                        option.color = 'font-gray';
                                        break;
                                    case 1:
                                        option.color = 'font-green';
                                        break;
                                    case 2:
                                        option.color = 'font-red';
                                        break;
                                }
                                return layui_textTemplate(option);
                            } ,
                        } ,
                        {
                            title: '修改日期',
                            field: 'change_date' ,
                            width: 170 ,
                        } ,
                        {
                            title: '创建日期',
                            field: 'date' ,
                            width: 170 ,
                        } ,

                        {
                            // fixed: 'right',
                            width: 400 ,
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
        dialog: function(link , option){
            var self = this;
            layer.open(Object.assign({} , {
                type: 2,
                area: ['800px', '600px'],
                fixed: false, //不固定
                maxmin: true,
                content: link ,
                end: function () {
                    self.reload(false);
                }
            } , option));
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
                    case 'status':
                        layer.alert('请选择' , {
                            // btn: ['禁用' , '正常' , '待验证'] ,
                            btn: ['禁用' , '正常'] , //  , '待验证'] ,
                            btn1: function (index) {
                                layer.close(index);
                                layui_table_update(self.data.tableId , self.data.updateUrl , {
                                    id: res.data.id ,
                                    status: 0
                                } , true);
                            } ,
                            btn2: function (index) {
                                layer.close(index);
                                layui_table_update(self.data.tableId , self.data.updateUrl , {
                                    id: res.data.id ,
                                    status: 1
                                } , true);
                            } ,
                            btn3: function (index) {
                                layer.close(index);
                                layui_table_update(self.data.tableId , self.data.updateUrl , {
                                    id: res.data.id ,
                                    status: 2
                                } , true);
                            }
                        });
                        break;
                    case 'is_verify':
                        self.dialog(self.data.realNameVerifiedUrl + res.data.id);
                        // layer.alert('请选择' , {
                        //     btn: ['等待' , '通过' , '拒绝'] ,
                        //     btn1: function (index) {
                        //         layer.close(index);
                        //         layui_table_update(self.data.tableId , self.data.updateUrl , {
                        //             id: res.data.id ,
                        //             is_verify: 0
                        //         });
                        //     } ,
                        //     btn2: function (index) {
                        //         layer.close(index);
                        //         layui_table_update(self.data.tableId , self.data.updateUrl , {
                        //             id: res.data.id ,
                        //             is_verify: 1
                        //         });
                        //     } ,
                        //     btn3: function (index) {
                        //         layer.close(index);
                        //         layui_table_update(self.data.tableId , self.data.updateUrl , {
                        //             id: res.data.id ,
                        //             is_verify: 2
                        //         });
                        //     } ,
                        // });
                        break;
                    case 'balance':
                        self.dialog(self.data.balanceUrl + res.data.id);
                        break;
                    case 'relation':
                        self.dialog(self.data.relationUrl + res.data.id , {
                            area: ['1000px' , '700px'] ,
                            // area: ['1920px' , '1000px'] ,
                        });
                        break;
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

            /**
             * 导出到电子表格
             */
            this.data.dom.export.on('click' , this.exportEvent.bind(this));
        } ,

        exportEvent () {
            openLink(this.data.exportExcelUrl);
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