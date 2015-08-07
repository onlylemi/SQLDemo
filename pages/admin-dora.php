<?php
require 'inc/conn.php';
require 'inc/checklogin.php';
include 'inc/page.class.php';

// 地址栏得到 delete 的值，要删除的楼管 编号
$delete = $_GET ['delete'];
// 不为空时，执行删除操作
if ($delete != "") {
	$query2 = "DELETE FROM dor_admin WHERE da_no='$delete'";
	mysql_query ( $query2 ) or die ( '删除错误' . mysql_error () );
	echo "<script>alert('你好， 编号 " . $delete . " 楼管已成功删除！');location.href='?r=dora'</script>";
}

// 查询楼管信息
$query = "SELECT * FROM dor_admin ORDER BY da_id DESC";

// 搜索查询
$search = $_POST ['search'];
$searchkeys = $_POST ['searchkeys'];
// 搜索按钮已按，且 已输入搜索信息，执行搜索操作
if ($search != "" && $searchkeys != "") {
	$query = "SELECT * FROM dor_admin WHERE da_no='$searchkeys' OR da_name LIKE '%$searchkeys%'";
}
// 执行改 sql语句，得到结果集
$result = mysql_query ( $query ) or die ( 'SQL语句有误：' . mysql_error () );
?>
<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>楼管管理 - 中北大学宿舍管理系统</title>
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
					<strong class="am-text-primary am-text-lg">住宿楼管理员</strong>
				</div>
			</div>

			<div class="am-g">
				<div class="am-u-md-6 am-cf">
					<div class="am-fl am-cf">
						<div class="am-btn-toolbar am-fl">
							<div class="am-btn-group am-btn-group-xs">
							<?php
							if ($user_type == 0) {
								?>
								<a href="?r=danew"><button class="am-btn am-btn-default">新增楼管</button></a>
								<?php }?>
							</div>
						</div>
					</div>
				</div>
				<div class="am-u-md-3 am-cf">
					<div class="am-fr">
						<form method="post" action="" enctype="multipart/form-data">
							<div class="am-input-group am-input-group-sm">
								<input type="text" class="am-form-field" name="searchkeys"
									placeholder="请输入楼管编号/姓名"> <span class="am-input-group-btn">
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
									<th>编号</th>
									<th>姓名</th>
									<th>年龄</th>

								</tr>
							</thead>
							<tbody>
							<?php
							// 分页操作
							$bignum = 10;
							$da_num = mysql_num_rows ( $result );
							$page = new Page ( $da_num, $bignum );
							$query .= " {$page->limit}";
							$result = mysql_query ( $query ) or die ( '分页出错:' . mysql_error () );
							
							// 把得到的 $result 结果集遍历到数组中
							while ( $dadmins = mysql_fetch_array ( $result ) ) {
								?>
								<tr>
									<td><?php echo $dadmins['da_no']?></td>
									<td><a href=""><?php echo $dadmins['da_name']?></a></td>
									<td><?php echo $dadmins['da_age']?></td>
									<td><?php echo $dadmins['da_address']?></td>
									<td><?php echo $dadmins['da_tel']?></td>
									<?php
								// 根据 在 dor_admin中查询到的db_no，在dor_build中查询楼名
								$query1 = "SELECT db_name FROM dor_build WHERE db_no='{$dadmins['db_no']}'";
								$result1 = mysql_query ( $query1 ) or die ( 'SQL语句有误：' . mysql_error () );
								$dor_build = mysql_fetch_array ( $result1 );
								?>
									<td><?php echo $dor_build['db_name']?></td>
									<?php
								// 判断用户类型，赋予不同权限
								if ($user_type == 0) {
									?>
									<td><a href="?r=daedit&da=<?php echo $dadmins['da_no']?>"
										class="am-btn-xs"><i class="am-icon-pencil-square-o"></i>编辑</a>
										<a class="am-btn am-btn-xs"> </a> <a
										href="?r=dora&delete=<?php echo $dadmins['da_no']?>"
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
