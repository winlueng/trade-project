<?php 
namespace Template00002\Model;

use Think\Model;

class GoodsModel extends Model
{
	public function showGoodsList()
	{
		$uid = $_SESSION['projectInfo']['id'];
		$classify = M('Goods_classify');
		$classifyList = $classify->field('id, classify_name')->where(['uid' => $uid])->select();
		foreach ($classifyList as $k => $v) 
		{
			$classifyList[$k]['goodsList'] = $this->field('id, goods_name, goods_logo,price')->where(['classify_id' => $v['id'], 'uid' => $uid,  'status'=>['not in','3,4']])->select();
		}
		return $classifyList;
	}

	public function showGoodsDetail()
	{
		$uid = $_SESSION['projectInfo']['id'];
		$goodsId = I('get.id');
		$goods['Info'] = $this->field('classify_id, goods_name, goods_title, price')->where(['status'=>['neq',3], 'uid' => $uid,'id' => $goodsId])->select()[0];
		if ($goods['Info']) 
		{
			$goods['thesame'] = $this->field('id, goods_name, goods_logo')->where(['classify_id' => $goods['Info']['classify_id']])->limit(4)->select();
			$goods['pictureList'] = M('goods_picture')->where(['goods_id' => $goodsId])->getField('pic_path', true);
			$goods['Info']['goods_title'] = htmlspecialchars_decode(html_entity_decode($goods['Info']['goods_title']));
			return $goods;
		}else{
			return false;
		}


	}
}