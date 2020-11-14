<?php
/**
 * 文件处理逻辑服务层
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-10
 * Time: 下午 02:42
 */
namespace App\Service;
use App\Entity\File;
use App\Result\ResponseResult;
use App\Service\File\DocFileCheck;
use App\Service\File\ImgFileCheck;
use App\Service\File\VideoFileCheck;
use App\Service\File\VoiceFileCheck;

class FileService
{
    /**
     * 添加一条上传文件记录
     * @param File $file
     * @return bool
     */
    public function saveFileItem(File $file)
    {
        $fileModel = new \App\Model\File();
        //保存的文件字段
        $data = $file->getDbArray();
        return $fileModel->addFile($data);
    }

    /**
     * 获取文件后缀名
     * @param $filename
     * @return string
     */
    public static function getFileExt($filename)
    {
        return mb_substr($filename, mb_strrpos($filename, '.') + 1);
    }

    /**
     * 检测是否符合图片文件上传条件
     * @param \Illuminate\Http\UploadedFile $file
     * @param $type
     * @return bool | integer
     */
    public function checkFile($file, $type)
    {
        //获取文件后缀名
        $originFilename = $file->getClientOriginalName();
        $fileExt = FileService::getFileExt($originFilename);
        switch ($type) {
            case "img":
                $checkHandle = new ImgFileCheck($file->getSize(), $fileExt);
                break;
            case "doc":
                $checkHandle = new DocFileCheck($file->getSize(), $fileExt);
                break;
            case "voice":
                $checkHandle = new VoiceFileCheck($file->getSize(), $fileExt);
                break;
            case "video":
                $checkHandle = new VideoFileCheck($file->getSize(), $fileExt);
                break;
            default:
                return false;
        }
        if (!$checkHandle->isOk()) {
            if ($checkHandle->getIntercept() == ImgFileCheck::INTERCEPT_TYPE) {
                return ResponseResult::FAIL_NOT_ALLOWED_UPLOAD_IMG_TYPE;
            } elseif ($checkHandle->getIntercept() == ImgFileCheck::INTERCEPT_SIZE) {
                return ResponseResult::FAIL_EXCEED_SIZE_UPLOAD;
            } else {
                return ResponseResult::FAIL_UNEXPECTED_ERR;
            }
        }
        return true;
    }

    /**
     * 获取随机唯一值
     * @param string $prefix
     * @return string
     */
    public static function getUniqueId($prefix = "")
    {
        //日期、时间、title、desc、随机数
        $date = date("YmdHis");
        $prefixSha = empty($prefix) ? substr(sha1("MOOD"), 0, 8) : substr(sha1($prefix), 0, 8);
        $rand = mt_rand(100000, 999999);
        return "{$date}_{$prefixSha}_{$rand}";
    }

    /**
     * 获取自定义生成的文件名
     * @param $originName
     * @param string $prefix
     * @return string
     */
    public static function getUniqueFilename($originName, $prefix = "")
    {
        $timestamp = time();
        $shaStr = $originName . $timestamp;
        return $prefix . substr(sha1($shaStr), 16) . self::getUniqueId();
    }
}