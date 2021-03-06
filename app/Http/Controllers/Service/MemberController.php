<?php

namespace App\Http\Controllers\service;

use  App\Http\Controllers\Controller;
use  App\Models\M3Result;
use  Illuminate\Http\Request;
use  App\Entity\TmpPhone;
use  App\Entity\TmpEmail;
use  App\Entity\Member;
use  App\Models\M3Email;
use  App\Tool\UUID;
use  App\Jobs\SendEmail;
use  Carbon\Carbon;
class MemberController extends Controller
{
    //注册接口
    function register(Request $request){

        $email = $request->input('email', '');
        $phone = $request->input('phone', '');
        $password = $request->input('password', '');
        $confirm = $request->input('confirm', '');
        $phone_code = $request->input('phone_code', '');
        $validate_code = $request->input('validate_code', '');

        $m3_result = new M3Result;

        if($email == '' && $phone == '') {
            $m3_result->status = 1;
            $m3_result->message = '手机号或邮箱不能为空';
            return $m3_result->toJson();
        }
        if($password == '' || strlen($password) < 6) {
            $m3_result->status = 2;
            $m3_result->message = '密码不少于6位';
            return $m3_result->toJson();
        }
        if($confirm == '' || strlen($confirm) < 6) {
            $m3_result->status = 3;
            $m3_result->message = '确认密码不少于6位';
            return $m3_result->toJson();
        }
        if($password != $confirm) {
            $m3_result->status = 4;
            $m3_result->message = '两次密码不相同';
            return $m3_result->toJson();
        }
        
        if($phone !=''){//手机验证
            if($phone_code == '' || strlen($phone_code) < 6){
                $m3_result->status = 5;
                $m3_result->message = '手机验证码为6位数字';
                return $m3_result->toJson();
            }
            
            $phone_date = TmpPhone::where('phone',$phone)->first();

            if($phone_date->dateline < time() ){
                
                $m3_result->status = 6;
                $m3_result->message = '验证码已经失效';
                return $m3_result->toJson();
            }elseif($phone_date->code != $phone_code){

                $m3_result->status = 7;
                $m3_result->message = '验证码不正确';
                return $m3_result->toJson();
            }

            //验证通过储存数据库member表
            $member = new Member;
            $member->phone = "$phone";
            $member->pwd   = md5('bk' . $password);
            $member->save();
            
        }else{
            set_time_limit(0);
            //邮箱验证
            if($validate_code == '' || strlen($validate_code) != 4) {
                $m3_result->status = 6;
                $m3_result->message = '验证码为4位';
                return $m3_result->toJson();
            }

            $validate_code_session = $request->session()->get('validate_code', '');
            if($validate_code_session != $validate_code) {
                $m3_result->status = 8;
                $m3_result->message = '验证码不正确';
                return $m3_result->toJson();
            }

            $member = new Member;
            $member->email = $email;
            $member->pwd = md5('bk' . $password);
            $member->save();


            $uuid = UUID::create();
//
            $m3_email = new M3Email;
            $m3_email->to = $email;
            $m3_email->cc = '757849673@qq.com';
            $m3_email->subject = '凯恩书店验证';
            $m3_email->content = '请于24小时点击该链接完成验证. http://www.kaien.com/service/validate_email'
                . '?member_id=' . $member->id
                . '&code=' . $uuid;

            $tempEmail = new TmpEmail;
            $tempEmail->member_id = $member->id;
            $tempEmail->code = $uuid;
            $tempEmail->dateline = time() + 300;
            $tempEmail->save();

            //发送邮件
//            SendEmail::handle($m3_email);
            $job = (new SendEmail($m3_email))
                ->delay(Carbon::now()->addMinutes(5));
            dispatch($job);
//           $this->dispatch(new SendEmail($m3_email));
        }

        $m3_result->status = 0;
        $m3_result->message = '注册成功';
        return $m3_result->toJson();
    }

    public function login(Request $request) {
        $username = $request->get('username', '');
        $password = $request->get('password', '');
        $validate_code = $request->get('validate_code', '');

        $m3_result = new M3Result;

        // 校验
        // ....

        // 判断
        // $validate_code_session = $request->session()->get('validate_code');
        // if($validate_code != $validate_code_session) {
        //   $m3_result->status = 1;
        //   $m3_result->message = '验证码不正确';
        //   return $m3_result->toJson();
        // }

        $member = null;
        if(strpos($username, '@') == true) {
            $member = Member::where('email', $username)->first();
        } else {
            $member = Member::where('phone', $username)->first();
        }

        if($member == null) {
            $m3_result->status = 2;
            $m3_result->message = '该用户不存在';
            return $m3_result->toJson();
        } else {
            if(md5('bk' .$password) != $member->pwd) {
                $m3_result->status = 3;
                $m3_result->message = '密码不正确';
                return $m3_result->toJson();
            }
        }

        $request->session()->put('member', $member);//将用户信息存入session


        $m3_result->status = 0;
        $m3_result->message = '登录成功';
        return $m3_result->toJson();
    }


    //退出登录方法
    public function toExit(Request $request)
    {
        $request->session()->forget('member');
        return view('login');
    }




}
