<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-14
 * Time: 上午 10:34
 */
namespace App\Service\File;
use App\Service\File\Impl\FileCheck;

class VideoFileCheck extends FileCheck
{
    protected $limitSize = 200 * 1024 * 1024;
    protected $limitType = ['mpeg', 'avi', 'mov', 'asf', 'nAvi'];
}