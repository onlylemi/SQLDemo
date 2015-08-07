<?php
require 'inc/conn.php';
require 'inc/checklogin.php';

// 地址栏得到 db 的值，要新增的学生所在的 楼号
$db = $_GET ['db'];
// 判断用户权限，是否拥有该页面的权限
if ($db == "" || $user_type == 2) {
	echo "<script>history.back()</script>";
} else {
	if ($user_type == 1 && $db != $users ['db_no']) {
		echo "<script>history.back()</script>";
	}
}

// 查询 楼名
$query_dor_name = "SELECT db_name FROM dor_build WHERE db_no='$db'";
$result_dor_name = mysql_query ( $query_dor_name );
$dor_name = mysql_fetch_array ( $result_dor_name );

/* 新增学生 信息 */
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
	
	$result_stu = mysql_query ( "SELECT s_no FROM student WHERE s_no='$stu_no'" );
	if (mysql_num_rows ( $result_stu ) != 0) {
		echo "<script>alert('抱歉，该学号学生 已存在！');history.back()</script>";
		exit ();
	}
	
	if ($stu_no == "") {
		echo "<script>alert('抱歉，学号 不能为空！');history.back()</script>";
		exit ();
	}
	
	if ($stu_name == "") {
		echo "<script>alert('抱歉，姓名 不能为空！');history.back()</script>";
		exit ();
	}
	if ($stu_tel == "") {
		echo "<script>alert('抱歉，电话 不能为空！');history.back()</script>";
		exit ();
	}
	if ($stu_sex == "性别") {
		echo "<script>alert('抱歉，性别 不能为空！');history.back()</script>";
		exit ();
	}
	
	if (mysql_num_rows ( mysql_query ( "SELECT db_sex FROM dor_build WHERE db_no='$db' AND db_sex='$stu_sex'" ) ) == 0) {
		echo "<script>alert('抱歉，该学生 性别 与 住宿楼性别 不匹配！。');history.back()</script>";
		exit ();
	}
	
	if ($stu_school == "学院") {
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
	
	if ($stu_dor == "宿舍号") {
		echo "<script>alert('抱歉，宿舍号 不能为空！');history.back()</script>";
		exit ();
	}
	
	if ($stu_bed == "床号") {
		echo "<script>alert('抱歉，床号 不能为空！');history.back()</script>";
		exit ();
	}
	
	// 查询 输入的宿舍号 与 楼号查询到该其对于的 d_id
	$dors = mysql_fetch_array ( mysql_query ( "SELECT d_id,d_numnow FROM dor WHERE d_no='$stu_dor' AND db_no='$db'" ) );
	if (mysql_num_rows ( mysql_query ( "SELECT * FROM student WHERE s_bed='$stu_bed' AND d_id='{$dors['d_id']}'" ) ) != 0) {
		echo "<script>alert('抱歉，$stu_dor 宿舍 $stu_bed 床已有人！。');history.back()</script>";
		exit ();
	}
	
	if ($stu_admin == 1 && mysql_num_rows ( mysql_query ( "SELECT * FROM student WHERE s_isadmin='$stu_admin' AND d_id='{$dors['d_id']}'" ) ) != 0) {
		echo "<script>alert('抱歉，$stu_dor 宿舍 已存在舍长！。');history.back()</script>";
		exit ();
	}
	
	if ($stu_word == "") {
		echo "<script>alert('抱歉，密码 不能为空！');history.back()</script>";
		exit ();
	}
	
	// 插入到 student 表中
	$query = "INSERT INTO student(s_no,s_name,s_age,s_sex,s_address,s_tel,s_school,s_sub,s_class,s_family,s_bed,s_isadmin,d_id,s_password) 
	VALUES('$stu_no','$stu_name','$stu_age','$stu_sex','$stu_address','$stu_tel','$stu_school','$stu_sub','$stu_class','$stu_family','$stu_bed','$stu_admin','{$dors['d_id']}',md5($stu_word))";
	mysql_query ( $query ) or die ( '新增错误' . mysql_error () );
	
	// 更新人数 +1
	$dor_numnow = $dors ['d_numnow'] + 1;
	mysql_query ( "UPDATE dor SET d_numnow='$dor_numnow' WHERE d_no='$stu_dor' AND db_no='$db'" );
	
	echo "<script>alert('您好，学号 $stu_no 学生 已成功添加。');location.href='?r=dorstu&db=$db'</script>";
	exit ();
}

?>
<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>新增学生 - 中北大学宿舍管理系统</title>
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
					<strong class="am-text-primary am-text-lg"><?php echo $dor_name['db_name']?> 新增学生</strong>
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
								<input type="text" name="stu-no" placeholder="请输入新学生的 学号">
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-name" class="am-u-sm-3 am-form-label">姓名</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-name" placeholder="请输入新学生的 姓名">
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-tel" class="am-u-sm-3 am-form-label">电话</label>
							<div class="am-u-sm-9">
								<input type="tel" name="stu-tel" placeholder="请输入新学生的 电话号码">
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-age" class="am-u-sm-3 am-form-label">年龄</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-age" placeholder="请输入新学生的 年龄">
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-address" class="am-u-sm-3 am-form-label">家庭地址</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-address" placeholder="请输入新学生的 家庭地址">
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-sex" class="am-u-sm-3 am-form-label">性别</label>
							<div class="am-u-sm-9">
								<select name="stu-sex">
									<option value="性别">请选择 性别</option>
									<option value="男">男</option>
									<option value="女">女</option>
								</select>
							</div>
						</div>
						<div class="am-form-group">
							<label for="stu-family" class="am-u-sm-3 am-form-label">名族</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-family" placeholder="请输入新学生的 名族">
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-school" class="am-u-sm-3 am-form-label">学院</label>
							<div class="am-u-sm-9">
								<select name="stu-school" data-placeholder="请选择学院">
									<option value="学院">请选择 学院</option>
									<option value="机电工程学院">机电工程学院</option>
									<option value="机械与动力工程学院">机械与动力工程学院</option>
									<option value="材料科学与工程学院">材料科学与工程学院</option>
									<option value="化工与环境学院">化工与环境学院</option>
									<option value="信息与通信工程学院">信息与通信工程学院</option>
									<option value="仪器与电子学院">仪器与电子学院</option>
									<option value="计算机与控制工程学院">计算机与控制工程学院</option>
									<option value="理学院">理学院</option>
									<option value="经济与管理学院">经济与管理学院</option>
									<option value="人文社会科学学院">人文社会科学学院</option>
									<option value="体育学院">体育学院</option>
									<option value="艺术学院">艺术学院</option>
									<option value="软件学院">软件学院</option>
									<option value="研究生院">研究生院</option>
									<option value="继续教育学院">继续教育学院</option>
									<option value="后备军官教育学院">后备军官教育学院</option>
									<option value="国际教育学院">国际教育学院</option>
									<option value="信息商务学院">信息商务学院</option>
									<option value="中北大学朔州校区">中北大学朔州校区</option>
								</select>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-sub" class="am-u-sm-3 am-form-label">专业</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-sub" placeholder="请输入新学生的 专业">
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-class" class="am-u-sm-3 am-form-label">班级</label>
							<div class="am-u-sm-9">
								<input type="text" name="stu-class" placeholder="请输入新学生的 班级">
							</div>
						</div>
						
						<?php
						// 查询该楼的 宿舍
						$query_dor = "SELECT d_no,d_num FROM dor WHERE db_no='$db' AND d_num!=d_numnow";
						$result_dor = mysql_query ( $query_dor );
						?>

						<div class="am-form-group">
							<label for="stu-dor" class="am-u-sm-3 am-form-label">宿舍号</label>
							<div class="am-u-sm-9">
								<select name="stu-dor" data-placeholder="请选择宿舍号">
									<option value="宿舍号">请选择 宿舍号</option>
									<?php
									// 遍历 该楼的所有的宿舍号
									while ( $db_dor = mysql_fetch_array ( $result_dor ) ) {
										?>
									<option value='<?php echo $db_dor['d_no']?>'><?php echo $db_dor['d_no']?></option>
									<?php }?>
								</select>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-bed" class="am-u-sm-3 am-form-label">床号</label>
							<div class="am-u-sm-9">
								<select name="stu-bed" tabindex="1" data-placeholder="请选择床号">
									<option value="床号">请选择 床号</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
								</select>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-admin" class="am-u-sm-3 am-form-label">舍长</label>
							<div class="am-u-sm-9">
								<select name="stu-admin">
									<option value="0">否</option>
									<option value="1">是</option>
								</select>
							</div>
						</div>

						<div class="am-form-group">
							<label for="stu-word" class="am-u-sm-3 am-form-label">登录密码</label>
							<div class="am-u-sm-9">
								<input type="password" name="stu-word"
									placeholder="请输入新学生的 初始密码">
							</div>
						</div>
						<div class="am-form-group">
							<div class="am-u-sm-9 am-u-sm-push-3">
								<button type="submit" name="submit" value="yes"
									class="am-btn am-btn-primary">确认 添加</button>
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
