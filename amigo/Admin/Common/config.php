<?php 
	define('MYSQL_PASSWORD', 'sheng0123');
	define('MYSQL_USERNAME', 'root');
	define('MYSQL_HOST', '172.16.0.17');
	define('DBNAME', 'trade_database');
	define('FIX_NAME', 'market_');
	define('CHAR', 'utf8');

	/**
	 * 冒泡排序
	 * @param array() $arr 需要排序的数组
	 * @param string  $value 根据字段排序的名称
	 * @return array() $arr 返回排序后的数组
	 */
	function bubblingSort($arr, $value='click_total')
	{
		if (is_array($arr)) 
		{
			$len = count($arr);
		}else{
			return $arr;
		}

		for($i=1;$i<$len;$i++)
        { 
        	//该层循环用来控制每轮 冒出一个数 需要比较的次数
            for($k=0;$k<$len-$i;$k++)
            {
                if((int)$arr[$k][$value]<(int)$arr[$k+1][$value])
                {
                    $tmp=$arr[$k+1];
                    $arr[$k+1]=$arr[$k];
                    $arr[$k]=$tmp;
                }
            }
        }
        return $arr;
	}

	// 过滤重复值
	function filtrationArr($arr, $value)
	{
		$testArr = array();
		// 过滤重复goods_id
		foreach ($arr as $ki => $vo) 
		{
			if (!in_array($vo[$value], $testArr)) 
			{
				$testArr[] = $vo[$value];
			}
		}
		return $testArr;
	}

 ?>