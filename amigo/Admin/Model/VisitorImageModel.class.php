<?php 
namespace Admin\Model;

use Think\Model;

/**
* 前台用户model类
*/
class VisitorImageModel extends CommonModel
{
	private $visitorObj;

	protected $insertFields = array('visitor_id','company_upload','information','create_time','update');

	protected $updateFields = array('visitor_id','company_upload','information','create_time','update');

	protected $_validate = [
		['visitor_id', 'require', '请传入用户id'],
	];

	protected $_auto = [
		['update_time', 'time',2, 'function']
	];

	function __construct()
	{
		parent::__construct();

		$this->visitorObj=M('WechatVisitor');
	}

	public function update($id = '')
	{
		if (I('get.id')) {
			$id = I('get.id');
		}

		if (!$id) {
			return false;
		}
		if ($data = $this->create()) {
			$where = [
				'id' => $id,
				'visitor_id' => I('get.visitor_id')
			];
			if ($_FILES['company_upload']['size'][0] != 0) 
			{
				$pic = $this->where($where)->getField('company_upload');

				$pic = json_decode($pic, true);

				if ((count($_FILES['company_upload']['size']) + count($pic)) > 5) 
				{
					$this->error = '形象图片超过5张了';return false;
				}

				$img = fileUpload('/Uploads/visitorImage/', '', 'more');

				if (isset($img['error_msg'])) {
					$this->error = $img['error_msg'];return false;
				}

				foreach ($img as $v) {
					$path[] = thumbImage($v);
				}

				$pic = array_merge($pic, $path);

				$data['company_upload'] = json_encode($pic);
			}
			$data['information'] = json_encode($data['information']);
			// return $data;
			$result = $this->where($where)->save($data);

			if($result) return $result;

			$this->error = '修改形象失败';false;
		}
		return false;
	}

	public function insert()
	{
		$today = strtotime('Today');
		$where = [
				'create_time' => $today,
				'visitor_id' => I('get.visitor_id')
			];
		$find = $this->where($where)->find();
		// return $find;
		if ($find) {
			return $this->update($find['id']);
		}else{
			if ($data = $this->create()) {
				if ($_FILES['company_upload']['size'][0] != 0) 
				{
					if (count($_FILES['company_upload']['size']) > 5) 
					{
						$this->error = '最多上传5张图片';return false;
					}
					$img = fileUpload('/Uploads/visitorImage/', '', 'more');

					if (isset($img['error_msg'])) {
						$this->error = $img['error_msg'];return false;
					}

					foreach ($img as $v) {
						$path[] = thumbImage($v);
					}
					$data['visitor_id'] = I('get.visitor_id');
					$data['create_time'] = $today;
					$data['company_upload'] = json_encode($path);
					$data['information'] = json_encode($data['information']);
					$res = $this->add($data);
					if($res) return $res;

					$this->error = '上传失败';return false;
				}
				$this->error = '请上传用户照片';return false;
			}
			return false;
		}
	}

	/**
	 * 获取用户历史形象
	 */
	public function getImageInfo()
	{
		$where = ['visitor_id' => I('get.visitor_id')];

		$timeList = $this->field(['FROM_UNIXTIME(create_time, "%Y-%m-%d")' => 'create_time'])->where($where)->order('create_time desc')->select();
		if (I('get.time')) $where['create_time'] = I('get.time');
		
		$field = [
			'FROM_UNIXTIME(create_time, "%Y-%m-%d %H:%i:%S")' => 'create_time',
			'company_upload',
			'visitor_upload',
			'information',
			'visitor_id',
			'id',
		];
		$info = $this->field($field)->where($where)->order('create_time desc')->find();
		$info['historical_time'] = $timeList;
		$info['information'] = json_decode($info['information'], true);
		$info['company_upload'] = json_decode($info['company_upload'], true);
		$info['visitor_upload'] = json_decode($info['visitor_upload'], true);
		return $info;
	}

	// 删除形象图片
	public function delImagePic()
	{
		$where = [
			'id' => I('get.id'),
			'visitor_id' => I('get.visitor_id'),
		];
		$pic = $this->where($where)->getField('company_upload');
		$pic = json_decode($pic);
		$delPic = $pic[I('get.number')];
		unlink('./Public'.$delPic);
		unset($pic[I('get.number')]);
		$pic = array_merge($pic);
		return $this->where($where)->setField('company_upload', json_encode($pic));
	}

	// 删除形象图片
	public function delVisitorImagePic()
	{
		$where = [
			'id' => I('get.id'),
			'visitor_id' => I('get.visitor_id'),
		];
		$pic = $this->where($where)->getField('visitor_upload');
		$pic = json_decode($pic);
		$delPic = $pic[I('get.number')];
		unlink('./Public'.$delPic);
		unset($pic[I('get.number')]);
		$pic = array_merge($pic);
		return $this->where($where)->setField('visitor_upload', json_encode($pic));
	}

	/**
	 * ajax的操作
	 * @param  string $flag 传递过来的get参数
	 */
	public function ajaxControl($flag)
	{
		return $this->$flag();
	}

}

 ?>