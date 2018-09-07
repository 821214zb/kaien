<?php

namespace App\Http\Controllers\View;

use  App\Http\Controllers\Controller;
use  App\Tool\ValidateCode\ValidateCode;
use  Illuminate\Http\Request;
class MemberController extends Controller
{
    //登录界面
    function ToLogin(Request $request){

        $member = $request->session()->get('member');
        if($member == ''){
            $url = urldecode($request->input('return_url'));
            return  view('login')->with('return_url',$url);
        }else{
            return redirect('/view/category');
        }

    }

    
    //注册界面
    function ToRegister(){
        
        return  view('register');
    }


}
