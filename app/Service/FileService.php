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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
}