<?php

namespace App;


class Helper
{
    public static function secondToDate($second)
    {
        $day = floor($second / (3600 * 24));
        $second = $second % (3600 * 24);//除去整天之后剩余的时间
        $hour = floor($second / 3600);
        $second = $second % 3600;//除去整小时之后剩余的时间
        $minute = floor($second / 60);
        //返回字符串
        return $day . '天' . $hour . '小时' . $minute . '分';
    }

    public static function secondToDivide($second)
    {
        $day = floor($second / (3600 * 24));
        $second = $second % (3600 * 24);//除去整天之后剩余的时间
        $hour = floor($second / 3600);
        $second = $second % 3600;//除去整小时之后剩余的时间
        $minute = floor($second / 60);
        $second = $second % 60;//除去整分钟之后剩余的时间
        //返回字符串

        return [
            'day' => $day,
            'hour' => $hour,
            'minute' => $minute,
            'second' => $second,
        ];
    }

    public static function time_ago($agoTime)
    {
        $agoTime = strtotime($agoTime);

        // 计算出当前日期时间到之前的日期时间的毫秒数，以便进行下一步的计算
        $time = time() - $agoTime;

        if ($time >= 31104000) { // N年前
            $num = (int)($time / 31104000);
            return $num . '年前';
        }
        if ($time >= 2592000) { // N月前
            $num = (int)($time / 2592000);
            return $num . '月前';
        }
        if ($time >= 86400) { // N天前
            $num = (int)($time / 86400);
            return $num . '天前';
        }
        if ($time >= 3600) { // N小时前
            $num = (int)($time / 3600);
            return $num . '小时前';
        }
        if ($time > 60) { // N分钟前
            $num = (int)($time / 60);
            return $num . '分钟前';
        }
        return '1分钟前';
    }


    public static function unique_rand($min, $max, $num)
    {
        //初始化变量为0
        $count = 0;
        //建一个新数组
        $return = array();
        while ($count < $num) {
            //在一定范围内随机生成一个数放入数组中(含边界值)
            $return[] = mt_rand($min, $max);
            //去除数组中的重复值用了“翻翻法”，就是用array_flip()把数组的key和value交换两次。这种做法比用 array_unique() 快得多。
            $return = array_flip(array_flip($return));
            //将数组的数量存入变量count中
            $count = count($return);
        }
        //生成新键名
        shuffle($return);
        return $return;
    }

    public static $typeArray = [
        'apply' => '测评活动',
        'kill' => '秒杀活动',
        'task' => '任务活动',
        'airport' => '机场活动',
        'shop' => '烟店活动',
    ];

    public static $levelArray = [
        '菜鸟',
        '新手',
        '高手',
        '专家',
        '大师',
    ];

    public static $taskPrizeName = [
        'water' => '滴水',
        'seed' => '颗种子',
        'ticket' => '张礼品券',
    ];

    public static function chineseDate(){
        switch (date('w')){
            case 1:$week="星期一";break;
            case 2:$week="星期二";break;
            case 3:$week="星期三";break;
            case 4:$week="星期四";break;
            case 5:$week="星期五";break;
            case 6:$week="星期六";break;
            case 0:$week="星期日";break;
            default :$week="星期一";
        }
        return date('Y').'年'.date('m').'月'.date('d').'日 '.$week;
    }
}
