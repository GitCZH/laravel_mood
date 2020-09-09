<?php

namespace App\Http\Controllers\Index;

use App\Model\Essay;
use App\Model\EssayCmt;
use App\Result\ResponseResult;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EssayCmtController extends Controller
{
    private $_userModel = null;
    private $_essayCmtModel = null;

    /**
     * EssayCmtController constructor.
     * @param User $_userModel
     * @param EssayCmt $_essayCmtModel
     */
    public function __construct(User $_userModel, EssayCmt $_essayCmtModel)
    {
        $this->_userModel = $_userModel;
        $this->_essayCmtModel = $_essayCmtModel;
    }

    /**
     * 发布短文评论
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function publishEssayCmt(Request $request)
    {
        //评论数据验证
        $rules = [
            'cmt_content' => 'required|min:5|max:255',
            'essay_id' => 'required|integer|min:1',
            'cmt_id' => 'required|integer|min:0',
            'pub_uid' => 'required|integer|min:1'
        ];
//        $messages = [
//            'content.required' => "文本内容必填",
//            'content.min' => "文本内容最少5个字符",
//            'content.max' => "文本内容最多255个字符",
//            'essayId.required' => ""
//        ];
        $validator = Validator::make($request->all(), $rules);
        //参数基础验证失败
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json(ResponseResult::getResponse(ResponseResult::FAIL_PARAM_ILLEGAL, "", $errors));
        }
        //接受输入的心情参数
        $params = $request->all();
        //短文是否存在
        $essayModel = new Essay();
        if (empty($essayModel->getEssayById($params['essay_id']))) {
            $result = ResponseResult::getResponse(ResponseResult::FAIL_ESSAY_INVALID);
            return response()->json($result);
        }
        //TODO处理内容数据、过滤特殊字符

        //补充必要字段
        $curTime = time();
        $params['cmt_uid'] = session("user_id", 0);
        $params['ctime'] = $curTime;
        $params['mtime'] = $curTime;
        $params['cmt_state'] = 1;

        $cmtId = $this->_essayCmtModel->add($params);
        $result = empty($cmtId) ? ResponseResult::getResponse(ResponseResult::FAIL_SERVICE_ADD) :
            ResponseResult::getResponse(ResponseResult::SUCCESS_COM, "", ['cmt_id' => $cmtId]);
        return response()->json($result);
    }

    /**
     * 分页获取短文的评论
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEssayCmtPage(Request $request)
    {
        $rules = [
            'essayId' => 'required|min:1|integer',
            'cmtId' => 'required|integer|min:0'
        ];
        $validator = Validator::make($request->all(), $rules);
        //参数基础验证失败
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json(ResponseResult::getResponse(ResponseResult::FAIL_PARAM_ILLEGAL, "", $errors));
        }
        $params = $request->all();
        $cmtList = $this->_essayCmtModel->getEssayCmtByEssayIdPage($params['essayId'], $params['cmtId'], 10);
        if (empty($cmtList)) {
            $result = ResponseResult::getResponse(ResponseResult::FAIL_EMPTY);
            return response()->json($result);
        }
        //处理用户数据
        $pubUids = array_column($cmtList, 'pub_uid');
        $cmtUids = array_column($cmtList, 'cmt_uid');
        $uids = array_unique(array_merge($pubUids, $cmtUids));
        $userInfo = $this->_userModel->getUserByIds($uids);
        $cmtList = trans_time_in_array($cmtList, ['ctime', 'mtime']);

        $items = [
            'list' => $cmtList,
            'userInfo' => $userInfo
        ];
        $result = ResponseResult::getResponse(ResponseResult::SUCCESS_COM, "", $items);
        return response()->json($result);
    }
}
