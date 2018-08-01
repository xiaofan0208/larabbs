<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler ;

class UsersController extends Controller
{
    public function __construct()
    {
        /*  设定 指定动作 不使用 Auth 中间件进行过滤
            除了此处指定的动作以外，所有其他动作都必须登录用户才能访问
        */
        $this->middleware('auth',['except' => ['show'] ]);
    }

    //显示用户个人信息页面
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }
    //显示编辑个人资料页面
    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }
    //处理 edit 页面提交的更改
    public function update(UserRequest $request , ImageUploadHandler $uploader ,  User $user )
    {
        $this->authorize('update',$user);
        $data = $request->all();
        if( $request->avatar ){
            $result =  $uploader->save( $request->avatar  , 'avatars' , $user->id , 362) ;
            if( $result ){
                $data['avatar'] = $result['path'];
            }
        }

        $user->update(  $data );
        return redirect()->route('users.show',$user->id)->with('success','个人资料更新成功！') ;
    }
}
