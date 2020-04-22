(function () {
	"use strict";

	var app = {
		data: {
			url: '/vadilate/' + topContext.route.query.mode,
			dom: {},
			image: '',
			once: true,
		},

		initDom: function () {
			this.data.dom.form = $('#form');
		},

		initEvent: function () {
			var self = this;
			this.data.dom.form.on('submit', function (e) {
				e.preventDefault();
			});

			// 表单上传
			layui.form.on('submit(form)', function (res) {
				var data = Object.assign({}, res.field);
				if (topContext.route.query.mode == 'edit') {
					data.id = topContext.route.query.id;
				}
				request({
					url: self.data.url,
					data: data,
					tip: false,
					success: function (res) {
						success('操作成功', {
							btn: ['继续' + (topContext.route.query.mode == 'edit' ? '编辑' : '添加'), '关闭窗口'],
							btn1: function (index) {
								layer.close(index);
							},
							btn2: function (index) {
								layer.close(index);
								parent.layer.closeAll();
							},
						})
					}
				});
				return false;
			});
		},

		initialize: function () {

		},

		run: function () {
			this.initDom();
			this.initEvent();
			this.initialize();
		}
	};

	app.run();
})();