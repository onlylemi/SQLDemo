<?php
require 'inc/conn.php';
require 'inc/checklogin.php';

// 地址栏得到 sno 的值，要编辑的学生 学生
$sno = $_GET ['sno'];

$str = "true";
$str = "readonly='$str'";
// 判断用户类型，赋予不同权限
if ($sno == "" || ($user_type == 2 && $sno != $users ['s_no'])) {
	echo "<script>history.back()</script>";
} else {
	if ($user_type == 0) {
		$str = "";
	}
}

// 查询 学生信息
$query_stu = "SELECT * FROM student WHERE s_no='$sno'";
$result_stu = mysql_query ( $query_stu );
$stu = mysql_fetch_array ( $result_stu );
// 查询 当前学生所在楼的宿舍号、楼号
$studor = mysql_fetch_array ( mysql_query ( "SELECT * FROM dor WHERE d_id='{$stu['d_id']}'" ) );

// 判断 用户类型，是否拥有此操作
if ($user_type == 1 && $studor ['db_no'] != $users ['db_no']) {
	echo "<script>alert('该学生，不在你管理的宿舍内！');history.back()</script>";
}

/* 更新 学生 信息 */
$submit = $_POST ['submit'];
$stu_no = $_POST ['stu-no'];
$stu_name = $_POST ['stu-name'];
$stu_tel = $_POST ['stu-tel'];
$stu_age = $_POST ['stu-age'];
$stu_address = $_POST ['stu-address'];
$stu_sex = $_POST ['stu-sex'];
$stu_family = $_POST ['stu-family'];
$stu_school = $_POST ['stu-school'];
$stu_sub = $_POST ['stu-sub'];
$stu_class = $_POST ['stu-class'];
$stu_dor = $_POST ['stu-dor'];
$stu_bed = $_POST ['stu-bed'];
$stu_admin = $_POST ['stu-admin'];
$stu_word = $_POST ['stu-word'];
if ($submit != "") {
	// 管理员权限
	if ($user_type == 0) {
		if ($stu_name == "") {
			echo "<script>alert('抱歉，姓名 不能为空！');history.back()</script>";
			exit ();
		}
		if ($stu_tel == "") {
			echo "<script>alert('抱歉，电话 不能为空！');history.back()</script>";
			exit ();
		}
		if ($stu_sex == "") {
			echo "<script>alert('抱歉，性别 不能为空！');history.back()</script>";
			exit ();
		}
		
		if (mysql_num_rows ( mysql_query ( "SELECT * FROM dor_build WHERE db_no='{$studor['db_no']}' AND db_sex='$stu_sex'" ) ) == 0) {
			echo "<script>alert('抱歉，该学生 性别 与 住宿楼性别 不匹配！。');history.back()</script>";
			exit ();
		}
		
		if ($stu_school == "") {
			echo "<script>alert('抱歉，学院 不能为空！');history.back()</script>";
			exit ();
		}
		if ($stu_sub == "") {
			echo "<script>alert('抱歉，专业 不能为空！');history.back()</script>";
			exit ();
		}
		if ($stu_class == "") {
			echo "<script>alert('抱歉，班级 不能为空！');history.back()</script>";
			exit ();
		}
		
		mysql_query ( "UPDATE student SET s_name='$stu_name',s_tel='$stu_tel',s_age='$stu_address',s_sex='$stu_sex',s_family='$stu_family',s_school='$stu_school',s_sub='$stu_sub',s_class='$stu_class' WHERE s_no='$stu_no'" );
		echo "<script>alert('信息已成功 更新！');</script>";
	}
	
	// 楼管 和 管理员 可更换学生床位宿舍
	if ($user_type != 2) {
		$dors = mysql_fetch_array ( mysql_query ( "SELECT d_id,d_numnow FROM dor WHERE d_no='$stu_dor' AND db_no='{$studor['db_no']}'" ) );
		$result_stu_nowbed = mysql_query ( "SELECT s_no FROM student WHERE s_bed='$stu_bed' AND d_id='{$dors['d_id']}'" );
		$stu_nowbed = mysql_fetch_array ( $result_stu_nowbed );
		if (mysql_num_rows ( $result_stu_nowbed ) != 0) {
			mysql_query ( "UPDATE student SET s_bed='{$stu['s_bed']}',d_id='{$stu['d_id']}' WHERE s_no='{$stu_nowbed['s_no']}'" );
			mysql_query ( "UPDATE student SET s_bed='$stu_bed',d_id='{$dors['d_id']}' WHERE s_no='{$stu['s_no']}'" );
			
			echo "<script>alert('学号 {$stu['s_no']} 与 {$stu_nowbed['s_no']} 已对换！');location.href='?r=dorstu&db={$studor['db_no']}'</script>";
			exit ();
		} else {
			mysql_query ( "UPDATE student SET s_bed='$stu_bed',d_id='{$dors['d_id']}' WHERE s_no='{$stu['s_no']}'" );
			if ($stu_dor != $studor ['d_no']) {
				$temp = $studor ['d_numnow'] - 1;
				mysql_query ( "UPDATE dor SET d_numnow='$temp' WHERE d_id='{$stu['d_id']}'" );
				$temp = $dors ['d_numnow'] + 1;
				mysql_query ( "UPDATE dor SET d_numnow='$temp' WHERE d_id='{$dors['d_id']}'" );
			}
			
			echo "<script>alert('学号 {$stu['s_no']} 已更换宿舍与床位！');location.href='?r=dorstu&db={$studor['db_no']}'</script>";
			exit ();
		}
	}
	
	// 学生更改密码
	if ($user_type == 2 && $stu_word != "") {
		mysql_query ( "UPDATE student SET s_password=md5($stu_word) WHERE s_no='$sno'" );
		echo "<script>alert('您的信息已成功 更新！');location.href='?r=stuedit&sno=$sno'</script>";
		exit ();
	}
}
?>
<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>编辑学生 - 中北大学宿舍管理系统</title>
<link rel="icon" type="image/png" href="assets/i/favicon.png">
<link rel="stylesheet" href="assets/css/amazeui.min.css" />
<link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
	<header class="am-topbar admin-header">
		<?php require 'template/header.php';?>
	</header>

	<div class="am-cf admin-main">
		<!-- sidebar start -->
		<?php require 'template/sidebar.php';?>
		<!-- sidebar end -->

		<!-- content start -->
		<div class="admin-content">
			<div class="am-cf am-padding">
				<div class="am-fl am-cf">
					<strong class="am-text-primary am-text-lg">编辑 学号为<?php echo $sno?> 学生</strong>
				</div>
			</div>

			<hr />
			<div class="am-g">
				<div class="am-u-sm-12 am-u-md-4 am-u-md-push-8"></div>
				<div class="am-u-sm-12 am-u-md-8 am-u-md-pull-4">
					<form class="am-form am-form-horizontal" role="form" method="post"
						action="" enctype="multipart/form-data">
						<div class="am-form-group">
							<label for="stu-no" class="am-u-sm-3 am-form-label">学号</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-no" placeholder="学号"
									value="<?php echo $stu['s_no']?>" readonly="true">
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-name" class="am-u-sm-3 am-form-label">姓名</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-name" placeholder="输入你的姓名"
									value="<?php echo $stu['s_name']?>" <?php echo $str?>>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-tel" class="am-u-sm-3 am-form-label">电话</label>
							<div class="am-u-sm-9">
								<input type="tel" name="stu-tel" placeholder="输入你的电话号码"
									value="<?php echo $stu['s_tel']?>" <?php echo $str?>>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-age" class="am-u-sm-3 am-form-label">年龄</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-age" placeholder="输入你的年龄"
									value="<?php echo $stu['s_age']?>" <?php echo $str?>>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-address" class="am-u-sm-3 am-form-label">家庭地址</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-address" placeholder="输入你的家庭地址"
									value="<?php echo $stu['s_address']?>" <?php echo $str?>>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-sex" class="am-u-sm-3 am-form-label">性别</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-sex" placeholder="性别"
									value="<?php echo $stu['s_sex']?>" <?php echo $str?>>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-family" class="am-u-sm-3 am-form-label">名族</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-family" placeholder="名族"
									value="<?php echo $stu['s_family']?>" <?php echo $str?>>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-school" class="am-u-sm-3 am-form-label">学院</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-school" placeholder="请输入你的学院"
									value="<?php echo $stu['s_school']?>" <?php echo $str?>>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-sub" class="am-u-sm-3 am-form-label">专业</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-sub" placeholder="请输入你的专业"
									value="<?php echo $stu['s_sub']?>" <?php echo $str?>>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-class" class="am-u-sm-3 am-form-label">班级</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-class" placeholder="班级"
									value="<?php echo $stu['s_class']?>" <?php echo $str?>>
							</div>
						</div>
						
						<?php
						// 查询 宿舍楼名
						$stu_dor_name = mysql_fetch_array ( mysql_query ( "SELECT db_name FROM dor_build WHERE db_no='{$studor['db_no']}'" ) );
						?>

						<div class="am-form-group">
							<label for="stu-dorbuild" class="am-u-sm-3 am-form-label">宿舍楼号</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-dorbuild" placeholder="宿舍楼号"
									value="<?php echo $stu_dor_name['db_name']?>" readonly="true">
							</div>
						</div>
						
						<?php
						// 查询 该楼的所有宿舍号
						$result_dor = mysql_query ( "SELECT d_no FROM dor WHERE db_no='{$studor['db_no']}'" );
						?>
						<div class="am-form-group">
							<label for="stu-dor" class="am-u-sm-3 am-form-label">宿舍号</label>
							<div class="am-u-sm-9">
									<?php
									// 判断 用户类型，是否可编辑
									if ($user_type == 2) {
										echo "<select name='stu-dor' disabled='disabled'>";
									} else {
										echo "<select name='stu-dor'>";
									}
									// 把该宿舍楼的 所有宿舍号 遍历到数组中，输出
									while ( $db_dor = mysql_fetch_array ( $result_dor ) ) {
										if ($db_dor ['d_no'] == $studor ['d_no']) {
											echo "<option value='{$db_dor['d_no']}' selected='selected'>{$db_dor['d_no']}</option>";
										} else {
											echo "<option value='{$db_dor['d_no']}'>{$db_dor['d_no']}</option>";
										}
									}
									echo "</select>";
									?>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-bed" class="am-u-sm-3 am-form-label">床号</label>
							<div class="am-u-sm-9">
								<?php
								// 判断 用户类型，是否可编辑
								if ($user_type == 2) {
									echo "<select name='stu-bed' disabled='disabled'>";
								} else {
									echo "<select name='stu-bed'>";
								}
								
								// 输出该楼的 所有床位
								for($i = 1; $i <= $studor ['d_num']; $i ++) {
									if ($i == $stu ['s_bed']) {
										echo "<option value='$i' selected='selected'>$i</option>";
									} else {
										echo "<option value='$i' >$i</option>";
									}
								}
								echo "</select>";
								?>
								
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-admin" class="am-u-sm-3 am-form-label">舍长</label>
							<div class="am-u-sm-9">
									<?php
									// 判断 用户类型，是否可编辑
									if ($user_type == 2) {
										echo "<select name='stu-admin' disabled='disabled'>";
									} else {
										echo "<select name='stu-admin'>";
									}
									
									// 判断 是否为舍长
									if (1 == $stu ['s_isadmin']) {
										echo "<option value='0'>否</option>";
										echo "<option value='1' selected='selected'>是</option>";
									} else {
										echo "<option value='0' selected='selected'>否</option>";
										echo "<option value='1'>是</option>";
									}
									echo "</select>";
									?>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-word" class="am-u-sm-3 am-form-label">登录密码</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-word"
									placeholder="若修改密码，请直接输入新密码。否则，无需填写该项！" value="">
							</div>
						</div>

						<div class="am-form-group">
							<div class="am-u-sm-9 am-u-sm-push-3">
								<button type="submit" name="submit" value="yes"
									class="am-btn am-btn-primary">保存修改</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- content end -->

	</div>

	<footer class="template_footer">
		<?php require 'template/footer.php';?>
	</footer>

	<!--[if (gte IE 9)|!(IE)]><!-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/amazeui.min.js"></script>
	<!--<![endif]-->
	<script src="assets/js/app.js"></script>
</body>
</html>
