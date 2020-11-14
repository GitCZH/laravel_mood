<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-14
 * Time: 上午 10:33
 */
namespace App\Service\File;
use App\Service\File\Impl\FileCheck;

class VoiceFileCheck extends FileCheck
{
    protected $limitSize = 50 * 1024 * 1024;
    protected $limitType = ['mp3', 'wav', 'wave', 'wma', 'flac', 'ape'];
}