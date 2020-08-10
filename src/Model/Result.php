<?php


namespace Momo\ZhuanDan\Model;

/**
 * 返回实例
 * Class Result
 * @package Momo\ZhuanDan\Model
 */
class Result
{
    protected $ok = false,$message,$data;

    /**
     * @param bool $ok
     * @return $this
     */
    public function setOk(bool $ok) :Result
    {
        $this->ok = $ok;
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message) :Result
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setData($data)  :Result
    {
        $this->data = $data;
        return $this;
    }

    public function __call($name, $arguments)
    {
        $attribute = strtolower(substr($name,3));
        if(!property_exists($this,$attribute)) throw new \Exception("调用的属性不存在");
        return $this->$attribute;
    }
}