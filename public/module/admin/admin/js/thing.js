(function(){
    "use strict";

    var app = {
        data: {
            url: '/admin/' + topContext.route.query.mode ,
            dom: {} ,
            image: '' ,
            once: true ,
        } ,

        initDom: function(){
            this.data.dom.form = $('#form');
            this.data.dom.imagePreview = $('#image-preview');
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
                data.avatar = self.data.image;
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

            // 图片上传
            layui.upload.render({
                //绑定元素
                elem: '#image' ,
                //上传接口
                url: topContext.ossUrl ,
                // 多图上传
                multiple: false ,
                // 请求之前
                before: function(){
                    loading();
                    self.data.image = '';
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
                    self.data.image = res;
                    appendImage(self.data.dom.imagePreview.get(0) , res);
                } ,
                error: function(){
                    //请求异常回调
                }
            });
        } ,

        initialize: function(){

        } ,

        run: function () {
            this.initDom();
            this.initEvent();
            this.initialize();
        }
    };

    app.run();
})();