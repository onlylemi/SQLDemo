<?php
// 获得 登录 所存放的cookie值
$user = $_COOKIE ['user'];
$user_type = $_COOKIE ['user_type'];

// 判断是否 登录
if ($user == "") {
	// 重定向页面到 登录页面
	header ( "Location: ?r=login" );
	exit ();
} else {
	// 查到用户的个人信息，以备使用
	switch ($user_type) {
		case 0 :
			$query = "SELECT * FROM admin WHERE a_no='$user'";
			$result = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );
			$users = mysql_fetch_array ( $result );
			$username = "管理员：" . $users ['a_name'];
			break;
		case 1 :
			$query = "SELECT * FROM dor_admin WHERE da_no='$user'";
			$result = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );
			$users = mysql_fetch_array ( $result );
			$username = "楼管{$users ['da_no']}：" . $users ['da_name'];
			break;
		case 2 :
			$query = "SELECT * FROM student WHERE s_no='$user'";
			$result = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );
			$users = mysql_fetch_array ( $result );
			$username = "学生{$users ['s_no']}：" . $users ['s_name'];
			break;
		default :
			break;
	}
}