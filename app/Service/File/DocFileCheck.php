<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-14
 * Time: 上午 10:32
 */
namespace App\Service\File;
use App\Service\File\Impl\FileCheck;

class DocFileCheck extends FileCheck
{
    protected $limitSize = 10 * 1024 * 1024;
    protected $limitType = ['doc','xlxs','csv','ppt','txt','md'];
}