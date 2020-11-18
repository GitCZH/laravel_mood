<?php
/**
 * 用户访问记录
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-16
 * Time: 下午 04:59
 */
namespace App\Service\Visit;
use App\Cache\Redis\VisitCache;
use App\Entity\IpVisit;
use Illuminate\Http\Request;

class IpVisitService
{
    /**
     * 记录访问记录
     * @param Request $request
     * @return mixed
     */
    public static function recordVisit(Request $request)
    {
        $ip = $request->getClientIp();
        $uri = $request->getRequestUri();
        //解析uri
        $uriArr = parse_url($uri);
        $shortUri = $uriArr['path'];
        $query = $request->getQueryString();
        !empty($query) ? "" : $query = " ";

        //统计展示页浏览量 默认结尾index的为展示页
        if (strrpos($shortUri, "index")) {
            //pv 浏览量+1
            $visitCache = new VisitCache();
            $visitCache->incPageVisit(0);
            //根据ip统计uv

        }

        $ipVisit = new IpVisit();
        $ipVisit->setIp(ip2long($ip));
        $ipVisit->setUri($shortUri);
        $ipVisit->setQuery($query);
        return \App\Model\IpVisit::create($ipVisit->getDbArray());
    }
}