<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Topic;

class User extends Authenticatable
{
    use Notifiable;

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
}
