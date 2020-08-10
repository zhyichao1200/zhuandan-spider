<?php


namespace Momo\ZhuanDan\Page;

use Momo\ZhuanDan\Http\Http;
use QL\QueryList;
use Momo\ZhuanDan\Model\Result;
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
        $shopName = $ql->find("h3:eq(0) a:eq()")->text();
        $shopPic = $ql->find(".store_infos_pic a img")->attr('src');
        $res = new Result;
        $res->setOk(true);
        $res->setMessage("基本信息获取成功");
        $res->setData(compact("shopName","shopPic"));
        return $res;
    }

    public function deliveryOrder()
    {

    }
}