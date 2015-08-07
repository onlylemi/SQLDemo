<?php
require 'inc/conn.php';
require 'inc/checklogin.php';
include 'inc/page.class.php';

// 地址栏得到 delete 的值，要删除的学生 学号
$delete = $_GET ['delete'];
if ($delete != "") {
	// 宿舍人数减一
	$stu_dor = mysql_fetch_array ( mysql_query ( "SELECT d_id,d_numnow FROM dor WHERE d_id=(SELECT d_id FROM student WHERE s_no='$delete')" ) );
	$temp = $stu_dor ['d_numnow'] - 1;
	mysql_query ( "UPDATE dor SET d_numnow='$temp' WHERE d_id='{$stu_dor['d_id']}'" );
	
	$query1 = "DELETE FROM student WHERE s_no='$delete'";
	mysql_query ( $query1 ) or die ( '删除错误' . mysql_error () );
	
	echo "<script>alert('你好， 学号 " . $delete . " 学生已成功删除！');location.href='?r=stus'</script>";
}

// 查询学生信息
$query = "SELECT * FROM student ORDER BY s_id DESC";

// 搜索查询
$search = $_POST ['search'];
$searchkeys = $_POST ['searchkeys'];
if ($search != "" && $searchkeys != "") {
	$query = "SELECT * FROM student WHERE s_no='$searchkeys' OR s_name LIKE '%{$searchkeys}%' ORDER BY s_id DESC";
}

// 执行该 sql语句
$result = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );
?>

<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>学生管理 - 中北大学宿舍管理系统</title>
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
					<strong class="am-text-primary am-text-lg">所有学生</strong>
				</div>
			</div>

			<div class="am-g">
				<div class="am-u-md-6 am-cf">
					<div class="am-fl am-cf">
						<div class="am-btn-toolbar am-fl">
							<div class="am-btn-group am-btn-group-xs"></div>
						</div>
					</div>
				</div>
				<div class="am-u-md-3 am-cf">
					<div class="am-fr">
						<form method="post" action="" enctype="multipart/form-data">
							<div class="am-input-group am-input-group-sm">
								<input type="text" class="am-form-field" name="searchkeys"
									placeholder="请输入学号 / 姓名" value=""> <span
									class="am-input-group-btn">
									<button class="am-btn am-btn-default" type="submit"
										name="search" value="yes">搜索</button>
								</span>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="am-g">
				<div class="am-u-sm-12">
					<div class="am-form">
						<table class="am-table am-table-striped am-table-hover table-main">
							<thead>
								<tr>
									<th class="table-id">学号</th>
									<th class="table-title">姓名</th>
									<th class="table-title">住址</th>
									<th class="table-type">学院</th>
									<th class="table-author">专业</th>
									<th class="table-date">班级</th>
									<th class="table-ispay">性别</th>
									<th class="table-ispay">楼号</th>
									<th class="table-ispay">宿舍号</th>
									<th class="table-ispay">床号</th>
									<th class="table-set">操作</th>
								</tr>
							</thead>
							<tbody>
							<?php
							// 分页操作
							$bignum = 20;
							$da_num = mysql_num_rows ( $result );
							$page = new Page ( $da_num, $bignum );
							$query .= " {$page->limit}";
							$result = mysql_query ( $query ) or die ( '分页出错:' . mysql_error () );
							
							// 遍历 $result 结果集到数组中
							while ( $stus = mysql_fetch_array ( $result ) ) {
								
								?>
								<tr>
									<td><?php echo $stus['s_no']?></td>
									<td><a href="#"><?php echo $stus['s_name']?></a></td>
									<td><?php echo $stus['s_address']?></td>
									<td><span class="am-badge am-badge-success"><?php echo $stus['s_school']?></span></td>
									<td><?php echo $stus['s_sub']?></td>
									<td><?php echo $stus['s_class']?></td>
									<td><?php echo $stus['s_sex']?></td>
									<?php
								// 查询楼名信息
								$query_db_name = "SELECT db_name FROM dor_build WHERE db_no =ANY(SELECT db_no FROM dor WHERE d_id='{$stus['d_id']}')";
								$result_db_name = mysql_query ( $query_db_name ) or die ( 'SQL语句有误：' . mysql_error () );
								$db_names = mysql_fetch_array ( $result_db_name );
								?>
									<td><span class="am-badge am-badge-secondary"><?php echo $db_names['db_name']?></span></td>
									<?php
								// 查询 宿舍号 信息
								$query_d_no = "SELECT d_no,db_no FROM dor WHERE d_id='{$stus['d_id']}'";
								$result_d_no = mysql_query ( $query_d_no );
								$d_no = mysql_fetch_array ( $result_d_no );
								?>
									<td><?php echo $d_no['d_no']?></td>
									<td><?php echo $stus['s_bed']?></td>
									<?php
								if ($user_type == 0 || ($user_type == 1 && $d_no ['db_no'] == $users ['db_no'])) {
									?>
									<td><a href="?r=stuedit&sno=<?php echo $stus['s_no']?>"
										class="am-btn-xs"><i class="am-icon-pencil-square-o"></i>编辑</a>
										<a class="am-btn am-btn-xs"> </a> <a
										href="?r=stus&delete=<?php echo $stus['s_no']?>"
										onClick="return confirm('操作警告：\n\n请注意，删除后无法恢复，请谨慎操作\n\n您确定要删除吗？') "
										class="am-btn-xs am-text-danger"> <i class="am-icon-trash-o"></i>删除
									</a></td>
									<?php }?>
								</tr>
								<?php }?>
							</tbody>
						</table>
						<div class="am-cf">
							<?php echo $page->getMessage()?>
							<div class="am-fr">
								<ul class="am-pagination">
									<li><a href="<?php echo $page->startPage()?>">首页</a></li>
									<li><a href="<?php echo $page->prevPage()?>">«</a></li>
									<li><a href="<?php echo $page->nextPage()?>">»</a></li>
									<li><a href="<?php echo $page->endPage()?>">尾页</a></li>
								</ul>
							</div>
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
