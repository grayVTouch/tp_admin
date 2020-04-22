(function(){
    "use strict";

    var app = {
        data: {
            url: '/announcement/' + topContext.route.query.mode ,
            listUrl: '/announcement/listView' ,
            dom: {} ,
            image: '' ,
            images: [] ,
            ins: {
                editor: null ,
            } ,
        } ,

        initDom: function(){
            this.data.dom.form = $('#form');
            this.data.dom.imagePreview = $('#image-preview');
            this.data.dom.imagesPreview = $('#images-preview');
            this.data.dom.editor = $('#editor');
        } ,

        initImage: function(){
            var self = this;

            layui.upload.render({
                //绑定元素
                elem: '#image' ,
                //上传接口
                url: topContext.layuiImageHost ,
                // 多图上传
                multiple: false ,
                field: topContext.layuiImageField ,
                // 请求之前
                before: function(){
                    loading();
                    self.data.image = [];
                    self.data.dom.imagePreview.html('');
                } ,
                // 上传完成回调
                done: function(res){
                    layer.closeAll();
                    if (res.code != 0) {
                        error(res.data);
                        return ;
                    }
                    res = res.data;
                    self.data.image = res.path;
                    appendImage(self.data.dom.imagePreview.get(0) , res.url);
                } ,
                error: function(){
                    //请求异常回调
                }
            });
        } ,

        initEditor: function(){
            var editor = new wangEditor(this.data.dom.editor.get(0));
            editor.customConfig.uploadImgServer = topContext.wangEditor;
            editor.customConfig.uploadFileName = topContext.wangEditorFieldName;
            editor.create();
            editor.txt.html(this.data.dom.editor.data('content'));
            this.data.ins.editor = editor;
        } ,

        initEvent: function(){
            var self = this;
            this.data.dom.form.on('submit' , function (e) {
                e.preventDefault();
            });
            // 表单上传
            layui.form.on('submit(form)' , function(res){
                var data = Object.assign({} , res.field);
                if (topContext.route.query.mode == 'edit') {
                    data.id = topContext.route.query.id;
                }
                data.text = self.data.ins.editor.txt.html();
                request({
                    url: self.data.url ,
                    data: data ,
                    tip: false ,
                    success: function(res){
                        success('操作成功' , {
                            btn: ['继续' + (topContext.route.query.mode == 'edit' ? '编辑' : '添加') , '公告列表'] ,
                            btn1: function(index){
                                layer.close(index);
                            } ,
                            btn2: function(index){
                                toLink(self.data.listUrl);
                            } ,
                        })
                    }

                });
                return false;
            });
        } ,

        run: function () {
            this.initDom();
            this.initImage();
            this.initEditor();
            this.initEvent();
        }
    };

    app.run();
})();