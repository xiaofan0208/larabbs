<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    //显示用户个人信息页面
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }
    //显示编辑个人资料页面
    public function edit()
    {

    }
    //处理 edit 页面提交的更改
    public function update()
    {

    }
}
