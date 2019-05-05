<?php
/**
 *  CREATE TABLE `agent`(
 *     `id` int(10) UNSIGNED NOT NULL,
 *     `code` varchar(10) NOT NULL,
 *      `status` tinyint(3) NOT NULL,
 *      `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
 *  )ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员列表';
 */
require_once 'redis2.class.php';
$redis = new \Redis2('127.0.0.1','6379','','15');
//$order_sn   = 'SN'.time().'T'.rand(10000000,99999999);
//
//$use_mysql = 1;         //是否使用数据库，1使用，2不使用
//if($use_mysql == 1){
//    require_once 'db.class.php';
//    $mysql = new \mysql();
//    $mysql->connect();
//    $data = ['ordersn'=>$order_sn,'status'=>0,'createtime'=>date('Y-m-d H:i:s',time())];
//    $mysql->insert('order',$data);
//}

$list = ['123456', 1];
$key = implode(':',$list);
$redis->setex($key,3,'redis延迟任务');      //3秒后回调
print_r($list);

/*
 *   测试其他key会不会有回调，结果：有回调
 *   $k = 'test';
 *   $redis2->set($k,'100');
 *   $redis2->expire($k,10);
 *
*/
