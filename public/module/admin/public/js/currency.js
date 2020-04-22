/**
 * 删除选中项
 *
 * @param tableId
 * @param url
 */
function layui_deleteSelected(tableId , url){
    return info('确定要删除全部吗？' , {
        yes: function(){
            var idList = layui_idList(tableId);
            request({
                url: url ,
                data: {
                    id_list: JSON.stringify(idList)
                } ,
                success: function(){
                    layui.table.reload(tableId);
                }
            });
        } ,
    });
}

/**
 * 删除记录
 *
 * @param tableId
 * @param url
 * @param id
 */
function layui_delete(tableId , url , id){
    return info('确定要删除吗？' , {
        yes: function(){
            request({
                url: url ,
                data: {
                    id_list: JSON.stringify([id])
                } ,
                success: function(){
                    layui.table.reload(tableId);
                }
            });
        } ,
    });
}

/**
 * 设置状态
 * @param tableId
 * @param url
 * @param idList
 * @param field
 * @param value
 */
function layui_setStatus(tableId , url , idList , merge)
{
    var data = Object.assign({} , {
        id_list: JSON.stringify(idList)
    } , merge);
    request({
        url: url ,
        data: data ,
        success: function(){
            layui.table.reload(tableId);
        }
    });
}

/**
 * 获取选中的 id 列表
 *
 * @param tableId
 * @returns {Array}
 */
function layui_idList(tableId){
    var res = layui.table.checkStatus(tableId);
    var data = res.data;
    var idList = [];
    data.forEach(function (v) {
        idList.push(v.id);
    });
    return idList;
}

/**
 * 生成 url 地址
 *
 * @param path
 * @returns {string}
 */
function genUrl(path)
{
    return topContext.host + path;
}

/**
 * layui 表格模板字符串
 *
 * @param arr
 * @returns {string}
 */
function layui_lineTemplate(arr)
{
    var i = 0;
    var cur = null;
    var str = '';
    for (; i < arr.length; ++i)
    {
        cur = arr[i];
        str += '<p class="line">';
        if (cur.name) {
            str += '【' + cur.name + '】';
        }
        if (cur.weight) {
            if (cur.color) {
                str += '<b class="' + cur.color + '">' + cur.value + '</b>';
            } else {
                str += '<b>' + cur.value + '</b>';
            }
        } else {
            if (cur.color) {
                str += cur.value;
            } else {
                str += '<span class="' + cur.color + '">' + cur.value + '</span>';
            }
        }
        str += '</p>';
    }
    return str;
}

function layui_textTemplate(res)
{
    var str = '';
    if (res.weight) {
        if (res.color) {
            return '<b class="' + res.color + '">' + res.value + '</b>';
        }
        return '<b>' + res.value + '</b>';
    }
    if (res.color) {
        return '<span class="' + res.color + '">' + res.value + '</span>';
    }
    return res.value;
}

/**
 * 图片字符串
 *
 * @param src
 * @returns {string}
 */
function layui_imageTemplate(src)
{
    return "<img src='" + src + "' class='image'>";
}

function layui_table_update(tableId , url , data , isReload)
{
    request({
        url: url ,
        data: data ,
        tip: false ,
        success (res) {
            // layui.table.reload(tableId);
            msg(res);
            if (isReload) {
                layui.table.reload(tableId);
            }
        } ,
    });
}

function layui_linkTemplete(link , text , className)
{
    className = typeof className == 'undefined' ? '' : className;
    return '<a class="layui-btn layui-btn-xs ' + className + '" href="' + link + '" target="_blank">' + text + '</a>';
}