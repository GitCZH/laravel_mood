<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ClickLikeStat extends Model
{
    //
    protected $table = "user_likes_stat";
    protected $fillable = [
        'content_type', 'content_id', 'count',
    ];
    public $timestamps =false;

    /**
     * 点赞
     * @param $likeFields
     * @return int
     */
    public function addLike($likeFields)
    {
        //判断是否存在
        $statItem = $this->where('content_type', '=', $likeFields['content_type'])
            ->where('content_id', '=', $likeFields['content_id'])
            ->first();
        //不存在，添加
        if (empty($statItem) || empty($statItem->toArray())) {
            return $this->insertGetId($likeFields);
        }
        //存在，自增数目
        return $this->where('content_type', '=', $likeFields['content_type'])
            ->where('content_id', '=', $likeFields['content_id'])
            ->increment('count');

    }

}
