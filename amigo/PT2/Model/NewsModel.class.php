<?php 
namespace PT2\Model;

use Think\Model;

class NewsModel extends CommonModel
{
	public function showNewsList($classify)
	{
		$where = [
			'relevance_id' => $this->pInfo['id'],
			'company_id' => 0,
			'status' => 0,
			'news_classify_id' => $classify
		];
		$list = $this->field('id, news_logo, news_name, title, video, is_video')->where($where)->order('addtime desc')->select();
		foreach ($list as $v) {
			$v['news_logo'] = json_decode($v['news_logo'], true);
			$v['visit_total']   = M('NewsStatistics')->where(['relevance_id' => $v['id']])->sum('visit_total');
			$result[] = $v;
 		}
		return $result;
	}

	public function selNewsInfo()
	{
		$result = $this->field('id, news_logo, news_name, title, video, is_video, addtime, img_path, goods_id')
				->where([
					'id' => I('get.id'),
					'status' => ['neq', '-1'],
					'relevance_id' => $this->pInfo['id'],
					'company_id'=> 0,
				])->find();
		$result['img_path'] = htmlspecialchars_decode(html_entity_decode($result['img_path']));
		$result['addtime'] = date('Y-m-d H:i:s', $result['addtime']);
		$result['news_logo'] = json_decode($result['news_logo'], true);
		$result['visit_total']   = M('NewsStatistics')->where(['relevance_id' => $result['id']])->sum('visit_total');
		$result['goods_info']  = M('Goods')->field('id, price, goods_name, is_promotion, promotion_price, discount, goods_logo, status, sales_end_time, sales_start_time')->where(['id' => $result['goods_id']])->find();
		$this->saveStatis('NewsStatistics', I('get.id'));
		return $result;
	}

}