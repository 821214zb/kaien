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



