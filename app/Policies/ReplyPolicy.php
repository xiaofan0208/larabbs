<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Reply $reply)
    {
        // 只能删除 自己话题下面的留言 或者 删除自己在别人话题下面的留言
        return  $user->isAuthorOf( $reply ) || $user->isAuthorOf( $reply->topic ) ;
    }
}
