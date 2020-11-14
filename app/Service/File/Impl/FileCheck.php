<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-14
 * Time: 上午 10:14
 */
namespace App\Service\File\Impl;
abstract class FileCheck
{
    //文件大小限制
    protected $limitSize = 0;
    //文件类型限制
    protected $limitType = [];
    //文件大小
    private $fileSize = 0;
    //文件的类型
    private $fileType = "";
    //检测失败的原因 1|type 2|size
    private $intercept = 0;

    const INTERCEPT_TYPE = 1;
    const INTERCEPT_SIZE = 2;

    /**
     * FileCheck constructor.
     * @param int $fileSize
     * @param string $fileType
     */
    public function __construct($fileSize, $fileType)
    {
        $this->fileSize = $fileSize;
        $this->fileType = $fileType;
    }


    /**
     * @return int
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * @param int $fileSize
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;
    }

    /**
     * @return string
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @param string $fileType
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
    }

    /**
     * @return int
     */
    public function getIntercept()
    {
        return $this->intercept;
    }

    /**
     * @param int $intercept
     */
    public function setIntercept($intercept)
    {
        $this->intercept = $intercept;
    }

    /**
     * 检查后缀名
     * @return bool
     */
    protected function checkExt()
    {
        return in_array($this->getFileType(), $this->limitType);
    }

    /**
     * 检查文件大小
     * @return bool
     */
    protected function checkSize()
    {
        return $this->getFileSize() <= $this->limitSize;
    }

    /**
     * 检测是否满足上传条件
     * @return bool
     */
    public function isOk()
    {
        if (!$this->checkExt()) {
            $this->setIntercept(self::INTERCEPT_TYPE);
            return false;
        }
        if (!$this->checkSize()) {
            $this->setIntercept(self::INTERCEPT_SIZE);
            return false;
        }
        return true;
    }
}