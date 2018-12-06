<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//处理所有自定义页面的逻辑
class PagesController extends Controller
{
    //处理首页的展示
    public function root()
    {
        return view('pages.root');
    }

    // 无权限提醒
    public function permissionDenied()
    {
        // 如果当前用户有权限访问后台，直接跳转访问
        if( config('administrator.permission')() ){
            return redirect( url( config('administrator.uri') ) , 302 );
        }
        // 否则使用视图
        return view('pages.permission_denied');
    }
}
