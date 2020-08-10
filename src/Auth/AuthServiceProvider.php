<?php


namespace Momo\ZhuanDan\Auth;

use Momo\ZhuanDan\Bot;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * 注册AUTH
 * Class AuthServiceProvider
 * @package Momo\ZhuanDan\Auth
 */
class AuthServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['auth'] = function (Bot $pimple) {
            $config = $pimple->getConfig();
            return new Auth($config['username'], $config['password']);
        };
    }
}