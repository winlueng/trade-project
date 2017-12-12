<?php
namespace PT2\Model;

use Think\Model\AdvModel;
use Think\Model;

class GoodsCommentModel extends CommonModel
{ 
	protected $insertFields = ['goods_id','order_id','content','visitor_id','company_id','score','create_time','status','image'];

	public function __construct()
	{
		parent::__construct();
	}

	public function insert()
	{
		if ($data = $this->create()) {
			$ins['company_id'] 	= $data['company_id'];
			$ins['order_id'] 	= $data['order_id'];
			// return $data;
			if ($_FILES['image'.$data['goods_id'][0]]['size'][0] != 0 ) {
				$path = fileUpload('/Uploads/commentImg/', '', 'more');
				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}

				foreach ($path as $vo) {
					$arr[] = thumbImage($vo);
				}
			}
			
			$i = 0;

			$this->startTrans();

			foreach ($data['goods_id'] as $v) {
				if (($_FILES['image'.$v]['size']) != 0) {
					for ($j = 0; $j < count($_FILES['image'.$v]['size']); $i++, $j++) { 
						$img[] = $arr[$i];
					}
				}

				$ins['image'] = $img?json_encode($img):'';
				$ins['goods_id'] = (int)$v;
				$ins['visitor_id'] = $this->userInfo['id'];
				$ins['create_time'] = time();
				$ins['score'] = $data['score'][(int)$v]?$data['score'][(int)$v]:3;
				$ins['content'] = $data['content'][(int)$v]?$data['content'][(int)$v]:'有点懒,没做评论';
				$img = [];
				$res = $this->add($ins);
				if (!$res) {
					$this->rollback();
					$this->error = '评论出错';return false;
				}
			} 
			$orderData = [
				'goods_score' 	=> I('post.goods_score')?I('post.goods_score'):3,
				'express_score' => I('post.express_score')?I('post.express_score'):3,
				'status'		=> 4,
			];

			$res = M('OrderForm')->where(['id' => $data['order_id']])->save($orderData);

			if (!$res) {
				$this->rollback();
				$this->error = '评论出错';return false;
			}
			$this->commit();
			return true;
		}
		return false;
	}
}