<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-16
 * Time: 下午 05:49
 */
namespace App\Cache\Redis;
use Illuminate\Support\Facades\Redis;

class VisitCache
{
    private function getPageUvKey()
    {
        return "page_uv_visit";
    }

    private function getPagePvKey()
    {
        return "page_pv_visit";
    }

    public function incPageVisit($type = 0)
    {
        $redisHandle = Redis::connection();
        return $redisHandle->incr($type == 0 ? $this->getPagePvKey() : $this->getPageUvKey());
    }

    public function getPageVisit()
    {
        $redisHandle = Redis::connection();
        return $redisHandle->get($this->getPageKey());
    }
}