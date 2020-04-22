(function(){
    "use strict";

    var app = {
        data: {
            url: '/image/' + topContext.route.query.mode ,
            dom: {} ,
            image: '' ,
            images: [] ,
        } ,

        initDom: function(){
            this.data.dom.form = $('#form');
            this.data.dom.imagePreview = $('#image-preview');
            this.data.dom.imagesPreview = $('#images-preview');
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
                data.path = self.data.image;
                request({
                    url: self.data.url ,
                    data: data ,
                    tip: false ,
                    success: function(res){
                        success('操作成功' , {
                            btn: ['继续' + (topContext.route.query.mode == 'edit' ? '编辑' : '添加') , '关闭窗口'] ,
                            btn1: function(index){
                                layer.close(index);
                            } ,
                            btn2: function(index){
                                layer.close(index);
                                parent.layer.closeAll();
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
            this.initEvent();
        }
    };

    app.run();
})();