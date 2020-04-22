(function(){
    "use strict";

    var app = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/admin/admin/list' ,
            // 删除记录地址，请勿提供 module
            delUrl: '/admin/del' ,
            // 更新记录状态地址
            updateStatusUrl: '/admin/updateStatus' ,
            editUrl: '/admin/admin/editView?mode=edit&id=' ,
            updateRoleUrl: '/admin/updateRole' ,
            dom: {} ,
            tableId: 'table' ,
            filter: {} ,
        } ,
        initDom: function(){
            this.data.dom.search = $('#search');
            this.data.dom.add = $('#add');
            this.data.dom.deleteSelected = $('#delete-selected');
            this.data.dom.extraRole = $('.extra-role');
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
                            title: '用户',
                            field: 'username' ,
                        } ,
                        {
                            title: '头像',
                            field: 'avatar' ,
                            templet (res) {
                                return layui_imageTemplate(res.avatar);
                            } ,
                        } ,
                        {
                            title: '角色',
                            templet (res) {
                                return res.role ? res.role.name : '待查';
                            } ,

                        } ,
                        {
                            title: '超级管理员？',
                            templet (res) {
                                var option = {
                                    value: res.is_root_explain ,
                                    weight: true
                                };
                                switch (res.is_root)
                                {
                                    case 1:
                                        option.color = 'font-green';
                                        break;
                                    default:
                                        option.color = 'font-red';
                                }
                                return layui_textTemplate(option);
                            } ,

                        } ,
                        {
                            title: '状态',
                            templet: function (res) {
                                var text = {
                                    value: res.status_explain ,
                                    weight: true ,
                                };
                                switch (res.status)
                                {
                                    case 1:
                                        text.color = 'font-green';
                                        break;
                                    case 2:
                                        text.color = 'font-red';
                                        break;
                                    default:
                                        text.color = 'font-gray';

                                }
                                return layui_textTemplate(text);
                            }
                        } ,
                        {
                            field:'create_time',
                            title: '创建日期',
                        } ,
                        {
                            // fixed: 'right',
                            width: 300 ,
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
                area: ['600px', '600px'],
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
                    case 'update_role':
                        layer.open({
                            title: '请选择角色' ,
                            area: ['400px' , '300px'] ,
                            content: self.data.dom.extraRole.get(0).outerHTML ,
                            success (container) {
                                var extraRole = $('.extra-role' , container.get(0));
                                extraRole.removeClass('layui-hide');
                                layui.form.render('select');
                            } ,
                            yes (index , container) {
                                var select = $('.layui-select' , container.get(0));
                                var roleId = select.val();
                                if (!roleId) {
                                    info('请选择用户角色');
                                    return ;
                                }
                                request({
                                    url: self.data.updateRoleUrl ,
                                    data: {
                                        id: res.data.id ,
                                        role_id: roleId
                                    } ,
                                    success () {
                                        layui.table.reload(self.data.tableId);
                                    } ,
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