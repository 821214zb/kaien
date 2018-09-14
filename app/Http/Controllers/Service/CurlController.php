<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Entity\Category;
use App\Models\M3Result;

class CurlController extends Controller
{
  public static function getCurl($url,$data=null)
  {
      //初始化
      $curl = curl_init();
      //设置抓取的url
      curl_setopt($curl, CURLOPT_URL, $url);
      //设置头文件的信息作为数据流输出
      //curl_setopt($curl, CURLOPT_HEADER, 1);
      //设置获取的信息以文件流的形式返回，而不是直接输出。
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      //设置post方式提交
      if(!empty($data)){
          curl_setopt($curl, CURLOPT_POST, 1);

          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      }

      //执行命令
      $result = curl_exec($curl);
      //关闭URL请求
      curl_close($curl);
      //显示获得的数据
      return $result;
  }

  //获取access_token
  public static function get_access_token(){

    $appId  = 'wxa189887aa8051626';
    $secret = '26eeb8add58caa2e6cbb60941bd5e78d';
    $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appId.'&secret='.$secret;
    
    $access_token = json_decode(self::getCurl($url))->access_token;
    return $access_token;
  }

    //获取媒体资源的media_id
    public static function get_media_id(){

        $access_token = self::get_access_token();
        $type  = 'image';
        $path  =public_path().'/images/1.jpg';

        //根据php的版本不同选择不同方式组装媒体路数组
        //$data = array('media'=>'@'.$path); 5.6之前
        $data = array('media'=> new \CURLFile(realpath($path)));//5.6之后

        $url = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$access_token.'&type='.$type;
        $media_id = self::getCurl($url,$data);

        return $media_id;
    }

    //自定义菜单
    public static function get_menu(){
        $access_token = self::get_access_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;
        $data = '
        {
    "button": [
     
        {
            "name": "发图", 
            "sub_button": [
                {
                    "type": "pic_sysphoto", 
                    "name": "系统拍照发图", 
                    "key": "rselfmenu_1_0", 
                   "sub_button": [ ]
                 }, 
                {
                    "type": "pic_photo_or_album", 
                    "name": "拍照或者相册发图", 
                    "key": "rselfmenu_1_1", 
                    "sub_button": [ ]
                }, 
         
            ]
        }, 
        {
            "name": "发送位置", 
            "type": "location_select", 
            "key": "rselfmenu_2_0" 
        },
        {
           "type": "media_id", 
           "name": "图片", 
           "media_id": "MEDIA_ID1"
        }, 
        {
           "type": "view_limited", 
           "name": "图文消息", 
           "media_id": "MEDIA_ID2"
        }
    ]
}';
        
        $get_menu = self::getCurl($url,$data);
        return$get_menu;
 
    }
}
