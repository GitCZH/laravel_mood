<?php
/**
 * 上传文件实体
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-10
 * Time: 下午 02:51
 */
namespace App\Entity;
class File implements OrmEntity
{
    //上传路径字典
    public static $pathMap = [
        1 => 'public/imgs/upload',
        2 => 'public/docs/upload',
        3 => 'public/voices/upload',
        4 => 'public/videos/upload',
    ];

    //返回软连接的目录路径
    public static $delPathMap = [
        1 => '/storage/imgs/upload',
        2 => '/storage/docs/upload',
        3 => '/storage/voices/upload',
        4 => '/storage/videos/upload',
    ];

    private $id = 0;
    private $uid = 0;
    private $title = "";
    private $desc = "";
    private $cover = "";
    private $fileUrl = "";
    private $fileType = "";
    private $fileSize = 0;
    private $identifyId = 0;
    private $createdAt = "";
    private $updatedAt = "";

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
     * @return int
     */
    public function getIdentifyId()
    {
        return $this->identifyId;
    }

    /**
     * @param int $identifyId
     */
    public function setIdentifyId($identifyId)
    {
        $this->identifyId = $identifyId;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * 新增文件
     * @return bool
     */
    public function add()
    {
        $file = new \App\Model\File();
        return $file->addFile($this->getDbArray());
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
            'unique_id' => $this->getIdentifyId(),
        ];
    }
}