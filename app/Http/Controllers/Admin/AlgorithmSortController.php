<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

/**
 * 排序算法
 * Class AlgorithmSortController
 * @package App\Http\Controllers\Admin
 */
class AlgorithmSortController extends Controller
{
    private function getRandArr($len = 10)
    {
        //生成10个元素的随机数组
        $rangeArr = range(1, $len);
        shuffle($rangeArr);
        return $rangeArr;
    }
    //
    /**
     * 排序算法
     */
    public function bubble()
    {
        dump("冒泡排序算法：");
        $rangeArr = $this->getRandArr();
        dump($rangeArr);
        //执行冒泡排序
        for($i = 0; $i < count($rangeArr); $i++) {
            for($j = 0; $j < count($rangeArr) - $i - 1; $j++) {
                if ($rangeArr[$j] > $rangeArr[$j + 1]) {
                    $tmp = $rangeArr[$j];
                    $rangeArr[$j] = $rangeArr[$j + 1];
                    $rangeArr[$j + 1] = $tmp;
                }
            }
        }
        dump($rangeArr);
    }

    public function select()
    {
        dump("选择排序算法：");
        $rangeArr = $this->getRandArr();
        dump($rangeArr);
        //执行选择排序
        for($i = 0; $i < count($rangeArr); $i++) {
            //选择一个最小值
            $min = $i;
            for($j = $i + 1; $j < count($rangeArr); $j++) {
                //与剩下的值比较出最小值
                if ($rangeArr[$min] > $rangeArr[$j]) {
                    $tmp = $rangeArr[$min];
                    $rangeArr[$min] = $rangeArr[$j];
                    $rangeArr[$j] = $tmp;
                }
            }
        }
        dump($rangeArr);
    }

    /**
     * 插入排序
     * 1、选取第一个元素认为是已经排好序的结果集
     * 2、选取下一个元素，与已排好序的结果集从后向前过滤，直到结果集中的元素小于或等于当前元素
     * 3、插入当前元素
     * 4、重复2步骤
     */
    public function insert()
    {
        $rangeArr = $this->getRandArr();
        dump($rangeArr);
        //选取第一个元素为已排好序的结果集
        $result = [$rangeArr[0]];
        for ($i = 1; $i < count($rangeArr); $i++) {
            $cur = $rangeArr[$i];
            $preIndex = $i - 1;
            //与结果集的值比较，直到结果集的元素小于或等于当前元素
            //最大值在最后
            for ($j = count($result) - 1; $j >= 0; $j--) {
                //结果集后面的元素都自动往后移动一个位置
//                dump($rangeArr[$i]);
                $result[$j + 1] = $result[$j];
                if ($result[$j] <= $rangeArr[$i]) {
                    $result[$j + 1] = $rangeArr[$i];
                    break;
                }
                if ($j == 0 && $rangeArr[$i] >= $result[$j]) {
                    $result[$j + 1] = $rangeArr[$i];
                    break;
                }
                if ($j == 0 && $rangeArr[$i] < $result[$j]) {
                    $result[$j] = $rangeArr[$i];
                }
            }
//            dump($result);
        }
        dump($result);
    }

    /**
     * 网例插入排序
     */
    public function shortInsert()
    {
        $rangeArr = $this->getRandArr();
        dump($rangeArr);
/*        for ($i = 1; $i < count($rangeArr); $i++) {
            $cur = $rangeArr[$i];
            //记录将要插入值的前一个值的索引
            $preIndex = $i - 1;
            while ($preIndex > 0 && $rangeArr[$preIndex] > $cur) {
                $rangeArr[$preIndex + 1] = $rangeArr[$preIndex];
                $preIndex--;
            }
            $rangeArr[$preIndex + 1] = $cur;
        }*/
        for ($i = 1; $i < count($rangeArr); $i++) {
        $preIndex = $i - 1;
        $current = $rangeArr[$i];
        while ($preIndex >= 0 && $rangeArr[$preIndex] > $current) {
            $arr[$preIndex + 1] = $rangeArr[$preIndex];
            $preIndex--;
        }
            $rangeArr[$preIndex + 1] = $current;
    }
        dump($rangeArr);
    }

    /**
     * 输入ababab
     * 输出3ab
     * 输入aaaaa
     * 输出5a
     */
    public function topic01()
    {
        $inputStr = Input::get("inputStr", "aaaaa");
        //从头查找字符串中与第一个字符相同的片段
        //字符串转为数组
        $len = strlen($inputStr);
        $strArr = [];
        for($i = 0; $i < $len; $i++) {
            $strArr[] = substr($inputStr, $i, 1);
        }
        //全是相同字符的特殊处理
        if (count(array_unique($strArr)) == 1) {
            echo count($strArr), $strArr[0];
            exit;
        }
        //查找相同片段
        $firstChar = $strArr[0];
        $fragment = $firstChar;
        for($i = 1; $i < $len; $i++) {
            //与后一个字符拼接成一个临时的片段，比较后续tmpFragment字符是否与临时片段相同
            $fragment = $fragment . $strArr[$i];
            $tmpStr = substr($inputStr, strlen($fragment), strlen($fragment));
//            dump($fragment);
//            dump($tmpStr);
            if ($fragment == $tmpStr) {
                break;
            }

        }
        dump($fragment);
        //获取共多少个相同的片段
        $n = $len / strlen($fragment);
        echo $n, $fragment;
    }
}
