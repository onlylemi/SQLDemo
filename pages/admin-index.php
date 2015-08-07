<?php
require 'inc/conn.php';
require 'inc/checklogin.php';

// 查询最新 15 条学生记录
$query = "SELECT * FROM student ORDER BY s_id DESC LIMIT 15";
$result = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );

?>
<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>首页- 中北大学宿舍管理系统</title>
<link rel="icon" type="image/png" href="assets/i/favicon.png">
<link rel="stylesheet" href="assets/css/amazeui.min.css" />
<link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

	<!-- header start -->
	<header class="am-topbar admin-header">
		<?php require 'template/header.php';?>
	</header>
	<!-- header end -->

	<div class="am-cf admin-main">
		<!-- sidebar start -->
		<?php require 'template/sidebar.php';?>
		<!-- sidebar end -->

		<!-- content start -->
		<div class="admin-content">

			<div class="am-cf am-padding">
				<div class="am-fl am-cf">
					<strong class="am-text-primary am-text-lg">首页</strong>
				</div>
			</div>
			<ul
				class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list ">

				<li><a href="" class="am-text-success"><span
						class="am-icon-btn am-icon-user-md"></span><br />系统管理员<br />2</a></li>
				<li><a href="" class="am-text-warning"><span
						class="am-icon-btn am-icon-user-md"></span><br />楼管<br />14</a></li>
				<li><a href="" class="am-text-danger"><span
						class="am-icon-btn am-icon-recycle"></span><br />宿舍楼<br />20</a></li>
				<li><a href="" class="am-text-secondary"><span
						class="am-icon-btn am-icon-user-md"></span><br />学生<br /><?php echo mysql_num_rows ( $result )?></a></li>
			</ul>

			<div class="am-g">
				<div class="am-u-sm-12">
					<div class="am-form">
						<table class="am-table am-table-striped am-table-hover table-main">
							<thead>
								<tr>
									<th>学号</th>
									<th>姓名</th>
									<th>学院</th>
									<th>专业</th>
									<th>班级</th>
									<th>性别</th>
									<th>楼号</th>
									<th>宿舍号</th>
									<th>床号</th>
								</tr>
							</thead>
							<tbody>
							<?php
							// 结果集遍历到数组
							while ( $stus = mysql_fetch_array ( $result ) ) {
								?>
								<tr>
									<td><?php echo $stus['s_no']?></td>
									<td><a href="#"><?php echo $stus['s_name']?></a></td>
									<td><span class="am-badge am-badge-success"><?php echo $stus['s_school']?></span></td>
									<td><?php echo $stus['s_sub']?></td>
									<td><?php echo $stus['s_class']?></td>
									<td><?php echo $stus['s_sex']?></td>
									<?php
								// 查询 楼名 信息
								$query_db_name = "SELECT db_name FROM dor_build WHERE db_no =ANY(SELECT db_no FROM dor WHERE d_id='{$stus['d_id']}')";
								$result_db_name = mysql_query ( $query_db_name ) or die ( 'SQL语句有误：' . mysql_error () );
								$db_names = mysql_fetch_array ( $result_db_name );
								?>
									<td><span class="am-badge am-badge-secondary"><?php echo $db_names['db_name']?></span></td>
									<?php
								// 查询 宿舍 信息
								$query_d_no = "SELECT d_no FROM dor WHERE d_id='{$stus['d_id']}'";
								$result_d_no = mysql_query ( $query_d_no );
								$d_no = mysql_fetch_array ( $result_d_no );
								?>
									<td><?php echo $d_no['d_no']?></td>
									<td><?php echo $stus['s_bed']?></td>
								</tr>
								<?php }?>
							</tbody>
						</table>
						<div class="am-cf">
							<?php echo "最新15条记录"?>
						</div>
						<hr />
					</div>
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
