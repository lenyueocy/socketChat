<?php
header('content-type:text/html;charset=utf8');

//配置文件的处理和获取
$file = './config/config.php';
$config = include "./config/config.php";
class config{
    public static function get($key){
        global $config;
        return $config[$key];
    }
}
//开启监听以让前端握手
//system("php ./server.php $s >>/tmp/php-system().txt &",$result);

if(!file_exists($file)) {
    include "./install.php";
    exit;
}

$ctl = isset($_REQUEST['ctl'])? $_REQUEST['ctl'] : 'server';
$act = isset($_REQUEST['act'])? $_REQUEST['act'] : 'index';

if($ctl == 'server'){
    //聊天室控制器的设置参数
    $chat_host = '127.0.0.1';
    error_reporting(E_ALL);
    // 设置超时时间为无限,防止超时
    set_time_limit(0);
    date_default_timezone_set('Asia/shanghai');
}

//统一加载需要文件以及类文件
include "./model/DB.php";
include "./model/model.php";
include "./log/log.php";

//开始走控制器-》动作流程
include "./start.php";
include "./controller/".$ctl.".php";
start::run();

/*if(!file_exists($file)) {
    include "./install.php";
}else{
    include "./view/index.html";
}*/




function reurl($second,$url){
    include "../view/redirectURL.html";
}