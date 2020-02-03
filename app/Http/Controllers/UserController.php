<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {    //使用laravel提供的身份认证auth中间件来过滤未登录的用户的edit,在
        $this->middleware('auth',[
            'except' =>['show','create','store','index']
        ]);


        $this->middleware('guest',
            ['only' =>['create']]);

    }
    public function index()
    {
        $users = User::paginate(6);
        return view('users.index',compact('users'));
    }



    //
    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function gravatar($size= '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
            return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
    public function store(Request $request)
    {
        $this->validate($request,[
        'name' => 'required|max:50',
        'email' => 'required|email|unique:users|max:255',
        'password'=> 'required|confirmed|min:6'
        ]);

        //验证完了之后 对所验证的数据进行存储
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        //第一个是会话的键,第二个为会话的值.
        //下次如若再使用的
        session()->flash('sussecss','欢迎,你将在这里开启一段新的旅程');

//user::create()创建成功后会返回一个用户对象,并包含新注册用户的所有信息,我们将新注册用户的所有信息赋值给变量$user,并通过路由跳转来进行数据绑定
        //数据绑定什么值得看一看
//这里是一个约定优于配置的体现,此时$user是User模型对象的实例.route()方法会自动获取Model的主键,也就是数据表users的主键id
        //所以这个数据绑定的其实是他的ID   在路由跳转的同时把ID 传给了路由

        return redirect()->route('users.show',[$user]);
    }



    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));


    }


    public function update(User $user, Request $request)
    {

        $this->authorize('update',$user);




    //在这里是验证了数据
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'required|confirmed|min:6']);

        //准备一个空数组
        $date = [];
        //接收用户可能更改后的名字数据
        $data['name'] = $request->name;
        //如果数据里有更新后的密码,直接把密码和可能更新后的名字一起更改
        if($request->password){
           $data['password'] = bcrypt($request->password);

        //更新之后给的提示
            session()->flash('success','个人资料更新成功');
        $user->update($data);

        return redirect()->route('users.show',$user->id);
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success','成功删除用户!');
        return back();
    }

}


