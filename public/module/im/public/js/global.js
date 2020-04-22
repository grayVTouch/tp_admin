
var topContext = {
    host: '/im' ,
    imageHost: '/im/image/single' ,
    aliyunVideo: 'http://gaowan-oss.32me.cn/' ,
    layuiImageHost: '/im/image/layui_image' ,
    wangEditor: '/im/image/wangEditor' ,
    wangEditorFieldName: 'image[]' ,
    layuiCellMinWidth: 80 ,
    layuiTableIdWidth: 100 ,
    layuiOperationCellWidth: 200 ,
    layuiImageField: 'image' ,
    layuiTableResponse: {
        //规定数据状态的字段名称，默认：code
        statusName: 'code' ,
        //规定成功的状态码，默认：0
        statusCode: 0 ,
        //规定状态信息的字段名称，默认：msg
        msgName: 'msg' ,
        //规定数据总数的字段名称，默认：count
        countName: 'count' ,
        //规定数据列表的字段名称，默认：data
        dataName: 'data'
    } ,
    // layui 数据表格服务器响应数据解析格式
    layuiTableParseData: function(res){ //res 即为原始返回的数据
        return {
            //解析接口状态
            "code": res.code,
            //解析提示文本
            "msg": res.data ,
            //解析数据长度
            "count": res.data.total ,
            //解析数据列表
            "data": res.data.data
        };
    } ,
    // 页面路由信息
    route: {
        // 完整地址
        route: window.location.href ,
        //
        host: window.location.host ,
        // 页面路径
        path: window.location.pathname ,
        // 查询字符串
        query: queryString() ,
        // 锚点
        hash: window.location.hash ,
        // 查询字符串
        search: window.location.search ,
    }
};