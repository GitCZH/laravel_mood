<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EssayCmt extends Model
{
    //
    protected $table = "essay_cmt";
    protected $fillable = [
        'essay_id', 'pub_uid', 'cmt_uid', 'cmt_id', 'cmt_content', 'ctime', 'mtime', 'cmt_state'
    ];

    /**
     * 新增短文评论
     * @param $essayCmtField
     * @return int
     */
    public function add($essayCmtField)
    {
        return $this->insertGetId($essayCmtField);
    }

    /**
     * 获取直接评论
     * @param $essayId
     * @param int $cmtId
     * @param int $limit
     * @return array
     */
    public function getEssayCmtByEssayIdPage($essayId, $cmtId = 0, $limit = 10)
    {
        //获取一级评论
        if ($cmtId == 0) {
            return $this->where('essay_id', '=', $essayId)
//            ->where('cmt_id', '=', 0)
                ->orderBy('id', 'desc')
                ->limit($limit)
                ->get()->toArray();
        }
        return $this->where('essay_id', '=', $essayId)
            ->where('id', '<', $cmtId)
//            ->where('cmt_id', '=', 0)
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get()->toArray();
        //TODO 单独设置记录评论是否有子评论及数目的数据
    }

    /**
     * 获取当前用户获得的评论
     * @param integer $uid
     * @return int
     */
    public function getEssayCmtStat($uid)
    {
        return $this->where('pub_uid', '=', (int)$uid)
            ->where('cmt_state', '=', 1)
            ->count();
    }
}
