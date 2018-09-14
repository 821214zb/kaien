<?php

namespace App\Http\Controllers\WenXin;

use App\Http\Controllers\Controller;
class IndexController extends Controller
{

    public function  index(){
        if(!isset($_GET['echostr'])){

            self::receive();

        }else{
            self::checkSignature();
        }
    }

    //验证微信服务器消息
    public static function checkSignature()
    {
        $str  = $_SERVER['REMOTE_ADDR']."\n";
        $str .= $_SERVER['QUERY_STRING'].'有请求ssssss';
        file_put_contents('./log2.txt',$str,FILE_APPEND);

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];

        $token  = 123;
        $tmpArr = array($token,$timestamp,$nonce);
        sort($tmpArr,SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if( $signature == $tmpStr ){
            echo  $_GET["echostr"];
        }else{
          return false;
        }
    }


    //处理请求
    public  static  function  receive(){

        $obj=$GLOBALS['HTTP_RAW_POST_DATA'];
        $postSql=simplexml_load_string($obj,'SimpleXMLElement',LIBXML_NOCDATA);


        self::logger("接受：\n".$obj);

        if(!empty($postSql)){

            switch(trim($postSql->MsgType)){

                case "text" :
                    $result=self::receiveSocket($postSql);
                    break;
                case "event" :
                    $result=self::receiveEvent($postSql);
                    break;

            }

            if(!empty($result)){
                echo $result;

            }else{

                $xml="<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
					  </xml>";
                echo $result=sprintf($xml,$postSql->FromUserName,$postSql->ToUserName,time(),$postSql->MsgType,"没有这条文本消息");

            }
        }
    }


    //处理文本消息
    private static function receiveSocket($postSql){

        $result = '';

        $content=trim($postSql->Content);
        if(strstr($content,"你好")){
            $result = self::receiveText($postSql);

        }elseif (strstr($content,"单图文")){
            $result = self::receiveImage($postSql);

        }elseif (strstr($content,"多图文")){
            $result = self::receiveImages($postSql);

        }elseif (strstr($content,"图片")){
            $result = self::receiveMedia($postSql);
        }

        return $result;
    }


    //处理事件消息
    private static function receiveEvent($postSql){

        $xml="<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
					  </xml>";

        $result=sprintf($xml,$postSql->FromUserName,$postSql->ToUserName,time(),'text',"欢迎关注斌仔微信公众号");

        return $result; 
    }


    //回复文本消息
    private static function receiveText($postSql){

        $xml="<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
					  </xml>";

        $result=sprintf($xml,$postSql->FromUserName,$postSql->ToUserName,time(),$postSql->MsgType,"hello");

        return $result;
    }


    //回复单图文信息
    private static function receiveImage($postSql){

        $xml="<xml> 
                        <ToUserName><![CDATA[%s]]></ToUserName> 
                        <FromUserName><![CDATA[%s]]></FromUserName> 
                        <CreateTime>%s</CreateTime> 
                        <MsgType><![CDATA[%s]]></MsgType> 
                        <ArticleCount>1</ArticleCount>
                        <Articles>
                        <item>
                        <Title><![CDATA[%s]]></Title>
                        <Description><![CDATA[%s]]></Description>
                        <PicUrl><![CDATA[%s]]></PicUrl>
                        <Url><![CDATA[%s]]></Url>
                        </item>
                        </Articles>
                      </xml>";

        $result=sprintf($xml,$postSql->FromUserName,$postSql->ToUserName,time(),'news','测试图片','我iuwuecuwhciwcwuwcucuiw微蹙催我',"https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=2279708952,4010303640&fm=200&gp=0.jpg",'www.aslegou.top');

        return $result;
    }


    //回复多图文信息
    private static function receiveImages($postSql){

        $content= array(array('title'=>'测试图片','Description'=>'测试图片','PicUrl'=>'https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=2279708952,4010303640&fm=200&gp=0.jpg','Url'=>'www.aslegou.top'),
            array('title'=>'测试图片','Description'=>'测试图片','PicUrl'=>'https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=2279708952,4010303640&fm=200&gp=0.jpg','Url'=>'www.aslegou.top'),
            array('title'=>'测试图片','Description'=>'测试图片','PicUrl'=>'https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=2279708952,4010303640&fm=200&gp=0.jpg','Url'=>'www.aslegou.top'),
            array('title'=>'测试图片','Description'=>'测试图片','PicUrl'=>'https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=2279708952,4010303640&fm=200&gp=0.jpg','Url'=>'www.aslegou.top'));
        $str = ' <item>
                        <Title><![CDATA[%s]]></Title>
                        <Description><![CDATA[%s]]></Description>
                        <PicUrl><![CDATA[%s]]></PicUrl>
                        <Url><![CDATA[%s]]></Url>
                        </item>';
        $newStr = '';
        foreach ($content as $key){
            $newStr .=$result=sprintf($str,$key['title'],$key['Description'],$key['PicUrl'],$key['Url']);
        }


        $xml="<xml> 
                        <ToUserName><![CDATA[%s]]></ToUserName> 
                        <FromUserName><![CDATA[%s]]></FromUserName> 
                        <CreateTime>%s</CreateTime> 
                        <MsgType><![CDATA[%s]]></MsgType> 
                        <ArticleCount>%s</ArticleCount>
                        <Articles>
                            $newStr
                        </Articles>
                      </xml>";

        $result=sprintf($xml,$postSql->FromUserName,$postSql->ToUserName,time(),'news',count($content));

        return $result;
    }


    //回复图片
    private static function receiveMedia($postSql){


        $xml="<xml> 
                <ToUserName><![CDATA[%s]]></ToUserName> 
                <FromUserName><![CDATA[%s]]></FromUserName> 
                <CreateTime>%s</CreateTime> 
                <MsgType><![CDATA[%s]]></MsgType> 
                <Image>
                 <MediaId><![CDATA[%s]]></MediaId>
                </Image>
              </xml>";


        $result=sprintf($xml,$postSql->FromUserName,$postSql->ToUserName,time(),'image',"FnGwMjJ3q9mOW1qvRMB_dOLAEw7-lvlphQI7BIodlZy67UdXnHC2KTqz3vwFowC8");
        self::logger("发送：\n".$result);
        return $result;

    }

    private static function logger($content){
        $logSize=100000;

        $log="./log.txt";

        if(file_exists($log) && filesize($log)  > $logSize){
            unlink($log);
        }

        file_put_contents($log,date('H:i:s')." ".$content."\n",FILE_APPEND);

    }



}
