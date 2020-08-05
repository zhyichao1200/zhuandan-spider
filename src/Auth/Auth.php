<?php


namespace Momo\ZhuanDan\Auth;

use Momo\ZhuanDan\Http\Http;
use Momo\ZhuanDan\Model\Result;

/**
 * 登录
 * Class Auth
 * @package Momo\ZhuanDan\Auth
 */
class Auth
{
    /**
     * 用户名
     * @var string
     */
    private $username;

    /**
     * 密码
     * @var string
     */
    private $password;
    public function __construct(string $username,string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * 登录
     * @return Result
     */
    public function login() :Result
    {
        $res = Http::getClient()->post("/login",[
            "headers"=>[
                'X-Requested-With'=>'XMLHttpRequest',
                'isAjax'=>true
            ],
            "form_params"=>[
                "account"=>$this->username,
                "password"=>$this->password,
            ],
        ]);
        $logResAsArray = json_decode($res->getBody()->getContents(),true);
        $result = new Result;
        $result->setOk($logResAsArray["code"] === 0 ? true : false);
        $result->setMessage($logResAsArray["code"] === 0 ? "登录成功" : $logResAsArray["msg"]);
        return $result;
    }
}