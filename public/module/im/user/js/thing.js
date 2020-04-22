(function(){
    "use strict";

    var requestUrl = '/material/' + topContext.route.query.mode;
    // 仅在编辑的情况下有效
    var dom = {};
    var image = '';
    dom.form = $('#form');
    dom.imagePreview = $('#image-preview');

    // 签证轮播图
    layui.upload.render({
        //绑定元素
        elem: '#image' ,
        //上传接口
        url: topContext.layuiImageHost ,
        // 多图上传
        multiple: false ,
        // 请求之前
        before: function(){
            loading();
            image = [];
            dom.imagePreview.html('');
        } ,
        // 上传完成回调
        done: function(res){
            layer.closeAll();
            if (res.code != 200) {
                error(res.data);
                return ;
            }
            res = res.data;
            image = res.path;
            appendImage(dom.imagePreview.get(0) , res.url);
        } ,
        error: function(){
            //请求异常回调
        }
    });



    dom.form.on('submit' , function(e){
        e.preventDefault();
    });

    layui.form.on('submit(form)' , function(res){
        var data = Object.assign({} , res.field);
        if (topContext.route.query.mode == 'edit') {
            data.id = topContext.route.query.id;
        }
        data.image = image;
        request({
            url: requestUrl ,
            data: data ,
            tip: false ,
            success: function(res){
                success(res , {
                    btn: ['继续' + (topContext.route.query.mode == 'edit' ? '编辑' : '添加') , '材料列表'] ,
                    btn1: function(index){
                        layer.close(index);
                    } ,
                    btn2: function(){
                        toLink('/material/listView');
                    }
                })
            }

        });
        return false;
    });
})();