<?php

namespace App\Tool\SMS;

use App\Models\M3Result;

class SendTemplateSMS
{
  //主帐号
  private $accountSid='8a216da85f9fd676015fa5bf9419030b';

  //主帐号Token
  private $accountToken='b2eb9da310fc44489d7daba772c62330';

  //应用Id
  private $appId='8a216da85f9fd676015fa5bf94790312';

  //请求地址，格式如下，不需要写https://
  private $serverIP='sandboxapp.cloopen.com';

  //请求端口
  private $serverPort='8883';

  //REST版本号
  private $softVersion='2013-12-26';

  /**
    * 发送模板短信
    * @param to 手机号码集合,用英文逗号分开
    * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
    * @param $tempId 模板Id
    */
    public function sendTemplateSMS($to,$datas,$tempId)
    {
        $m3_result = new M3Result;

        // 初始化REST SDK
        $rest = new CCPRestSDK($this->serverIP,$this->serverPort,$this->softVersion);
        $rest->setAccount($this->accountSid,$this->accountToken);
        $rest->setAppId($this->appId);

        // 发送模板短信
        //  echo "Sending TemplateSMS to $to <br/>";
        $result = $rest->sendTemplateSMS($to,$datas,$tempId);
        if($result == NULL ) {
            $m3_result->status = 3;
            $m3_result->message = 'result error!';
        }

        //转译下短信接口返回的参数
        $statusCode = json_decode(json_encode($result->statusCode),true)[0];
        if($statusCode != 0) {
            $m3_result->status = $statusCode;
            $m3_result->message = json_decode(json_encode($result->statusMsg),true)[0];
        }else{
            $m3_result->status = 0;
            $m3_result->message = '发送成功';
        }

        return $m3_result;
    }
}

//sendTemplateSMS("18576437523", array(1234, 5), 1);
