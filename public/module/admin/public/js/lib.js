// post 请求
function post(uri  ,option) {
    option.method = 'POST';
    option.url = topContext.host + uri;
    option.error = function(info , type , msg){
        layer.closeAll();
        error('<p>服务器发生错误，请稍后再试！</p><p style="font-size: 12px;color: #555;padding-top: 10px;">如果多次发生同样的错误，请联系开发人员</p>');
    };
    return $.ajax(option);
}

// 加载函数
function loading()
{
    return layer.msg('正在拼命处理...' , {
        icon: 16 ,
        shade: 0.6 ,
        time: 0 ,
    });
}


function success (msg , option = {}) {
    option.icon = 1;
    layer.alert(msg , option);
}

// 错误提示
function error (msg , option = {}) {
    option.icon = 2;
    layer.alert(msg , option);
}

// 消息提醒
function msg (msg , option = {}) {
    layer.msg(msg , option);
}

function info (msg , option = {}) {
    option.icon = 7;
    layer.alert(msg , option);
}

function toLink(uri){
    window.location.href = topContext.host + uri;
}

function openLink(uri){
    window.open(topContext.host + uri , '_blank');
}


// 数据请求
function request(option){
    var _default = {
        url: '' ,
        data: {} ,
        success: null ,
        error: null ,
        tip: true ,
    };
    if (typeof option != 'object') {
        option = _default;
    }
    option.url = option.url ? option.url : _default.url;
    option.data = option.data ? option.data : _default.data;
    option.success = option.success ? option.success : _default.success;
    option.error = option.error ? option.url : _default.error;
    option.tip = typeof option.tip == 'boolean' ? option.tip : _default.tip;
    var index = loading();
    post(option.url , {
        data: option.data ,
        success: function(res){
            layer.close(index);
            if (res.code != 0) {
                error(res.data);
                return ;
            }
            if (option.tip) {
                success(res.data);
            }
            if (typeof option.success == 'function') {
                option.success(res.data);
            }
        } ,
    });
}

function queryString(){
    var str    = decodeURIComponent(window.location.search);
    var result = '';
    var obj    = {};
    var assoc  = null;

    if (str === '') {
        return false;
    }

    str = trim(str.substring(1));

    result = str.split('&');

    for (var i = 0; i < result.length; ++i)
    {
        assoc = result[i].split('=');

        if (assoc.length !== 2) {
            continue;
        }

        obj[assoc[0]] = assoc[1];
    }

    return obj;
}


/*
 * 过滤 左右两边 空格 \r \n \r\n
 * @param String str 将要过滤的字符串
 */
function trim(str){
    str = lTrim(str);
    str = rTrim(str);
    return str;
}

function rTrim(str){
    return str.replace(/( |\r|\n)*$/ , '');
}

function lTrim(str){
    return str.replace(/^( |\r|\n)*/ , '');
}

function appendImage(container , src){
    var img = new Image();
    img.src = src;
    img.className = 'image';
    container.appendChild(img);
}
