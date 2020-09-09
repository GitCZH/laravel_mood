<?php
/**
 * 接口响应结果返回结果
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-09-06
 * Time: 22:54
 */
namespace App\Result;

class ResponseResult
{
    private $_errCode = 0;
    private $_errMsg = "";
    private $_result = [];

    //所有响应码集合
    const SUCCESS_COM = 0;
    //数据错误类
    //数据为空 | 不存在
    const FAIL_EMPTY = -1001;
    const FAIL_PARAM_LACK = -1002;
    const FAIL_PARAM_EMPTY = -1003;
    const FAIL_PARAM_ILLEGAL = -1004;
    const FAIL_ESSAY_INVALID = -1101;
    const FAIL_DATA_EXISTS = -1201;
    //逻辑错误
    //服务错误
    const FAIL_SERVICE_ADD = -2001;
    const FAIL_COM = -1000;

    //所有响应码对应提示语集合
    public static $_msgArr = [
        self::SUCCESS_COM => "成功",
        self::FAIL_COM => "响应失败",
        self::FAIL_EMPTY => "查询结果为空",
        self::FAIL_PARAM_LACK => "缺少参数",
        self::FAIL_PARAM_EMPTY => "参数为空",
        self::FAIL_PARAM_ILLEGAL => "参数不合法",
        self::FAIL_SERVICE_ADD => "服务出错，新增失败",
        self::FAIL_ESSAY_INVALID => "短文不存在",
        self::FAIL_DATA_EXISTS => "操作重复",
    ];
    /**
     * 成功响应结果
     * @param int $errCode
     * @param string $errMsg
     * @param array $result
     * @return array
     */
    public static function getResponse($errCode = 0, $errMsg = "", $result = [])
    {
        $resultArr = [
            'status_code' => $errCode
        ];

        if (empty($errMsg)) {
            if (isset(self::$_msgArr[$errCode])) {
                $errMsg = self::$_msgArr[$errCode];
            } else {
                $errMsg = "响应成功";
            }
        }
        $resultArr['status_msg'] = $errMsg;
        if (!is_array($result)) {
            $result = [$result];
        }
        $resultArr['result'] = $result;
        return self::formatReturn($errCode, $errMsg, $result);
    }

    /**
     * 获取直接响应成功的结果数组
     * @return array
     */
    public static function success()
    {
        return self::getResponse(self::SUCCESS_COM);
    }

    /**
     * 获取直接响应失败的结果数组
     * @return array
     */
    public static function fail()
    {
        return self::getResponse(self::FAIL_COM);
    }

    /**
     * 返回统一格式的结果数组
     * @param $errCode
     * @param $errMsg
     * @param $result
     * @return array
     */
    private static function formatReturn($errCode, $errMsg, $result)
    {
        return [
            'status_code' => $errCode,
            'status_msg' => $errMsg,
            'result' => $result
        ];
    }
}