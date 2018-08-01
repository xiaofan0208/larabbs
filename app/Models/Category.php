<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// 分类模型
class Category extends Model
{
    protected $fillable = [
        'name','description'
    ];
}
