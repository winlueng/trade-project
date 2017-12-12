<?php 
namespace Template00002\Controller;

use Think\Controller;

// 搜索控制器
class SearchController extends CommonController
{
	private $XS;
	private $doc;
	private $XSindex;
	private $search;

	public function __construct()
	{
		parent::__construct();
		vendor('XSsdk.php.lib.XS');
		$this->XS  		= new \XS($this->companyInfo['sx_data_base']);
		$this->doc 		= new \XSDocument();
		$this->XSindex	= $this->XS->index;
		$this->search 	= $this->XS->search;
		$this->assign('searchObj',$this->search);
	}

	public function showSearch()
	{
		$hotWord = $this->search->getHotQuery(10, 'currnum');// 查询本周前10的热门搜索关键词
		arsort($hotWord);// 搜索量从大到小排序
		$hotWord = array_flip($hotWord);
		$history = $this->saveOrGetHistory();
		$this->assign('hotWords', $hotWord);
		$this->assign('historyWords', $history);
		$this->display();exit;
	}

	// 进行搜索
	public function goSearch()
	{
		if (!I('get.words')) {// 判断时候有输入词搜索
			$hotWord = $this->search->getHotQuery();// 获取前 6 个总热门搜索词
			arsort($hotWord);// 根据值降序数组
			$hotWord = array_flip($hotWord); // 键值反转
			$hotWord = array_merge($hotWord);// 重新排列数组下标
			$word = $hotWord[0];// 得到第一热门的搜索词
			$_GET['words'] = $word;
		}else{
			$word = I('get.words');
		}
		$res = $this->search->setFuzzy()->setQuery($word)->setLimit(30)->setSort('addtime', true)->search();
		$this->saveOrGetHistory(I('get.words'));// 记录用户搜索词
		foreach ($res as $v) {
			$arr[$v->id]['sales'] = M('GoodsSalesVolume')->where(['goods_id' => $v->id])->sum('sales_total');
		} 
		$this->assign('empty','<br><center><font size="3" color="gary">暂时没有找到你想要的</font></center>');
		$this->assign('words', $word);
		$this->assign('sales', $arr);
		$this->assign('list', $res);
		$this->display();exit;
	}

	/**
	 * 记录搜索记录
	 * @param  [type] $status 1: 获取历史记录 2: 记录历史记录
	 */
	public function saveOrGetHistory($data = '')
	{
		// $this->redis->delete('B_history_search_by'.$this->userInfo['id']);
		$history = $this->redis->get('B_history_search_by'.$this->userInfo['id']);
		$history = json_decode($history, true);
		if ($data) {
			if (count($history) > 5) {// 判断搜索记录是否超过5个
				array_pop($history);// 弹出最后的搜索记录
				array_unshift($history, $data); // 压入这次的搜索记录
			}else if(!$history){// 如果没记录就记录这次
				$history = [$data];
			}else{
				array_unshift($history, $data);// 压入这次的搜索记录
				$history = array_unique($history);
			}
			$history = array_unique($history);
			$this->redis->set('B_history_search_by'.$this->userInfo['id'], json_encode($history));
		}else{
			return $history;
		}
	}

	public function ajaxControl()
	{
		if(!IS_AJAX) E('非法访问');
		$flag = I('get.flag');
		$this->ajaxReturn($this->$flag());
	}

	// 获取相关搜索词
	public function getCorrelation()
	{
		$words = $this->search->getExpandedQuery(I('get.correlation'), 10);// 获取10个相关搜索词
		foreach ($words as $v) {
			$arr[] = ['name' => $v];
		}
		return $arr;
	}
}