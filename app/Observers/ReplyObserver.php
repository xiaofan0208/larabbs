<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    // 数据成功创建时，created 方法将会被调用。
    public function created(Reply $reply)
    {
        $reply->topic->increment('reply_count',1) ;
    }
    // 对 content 字段进行净化处理
    public function creating(Reply $reply)
    {
        $reply->content = clean( $reply->content,'user_topic_body' );
    }

}