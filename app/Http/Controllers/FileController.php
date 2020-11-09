<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-09
 * Time: 上午 11:53
 */
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function uploadImgPage()
    {
        return view("file/img/upload");
    }

    public function saveImg(Request $request)
    {
        dump($request->file());
    }

    public function getNav()
    {
        $result = [
            'error_code' => 0,
            'error_msg' => 'success',
            'result' => asset("imgs/brand.png")
        ];
        return $result;
    }
}