<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//这玩意使用了就不需要去使用mysql的查询语句去使用这些东西了,几乎就是直接用他自带的方法去让字段和数据库去匹配所有的东西;
use Auth;

class SessionController extends Controller
{
    //
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {   //先将用户传过来的数据验证是否符合正常的规则
        $credentials = $this->validate($request,[
            'email' => 'required|email|max;255',
            'password'=>'required'
        ]);
        return;

    //如果第一步验证通过,数据用Auth::attempt方法将传过来的数据拿去和数据库进行去比对
    if (Auth::attempt($credentials))
     {
            # code...登录后的相关操作

        }else{
            //登陆失败后的相关操作

        }
        return;
    }
    }


