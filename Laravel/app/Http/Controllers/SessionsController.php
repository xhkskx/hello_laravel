<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
     public function __construct()//只有未登录用户才能访问
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    public function create()
    {
        return view('sessions.create');
    }
    
     public function store(Request $request)//用户登录
    {
       $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);

      if(Auth::attempt($credentials, $request->has('remember'))){
           // 登录成功后的相关操作
            session()->flash('success', '欢迎回来！');//闪存
           return redirect()->intended(route('users.show', [Auth::user()]));//redirect() 实例提供了一个 intended 方法，该方法可将页面重定向到上一次请求尝试访问的页面上，并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上。
       } else {
           // 登录失败后的相关操作
           session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
           return redirect()->back();
       }
    }
    
     public function destroy()//用户登出
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('');
    }
}