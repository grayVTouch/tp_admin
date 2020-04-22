(function(){
    "use strict";
    var dom = {};
    dom.username = $('input[name=username]');
    dom.password = $('input[name=password]');

    $('#form').on('submit' , function(e){
        e.preventDefault();
        var data = {};
        data.username = dom.username.val();
        data.password = dom.password.val();
        var index = loading();
        post('/login/login' , {
            data: data ,
            success: function(res){
                layer.close(index);
                if (res.code != 0) {
                    error(res.data);
                    return ;
                }
                toLink('/index/indexView');
            } ,
        });
    });
})();