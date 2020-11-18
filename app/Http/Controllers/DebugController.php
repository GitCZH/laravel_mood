<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-16
 * Time: 下午 04:27
 */
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class DebugController
{
    public function debugRequest(Request $request)
    {
        dump($request->getClientIps());
        dump($request->getUri());
        dump($request->getQueryString());
        dump($request->getRequestUri());
        dump(parse_url($request->getRequestUri()));
        dump($request);
    }
}