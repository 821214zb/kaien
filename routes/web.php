<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'View\MemberController@ToLogin');

//获取验证码
Route::any('/service/validate_code/create','Service\ValidateCodeController@CreateCode');
//获取手机验证码
Route::any('/service/validate_phone/send','Service\ValidateCodeController@sendSMS');

//登录注册界面
Route::get('/login','View\MemberController@ToLogin');
Route::get('/register','View\MemberController@ToRegister');

//注册路由
Route::post('/service/register','Service\MemberController@register');
//登录路由
Route::post('/service/login','Service\MemberController@login');

//路由组
Route::group(['prefix'=>'service'],function (){


});

//书籍分类
Route::get('/view/category','View\BookController@toCategory');
Route::get('/service/category/parent_id/{parent_id}','Service\BookController@getCategoryByParentId');

//书籍列表
Route::get('/product/category_id/{category_id}','View\BookController@toProduct');
//书籍详情
Route::get('/product/{product_id}','View\BookController@toPdtContent');

//添加购物车
Route::get('/service/cart/add/{product_id}','Service\CartController@addCart');
//查看购物车
Route::get('/cart','View\CartController@toCart');
//删除购物车
Route::get('/service/cart/delete','Service\CartController@delCart');

//我的订单
Route::get('/service/order_list','View\OrderController@toOrderList');

//中间件使用
Route::group(['middleware'=>'check.login'],function (){
    //结算路由
    Route::post('/order_commit','View\OrderController@toOrderCommit');
    //支付宝支付
    Route::post('/service/alipay','Service\PayController@aliPay');
    Route::post('/pay/notify','Service\PayController@notify');
    Route::post('/pay/call_back','Service\PayController@callback');
    Route::post('/pay/merchant','Service\PayController@merchant');
    
    //微信支付
    Route::post('/service/WXpay','Service\PayController@wxPay');
    Route::post('/openid/get','Service\PayController@getOpenid');
    
});

//凯恩书店后台
Route::group(['prefix'=>'admin'],function (){
    Route::get('index','Admin\IndexController@toIndex');//首页
    Route::get('default','Admin\IndexController@toDefault');//首页左侧公告
    Route::get('login','Admin\IndexController@toLogin');//登录
    Route::post('check_login','Admin\IndexController@login');//登录检测
    Route::get('exit','Admin\IndexController@toExit');//退出登录
    
    //书籍分类
    Route::get('category','Admin\CategoryController@toCategory');
    //分类添加
    Route::get('category_add','Admin\CategoryController@toCategoryAdd');
    Route::post('service/category/add','Admin\CategoryController@categoryAdd');

    //分类编辑
    Route::get('category_edit','Admin\CategoryController@toCategoryEdit');
    Route::post('service/category/edit','Admin\CategoryController@CategoryEdit');
    //分类删除
    Route::post('service/category/del','Admin\CategoryController@categoryDel');


    //产品管理
    Route::get('product','Admin\ProductController@toProduct');
    //产品添加
    Route::get('product_add','Admin\ProductController@toProductAdd');
    Route::post('service/product/add','Admin\ProductController@ProductAdd');
    //获取产品详细信息
    Route::get('product_info','Admin\ProductController@toProductInfo');
   
    //产品编辑

});
//文件上传方法
Route::post('service/upload/{type}','Service\UploadController@UploadFile');










