<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    //获取到话题对应的分类
    public function category()
    {
        //一个话题属于一个分类
        return $this->belongsTo(Category::class);
    }
    //话题对应的作者
    public function user()
    {
        //一个话题拥有一个作者。
        return $this->belongsTo(User::class);
    }

}
