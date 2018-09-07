<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entity\CartItem;
use App\Entity\Product;

use Log;

class CartController extends Controller
{
  //查看购物车信息
  public function toCart(Request $request)
  {
    $cart_items = array();

    $bk_cart = $request->cookie('bk_cart');
    $bk_cart_arr = ($bk_cart!=null ? explode(',', $bk_cart) : array());

    $member = $request->session()->get('member', '');
    if($member != '') {
      $cart_items = $this->syncCart($member->id, $bk_cart_arr);
      return response()->view('cart', ['cart_items' => $cart_items])->withCookie('bk_cart', null);
    }

    foreach ($bk_cart_arr as $key => $value) {
      $index = strpos($value, ':');
      $cart_item = new CartItem;
      $cart_item->id = $key;
      $cart_item->product_id = substr($value, 0, $index);
      $cart_item->count = (int) substr($value, $index+1);
      $cart_item->product = Product::find($cart_item->product_id);
      if($cart_item->product != null) {
        array_push($cart_items, $cart_item);
      }
    }

    return view('cart')->with('cart_items', $cart_items);
  }

  private function syncCart($member_id, $bk_cart_arr)
  {
      //首先很据用户id查询相关商品明细
      $cart_item_obj = CartItem::where('member_id',$member_id)->get();

      //用户存放返回数据
      $cart_array = [];
      foreach ($bk_cart_arr as $key=>$value){

        $index = strpos($value,":");
        $product_id = substr($value,0,$index);//获取id
        $count = substr($value,$index+1);

        $true = false;
        foreach ($cart_item_obj as $cartKey=>$cartValue){
          //如果cookie和数据库同事存在就同步数据
          if($product_id == $cartValue->product_id){
            if($count > $cartValue->count){
              $cartValue->count = $count;
            }
          }
          $true = true;
          break;
        }

        //如果数据库中没有cookie中当前的就生成记录插入到数据库
        if($true == false){
          $cartProduct  = new CartItem;
          $cartProduct->member_id = $member_id;
          $cartProduct->product_id = $product_id;
          $cartProduct->count = $count;
          $cartProduct->save();
          // 为每个对象附加产品对象便于显示
          $cartProduct->product = Product::find($cartProduct->product_id);
          array_push($cart_array,$cartProduct);

        }
      }

    //为每个对象附加产品对象便于显示
    foreach ($cart_item_obj as $key=>$value){
      $value->product = Product::find($value->product_id);
      array_push($cart_array,$value);
    };
    return $cart_array;
  }
}
