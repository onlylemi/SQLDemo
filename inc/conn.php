<?php
error_reporting ( 0 );
header ( 'Content-Type:text/html;charset=utf-8' ); // 页面字符集utf-8
                                                   
// 常量参数
define ( 'DB_HOST', 'localhost' );
define ( 'DB_USER', 'root' );
define ( 'DB_PWD', 'root' );
define ( 'DB_NAME', 'sqldemo' );

// 第一步，连接MYSQL服务器
$conn = mysql_connect ( DB_HOST, DB_USER, DB_PWD ) or die ( '连接MYSQL服务器 失败！' . mysql_error () );
// 第二步，选择指定的数据库
mysql_select_db ( DB_NAME ) or die ( '数据库错误，错误信息：' . mysql_error () );

// 设置字符集
mysql_query ( 'SET NAMES UTF8' ) or die ( '字符集设置错误' . mysql_error () );
// 设置中国时区
date_default_timezone_set ( 'PRC' ); 
