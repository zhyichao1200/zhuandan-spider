<?php


namespace Momo\ZhuanDan\Http;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
class HttpServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        Http::setClient($pimple->getConfig('cookiePath'));
    }
}