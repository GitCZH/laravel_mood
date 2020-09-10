<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Essay extends Model
{
    //
    protected $table = "essay";
    protected $fillable = [
        'uid', 'content', 'ctime', 'mtime', 'essay_state'
    ];

    /**
     * 新增短文
     * @param $essayField
     * @return int
     */
    public function add($essayField)
    {
        return $this->insertGetId($essayField);
    }

    /**
     * 分页获取短文列表
     * @param $uid
     * @param $id
     * @param $order
     * @param int $limit
     * @return array
     */
    public function getPaginate($uid, $id, $order, $limit = 10)
    {
        $uid = (int)$uid;
        $id = (int)$id;
        if ($id == 0) {
            return $this/*->where('uid', '=', $uid)*/
                ->where('essay_state', '=', 1)
                ->orderBy('id', $order)
                ->limit($limit)
                ->get()->toArray();
        }
        return $this/*->where('uid', '=', $uid)*/
            ->where('id', '<', $id)
            ->where('essay_state', '=', 1)
            ->orderBy('id', $order)
            ->limit($limit)
            ->get()->toArray();
    }

    /**
     * 根据id获取短文
     * @param $id
     * @return Essay[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getEssayById($id)
    {
        return $this->where('id', '=', (int)$id)
            ->where('essay_state', 1)
            ->get()->toArray();
    }

    /**
     * 获取正常状态的短文数量
     * @param integer $uid
     * @return int
     */
    public function getEssayStat($uid)
    {
        return $this->where('essay_state', '=', 1)
            ->where('uid', '=', (int)$uid)
            ->count();
    }
}
