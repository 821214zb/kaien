<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Tool\WXpay\WXTool;
use App\Entity\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\M3Result;

class PayController extends Controller
{
  public function aliPay(Request $request) {

    require_once(app_path() . "/Tool/alipay/config.php");//主要配置文件
    require_once(app_path() . "/Tool/alipay/wappay/service/AlipayTradeService.php");
    require_once(app_path() . "/Tool/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php");


      if (!empty($_POST['order_no'])&& trim($_POST['order_no'])!=""){
          //商户订单号，商户网站订单系统中唯一订单号，必填
          $out_trade_no = $_POST['order_no'];

          //订单名称，必填
          $subject = $_POST['name'];

          //付款金额，必填
          $total_amount = $_POST['total_price'];

          //商品描述，可空
          $body = $_POST['WIDbody'];

          //超时时间
          $timeout_express="1m";

          $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
          $payRequestBuilder->setBody($body);
          $payRequestBuilder->setSubject($subject);
          $payRequestBuilder->setOutTradeNo($out_trade_no);
          $payRequestBuilder->setTotalAmount($total_amount);
          $payRequestBuilder->setTimeExpress($timeout_express);

          $payResponse = new \AlipayTradeService($config);

           $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
           return;


      }
      
      
//
//    //返回格式
//    $format = "xml";
//    //必填，不需要修改
//
//    //返回格式
//    $v = "2.0";
//    //必填，不需要修改
//
//    //请求号
//    $req_id = date('Ymdhis');
//    //必填，须保证每次请求都是唯一
//
//    //**req_data详细信息**
//
//    //服务器异步通知页面路径
//    $notify_url = "http://" . $_SERVER['HTTP_HOST'] . '/service/pay/ali_notify';
//    //需http://格式的完整路径，不允许加?id=123这类自定义参数
//
//    //页面跳转同步通知页面路径
//    $call_back_url = "http://" . $_SERVER['HTTP_HOST'] . '/service/pay/ali_result';
//    //需http://格式的完整路径，不允许加?id=123这类自定义参数
//    //http://127.0.0.1:8800/WS_WAP_PAYWAP-PHP-UTF-8/call_back_url.php
//
//    //操作中断返回地址
//    $merchant_url = "http://" . $_SERVER['HTTP_HOST'] . '/service/pay/ali_merchant';
//    //用户付款中途退出返回商户的地址。需http://格式的完整路径，不允许加?id=123这类自定义参数
//
//    //卖家支付宝帐户
//    $seller_email = '757849673@qq.com';
//    //必填
//
//    //商户订单号
//    $out_trade_no = $_POST['order_no'];
//    //商户网站订单系统中唯一订单号，必填
//    Log::info('out_trade_no:' . $out_trade_no);
//
//    //订单名称
//    $subject = $_POST['name'];
//    //必填
//
//    //付款金额
//    $total_fee = $_POST['total_price'];
//    //必填
//
//    //请求业务参数详细
//    $req_data = '<direct_trade_create_req><notify_url>' . $notify_url . '</notify_url><call_back_url>' . $call_back_url . '</call_back_url><seller_account_name>' . $seller_email . '</seller_account_name><out_trade_no>' . $out_trade_no . '</out_trade_no><subject>' . $subject . '</subject><total_fee>' . $total_fee . '</total_fee><merchant_url>' . $merchant_url . '</merchant_url></direct_trade_create_req>';
//    //必填

    /************************************************************/

    //构造要请求的参数数组，无需改动
//    $para_token = array(
//    		"service" => "alipay.wap.trade.create.direct",
//    		"partner" => trim($alipay_config['partner']),
//    		"sec_id" => trim($alipay_config['sign_type']),
//    		"format"	=> $format,
//    		"v"	=> $v,
//    		"req_id"	=> $req_id,
//    		"req_data"	=> $req_data,
//    		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
//    );
//
//
//    //建立请求
//    $alipaySubmit = new \AlipaySubmit($alipay_config);
//    $html_text = $alipaySubmit->buildRequestHttp($para_token);
//
//    //URLDECODE返回的信息
//    $html_text = urldecode($html_text);
//        p($html_text);
//    //解析远程模拟提交后返回的信息
//    $para_html_text = $alipaySubmit->parseResponse($html_text);
//
//    //获取request_token
//    $request_token = $para_html_text['request_token'];
//
//
//    /**************************根据授权码token调用交易接口alipay.wap.auth.authAndExecute**************************/
//
//    //业务详细
//    $req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';
//    //必填
//
//    //构造要请求的参数数组，无需改动
//    $parameter = array(
//    		"service" => "alipay.wap.auth.authAndExecute",
//    		"partner" => trim($alipay_config['partner']),
//    		"sec_id" => trim($alipay_config['sign_type']),
//    		"format"	=> $format,
//    		"v"	=> $v,
//    		"req_id"	=> $req_id,
//    		"req_data"	=> $req_data,
//    		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
//    );

    //建立请求
//    $alipaySubmit = new \AlipaySubmit($alipay_config);
//    $html_text = $alipaySubmit->buildRequestForm($parameter, 'get', '确认');
//
//    return $html_text;
  }

    //异步通知
  public function aliNotify() {

      require_once(app_path() . "/Tool/alipay/config.php");//主要配置文件
      require_once(app_path() . "/Tool/alipay/wappay/service/AlipayTradeService.php");
      
      $arr = $_POST;
      $alipaySevice = new \AlipayTradeService($config);
      $alipaySevice->writeLog(var_export($_POST,true));
      $result = $alipaySevice->check($arr);

      /* 实际验证过程建议商户添加以下校验。
      1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
      2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
      3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
      4、验证app_id是否为该商户本身。
      */
      if($result) {
          //请在这里加上商户的业务逻辑程序代
          //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
          //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

          $out_trade_no = $_POST['out_trade_no']; //商户订单号
          $trade_no     = $_POST['trade_no'];     //支付宝交易号
          $trade_status = $_POST['trade_status']; //交易状态

          if($trade_status == 'TRADE_FINISHED') {
              Log::info('支付完成');
          }
          else if ($trade_status == 'TRADE_SUCCESS') {
              Log::info('支付成功');
              $order = Order::where('order_no', $out_trade_no)->first();
              $order->status = 2;
              $order->save();
          }
          echo "success";		//请不要修改或删除
      }else {
          //验证失败
          echo "fail";	        //请不要修改或删除
      }
  }

    //同步通知
  public function aliResult() {

      require_once(app_path() . "/Tool/alipay/config.php");//主要配置文件
      require_once(app_path() . "/Tool/alipay/wappay/service/AlipayTradeService.php");


      $arr=$_GET;
      $alipaySevice = new \AlipayTradeService($config);
      $result = $alipaySevice->check($arr);

      /* 实际验证过程建议商户添加以下校验。
      1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
      2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
      3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
      4、验证app_id是否为该商户本身。
      */
      if($result) {//验证成功
          /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          //请在这里加上商户的业务逻辑程序代码

          //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
          //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

          //商户订单号

          $out_trade_no = htmlspecialchars($_GET['out_trade_no']);

          //支付宝交易号

          $trade_no = htmlspecialchars($_GET['trade_no']);

          echo "验证成功<br />外部订单号：".$out_trade_no;

          //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

          /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      }
      else {
          //验证失败
          echo "验证失败";
      }
  }


  public function aliMerchant() {

    return view('alipay.merchant_url');
  }

  public function wxPay(Request $request) {
    $openid = $request->session()->get('openid', '');
    if($openid == '') {
      $m3_result = new M3Result;
      $m3_result->status = 1;
      $m3_result->message = 'Session已过期, 请重新提交订单';

      return $m3_result;
    }

    return WXTool::wxPayData($request->input('name'), $request->input('order_no'), 1, $openid);
  }

  public function wxNotify() {
    Log::info('微信支付回调开始');
    $return_data = file_get_contents("php://input");
    Log::info('return_data: '.$return_data);

    libxml_disable_entity_loader(true);
    $data = simplexml_load_string($return_data, 'SimpleXMLElement', LIBXML_NOCDATA);

    Log::info('return_code: '.$data->return_code);
    if($data->return_code == 'SUCCESS') {
      $order = Order::where('order_no', $data->out_trade_no)->first();
      $order->status = 2;
      $order->save();

      return "<xml>
                <return_code><![CDATA[SUCCESS]]></return_code>
                <return_msg><![CDATA[OK]]></return_msg>
              </xml>";
    }

    return "<xml>
              <return_code><![CDATA[FAIL]]></return_code>
              <return_msg><![CDATA[FAIL]]></return_msg>
            </xml>";

  }
}
