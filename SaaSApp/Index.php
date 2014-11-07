<?php

define('STRIP_RUNTIME_SPACE',false);
//定义项目名称
define('APP_NAME', 'index');
//定义项目存放路径
define('APP_PATH', 'index');
//定义ThinkPHP核心文件路径
define('THINK_PATH','./ThinkPHP');
//引入PHP核心文件
require THINK_PATH.'/ThinkPHP.php';
//实例化项目
App::run();
?>