<?php


namespace Momo\ZhuanDan\Tools;

/**
 * 数据处理
 * Class Filter
 * @package Momo\ZhuanDan\Tools
 */
class Filter
{
    /**
     * 处理时间
     * @param string $html
     * @return string|null
     */
    static public function orderMultipleTime(string $html){
        $time = explode("\n",$html);
        return empty($time[1]) ? null : trim($time[1]);
    }

    /**
     * 合并空格
     * @param string $string
     * @return string|string[]|null
     */
    static public function mergeSpaces(string $string){
        return preg_replace("/\s(?=\s)/","\\1",$string);
    }
}