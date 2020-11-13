<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-05
 * Time: 下午 06:07
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use app\Service\SendMsg;

class MsgController extends Controller
{
    public function sendRegMsg()
    {
        $phone = [
            '+8618655959420'
        ];
        $code = [
            '888899'
        ];
        SendMsg::send($phone, $code);
    }
}