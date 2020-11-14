<?php
/**
 * 文件数据缓存
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-14
 * Time: 上午 11:02
 */
namespace App\Cache\Redis;

use Illuminate\Support\Facades\Redis;

class FileCache
{
    private function getUploadStatKey($uid)
    {
        return "upload_{stat}_uid_{$uid}";
    }

    /**
     * 统计用户上传数量，根据类型区分
     * @param $uid
     * @param $type
     * @return int
     */
    public function statUpload($uid, $type)
    {
        $redisHandle = Redis::connection();
        $statKey = $this->getUploadStatKey($uid);
        if ($redisHandle->hexists($statKey, $type)) {
            return $redisHandle->hsetnx($statKey, $type, 1);
        } else {
            return $redisHandle->hincrby($statKey, $type, 1);
        }
    }

    /**
     * 获取用户上传数量
     * @param $uid
     * @return array
     */
    public function getStatUpload($uid)
    {
        $redisHandle = Redis::connection();
        $statKey = $this->getUploadStatKey($uid);
        return $redisHandle->hgetall($statKey);
    }
}