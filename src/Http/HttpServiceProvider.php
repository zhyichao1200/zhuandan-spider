<?php


namespace Momo\ZhuanDan\Http;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * HTTP客户端注册
 * Class HttpServiceProvider
 * @package Momo\ZhuanDan\Http
 */
class HttpServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        Http::setClient($pimple->getConfig('cookiePath'));
    }
}