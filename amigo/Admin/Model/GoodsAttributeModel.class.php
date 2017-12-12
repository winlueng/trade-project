<?php 
namespace Admin\Model;

use Think\Model;
use Think\Exception;

/**
 * 商品属性类
 */
class GoodsAttributeModel extends Model
{
	protected $_validate = array(
		array('attr_name', 'require', '请填写属性名称'),
		// array('inventory_total', 'require', '请输入库存'),
	);

	protected $_auto = array(
		array('update_time', 'time', 3, 'function'),
	);

	public function insert($goodsID)
	{
		if ($data = $this->create()) {
			$pic 	= I('post.attr_pic');
			$price 	= I('post.attr_price');
			$inventory 	= I('post.inventory_total');
			$data['goods_id'] = $goodsID;
			foreach (I('post.attr_val') as $k => $v) {
				if (!$v) {
					$this->error = '请填写商品属性值';return false;
				}
				$data['attr_val'] 	= $v;
				$data['attr_price'] = $price[$k];
				$data['inventory_total'] = $inventory[$k];
				$data['attr_pic'] 	= $pic[$k];
				$data['create_time'] = time();
				$res = $this->add($data);

				if (!$res) return false;
			}
			return true;
		}
		return false;
	}

	public function goodsList($goodsID)
	{
		return $this->where(['goods_id' => $goodsID, 'status' => ['neq', '-1']])->select();
	}

	/**
	 * 异步更新属性
	 */
	public function update()
	{
		if ($data = $this->create()) {
			$res = $this->where(['id' => I('post.attr_id')])->save($data);

			if ($res) return true;

			return false;
		}
		return false;
	}

	/**
	 * 异步上传
	 */
	private function asyncUpload()
	{
		$path = fileUpload('/Uploads/GoodsAttrImg/', 'attrPic', 'one', 500000);

		if (isset($path['error_msg'])) return $path['error_msg'];

		return thumbImage($path);
	}

	public function del()
	{
		$path = $this->where(['id' => I('get.attr_id')])->getField('attr_pic');

		unlink('./Public'.$path);

		$res = $this->where(['id' => I('get.attr_id')])->delete();
		
		return $res;
	}

	public function ajaxControl()
	{
		switch (I('get.flag')) {
			case 'asyncUpload':
				$result = $this->asyncUpload();
				break;
			case 'delAttrPic':
				$result = $this->delAttrPic();
				break;
			case 'del':
				$result = $this->del();
				break;
			case 'update' :
				$result = $this->update();
				break;
			case 'insAttr' :
				$result = $this->insert(I('post.goods_id'));
				break;
		}
		return $result;
	}

	public function delAttrPic()
	{
		$path = $this->where(['id' => I('get.attr_id')])->getField('attr_price');
		return unlink('./Public'.$path);
	}

}



 ?>