<?php


namespace Momo\ZhuanDan\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;

/**
 * http客户端（单例）
 * Class Http
 * @package Momo\ZhuanDan\Http
 */
class Http
{
    static $client;

    /**
     * @param string $cookiePath
     */
    public static function setClient(string $cookiePath)
    {
        $cookie = new FileCookieJar($cookiePath, true);
        static::$client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36'
            ],
            'cookies' => $cookie,
            "verify"=>false,
            "http_errors"=>false,
            "base_uri"=> 'http://www.zhuandan.com',
        ]);
    }

    /**
     * @return Client
     */
    public static function getClient() :Client
    {
        return static::$client;
    }
}