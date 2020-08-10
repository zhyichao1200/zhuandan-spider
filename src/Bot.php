<?php


namespace Momo\ZhuanDan;

use Momo\ZhuanDan\Http\HttpServiceProvider;
use Momo\ZhuanDan\Auth\AuthServiceProvider;
use Momo\ZhuanDan\Model\Result;
use Momo\ZhuanDan\Page\PageServiceProvider;

/**
 * 转单宝机器人
 * Class Bot
 * @package Momo\ZhuanDan
 */
class Bot extends Foundation
{
    /**
     * 注册组件
     * @var string[]
     */
    protected $providers = [
        HttpServiceProvider::class, #http客户端
        AuthServiceProvider::class, #登录
        PageServiceProvider::class, #获取页面数据
    ];

    /**
     * 登录
     * @return Result
     */
    public function login(){
        return $this->auth->login();
    }
}