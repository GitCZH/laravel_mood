<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2020-09-07
 * Time: 10:50
 */
if (!function_exists("trans_time_in_array")) {
    /**
     * 转换数组中的时间戳列，只支持二维数组
     * @param $data
     * @param array $timeCol
     * @param string $timeFormat
     * @return mixed
     */
    function trans_time_in_array($data, array $timeCol, $timeFormat = "Y-m-d H:i:s")
    {
        if (empty($timeCol)) {
            return $data;
        }
        //判断是否是二维数组
        if (isset($data[$timeCol[0]])) {
            foreach ($timeCol as $colItem) {
                $data[$colItem] = date($timeFormat, $data[$colItem]);
            }
            return $data;
        }
        foreach ($data as &$item) {
            if (!isset($item[$timeCol[0]])) {
                break;
            }
            foreach ($timeCol as $colItem) {
                $item[$colItem] = date($timeFormat, $item[$colItem]);
            }
        }
        return $data;
    }
}