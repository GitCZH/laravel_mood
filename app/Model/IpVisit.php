<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-16
 * Time: 下午 04:53
 */
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class IpVisit extends Model
{
    protected $table = "ip_visit";
    protected $fillable = ['ip', 'uri', 'query', 'ctime'];
}