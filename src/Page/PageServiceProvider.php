<?php


namespace Momo\ZhuanDan\Page;

use Momo\ZhuanDan\Bot;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
class PageServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['page'] = function (Bot $pimple) {
            return new Page();
        };
    }
}