(function(){
    'use strict';

    var dom = {};

    dom.logout = $('#logout');

    dom.logout.on('click' , function(){
        var index = loading();
        post('/admin/logout' , {
            success: function(){
                layer.close(index);
                window.history.go(0);
            }
        });
    });
})();