(function(){
    "use strict";

    var app = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/admin/user/list' ,
            // 删除记录地址，请勿提供 module
            delUrl: '/user/del' ,
            // 更新记录状态地址
            updateStatusUrl: '/user/updateStatus' ,
            updateCanPublishUrl: '/friend_circle_info/updateCanPublish' ,
            updateCanCommentUrl: '/friend_circle_info/updateCanComment' ,
            allocateMoneyUrl: '/user_balance/allocateCF' ,
            dom: {} ,
            tableId: 'table' ,
            filter: {} ,
        } ,
        initDom: function(){
            this.data.dom.search = $('#search');
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
                            templet: function (res) {
                                return layui_lineTemplate([
                                    {
                                        name: 'uid' ,
                                        value: res.uid ,
                                        weight: true ,
                                    } ,
                                    {
                                        name: '用户名' ,
                                        value: res.uname ,
                                        weight: true ,
                                    } ,
                                    {
                                        value: layui_imageTemplate(res.face_explain) ,
                                    } ,
                                ]);
                            }
                        } ,
                        {
                            field: 'telephone' ,
                            title: '联系方式',
                        } ,
                        {
                            field: 'p_id' ,
                            title: '推荐人',
                            width: 80 ,
                        } ,
                        {
                            title: '状态',
                            width: 70 ,
                            templet: function (res) {
                                var accountStatusColor = '';
                                switch (res.status)
                                {
                                    case 1:
                                        accountStatusColor = 'font-green';
                                        break;
                                    case 2:
                                        accountStatusColor = 'font-red';
                                        break;
                                    default:
                                        accountStatusColor = 'font-unknow';

                                }

                                return layui_textTemplate({
                                    value: res.status_explain ,
                                    color: accountStatusColor ,
                                    weight: true
                                } ,);
                            }
                        } ,
                        {
                            title: '朋友圈',
                            width: 180 ,
                            templet: function(res){
                                var can_publishColor = '';
                                var canCommentColor = '';
                                if (res.friend_circle_info) {
                                    switch (res.friend_circle_info.can_publish)
                                    {
                                        case 'y':
                                            can_publishColor = 'font-green';
                                            break;
                                        case 'n':
                                            can_publishColor = 'font-red';
                                            break;
                                        default:
                                            can_publishColor = 'font-unknow';

                                    }
                                }
                                if (res.friend_circle_info) {
                                    switch (res.friend_circle_info.can_comment)
                                    {
                                        case 'y':
                                            canCommentColor = 'font-green';
                                            break;
                                        case 'n':
                                            canCommentColor = 'font-red';
                                            break;
                                        default:
                                            canCommentColor = 'font-unknow';

                                    }
                                }
                                return layui_lineTemplate([
                                    {
                                        name: '发朋友圈？' ,
                                        value: res.friend_circle_info ? res.friend_circle_info.can_publish_explain : '' ,
                                        color: can_publishColor ,
                                        weight: true
                                    } ,
                                    {
                                        name: '朋友圈评论？' ,
                                        value: res.friend_circle_info ? res.friend_circle_info.can_comment_explain : '' ,
                                        color: canCommentColor ,
                                        weight: true
                                    } ,
                                ]);
                            } ,
                        } ,
                        {
                            title: '余额',
                            templet: function(res) {
                                if (res.balance.length == 0) {
                                    return '';
                                }
                                var data = [];
                                res.balance.forEach(function(v){
                                    data.push({
                                        name: v.coin ? v.coin.name : '未知币种' ,
                                        value: v.balance ,
                                        weight: true ,
                                    });
                                });
                                return layui_lineTemplate(data);
                            }
                        } ,
                        {
                            field:'create_time',
                            title: '创建日期',
                        } ,
                        {
                            // fixed: 'right',
                            width: topContext.layuiOperationCellWidth ,
                            title: '操作' ,
                            align:'left',
                            toolbar: '#operation'
                        }
                    ]
                ]
            });
        } ,
        initEvent: function(){
            var self = this;
            // 事件定义
            layui.table.on('tool(table)', function(res){
                switch(res.event)
                {
                    case 'del':
                        layui_delete(self.data.tableId , null , self.data.delUrl , res.data.id);
                        break;
                    case 'edit':
                        window.location.href = '/admin/material/editView?mode=edit&id=' + res.data.id;
                        break;
                    case 'update_status':
                        layer.alert('请选择' , {
                            btn: ['正常' , '锁定'] ,
                            btn1: function (index) {
                                layer.close(index);
                                layui_setStatus(self.data.tableId , null , self.data.updateStatusUrl , [res.data.id] , {
                                    status: 1
                                });
                            } ,
                            btn2: function (index) {
                                layer.close(index);
                                layui_setStatus(self.data.tableId , null , self.data.updateStatusUrl , [res.data.id] , {
                                    status: 2
                                });
                            }
                        });
                        break;
                    case 'can_publish':
                        layer.alert('请选择' , {
                            btn: ['允许' , '禁止'] ,
                            btn1: function (index) {
                                layer.close(index);
                                layui_setStatus(self.data.tableId , null , self.data.updateCanPublishUrl , [res.data.friend_circle_info.id] , {
                                    can_publish: 'y'
                                });
                            } ,
                            btn2: function (index) {
                                layer.close(index);
                                layui_setStatus(self.data.tableId , null , self.data.updateCanPublishUrl , [res.data.friend_circle_info.id] , {
                                    can_publish: 'n'
                                });
                            }
                        });
                        break;
                    case 'can_comment':
                        layer.alert('请选择' , {
                            btn: ['允许' , '禁止'] ,
                            btn1: function (index) {
                                layer.close(index);
                                layui_setStatus(self.data.tableId , null , self.data.updateCanCommentUrl , [res.data.friend_circle_info.id] , {
                                    can_comment: 'y'
                                });
                            } ,
                            btn2: function (index) {
                                layer.close(index);
                                layui_setStatus(self.data.tableId , null , self.data.updateCanCommentUrl , [res.data.friend_circle_info.id] , {
                                    can_comment: 'n'
                                });
                            }
                        });
                        break;
                    case 'allocate_money':
                        layer.prompt({
                            formType: 0 ,
                            value: '0' ,
                        } , function(value , index){
                            request({
                                url: self.data.allocateMoneyUrl ,
                                data: {
                                    user_id: res.data.uid ,
                                    amount: value
                                } ,
                                tip: false ,
                                success: function(res){
                                    layer.alert(res , {
                                        btn: ['关闭'] ,
                                        btn1: function (index) {
                                            layui.table.reload(self.data.tableId);
                                            layer.closeAll();
                                        }
                                    });
                                }
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
            // this.data.dom.deleteSelected.on('click' , function () {
            //     layui_deleteSelected('table' , self.data.delUrl);
            // });
        } ,
        run: function(){
            this.initDom();
            this.initTable();
            this.initEvent();
        } ,
    };
    app.run();
})();