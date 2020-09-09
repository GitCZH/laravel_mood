<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 根据用户id获取用户数据
     * @param $ids
     * @return array
     */
    public function getUserByIds($ids)
    {
        return $this->whereIn('id', $ids)
            ->select(['id', 'name'])
            ->get()->toArray();
    }
}
