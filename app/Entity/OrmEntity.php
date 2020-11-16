<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-16
 * Time: 下午 05:11
 */
namespace App\Entity;
interface OrmEntity
{
    function getDbArray();
}