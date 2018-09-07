<?php

namespace App\Http\Controllers\Service;

use  App\Http\Controllers\Controller;
use  App\Tool\ValidateCode\ValidateCode;
use  App\Tool\SMS\SendTemplateSMS;
use  App\Models\M3Result;
use  Illuminate\Http\Request;
use  App\Entity\TmpPhone;
use  App\Entity\TmpEmail;
use  App\Entity\Member;
class ValidateCodeController extends Controller
{
    //返回图形验证码
    function CreateCode(Request $request){

        $codeObj = new ValidateCode;
        $request->session()->put('validate_code', $codeObj->getCode());//验证码存入session中
        return  $codeObj->doimg();
    }

    //获取手机验证码

    function sendSMS(Request $request){

        $m3_result = new M3Result;

        $phone = $request->input('phone', '');
        if($phone == '') {
            $m3_result->status = 1;
            $m3_result->message = '手机号不能为空';
            return $m3_result->toJson();
        }
        if(strlen($phone) != 11 || $phone[0] != '1') {
            $m3_result->status = 2;
            $m3_result->message = '手机格式不正确';
            return $m3_result->toJson();
        }

        $sendTemplateSMS = new SendTemplateSMS;
        $code = '';
        $charset = '1234567890';
        $_len = strlen($charset) - 1;
        for ($i = 0;$i < 6;++$i) {
            $code .= $charset[mt_rand(0, $_len)];
        }
        $m3_result = $sendTemplateSMS->sendTemplateSMS($phone, array($code, 60), 1);
      
        if($m3_result->status == 0) {
            $tempPhone = TmpPhone::where('phone', $phone)->first();
            if($tempPhone == null) {
                $tempPhone = new TmpPhone;
            }
            $tempPhone->phone = $phone;
            $tempPhone->code = $code;
            $tempPhone->dateline = time() + 300;
            $tempPhone->save();
        }
       
        return $m3_result->toJson();
    }


    //邮箱激活验证
    public function validateEmail(Request $request)
    {
        $member_id = $request->input('member_id', '');
        $code = $request->input('code', '');
        if($member_id == '' || $code == '') {
            return '验证异常';
        }

        $tempEmail = TmpEmail::where('member_id', $member_id)->first();
        if($tempEmail == null) {
            return '验证异常';
        }

        if($tempEmail->code == $code) {
            if(time() > strtotime($tempEmail->dateline)) {
                return '该链接已失效';
            }

            $member = Member::find($member_id);
            $member->active = 1;
            $member->save();

            return redirect('/login');
        } else {
            return '该链接已失效';
        }
    }




}
