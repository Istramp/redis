<?php
/**
 * Created by PhpStorm.
 * User: cd
 * Date: 2019/4/23
 * Time: 18:15
 */
class Redis2
{
    private $redis;

    public function __construct($host = '127.0.0.1', $port = '6379',$password = '',$db = '15')
    {
        $this->redis = new Redis();
        $this->redis->connect($host, $port);    //连接Redis
        $this->redis->auth($password);      //密码验证
        $this->redis->select($db);    //选择数据库
    }

    public function setex($key, $time, $val)
    {
        return $this->redis->setex($key, $time, $val);
    }

    public function set($key, $val)
    {
        return $this->redis->set($key, $val);
    }

    public function get($key)
    {
        return $this->redis->get($key);
    }

    public function expire($key = null, $time = 0)
    {
        return $this->redis->expire($key, $time);
    }

    public function psubscribe($patterns = array(), $callback)
    {
        $this->redis->psubscribe($patterns, $callback);
    }

    public function setOption()
    {
        $this->redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
    }

    public function lRange($key,$start,$end)
    {
        return $this->redis->lRange($key,$start,$end);
    }

    public function lPush($key, $value1, $value2 = null, $valueN = null ){
        return $this->redis->lPush($key, $value1, $value2 = null, $valueN = null );
    }

    public function delete($key1, $key2 = null, $key3 = null)
    {
        return $this->redis->delete($key1, $key2 = null, $key3 = null);
    }

}