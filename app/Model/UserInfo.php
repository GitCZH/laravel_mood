<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    //
    protected $table = "user_info";
    protected $fillable = [
        'uid', 'nickname', 'avatar', 'ctime', 'born', 'sex', 'age', 'user_state'
    ];

    public function getUserInfoByUid($uid)
    {

    }
}
