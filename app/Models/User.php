<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Topic;
use Auth;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    
    use Notifiable {
        notify as protected laravelNotify ;// 把系统的notify重命名为laravelNotify
    }
    // 对notify的重写
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if( $this->id == Auth::id() ){
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [     // 可以写入的字段
        'name', 'email', 'password','introduction','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // 用户与话题中间的关系是 一对多 的关系，一个用户拥有多个主题
    public function topics()
    {
        return $this->hasMany( Topic::class );
    }
    // 是否是作者
    public function isAuthorOf( $model )
    {
        return $this->id == $model->user_id ;
    }

    // 一个用户可以拥有多条评论
    public function replies()
    {
        return $this->hasMany(Reply::class );
    }

    // 清空未读消息数
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead() ;
    }
}
