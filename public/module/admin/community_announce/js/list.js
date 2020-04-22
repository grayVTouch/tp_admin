(function(){
    "use strict";

    var app = {
        data: {
            // layui 调用的地址，请提供完整地址
            listUrl: '/admin/community_announce/list' ,
            // 删除记录地址，请勿提供 module
            delUrl: '/community_announce/del' ,
            // 更新记录状态地址
            updateStatusUrl: '/community_announce/updateStatus' ,
            editUrl: '/community_announce/editView?mode=edit&id=' ,
            allocateUrl: '/community_announce/privilegeView?id=' ,
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
                            type:'checkbox'
                        } ,
                        {
                            field:'id',
                            title: 'id',
                            sort: true ,
                            width: topContext.layuiTableIdWidth ,
                        } ,
                        {
                            title: '标题',
                            field: 'title' ,
                            width: 163 ,
                        } ,
                        {
                            title: '类型',
                            field: 'type_explain' ,
                            width: 120 ,
                        } ,
                        {
                            title: '内容',
                            field: 'simple_content' ,
                            width: 300 ,
                        } ,
                        {
                            title:'状态',
                            templet (res) {
                                var option = {
                                    value: res.status_explain ,
                                    weight: true
                                };
                                switch (res.status)
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
                            width: 160 ,
                        } ,
                        // {
                        //     title:'内容',
                        //     templet (res) {
                        //         return res.content.slice(0 , 100);
                        //     } ,
                        // } ,
                        {
                            title: '创建时间',
                            field: 'time' ,
                            width: 160 ,
                        } ,
                        {
                            width: 200 ,
                            title: '操作' ,
                            align:'left',
                            // toolbar: '#operation' ,
                            templet (res) {
                                var str = `<button class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i>编辑</button>`;
                                if (res.type == 0) {
                                    str += `<button class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del"><i class="layui-icon">&#xe640;</i>删除</button>`;
                                }
                                return str;
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
                area: ['700px', '820px'],
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
                        toLink(self.data.editUrl + res.data.id);
                        break;
                    case 'allocate':
                        toLink(self.data.allocateUrl + res.data.id);
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