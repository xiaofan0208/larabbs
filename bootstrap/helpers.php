<?php
// 将当前请求的路由名称转换为 CSS 类名称，作用是允许我们针对某个页面做页面样式定制
function route_class()
{
    //把当前路由中的'.'改为'-'连接
    return str_replace('.','-', Route::currentRouteName() );
}