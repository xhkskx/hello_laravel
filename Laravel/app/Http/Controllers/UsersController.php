<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;
class UsersController extends Controller
{
        public function __construct()//设置登录才能访问的权限，除了show、create、store页面
    {
        $this->middleware('auth', [            
            'except' => ['show', 'create', 'store','index']
        ]);
        //只让未登录用户访问
         $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    public function index()//用户列表
    {
        
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }
    public function create()
    {
        
        return view('users.create');
    }
    
    
     public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    
    
       public function store(Request $request)
    {
       
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
       Auth::login($user);
       session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);;
    }
    
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    
    
    //更新用户资料
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);
        $this->authorize('update', $user);//这里检查用户权限是否是修改自己的资料
        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user->id);
    }
    
    //删除用户
    public function destroy (User $user){
       $this->authorize('destroy', $user);
       
        $user->delete();
        session()->flash('susccess','成功删除用户');
        return back();
    }
    
    
}