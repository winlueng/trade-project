<?php 
namespace Template00002\Model;

use Think\Model;

class VisitorImageModel extends CommonModel
{
	private $where;

	public function __construct()
	{
		parent::__construct();
		$this->where = ['visitor_id' => $this->userInfo['id']];
	}

	public function imageList()
	{
		$count = M('VisitorImage')->where($this->where)->count();

		$page = new \Think\Page($count, 10);

		$list = $this->field('company_upload, visitor_upload, create_time')
				->where($this->where)
				->order('create_time desc')
				->limit($page->firstRow.','.$page->listRows)
				->select();
		foreach ($list as $v) {
			$v['company_upload'] = json_decode($v['company_upload'], true);
			$v['visitor_upload'] = json_decode($v['visitor_upload'], true);
			$result[] = $v;
		}
		return $result;
	}

	public function imageUpdate()
	{
		$info = $this
			->field('visitor_upload,id')
			->where($this->where)
			->order('create_time desc')
			->find();

		$pic = json_decode($info['visitor_upload'], true);

		$path = fileUpload('/Uploads/visitorImage/', 'visitor_image', 'one', 2000000);

		if (isset($path['error_msg'])) return $path['error_msg'];
		$image = thumbImage($path);
		// return json_encode([$image]);
		if (!$pic) {
			return $this->where(['id' => $info['id']])->setField('visitor_upload', json_encode([$image]));
		}else{
			if (count($pic) > 2) {
				$oldPic = array_shift($pic);
				unlink('./Public'.$oldPic);
			}
			array_push($pic, $image);

			return $this->where(['id' => $info['id']])->setField('visitor_upload', json_encode($pic));
		}
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}
}

?>