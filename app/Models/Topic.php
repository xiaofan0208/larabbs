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

    public function scopeWithOrder($query , $order)
    {
        switch($order){
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }
        // 预加载防止 N+1 问题
        return $query->with('user','category');
    }
    // 按照最新回复排列
    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at' , 'desc');
    }

    public function scopeRecent($query)
    {
        // // 按照创建时间排序
        return $query->orderBy('created_at','desc');
    }
}
