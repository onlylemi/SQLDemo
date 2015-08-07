<?php
ob_start ();
require 'inc/conn.php';

$login = $_POST ['login'];
$admin_no = $_POST ['admin_no'];
$password = $_POST ['password'];
$vcode = $_POST ['vcode'];
if ($login != "") {
	session_start (); // 开启SESSION
	/* 判断用户在表单中输入的字符串和验证码图片中的字符串是否相同 */
	if (strtoupper ( trim ( $vcode ) ) != $_SESSION ['vcode']) { // 如果验证码输出成功
		echo "<Script language=JavaScript>alert('抱歉，验证码输入错误。');history.back();</Script>";
		exit ();
	}
	// 从 管理员 中查找
	$admin_type = 0;
	$query = "SELECT a_no,a_password password FROM admin WHERE a_no='$admin_no'";
	$result1 = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );
	if (! mysql_num_rows ( $result1 )) {
		// 从 楼管 中查找
		$query = "SELECT da_no,da_password password FROM dor_admin WHERE da_no='$admin_no'";
		$result1 = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );
		$admin_type = 1;
		
		if (! mysql_num_rows ( $result1 )) {
			// 从 学生 中查找
			$query = "SELECT s_no,s_password password FROM student WHERE s_no='$admin_no'";
			$result1 = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );
			$admin_type = 2;
		}
	}
	$users = mysql_fetch_array ( $result1 );
	
	if (! mysql_num_rows ( $result1 )) {
		echo "<Script language=JavaScript>alert('抱歉，用户名或者密码错误。');history.back();</Script>";
		exit ();
	} else {
		$passwords = $users ['password'];
		if (md5 ( $password ) != $passwords) {
			echo "<Script language=JavaScript>alert('抱歉，用户名或者密码错误。');history.back();</Script>";
			exit ();
		}
		// 把当前登录的用户号存到cookie中
		setcookie ( 'user_type', $admin_type, 0, '/' );
		setcookie ( 'user', $admin_no, 0, '/' );
		echo "<script>this.location='?r=index'</script>";
		exit ();
	}
	exit ();
}
ob_end_flush ();
?>

<!DOCTYPE html>
<html>
<head>
<meta content="IE=11.0000" http-equiv="X-UA-Compatible">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="icon" type="image/png" href="assets/i/favicon.png">
<title>登录 - 中北大学宿舍管理系统</title>
<script src="assets/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="assets/js/login.js" type="text/javascript"></script>
<link rel="stylesheet" type="test/css" href="assets/css/login.css">
</head>
<script>
	/* 定义一个JavaScript函数，当单击验证码时被调用，将重新请求并获取一个新的图片 */
	function newgdcode(obj, url) {
		/* 后面传递一个随机参数，否则在IE7和火狐下，不刷新图片 */
		obj.src = url + '?nowtime=' + new Date().getTime();
	}
</script>
<body>
	<div class="top_div">
		<div class="top_title">
			<h1>中北大学 宿舍管理系统</h1>
		</div>

	</div>
	<div class="login_window">
		<div class="login_cat">
			<div class="tou"></div>
			<div class="initial_left_hand" id="left_hand"></div>
			<div class="initial_right_hand" id="right_hand"></div>
		</div>
		<form method="post" action="" enctype="multipart/form-data">
			<p style="padding: 30px 0px 10px; position: relative;">
				<span class="u_logo"></span> <input name="admin_no" class="ipt"
					type="text" placeholder="请输入管理员号/楼管编号/学号" value="" />
			</p>
			<p style="padding: 0px 0px 10px; position: relative;">
				<span class="p_logo"></span> <input class="ipt" name="password"
					type="password" placeholder="请输入密码" value="" />
			</p>
			<p style="position: relative;">
				<span class="p_logo"></span> <input name="vcode" class="ipt1"
					type="text" placeholder="请输入验证码" /> <img id="vcode_img"
					src="inc/imagecode.php" alt="看不清楚，换一张" style="cursor: pointer;"
					onclick="javascript: newgdcode(this, this.src);" />
			</p>
			<div
				style="height: 50px; line-height: 50px; margin-top: 30px; border-top-color: rgb(231, 231, 231); border-top-width: 1px; border-top-style: solid;">
				<p style="margin: 0px 35px 20px 45px;">
					<span style="float: left;"><a style="color: rgb(204, 204, 204);"
						href="#">忘记密码?</a></span> <span style="float: right;"><a
						style="color: rgb(204, 204, 204); margin-right: 10px;" href="#">注册</a>
						<button type="submit" name="login" value="yes" class="btn_login">登录</button>
					</span>
				</p>
			</div>
		</form>
	</div>
	<footer class="template_footer">
		<?php require 'template/footer.php';?>
	</footer>
</body>
</html>
