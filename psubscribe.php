<?php
#! /usr/bin/env php
ini_set('default_socket_timeout', -1);  //不超时
require_once 'redis2.class.php';
$redis_db = '15';
$redis = new \Redis2('127.0.0.1','6379','',$redis_db);
// 解决Redis客户端订阅时候超时情况
$redis->setOption();
//当key过期的时候就看到通知，订阅的key __keyevent@<db>__:expired 这个格式是固定的，db代表的是数据库的编号，由于订阅开启之后这个库的所有key过期时间都会被推送过来，所以最好单独使用一个数据库来进行隔离
$redis->psubscribe(array('__keyevent@'.$redis_db.'__:expired'), 'keyCallback');
// 回调函数,这里写处理逻辑
function keyCallback($redis, $pattern, $channel, $msg)
{
    echo PHP_EOL;
    echo "Pattern: $pattern\n";
    echo "Channel: $channel\n";
    echo "Payload: $msg\n\n";
    $list = explode(':',$msg);

    $code = isset($list[0])?$list[0]:'0';
    $use_mysql = isset($list[1])?$list[1]:'0';

    if($use_mysql == 1){
        require_once 'db.class.php';
        $mysql = new \mysql();
        $mysql->connect();
        $where = "code = '".$code."'";
        $mysql->select('agent','',$where);
        $finds=$mysql->fetchAll();
        print_r($finds);
        if(isset($finds[0]['status']) && $finds[0]['status']==0){
            $data   = array('status' => 3);
            $where  = " id = ".$finds[0]['id'];
            $mysql->update('agent',$data,$where);
        }
    }

}


//或者
/*$redis->psubscribe(array('__keyevent@'.$redis_db.'__:expired'), function ($redis, $pattern, $channel, $msg){
    echo PHP_EOL;
    echo "Pattern: $pattern\n";
    echo "Channel: $channel\n";
    echo "Payload: $msg\n\n";
    //................
});*/
