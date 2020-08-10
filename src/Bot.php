<?php


namespace Momo\ZhuanDan;

use Momo\ZhuanDan\Http\HttpServiceProvider;
use Momo\ZhuanDan\Auth\AuthServiceProvider;
use Momo\ZhuanDan\Page\PageServiceProvider;

/**
 * 转单宝机器人
 * Class Bot
 * @package Momo\ZhuanDan
 */
class Bot extends Foundation
{
    protected $providers = [
        HttpServiceProvider::class,
        AuthServiceProvider::class,
        PageServiceProvider::class,
    ];

    /**
     * 登录
     * @return \Momo\ZhuanDan\Model\Result
     */
    public function login(){
        return $this->auth->login();
    }
}