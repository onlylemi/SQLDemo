<div class="admin-sidebar">
	<ul class="am-list admin-sidebar-list">
		<li><a href="?r=index"><span class="am-icon-home"></span> 首页 </a></li>
		<?php
		// 判断 用户类型，设置显示的不同页面
		switch ($user_type) {
			case 0 :
				$href = "?r=admin&ano={$users['a_no']}";
				$guandor = "管理";
				$guanstu = "管理";
				break;
			case 1 :
				$href = "?r=daedit&da={$users['da_no']}";
				$guandor = "";
				$guanstu = "管理";
				break;
			case 2 :
				$href = "?r=stuedit&sno={$users['s_no']}";
				$guandor = "";
				$guanstu = "";
				break;
		}
		?>
		<li><a href='<?php echo $href?>'><span class="am-icon-pencil-square-o"></span>
				个人信息 </a></li>
		<li><a href="?r=dora"><span class="am-icon-table"></span> 楼管<?php echo $guandor?> </a></li>
		<li><a href="?r=stus"><span class="am-icon-table"></span> 学生<?php echo $guanstu?> </a></li>
		<li class="admin-parent"><a class="am-cf"
			data-am-collapse="{target: '#collapse-nav'}"><span
				class="am-icon-file"></span> 宿舍<?php echo $guanstu?> <span
				class="am-icon-angle-right am-fr am-margin-right"></span></a>
			<ul class="am-list am-collapse admin-sidebar-sub am-in"
				id="collapse-nav">
				<?php
				// 查询 宿舍楼信息
				$query_db = "SELECT * FROM dor_build";
				$result_db = mysql_query ( $query_db ) or die ( 'SQL语句有误：' . mysql_error () );
				while ( $d_b = mysql_fetch_array ( $result_db ) ) {
					?>
				<li><a href="?r=dorstu&db=<?php echo $d_b['db_no']?>" class="am-cf"><?php echo $d_b['db_name']."（{$d_b['db_sex']}）"?></a></li>
			<?php }?>
			</ul></li>
	</ul>

</div>