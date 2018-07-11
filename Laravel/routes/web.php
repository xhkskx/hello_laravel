<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/home', 'StaticPagesController@home')->name('backhome');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');


//user 用户注册
Route::get('signup', 'UsersController@create')->name('signup');
//user路由
Route::resource('users', 'UsersController');
/*
 * 可以看到使用 resource 方法让我们少写了很多代码，且严格按照了 RESTful 架构对路由进行设计。

生成的资源路由列表信息如下所示：

HTTP 请求	URL	动作	作用
GET	/users	UsersController@index	显示所有用户列表的页面
GET	/users/{user}	UsersController@show	显示用户个人信息的页面
GET	/users/create	UsersController@create	创建用户的页面
POST	/users	UsersController@store	创建用户
GET	/users/{user}/edit	UsersController@edit	编辑用户个人资料的页面
PATCH	/users/{user}	UsersController@update	更新用户
DELETE	/users/{user}	UsersController@destroy	删除用户
 */
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');