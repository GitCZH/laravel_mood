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
use App\Service\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {

    }

    /**
     * 上传图片页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadFilePage()
    {
        return view("file/img/upload");
    }

    /**
     * 保存用户上传文件
     * @param Request $request
     * @return array
     */
    public function storeFileUploadInfo(Request $request)
    {
        //获取参数
        $title = $request->get('title', '');
        $desc = $request->get('desc', '');
        $coverUrl = $request->get('cover_url', '');
        $fileUrl = $request->get('fileListInfo', '');
        $fileType = $request->get('fileType', '');
        $file = new File();
        //文件类型 图片 语音 文档 视频
        $file->setFileType($fileType);
        $file->setDesc($desc);
        $file->setTitle($title);
        $file->setCover($coverUrl);
        $file->setUid(Auth::user()->id);
        //生成每次上传的唯一id TODO使用雪花算法生成唯一id
        $file->setIdentifyId(FileService::getUniqueId($title . $desc));
        $saveRes = [];
        foreach ($fileUrl as $tmpFile) {
            $file->setFileUrl($tmpFile['src']);
            //获取图片基本信息
            $file->setFileSize($tmpFile['size']);
            //获取后缀名
            $file->setMineType(FileService::getFileExt($tmpFile['src']));
            //添加图片
            $addRes = $file->add();
            if ($addRes instanceof \App\Model\File) {
                continue;
            }
            //保存失败
            $saveRes['filename'][] = $tmpFile['src'];
            //删除文件
            Storage::delete($tmpFile['src']);
        }
        $code = !empty($saveRes) ? ResponseResult::FAIL_SERVICE_ADD : ResponseResult::SUCCESS_COM;
        return ResponseResult::getResponse($code);
    }

    /**
     * 上传封面接口
     * @param Request $request
     * @return array
     */
    public function uploadFileCover(Request $request)
    {
        $uploadFileObj = $request->file('file');
        return $this->saveImg($uploadFileObj);
    }

    /**
     * 保存文件
     * @param Request $request
     * @return array
     */
    public function saveFile(Request $request)
    {
        //获取上传文件的类型
        $fileType = $request->get("fileType");
        $uploadFileObj = $request->file('file');
        switch ($fileType) {
            case "1":
                return $this->saveImg($uploadFileObj);
                break;
            case "2":
                return $this->saveDoc($uploadFileObj);
                break;
            case "3":
                return $this->saveVoice($uploadFileObj);
                break;
            case "4":
                return $this->saveVideo($uploadFileObj);
                break;
            default:
                return ResponseResult::getResponse(ResponseResult::FAIL_PARAM_ILLEGAL);
        }
    }

    /**
     * 保存图片
     * @param \Illuminate\Http\UploadedFile $uploadFileObj
     * @return array
     */
    public function saveImg($uploadFileObj)
    {
        if (is_null($uploadFileObj)) {
            return ResponseResult::getResponse(ResponseResult::FAIL_PARAM_ILLEGAL);
        }
        //图片上传检查
        $checkRes = $this->checkImgFile($uploadFileObj);
        if ($checkRes !== true) {
            return ResponseResult::getResponse($checkRes);
        }
        //保存文件
        $saveRes = $uploadFileObj->storeAs(File::$pathMap[1], $uploadFileObj->getClientOriginalName());
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
            'src' => $imgUrl,
            'size' => $uploadFileObj->getSize()
        ];
        return ResponseResult::getResponse($code, '', $result);
    }

    /**
     * 检测是否符合图片文件上传条件
     * @param \Illuminate\Http\UploadedFile $file
     * @return bool | integer
     */
    public function checkImgFile($file)
    {
        //获取文件后缀名
        $originFilename = $file->getClientOriginalName();
        $fileExt = FileService::getFileExt($originFilename);
        if (!in_array($fileExt, File::$typeMap[1])) {
            return ResponseResult::FAIL_NOT_ALLOWED_UPLOAD_IMG_TYPE;
        }
        if ($file->getSize() > File::$sizeMap[1]) {
            return ResponseResult::FAIL_EXCEED_SIZE_UPLOAD;
        }
        return true;
    }

    public function saveDoc($uploadFileObj)
    {

    }

    public function saveVoice($uploadFileObj)
    {

    }

    public function saveVideo($uploadFileObj)
    {

    }

    /**
     * 删除文件
     * @param Request $request
     * @return array
     */
    public function removeFile(Request $request)
    {
        $file = $request->get("filename");
        $fileType =$request->get("fileType");
        if (!isset(File::$pathMap[$fileType])) {
            return ResponseResult::getResponse(ResponseResult::FAIL_PARAM_ILLEGAL);
        }
        $path = File::$pathMap[$fileType];
        $filename = $path . '/' . $file;
        $delRes = Storage::delete($filename);
        $code = $delRes === true ? ResponseResult::SUCCESS_COM : ResponseResult::FAIL_SERVICE_DEL;
        return ResponseResult::getResponse($code, "删除文件成功");
    }

    /**
     * 获取brand图片
     * @return array
     */
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