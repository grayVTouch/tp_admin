(function(){
    "use strict";

    var app = {
        data: {
            layuiEditImageUploadUrl: genUrl('/Image/layuiEditImageUpload') ,
            url: genUrl('/shop_goods/' + topContext.route.query.mode) ,
            dom: {} ,
            image: '' ,
            ins: {} ,
        } ,

        initDom: function(){
            this.data.dom.form = $('#form');
            this.data.dom.imagePreview = $('#image-preview');
            this.data.dom.introduction = $('#introduction');
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

                // console.log(self.data.ins.goodsRule.res);

                // 商品参数
                data.shop_param = JSON.stringify(self.data.ins.shopParam.res);
                // 商品规格
                data.shop_rule = JSON.stringify(self.data.ins.goodsRule.res);
                // 商品图片
                data.shop_image = JSON.stringify(self.data.ins.goodsImage.res);
                // 商品介绍
                data.my_introduction = layui.layedit.getContent(self.data.introductionForLayuiEditor);
                // 商品封面
                data.pic = self.data.image;

                request({
                    url: self.data.url ,
                    data: data ,
                    tip: false ,
                    success: function(res){
                        success('操作成功' , {
                            btn: ['继续' + (topContext.route.query.mode == 'edit' ? '编辑' : '添加') , '商品列表'] ,
                            btn1: function(index){
                                layer.close(index);
                            } ,
                            btn2: function(index){
                                // layer.close(index);
                                // parent.layer.closeAll();
                                toLink(genUrl('/shop_goods/listView'));
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

            // 富文本编辑器
            // layui.layedit.getContent(index) 获取 html
            // layui.layedit.getText(index) 获取 text
            // layui.layedit.getSelection(index) 获取 selection 选中的内容
            this.data.introductionForLayuiEditor = layui.layedit.build('introduction' , {
                uploadImage: {
                    url: self.data.layuiEditImageUploadUrl ,
                    type: 'post' ,
                } ,
                height: 400 ,
            });

            /**
             * 商品规格
             */
            this.data.ins.goodsRule = new Vue({
                el: '#goods_rule' ,
                data: {
                    dom: {} ,
                    json: null ,
                    res: [] ,
                } ,
                mounted () {
                    const self = this;
                    this.json = this.$el.getAttribute('data-data');
                    if (topContext.route.query.mode == 'edit' && this.json != null) {
                        this.res = JSON.parse(this.json);
                    }
                    this.$nextTick(() => {
                        for (let i = 0; i < this.res.length; ++i)
                        {
                            const uploadBtn     = this.$refs['run_upload_' + i][0];
                            const imagePreview  = this.$refs['run_preview_' + i][0];

                            // 图片上传
                            layui.upload.render({
                                //绑定元素
                                elem: uploadBtn ,
                                //上传接口
                                url: topContext.ossUrl ,
                                // 多图上传
                                multiple: false ,
                                // 请求之前
                                before: function(){
                                    loading();
                                    self.res[i].pic = '';
                                    imagePreview.src = '';
                                } ,
                                // 上传完成回调
                                done: function(res){
                                    layer.closeAll();
                                    if (res.code != 0) {
                                        error(res.data);
                                        return ;
                                    }
                                    res = res.data;
                                    self.res[i].pic = res;
                                    imagePreview.src = res;
                                } ,
                                error: function(){
                                    //请求异常回调
                                }
                            });
                        }
                    });
                } ,
                methods: {
                    del (index) {
                        this.res.splice(index , 1);
                    } ,

                    // 添加项
                    add () {
                        this.res.push({
                            pic: '' ,
                            name: '' ,
                            price: 0 ,
                            original_price: 0 ,
                            salas: 0 ,
                            stock: 0 ,
                        });
                    } ,
                }
            });

            /**
             * 商品参数
             */
            this.data.ins.shopParam = new Vue({
                el: '#shop_param' ,
                data: {
                    dom: {} ,
                    json: null ,
                    res: [] ,
                } ,
                mounted () {
                    const self = this;
                    this.json = this.$el.getAttribute('data-data');
                    if (topContext.route.query.mode == 'edit' && this.json != null) {
                        this.res = JSON.parse(this.json);
                    }
                } ,
                methods: {
                    del (index) {
                        this.res.splice(index , 1);
                    } ,

                    add () {
                        this.res.push({
                            param_name: '' ,
                            param_value: '' ,
                        });
                    } ,
                }
            });

            /**
             * 商品图片
             */
            this.data.ins.goodsImage = new Vue({
                el: '#goods_image' ,
                data: {
                    dom: {} ,
                    json: null ,
                    res: [] ,
                } ,
                mounted () {
                    const self = this;
                    this.json = this.$el.getAttribute('data-data');
                    if (topContext.route.query.mode == 'edit' && this.json != null) {
                        this.res = JSON.parse(this.json);
                    }

                    // 实例化图片上传
                    layui.upload.render({
                        //绑定元素
                        elem: this.$refs.upload ,
                        //上传接口
                        url: topContext.ossUrl ,
                        // 多图上传
                        multiple: true ,
                        // 请求之前
                        before: function(){
                            loading();
                        } ,
                        // 上传完成回调
                        done: function(res){
                            layer.closeAll();
                            if (res.code != 0) {
                                error(res.data);
                                return ;
                            }
                            res = res.data;
                            self.res.push({
                                pic: res ,
                                pic_explain: res ,
                            });
                        } ,
                        error: function(){
                            //请求异常回调
                        }
                    });
                } ,
                methods: {
                    del (index) {
                        this.res.splice(index , 1);
                    } ,
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