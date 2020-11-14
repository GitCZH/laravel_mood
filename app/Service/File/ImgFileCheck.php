<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-14
 * Time: 上午 10:21
 */
namespace App\Service\File;
use App\Service\File\Impl\FileCheck;

class ImgFileCheck extends FileCheck
{
    protected $limitSize = 5 * 1024 * 1024;
    protected $limitType = ['jpeg', 'jpg', 'png', 'gif'];
}