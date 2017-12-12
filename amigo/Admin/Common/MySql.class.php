<?php 

/**
 * mysql封装类
 */
class MySql
{
	protected $link;		//连接数据库
	protected $tabName;		//表格名
	protected $where;		//条件
	protected $allFields;	//所有字段名
	protected $limit = '';		//查询几条
	protected $order;		//排序条件
	protected $Field = '*';	//查询的目标
	public    $redis;
	//连接数据库构造函数
	public function __construct($table)
	{
		$this->link=mysqli_connect(MYSQL_HOST,MYSQL_USERNAME,MYSQL_PASSWORD,DBNAME) or die('连接数据库失败');
		mysqli_set_charset($this->link,CHAR);
		$this->tabName=FIX_NAME.$table;
		$this->desc();
		$this->redis = new Redis;
		$this->redis->connect('127.0.0.1', 6379);
	}

	//基于id条件查询表里的数据
	public function selectId($id)
	{
		$sql="select * from {$this->tabName} where id={$id}";
		return $this->query($sql)[0];
	}

	//查询表格里所有数据
	public function select()
	{
		$sql="select {$this->Field} from {$this->tabName} {$this->where} {$this->order} {$this->limit}";
		// return "$sql";
		return $this->query($sql);
	}

	//为分页做准备的
	public function Count()
	{
		$sql="select count(*) as total from {$this->tabName} {$this->where}";
		return $this->query($sql)[0]['total'];
	}


	//删除数据
	public function del()
	{
		$sql="delete from {$this->tabName} {$this->where}";
		return $this->exe($sql);
	}

	//修改表格数据(改)
	public function update($post)
	{	
		if (is_array($post)) {
			foreach ($post as $k => $v) {
				$arr[] = $k.'="'.$v.'"';
			}
			$str=join(',',$arr);
		$sql="update {$this->tabName} set {$str} {$this->where}";
		return $this->exe($sql);
		}
		//return false;
	}

	//插入数据(增)
	public function insert($post)
	{	
		if(!empty($this->field(join(',',array_keys($post))))){
		$sql="insert into {$this->tabName}(".join(',',array_keys($post)).") values('".implode($post,'\',\'')."')";
		// echo "$sql";
		return $this->exe($sql);
		}
		return false;
	}

	//原始sql语句执行
	public function sqlV($sql)
	{
		return $this->query($sql);
	}
	
	/********************** 辅助方法 ***************************/

	/**
	 * 作为select查询目标
	 * @param $arr:传进来的字符串或数组进行跟数据库字段匹配过滤
	 * @return 返回一个过滤后的字符串
	 */
	public function field($arr)
	{	
		if (!is_array($arr)){
			$arr=explode(',',$arr);
		}
		
		$b=array_intersect($this->allFields,$arr);

		if (!empty($b)) {
			$this->Field=implode(',',$b);
			return $this;
		}
		//return false;
	}

	/*
	 *查询where条件
	 */
	public function where($post)
	{
		$arr = array();
		if (is_array($post)) {
			foreach ($post as $k => $v) {
				if (is_array($v)) {
				 	foreach ($v as $ki => $va){
				 		switch ($k) {
				 			case 'gt':
				 				$arr[] = $ki.'>"'.$va.'"';
				 				break;
				 			case 'lt':
				 				$arr[] = $ki.'<"'.$va.'"';
				 				break;
				 			case 'neq':
				 				$arr[] = $ki.'<>"'.$va.'"';
				 				break;
				 			case 'like':
				 				$arr[] = $ki.' like "%'.$va.'%"';
				 				break;
				 			case 'in':
				 				$arr[] = $ki.' in('.$va.')';
				 				break;
				 			case 'not in':
				 				$arr[] = $ki.' not in('.$va.')';
				 				break;
				 		}
				 	}
				 }else{
				 	$arr[] = $k.'="'.$v.'"';
				 }
			}
			$this->where="where ".join(' and ',$arr);
			return $this;
		} 
		//return false;
	}

	/*
	 * limit为分页做准备
	 */
	public function limit($str ='')
	{
		if(is_string($str)){
		$this->limit="limit ".$str;
		return $this;
		}
		//return false;
	}

	/**
	 * 排序
	 */
	public function order($con)
	{
		$this->order="order by ".$con;
		return $this;
	}
/******************************发送到数据库******************************/
	/**
	 *	发送数据库执行用于查询
	 * @param   $sql 发送到数据库
	 * @return array     返回一个查询后的二维数组
	 */
	protected function query($sql)
	{
		$res=mysqli_query($this->link,$sql);
		if ($res && mysqli_num_rows($res)>0) {
			while ($row = mysqli_fetch_assoc($res)) {
				$arr[]=$row;
			}
			return $arr;
		}
		return false;
	}

	/**
	 * 用于执行增删改
	 * @param  string $sql [description]
	 * @return 返回一个结果值
	 */
	protected function exe($sql)
	{
		$res=mysqli_query($this->link,$sql);
		if($res && mysqli_affected_rows($this->link)>0){
			return mysqli_insert_id($this->link)?mysqli_insert_id($this->link):mysqli_affected_rows($this->link);
		}
		return false;
	}

	/**
	 * 得到一个表格里的所有字段
	 */
	public function desc()
	{
		$sql="desc {$this->tabName}";
		$arr1=array();
		$arr=$this->query($sql);
		foreach ($arr as $v) {
			$arr1[]= $v['Field'];
		}
		return $this->allFields=$arr1;
	}

	public function __set($tabName,$value)
	{
		if ($tabName == 'tabName') {
			$this->$tabName = FIX.$value;
			$this->desc();
		}
	}
}
?>