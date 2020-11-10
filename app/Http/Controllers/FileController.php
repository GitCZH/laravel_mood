<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-09
 * Time: 上午 11:53
 */
namespace App\Http\Controllers;
use App\Entity\File;
use App\Result\ResponseResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    //允许上传的图片类型
    protected static $imgType = [
        'jpeg', 'jpg', 'png', 'gif',
    ];
    //图片最大5M
    protected static $imgSize = 5 * 1024 * 1024;
    //图片路径
    protected static $imgPath = "imgs/upload";

    protected static $docType = [

    ];

    //上传图片页面
    public function uploadImgPage()
    {
        return view("file/img/upload");
    }

    /**
     * 保存图片
     * @param Request $request
     * @return array
     */
    public function saveImg(Request $request)
    {
        //获取上传文件的类型
        $fileType = $request->get("fileType");
//        var_dump($request->file('file')->store("imgs/"));
        $uploadFileObj = $request->file('file');
        if (is_null($uploadFileObj)) {
            return ResponseResult::getResponse(ResponseResult::FAIL_PARAM_ILLEGAL);
        }
        //获取文件后缀名
        $originFilename = $uploadFileObj->getClientOriginalName();
        //判断文件信息
        if (!in_array($uploadFileObj->getMimeType(), self::$imgType)) {
            return ResponseResult::getResponse(ResponseResult::FAIL_NOT_ALLOWED_UPLOAD_IMG_TYPE);
        }
        //判断文件大小
        if ($uploadFileObj->getSize() > self::$imgSize) {
            return ResponseResult::getResponse(ResponseResult::FAIL_EXCEED_SIZE_UPLOAD);
        }
        //保存文件
        $saveRes = $uploadFileObj->store(self::$imgPath);
        $code = $saveRes === false ? ResponseResult::FAIL_COM : ResponseResult::SUCCESS_COM;
        if ($saveRes) {
            //记录上传成功的图片信息到redis
            $redisHandle = Redis::connection();
            $imgHashKey = Auth::user()->id . "_";
            $redisHandle->set("aa", $saveRes);
        }
        //获取上传后的文件url
        $imgUrl = Storage::url($saveRes);
        $result = [
            'src' => $imgUrl
        ];
        return ResponseResult::getResponse($code, '', $result);
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