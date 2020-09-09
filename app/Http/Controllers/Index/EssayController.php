<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Model\ClickLike;
use App\Model\Essay;
use App\Model\EssayCmt;
use App\Result\ResponseResult;
use App\User;
use Illuminate\Http\Request;
use Validator;

class EssayController extends Controller
{
    private $_userModel = null;
    private $_essayModel = null;
    private $_essayCmtModel = null;
    private $_likeModel = null;

    /**
     * EssayController constructor.
     * EssayController constructor.
     * @param User $_userModel
     * @param Essay $_essayModel
     * @param EssayCmt $_essayCmtModel
     */
    public function __construct(User $_userModel, Essay $_essayModel, EssayCmt $_essayCmtModel, ClickLike $_likeModel)
    {
        $this->_userModel = $_userModel;
        $this->_essayModel = $_essayModel;
        $this->_essayCmtModel = $_essayCmtModel;
        $this->_likeModel = $_likeModel;
    }

    /**
     * 短文首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function essayIndex()
    {
        return view("short/essay/index");
    }

    /**
     * 发布短文心情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function publishEssay(Request $request)
    {
        $rules = [
            'content' => 'required|min:5|max:255'
        ];
        $messages = [
            'content.required' => "文本内容必填",
            'content.min' => "文本内容最少5个字符",
            'content.max' => "文本内容最多255个字符",
        ];
        //\Illuminate\Validation\Validator
        $validator = Validator::make($request->all(), $rules, $messages);
        //参数基础验证失败
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            return response()->json(ResponseResult::getResponse(ResponseResult::FAIL_PARAM_ILLEGAL, "", $errors));
        }
//        dd($validator);
        //接受输入的心情参数
        $params = $request->all();
        //TODO处理内容数据、过滤特殊字符

        //补充必要字段
        $curTime = time();
        $params['uid'] = session("user_id", 0);
        $params['ctime'] = $curTime;
        $params['mtime'] = $curTime;
        $params['essay_state'] = 1;
        //写入数据库
        $result = $this->_essayModel->add($params);
        $returnArr = $result ? ResponseResult::getResponse(ResponseResult::SUCCESS_COM, "", ['insert_id' => $result]) :
        ResponseResult::getResponse(ResponseResult::FAIL_SERVICE_ADD);
        return response()->json($returnArr);
    }

    /**
     * 分页获取短文内容
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEssayPage(Request $request)
    {
        $uid = session("user_id", 0);
        $essayId = $request->get('essayId', 0);
        //查询排序方式，默认倒序 asc|desc
        $order = $request->get("order", "desc");
        $essayList = $this->_essayModel->getPaginate($uid, $essayId, $order);
        if (empty($essayList)) {
            $result = ResponseResult::getResponse(ResponseResult::FAIL_EMPTY);
            return response()->json($result);
        }
        //获取用户数据
        $uids = array_column($essayList, 'uid');
        $userInfo = $this->_userModel->getUserByIds($uids);
        $uidTmp = array_column($userInfo, 'id');
        $userInfo = array_combine($uidTmp, $userInfo);
        //短文总数
        $essayCount = $this->_essayModel->getEssayStat(session('user_id'));
//        dd($essayList);
//        dd($userInfo);

        $essayList = trans_time_in_array($essayList, ['ctime', 'mtime']);
        $items = [
            'list' => $essayList,
            'essayIds' => array_column($essayList, 'id'),
            'userInfo' => $userInfo,
            'total' => $essayCount
        ];
        $result = ResponseResult::getResponse(ResponseResult::SUCCESS_COM, "", $items);
        return response()->json($result);
    }

    /**
     * 获取当前用户的短文统计数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserEssayStat()
    {
        //获取短文数量
        $essayCount = $this->_essayModel->getEssayStat(session('user_id'));
        //获取短文评论数量
        $essayCmtCount = $this->_essayCmtModel->getEssayCmtStat(session('user_id'));
        //获取总转发量

        //获取获得的总点赞数量
        $likeStat = $this->_likeModel->getReceiveLikeStat(session('user_id'));
        //获取给别人点赞数量

        $result = [
            'essayCount' => $essayCount,
            'essayCmtCount' => $essayCmtCount,
            'essayLikeCount' => $likeStat
        ];
        return response()->json(ResponseResult::getResponse(ResponseResult::SUCCESS_COM, '', $result));
    }
}
