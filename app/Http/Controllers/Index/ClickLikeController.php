<?php

namespace App\Http\Controllers\Index;

use App\Model\ClickLikeStat;
use App\Result\ResponseResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClickLikeController extends Controller
{
    private $_likeModel = null;
    private $_likeStatModel = null;

    /**
     * ClickLike constructor.
     * @param \App\Model\ClickLike $_likeModel
     * @param ClickLikeStat $_likeStatModel
     */
    public function __construct(\App\Model\ClickLike $_likeModel, ClickLikeStat $_likeStatModel)
    {
        $this->_likeModel = $_likeModel;
        $this->_likeStatModel = $_likeStatModel;
    }


    /**
     * 点赞
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addClick(Request $request)
    {
        $rules = [
            'content_type' => 'required|min:1',
            'content_id' => 'required|integer|min:1',
            'for_uid' => 'required|integer|min:1'
        ];
        //\Illuminate\Validation\Validator
        $validator = Validator::make($request->all(), $rules);
        //参数基础验证失败
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json(ResponseResult::getResponse(ResponseResult::FAIL_PARAM_ILLEGAL, "", $errors));
        }
        $params = $request->all();
        $params['click_uid'] = session("user_id", 0);
        $params['ctime'] = time();
        //判断是否已点赞
        $likeItem = $this->_likeModel->isClick($params['content_type'], $params['content_id'], session('user_id'));
        if (!empty($likeItem)) {
            $result = ResponseResult::getResponse(ResponseResult::FAIL_DATA_EXISTS, "已点赞", []);
            return response()->json($result);
        }
        //添加点赞
        DB::beginTransaction();
        $likeRes = $this->_likeModel->addLike($params);
        $statField = [
            'content_type' => $params['content_type'],
            'content_id' => $params['content_id'],
            'count' => 1
        ];
        $likeStatRes = $this->_likeStatModel->addLike($statField);
        if ($likeRes && $likeStatRes) {
            DB::commit();
            $result = ResponseResult::getResponse(ResponseResult::SUCCESS_COM);
            return response()->json($result);
        }
        DB::rollback();
        $result = ResponseResult::getResponse(ResponseResult::FAIL_SERVICE_ADD);
        return response()->json($result);
    }

    /**
     * 获取点赞数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEssayClick(Request $request)
    {
        $rules = [
            'content_type' => 'required|min:1',
            'content_id' => 'required|array'
        ];
        //\Illuminate\Validation\Validator
        $validator = Validator::make($request->all(), $rules);
        //参数基础验证失败
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json(ResponseResult::getResponse(ResponseResult::FAIL_PARAM_ILLEGAL, "", $errors));
        }

        $params = $request->all();
        //获取点赞数据
        $likes = $this->_likeModel->getLikeForUser(session('user_id'), $params['content_type'], $params['content_id']);
        //获取内容id
        $contentIds = array_column($likes, 'content_id');
        $valFill = array_fill(0, count($likes), 1);
        $likes = array_combine($contentIds, $valFill);
        $result = [
            'likes' => $likes
        ];
        return response()->json(ResponseResult::getResponse(ResponseResult::SUCCESS_COM, "", $result));
    }
}
