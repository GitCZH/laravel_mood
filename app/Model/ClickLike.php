<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ClickLike extends Model
{
    //
    protected $table = "user_likes";
    protected $fillable = [
        'content_type', 'click_uid', 'content_id', 'ctime',
    ];
    public $timestamps =false;

    /**
     * 点赞
     * @param $likeFields
     * @return int
     */
    public function addLike($likeFields)
    {
        return $this->insertGetId($likeFields);
    }

    /**
     * 判断是否已点赞
     * @param $contentType
     * @param $contentId
     * @return array
     */
    public function isClick($contentType, $contentId)
    {
        $collection = $this->where('content_type', '=', $contentType)
            ->where('content_id', '=', (int)$contentId)
            ->first();
        return empty($collection) ? [] : $collection->toArray();
    }

    /**
     * 根据用户和内容id获取点赞数据
     * @param $uid
     * @param $contentType
     * @param $contentId
     * @return array
     */
    public function getLikeForUser($uid, $contentType, $contentId)
    {
        $items = $this->where('click_uid', '=', (int)$uid)
            ->where('content_type', '=', $contentType)
            ->whereIn('content_id', $contentId)
            ->get();
        return empty($items) ? [] : $items->toArray();
    }

    /**
     * 获取用户获取的点赞数
     * @param $uid
     * @return int
     */
    public function getReceiveLikeStat($uid)
    {
        return $this->where('for_uid', '=', (int)$uid)
            ->count();
    }
}
