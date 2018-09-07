<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Entity\Category;
use App\Entity\CartItem;
use App\Models\M3Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CartController extends Controller
{
  public function addCart(Request $request, $product_id)
  {
    //设置数据返回格式
    $m3_result = new M3Result;
    $m3_result->status = 0;
    $m3_result->message = '添加成功';

    //获取当前用户信息
    $member = $request->session()->get('member');

    if($member){
      //如果用户已经登录
      $cart_product = CartItem::where('member_id',$member->id)->get();
      $cart_array   = json_decode(json_encode($cart_product),true);

      if($cart_array){
        foreach ($cart_product as $key=>$value){
          if($value->product_id == $product_id){
              $value->count = $value->count+1;
              $value->save();
              break;
          }
        }
      }else{
        $cart_product_obj = new CartItem();
        $cart_product_obj->member_id  = $member->id;
        $cart_product_obj->product_id = $product_id;
        $cart_product_obj->count      = 1;
        $cart_product_obj->save();
      }
      return $m3_result->toJson();

    }else{
      //用户没有登录的情况下
      $bk_cart     = $request->cookie('bk_cart');
      $bk_cart_arr = ($bk_cart!= null ? explode(',',$bk_cart): array());

      $count = 1;

      foreach ($bk_cart_arr as $key=>&$value){
        $index       = strpos($value,':');
        $value_id    = substr($value,0,$index);//获取cookie中商品id
        $value_count = substr($value,$index+1);//获取cookie中商品数量

        if($value_id == $product_id){//如果有此商品就在cookie中增加数量
          $count = $value_count+1;
          $value = $value_id .":".$count;
        }
      }

      //如果cookie中没有此数据记录就添加一条
      if($count == 1){
        array_push($bk_cart_arr,$product_id.":".$count);
      }
      //print_r($bk_cart_arr);
      return response($m3_result->toJson())->withCookie('bk_cart',implode(',',$bk_cart_arr));
    }
  }


  //删除购物车商品
  public function delCart(Request $request)
  {
    $m3_result = new M3Result;
    $m3_result->status = 0;
    $m3_result->message = '删除成功';

    $product_ids = $request->input('product_ids', '');
    if($product_ids == '') {
      $m3_result->status = 1;
      $m3_result->message = '书籍ID为空';
      return $m3_result->toJson();
    }
    $product_ids_arr = explode(',', $product_ids);

    $member = $request->session()->get('member', '');
    if($member != '') {
      // 已登录
      CartItem::whereIn('product_id', $product_ids_arr)->delete();
      return $m3_result->toJson();
    }else{
      // 未登录
      $bk_cart = $request->cookie('bk_cart');
      $bk_cart_arr = ($bk_cart!=null ? explode(',', $bk_cart) : array());
      foreach ($bk_cart_arr as $key => $value) {
        $index = strpos($value, ':');
        $product_id = substr($value, 0, $index);
        // 存在, 删除
        if(in_array($product_id, $product_ids_arr)) {
          unset($bk_cart_arr[$key]);
          continue;
        }
      }

      return response($m3_result->toJson())->withCookie('bk_cart', implode(',', $bk_cart_arr));
    }
  }







}
