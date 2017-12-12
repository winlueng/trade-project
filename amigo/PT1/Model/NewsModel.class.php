<?php 
namespace PT1\Model;

use Think\Model;

class NewsModel extends Model
{
	public function showNewsList()
	{
		$result = $this->field('id, news_logo, news_name, title')->where(['uid' => $_SESSION['projectInfo']['id'],'status' => 0])->select();
		return $result;
	}

	public function selNewsInfo()
	{
		$id = I('get.id');
		$result = $this->field('news_name, addtime, img_path')->where(['id' => $id])->select()[0];
		$result['img_path'] = htmlspecialchars_decode(html_entity_decode($result['img_path']));
		$result['addtime'] = date('Y-m-d H:i:s', $result['addtime']);
		return $result;
	}

	public function selPrevAndNextNews()
	{
		$id = I('get.id');
		$uid = $_SESSION['projectInfo']['id'];
		$news['prev'] = $this->field('id, news_name')->where(['id'=>['lt',$id],'uid' => $uid])->order('id desc')->limit(1)->select()[0];
		$news['next'] = $this->field('id, news_name')->where(['id'=>['gt',$id],'uid' => $uid])->order('id')->limit(1)->select()[0];
		return $news;
	}
}