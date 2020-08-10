<?php
include_once __DIR__.'/../vendor/autoload.php';
use Momo\ZhuanDan\Bot;
$username = "18698562829";
$password = "hn123qy";
$cookiePath = __DIR__."\user\\".$username."\cookie.txt";
//!is_dir($cookiePath) and mkdir($cookiePath,0777,true);
$bot = new Bot([
    "username"=>$username,
    "password"=>$password,
    "cookiePath"=>$cookiePath
]);
$res = $bot->login();
if(!$res->getOk()) throw new \Exception($res->getMessage());
$page = $bot->page;
var_dump($page->main());