商城功能

后台功能：

- 商品分类
- 商城公告
- 用户管理
    - 用户列表
- 商家管理
    - 申请列表
    - 商家列表
- 订单管理
    - 订单列表
        - 未付款
        - 已付款
        - 已完成
        - 已取消
    - 退款列表
- 文章资讯

用户端需要提供 


#### 为了测试功能需要实现的前端 api 接口

```
1. 登录
2. 添加到购物车
3. 下单
4. 不付款（创建订单）
5. 去付款（展示 付款倒计，多少时效内未付款，自动取消）
6. 用户付款
7. 商家发货，等待收货（规定时间内，没有收货，自动收货）
8. 已完成
9. 申请售后
10. 商家审核
11. 商家同意，用户在规定的时间内发货，则等待商家收获，否则自动关闭申请
12. 货物原路返回之后，商家同意退款，钱自动返回用户账户，结束；商家不同意，货物原来返回给用户，申请结束
13. 打电话给客服，客服处理

1. 用户付款倒计时
2. 用户收货倒计时
```