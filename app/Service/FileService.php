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
}