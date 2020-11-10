<?php
/**
 * 上传文件实体
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-10
 * Time: 下午 02:51
 */
namespace App\Entity;
class File
{
    private $id = 0;
    private $uid = 0;
    private $title = "";
    private $desc = "";
    private $cover = "";
    private $fileUrl = "";
    private $fileType = "";
    private $fileSize = 0;
    private $mineType = "";
    private $ctime = 0;

    /**
     * File constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param int $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param string $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    /**
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param string $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
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
     * @return int
     */
    public function getCtime()
    {
        return $this->ctime;
    }

    /**
     * @param int $ctime
     */
    public function setCtime($ctime)
    {
        $this->ctime = $ctime;
    }

    /**
     * @return string
     */
    public function getFileUrl()
    {
        return $this->fileUrl;
    }

    /**
     * @param string $fileUrl
     */
    public function setFileUrl($fileUrl)
    {
        $this->fileUrl = $fileUrl;
    }

    /**
     * @return string
     */
    public function getMineType()
    {
        return $this->mineType;
    }

    /**
     * @param string $mineType
     */
    public function setMineType($mineType)
    {
        $this->mineType = $mineType;
    }

    /**
     * 获取入库的数据
     * @return array
     */
    public function getDbArray()
    {
        return [
            'uid' => $this->getUid(),
            'title' => $this->getTitle(),
            'desc' => $this->getDesc(),
            'cover' => $this->getCover(),
            'file_url' => $this->getFileUrl(),
            'file_type' => $this->getFileType(),
            'file_size' => $this->getFileSize(),
            'ctime' => time()
        ];
    }
}