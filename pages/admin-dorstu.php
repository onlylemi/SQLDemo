<?php
require 'inc/conn.php';
require 'inc/checklogin.php';
include 'inc/page.class.php';

// 地址栏得到 db 的值，为当前宿舍楼号
$db_no = $_GET ['db'];

// 根据楼号，查询宿舍信息
$query = "SELECT * FROM dor WHERE db_no='$db_no' ORDER BY d_no ASC";

// 搜索查询
$search = $_POST ['search'];
$searchkeys = $_POST ['searchkeys'];
// 搜索按钮已按，且 已输入搜索信息，执行搜索操作
if ($search != "" && $searchkeys != "") {
	$query = "SELECT * FROM dor WHERE db_no='$db_no' AND d_no='$searchkeys' ORDER BY d_no ASC";
}

// 地址栏得到 isfull 的值，判断是否住满
$isfull = $_GET ['isfull'];
// 当 isfull 不为控制，执行该操作
if ($isfull != "") {
	if ($isfull == 1) { // 查询住满
		$query = "SELECT * FROM dor WHERE db_no='$db_no' AND d_num=d_numnow ORDER BY d_no ASC";
	} else if ($isfull == 0) { // 查询未住满
		$query = "SELECT * FROM dor WHERE db_no='$db_no' AND d_num!=d_numnow ORDER BY d_no ASC";
	}
}

// 执行改 sql语句，得到结果集
$result = mysql_query ( $query ) or die ( '分页出错:' . mysql_error () );

// 根据楼号，查询楼名信息
$query_db_name = "SELECT db_name,db_sex FROM dor_build WHERE db_no='$db_no'";
$result_db_name = mysql_query ( $query_db_name ) or die ( 'SQL语句有误：' . mysql_error () );
$db_names = mysql_fetch_array ( $result_db_name );
?>
<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $db_names['db_name']?> - 中北大学宿舍管理系统</title>
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
					<strong class="am-text-primary am-text-lg"><?php echo $db_names['db_name']."（{$db_names['db_sex']}）"?></strong>
				</div>
			</div>

			<div class="am-g">
				<div class="am-u-md-6 am-cf">
					<div class="am-fl am-cf">
						<div class="am-btn-toolbar am-fl">
							<div class="am-btn-group am-btn-group-xs">
							<?php
							if ($user_type == 0 || ($user_type == 1 && $db_no == $users ['db_no'])) {
								echo "<a href='?r=stunew&db=$db_no'><button
										class='am-btn am-btn-default'>新增学生</button></a> ";
							}
							?>
										<a href="?r=dorstu&db=<?php echo $db_no?>&isfull=1"><button
										class="am-btn am-btn-default">已住满</button></a> <a
									href="?r=dorstu&db=<?php echo $db_no?>&isfull=0"><button
										class="am-btn am-btn-default">未住满</button></a>
							</div>
						</div>
					</div>
				</div>
				<div class="am-u-md-3 am-cf">
					<div class="am-fr">
						<form method="post" action="" enctype="multipart/form-data">
							<div class="am-input-group am-input-group-sm">
								<input type="text" class="am-form-field" name="searchkeys"
									placeholder="请输入宿舍号"> <span class="am-input-group-btn">
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
									<th>宿舍号</th>
									<th>应住人数</th>
									<th>实住人数</th>
									<th>1号</th>
									<th>2号</th>
									<th>3号</th>
									<th>4号</th>
									<th>5号</th>
									<th>6号</th>
									<th>7号</th>
									<th>8号</th>
									<th>备注</th>
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
							
							// 把 $result 结果集遍历到数组中
							while ( $dor = mysql_fetch_array ( $result ) ) {
								?>
								<tr>
									<td><?php echo $dor['d_no']?></td>
									<td><?php echo $dor['d_num']?></td>
									<td><?php echo $dor['d_numnow']?></td>
									<?php
								// 根据 宿舍dor表中的d_id，在student表中查找该宿舍的所有学生
								$query1 = "SELECT s_no,s_name,s_bed,s_isadmin FROM student WHERE d_id ={$dor['d_id']} ORDER BY s_bed ASC";
								$result1 = mysql_query ( $query1 ) or die ( 'SQL语句有误：' . mysql_error () );
								
								// 宿舍成员，对号入座
								$i = 1;
								$isSame = false;
								while ( $i <= 8 ) {
									if (! $isSame) {
										$stus = mysql_fetch_array ( $result1 );
										$isSame = true;
									}
									
									if ($i == $stus ['s_bed']) {
										$isSame = false;
										// 判断是否为 舍长
										if ($stus ['s_isadmin']) {
											echo "<td><span class='am-badge am-badge-secondary'><a href='?r=stuedit&sno={$stus['s_no']}' title='{$stus['s_no']}'>{$stus['s_name']}</a></span></td>";
										} else {
											echo "<td><a href='?r=stuedit&sno={$stus['s_no']}' title='{$stus['s_no']}'>{$stus['s_name']}</a></td>";
										}
									} else {
										echo "<td></td>";
									}
									$i ++;
								}
								// 判断该宿舍 是否住满
								if ($dor ['d_num'] == $dor ['d_numnow']) {
									echo "<td><span class='am-badge am-badge-success'>已住满</span></td>";
								} else {
									echo "<td><span class='am-badge am-badge-danger'>未住满</span></td>";
								}
								?>
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
