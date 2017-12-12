<?php 
namespace Template00002\Model;

use Think\Model;

class NewsModel extends CommonModel
{
	public function showNewsList()
	{
		$classifyList = M('NewsClassify')->field('id, news_type_name')->where([
						'company_id' => $this->companyInfo['id'], 
						'status' => 0
					])->select();
		$result['classifyList'] = $classifyList;

		$where = array(
				'company_id' => $this->companyInfo['id'],
				'status' => 0,
				'news_classify_id' => $classifyList[0]['id'],
				'is_top' => 0,
			);
		
		if (I('get.news_classify_id')) 
		{
			$where['news_classify_id'] = I('get.news_classify_id');
		}
		$topNewsList = $this->newsList($where);

		$where['is_top'] = 1;

		$noTop = $this->newsList($where);
		
		if (!$topNewsList) {
			$result['newsList'] = $noTop;
		}else{
			$result['newsList'] = array_merge((array)$topNewsList, (array)$noTop);
		}

		return $result;
	}

	public function newsList($where)
	{
		
		$list = $this->field('id, news_logo, news_name, title')->where($where)->order('addtime desc')->select();

		foreach ($list as $v) {
			$v['visit_total'] = M('NewsStatistics')->where(['relevance_id' => $v['id']])->sum('visit_total');
			$res[] = $v;
		}
		return $res;
	}

	public function selNewsInfo()
	{
		$id = I('get.id');
		$result = $this->where(['id' => $id])->find();
		$result['visit_total'] = M('NewsStatistics')->where(['relevance_id' => $id])->sum('visit_total');
		$result['img_path'] = htmlspecialchars_decode(html_entity_decode($result['img_path']));
		$this->saveStatis('NewsStatistics', $id);
		return $result;
	}

	public function ajaxControl()
	{
		$flag = I('get.flag');
		switch ($flag) {
			case 'showNewsList':
				$result = $this->showNewsList();
				break;
		}

		return $result;
	}
}