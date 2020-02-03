<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//这玩意使用了就不需要去使用mysql的查询语句去使用这些东西了,几乎就是直接用他自带的方法去让字段和数据库去匹配所有的东西;
use Auth;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest',
            ['only' =>['create']]);
    }





    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {   //先将用户传过来的数据验证是否符合正常的规则
        $credentials = $this->validate($request,[
            'email' => 'required|email|max:255',
            'password'=>'required'
        ]);

    //如果第一步验证通过,数据用Auth::attempt方法将传过来的数据拿去和数据库进行去比对
    if (Auth::attempt($credentials,$request->has('remember')))
     {
            # code...登录后的相关操作
        session()->flash('success','欢迎回来');
        $fallback = route('users.show',Auth::user());
        return redirect()->intended($fallback);

        }else{
            //登陆失败后的相关操作
            session()->flash('dange','很抱歉,您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
        return;
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已成功退出');
        return redirect('login');


    }






}


