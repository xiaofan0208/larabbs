<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;


class TopicPolicy extends Policy
{
    // 编辑文章时，只有当话题关联作者的 ID 等于当前登录用户 ID 时候才放行
    public function update(User $user, Topic $topic)
    {
   //     return $topic->user_id == $user->id;
        return $user->isAuthorOf($topic);
    }

    public function destroy(User $user, Topic $topic)
    {
    //    return $topic->user_id == $user->id ;
        return $user->isAuthorOf($topic);
    }
}
