<?php
include_once __DIR__.'/../vendor/autoload.php';
use Momo\ZhuanDan\Bot;
$username = "13566211389";
$password = "qw63878363";
$cookiePath = __DIR__."\user\\".$username."\cookie.txt";
//!is_dir($cookiePath) and mkdir($cookiePath,0777,true);
$bot = new Bot([
    "username"=>$username,
    "password"=>$password,
    "cookiePath"=>$cookiePath
]);
$bot->login();