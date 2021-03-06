<?php
/**
 * 文件模型类
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-10
 * Time: 下午 02:44
 */
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = "upload_file";
    //使模型支持批量赋值 一般模型数据是单属性逐个赋值
    protected $fillable = [
        'uid', 'title', 'desc', 'cover', 'file_url', 'file_type', 'file_size', 'minetype', 'unique_id'
    ];

    /**
     * 添加一条文件记录
     * @param $data
     * @return bool
     */
    public function addFile($data)
    {
        return $this->firstOrCreate($data);
    }
}