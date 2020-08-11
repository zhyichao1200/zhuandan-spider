<?php


namespace Momo\ZhuanDan\Page;

use Momo\ZhuanDan\Http\Http;
use QL\QueryList;
use Momo\ZhuanDan\Model\Result;
use Momo\ZhuanDan\Model\Base;
use Momo\ZhuanDan\Tools\Filter;
/**
 * 页面数据
 * Class Page
 * @package Momo\ZhuanDan\Page
 */
class Page
{
    /**
     * 获取基本信息
     * @return Result
     */
    public function main() :Result
    {
        $response = Http::getClient()->get("/main")->getBody()->getContents();
        $ql = QueryList::html($response);
        $shopName = $ql->find("h3:eq(0) a:eq(0)")->text();
        $shopPic = $ql->find(".store_infos_pic a img")->attr('src');
        $res = new Result;
        $res->setOk(true)->setMessage("基本信息获取成功")->setData(compact("shopName","shopPic"));
        return $res;
    }

    /**
     * 待配送订单
     * @param int $page
     * @return Result
     */
    public function toBeDelivered($page = 1)
    {
        $ql = QueryList::html(
            Http::getClient()->get("/Joinorder/lists_waitDelivery?p=".$page)->getBody()->getContents()
        );
        $listDataTotalStr = $ql->find(".rows")->text();
        preg_match("/\d+/",$listDataTotalStr,$listDataTotalNum);
        $res = new Result;
        if(empty($listDataTotalNum[0])) return $res->setMessage("数据总数获取失败...");
        $listDataTotalNum = (int) $listDataTotalNum[0];
        $listDataTotalPageStr = $ql->find(".total_page")->text();
        preg_match("/\d+/",$listDataTotalPageStr,$listDataTotalPageNum);
        if(empty($listDataTotalPageNum[0])) return $res->setMessage("数据总页数获取失败...");
        $listDataTotalPageNum = (int) $listDataTotalPageNum[0];
        $listDataBase = $ql->rules([
            'href' => ['.dis-inline a','href'],
        ])->range(".three-party-this")->query()->getData()->all();
        $listDataArray = [];
        foreach ((array) $listDataBase as $index=>$item){
            if(empty($item["href"])) continue;
            $temp = [];
            $temp["orderId"] = explode("_",$item["href"]);
            $temp["orderId"] = end($temp["orderId"]);
            $qlDetail = QueryList::html(Http::getClient()->get($item["href"])->getBody()->getContents());
            $temp["createTime"] = Filter::orderMultipleTime(
                $qlDetail->find(".pt10.mb10.fcgray.f12 li:eq(0)")->text()
            );
            $temp["payTime"] = Filter::orderMultipleTime(
                $qlDetail->find(".pt10.mb10.fcgray.f12 li:eq(1)")->text()
            );
            $temp["confirmTime"] = Filter::orderMultipleTime(
                $qlDetail->find(".pt10.mb10.fcgray.f12 li:eq(2)")->text()
            );
            $goods = $qlDetail->rules([
                'imageUri' => ['.pull-left a','href'],
                'name' => ['.fcgray','text'],
                'num' => ['.pull-right','text'],
            ])->range("#orderinfo .clearfix")->queryData(function($value){
                preg_match("/\d+/",$value["num"],$num);
                $value["num"] = $num[0];
                return $value;
            });
            $temp["items"] = $goods;
            $timeStr = $qlDetail->find(".table:eq(0) tbody tr:eq(0) td:eq(0)")->text();
            preg_match("/\d{4}-\d{2}-\d{2}/",$timeStr,$sendDate);
            preg_match("/-(([01]?[0-9]|2[0-3]):[0-5][0-9])/",$timeStr,$time);
            $temp["deadline"] = $sendDate[0]." ".$time[1];
            $temp["payment"] = (float) $qlDetail->find(".table:eq(0) tbody tr:eq(0) td:eq(1) .fcred:eq(1)")->text();
            $rev = $qlDetail->find(".table:eq(0)  tbody tr:eq(1) td:eq(0)")->text();
            $rev = Filter::mergeSpaces($rev);
            $revArray = explode("   ",$rev);
            $receiveInfo = str_replace("收货信息：","",$revArray[0]);
            $receiveInfo = explode("  ",$receiveInfo);
            $temp["receiveName"] = $receiveInfo[0];
            $temp["receivePhone"] = $receiveInfo[1];
            $receiveCity = str_replace("收货地址：","",trim($revArray[1]));
            $receiveCity = explode("|",$receiveCity);
            $temp["receiveProvince"] = $receiveCity[0];
            $temp["receiveCity"] = $receiveCity[1];
            $temp["receiveRegion"] = $receiveCity[2];
            $temp["receiveAddress"] = $revArray[2];
            $card = $qlDetail->find(".table:eq(1) tbody tr:eq(1)")->text();
            $temp["card"] = $card == "暂无贺卡信息" ? "" : $card;
            $remarkHeader = $qlDetail->find(".table:eq(2) tbody tr:eq(0)")->text();
            $temp["remark"] = $remarkHeader == "订单备注" ? $qlDetail->find(".table:eq(2) tbody tr:eq(1)")->text() : "";
            $temp["shopInfo"]["shopName"] = trim($qlDetail
                ->find(".panel.panel-info:eq(3) .panel-body .table tbody tr:eq(0) td:eq(0) a")->text());
            $temp["shopInfo"]["shopPhone"] = trim($qlDetail
                ->find(".panel.panel-info:eq(3) .panel-body .table tbody tr:eq(1) td:eq(1)")->text(),"     ");
            $listDataArray[] = $temp;
        }
        return $res->setOk(true)->setMessage("获取成功")->setData([
            "totalPage"=>$listDataTotalPageNum,
            "total"=>$listDataTotalNum,
            "data"=>$listDataArray
        ]);
    }
}