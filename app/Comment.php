<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'comment'
    ];

    // いかに投稿者との紐付けを行う

     public function user(){
      return $this->belongsTo(\App\User::class,'user_id');
    }
}
