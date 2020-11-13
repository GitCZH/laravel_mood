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
            //待插入元素
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
     * 插入排序
     * 索引值确定新定义
     */
    public function newInsert($rangeArr)
    {
        if (empty($rangeArr)) {
            $rangeArr = $this->getRandArr();
        }
        dump($rangeArr);

        $len = count($rangeArr);
        //假定第一个元素为已排好序的列
        for ($i = 1; $i < $len; $i++) {
            //待插入元素
            $waitInsert = $rangeArr[$i];
            //已排序列的最大索引值
            $sortedMaxIndex = $i - 1;
            //从后向前遍历已排序列的元素
            while ($sortedMaxIndex >= 0 && $rangeArr[$sortedMaxIndex] >= $waitInsert) {
                //已排序元素后移
                $rangeArr[$sortedMaxIndex + 1] = $rangeArr[$sortedMaxIndex];
                $sortedMaxIndex--;
            }
            //待插入元素比所有已排序元素都小 || 待排序元素小于已排序列的某一个值
            $rangeArr[$sortedMaxIndex + 1] = $waitInsert;
        }
        dump($rangeArr);
    }

    /**
     * 希尔排序
     * 希尔排序可以说是插入排序的一种变种。
     * 无论是插入排序还是冒泡排序，如果数组的最大值刚好是在第一位，
     * 要将它挪到正确的位置就需要 n - 1 次移动。
     * 也就是说，原数组的一个元素如果距离它正确的位置很远的话，
     * 则需要与相邻元素交换很多次才能到达正确的位置，这样是相对比较花时间了。
     *
     * 把原序列进行增量间隔排序形成局部有序，最后再进行插入排序时移动元素次数就会变少
     */
    public function shellInsert()
    {
        $rangeArr = $this->getRandArr();
        dump($rangeArr);

        //设置增量间隔
        $len = count($rangeArr);
        //从1/2间隔开始，到1为止
        for ($i = $len / 2; $i > 0; $i--) {
            //执行插入排序
            for ($j = $i; $j < $len; $j++) {
                //待插入元素
                $waitInsert = $rangeArr[$j];
                //已排序的最大索引值
                $sortedMaxIndex = $j - $i;
                //对已排序元素进行比较
                while ($sortedMaxIndex >= 0 && $rangeArr[$sortedMaxIndex] >= $waitInsert) {
                    //已排序元素后移$i位
                    $rangeArr[$sortedMaxIndex + $i] = $rangeArr[$sortedMaxIndex];
                    $sortedMaxIndex -= $i;
                }
                $rangeArr[$sortedMaxIndex + $i] = $waitInsert;
//                dump($rangeArr);
            }
//            break;
        }
        dump($rangeArr);
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
     * 归并排序
     * 利用递归和分治的方法实现排序。
     * 整个无序序列分割成n/2个子序列，通过分治使每个子序列有序
     * 再通过归并把n/2个子序列合并为一个完整有序序列
     *
     * 首先把一个未排序的序列从中间分割成2部分，
     * 再把2部分分成4部分，依次分割下去，
     * 直到分割成一个一个的数据，再把这些数据两两归并到一起，
     * 使之有序，不停的归并，最后成为一个排好序的序列。
     */
    public function mergeSort()
    {
        $rangeArr = $this->getRandArr();
        dump($rangeArr);

        $this->bladeMergeSort($rangeArr, 0, count($rangeArr) - 1);
        dump($rangeArr);
    }

    private function bladeMergeSort(&$origin, $start, $end)
    {
        //最小序列，一个序列只有一个元素
        if ($start >= $end) {
            return [];
        }

        $result = [];
        //分割序列
        $len = $end - $start;
        $mid = $start + floor($len / 2);
        $leftStart = $start;
        $leftEnd = $mid;
        $rightStart = $mid + 1;
        $rightEnd = $end;

//        dd($mid);
        $k = $start;
        //处理左半边序列
        $this->bladeMergeSort($origin, $leftStart, $leftEnd);
        //处理右半边序列
        $this->bladeMergeSort($origin, $rightStart, $rightEnd);


        while ($leftStart <= $leftEnd && $rightStart <= $rightEnd) {
            $result[$k++] = $origin[$leftStart] < $origin[$rightStart] ? $origin[$leftStart++] : $origin[$rightStart++];
        }
        //剩余元素加入到合并数组
        while ($leftStart <= $leftEnd) {
            $result[$k++] = $origin[$leftStart++];
        }
        while ($rightStart <= $rightEnd) {
            $result[$k++] = $origin[$rightStart++];
        }
//        echo "before origin\n";
//        dump($origin);
//        echo "result\n";
//        dump($result);
        //重赋值原数组中前end位已排好序的元素 【因为归并排序是稳定的，所以可以这么修改原数组赋值】
        for ($i = $start; $i <= $end; $i++) {
            $origin[$i] = $result[$i];
        }
//        echo "after origin\n";
//        dump($origin);
        return $result;
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
