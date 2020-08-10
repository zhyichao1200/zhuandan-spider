<?php


namespace Momo\ZhuanDan\Page;

use Momo\ZhuanDan\Bot;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * 注册页面数据
 * Class PageServiceProvider
 * @package Momo\ZhuanDan\Page
 */
class PageServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['page'] = function (Bot $pimple) {
            return new Page();
        };
    }
}