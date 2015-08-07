<?php
/**
	 * file: page.class.php 
	 * 完美分页类 Page 
	 */
class Page {
	private $total; // 数据表中总记录数
	private $listRows; // 每页显示行数
	private $limit; // SQL语句使用limit从句,限制获取记录个数
	private $uri; // 自动获取url的请求地址
	private $pageNum; // 总页数
	private $page; // 当前页
	private $listNum = 10; // 默认分页列表显示的个数
	
	/**
	 * 构造方法，可以设置分页类的属性
	 *
	 * @param int $total        	
	 * @param int $listRows        	
	 * @param mixed $query        	
	 * @param bool $ord        	
	 */
	public function __construct($total, $listRows = 15, $query = "", $ord = true) {
		$this->total = $total;
		$this->listRows = $listRows;
		$this->uri = $this->getUri ( $query );
		$this->pageNum = ceil ( $this->total / $this->listRows );
		/* 以下判断用来设置当前面 */
		if (! empty ( $_GET ["page"] )) {
			$page = $_GET ["page"];
		} else {
			if ($ord)
				$page = 1;
			else
				$page = $this->pageNum;
		}
		
		if ($total > 0) {
			if (preg_match ( '/\D/', $page )) {
				$this->page = 1;
			} else {
				$this->page = $page;
			}
		} else {
			$this->page = 0;
		}
		
		$this->limit = "LIMIT " . $this->setLimit ();
	}
	
	/**
	 * 用于设置显示分页的信息，可以进行连贯操作
	 *
	 * @param string $param        	
	 * @param string $value        	
	 * @return object 用于连惯操作
	 */
	function set($param, $value) {
		if (array_key_exists ( $param, $this->config )) {
			$this->config [$param] = $value;
		}
		return $this;
	}
	
	/* 不是直接去调用，通过该方法，可以使用在对象外部直接获取私有成员属性limit和page的值 */
	function __get($args) {
		if ($args == "limit" || $args == "page")
			return $this->$args;
		else
			return null;
	}
	
	/**
	 * 得到记录信息
	 */
	public function getMessage() {
		$str = "共<b> {$this->total} </b> 条记录&nbsp;&nbsp;&nbsp;&nbsp;本页从 <b>{$this->start()}-{$this->end()}</b> 条";
		return $str;
	}
	
	/**
	 * 首页
	 */
	public function startPage() {
		$str = "{$this->uri}page=1";
		return $str;
	}
	
	/**
	 * 尾页
	 */
	public function endPage() {
		$str = "{$this->uri}page=" . ($this->pageNum) . "";
		return $str;
	}
	
	/**
	 * 上一页
	 */
	public function prevPage() {
		if ($this->page > 1) {
			$str = "{$this->uri}page=" . ($this->page - 1) . "";
			return $str;
		}
		$this->startPage ();
	}
	
	/**
	 * 下一页
	 */
	public function nextPage() {
		if ($this->page != $this->pageNum) {
			$str = "{$this->uri}page=" . ($this->page + 1) . "";
			return $str;
		}
		$this->endPage ();
	}
	
	/* 在对象内部使用的私有方法， */
	private function setLimit() {
		if ($this->page > 0)
			return ($this->page - 1) * $this->listRows . ", {$this->listRows}";
		else
			return 0;
	}
	
	/* 在对象内部使用的私有方法，用于自动获取访问的当前URL */
	private function getUri($query) {
		$request_uri = $_SERVER ["REQUEST_URI"];
		$url = strstr ( $request_uri, '?' ) ? $request_uri : $request_uri . '?';
		
		if (is_array ( $query ))
			$url .= http_build_query ( $query );
		else if ($query != "")
			$url .= "&" . trim ( $query, "?&" );
		
		$arr = parse_url ( $url );
		
		if (isset ( $arr ["query"] )) {
			parse_str ( $arr ["query"], $arrs );
			unset ( $arrs ["page"] );
			$url = $arr ["path"] . '?' . http_build_query ( $arrs );
		}
		
		if (strstr ( $url, '?' )) {
			if (substr ( $url, - 1 ) != '?')
				$url = $url . '&';
		} else {
			$url = $url . '?';
		}
		
		return $url;
	}
	
	/* 在对象内部使用的私有方法，用于获取当前页开始的记录数 */
	private function start() {
		if ($this->total == 0)
			return 0;
		else
			return ($this->page - 1) * $this->listRows + 1;
	}
	
	/* 在对象内部使用的私有方法，用于获取当前页结束的记录数 */
	private function end() {
		return min ( $this->page * $this->listRows, $this->total );
	}
	
	/* 在对象内部使用的私有方法，用于获取页数列表信息 */
	private function pageList() {
		$linkPage = "&nbsp;<b>";
		
		$inum = floor ( $this->listNum / 2 );
		/* 当前页前面的列表 */
		for($i = $inum; $i >= 1; $i --) {
			$page = $this->page - $i;
			
			if ($page >= 1)
				$linkPage .= "<a href='{$this->uri}page={$page}'>{$page}</a>&nbsp;";
		}
		/* 当前页的信息 */
		if ($this->pageNum > 1)
			$linkPage .= "<span style='padding:1px 2px;background:#BBB;color:white'>{$this->page}</span>&nbsp;";
			
			/* 当前页后面的列表 */
		for($i = 1; $i <= $inum; $i ++) {
			$page = $this->page + $i;
			if ($page <= $this->pageNum)
				$linkPage .= "<a href='{$this->uri}page={$page}'>{$page}</a>&nbsp;";
			else
				break;
		}
		$linkPage .= '</b>';
		return $linkPage;
	}
	
	/* 在对象内部使用的私有方法，用于显示和处理表单跳转页面 */
	private function goPage() {
		if ($this->pageNum > 1) {
			return '&nbsp;<input style="width:20px;height:17px !important;height:18px;border:1px solid #CCCCCC;" type="text" onkeydown="javascript:if(event.keyCode==13){var page=(this.value>' . $this->pageNum . ')?' . $this->pageNum . ':this.value;location=\'' . $this->uri . 'page=\'+page+\'\'}" value="' . $this->page . '"><input style="cursor:pointer;width:25px;height:18px;border:1px solid #CCCCCC;" type="button" value="GO" onclick="javascript:var page=(this.previousSibling.value>' . $this->pageNum . ')?' . $this->pageNum . ':this.previousSibling.value;location=\'' . $this->uri . 'page=\'+page+\'\'">&nbsp;';
		}
	}
	
	/* 在对象内部使用的私有方法，用于获取本页显示的记录条数 */
	private function disnum() {
		if ($this->total > 0) {
			return $this->end () - $this->start () + 1;
		} else {
			return 0;
		}
	}
}

	
	
	