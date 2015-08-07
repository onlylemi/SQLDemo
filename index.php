<?php
// 单一入口模式
error_reporting ( 0 ); // 关闭错误显示
$file = addslashes ( $_GET ['r'] ); // 接收文件名
$action = $file == '' ? 'index' : $file; // 判断为空或者等于index
include ('pages/admin-' . $action . '.php'); // 载入相应文件
