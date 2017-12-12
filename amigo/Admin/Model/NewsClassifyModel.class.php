<?php 
namespace Admin\Model;

use Think\Model;

class NewsClassifyModel extends CommonModel
{
	protected $_validate = array(
		array('news_type_name', 'require', '分类名不能为空！'),
		// array('title', 'require', '描述不能为空！'),
	);

	public function __construct()
	{
		parent::__construct();
		$this->_auto = array(
			array('create_time', 'time', 1, 'function'),
			array('update_time', 'time', 2, 'function'),
			array('relevance_id', $this->userInfo['relevance_id'],1),
			array('company_id', ($this->userInfo['company_id']?$this->userInfo['company_id']:0),1),
			array('category_id', $this->userInfo['category_id'],1),
		);
	}

	// 添加动态分类
	public function newsClassifyAdd()
	{
		if ($data = $this->create()) 
		{
			if ($_FILES['news_classify_logo']['size'] != 0)  
			{
				$path = fileUpload('/Uploads/news/', 'news_classify_logo');

				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}

				$data['news_classify_logo'] = thumbImage($path);

				$result = $this->add($data);

				if ($result) return $result;

				$this->error = '添加分类失败';return false;
			}
			$this->error = '请上传分类logo';return false;
		}
		return false;
	}

	// 分类修改
	public function newsClassifyUpdate()
	{
		$where['id'] = I('get.id');

		if ($data = $this->create()) 
		{
			if ($_FILES['news_classify_logo']['size'] != 0) 
			{
				$path = fileUpload('/Uploads/news/', 'news_classify_logo');

				if (isset($path['error_msg'])) {
					$this->error = $path['error_msg'];return false;
				}
				$data['news_classify_logo'] = thumbImage($path);

				$logoPath = $this->where($where)->getField('news_classify_logo');

			}
			$result = $this->where($where)->save($data);

			if ($result) {
				unlink(C('IMG_DIR').$logoPath);
				unlink(C('IMG_DIR').getArtwork($logoPath));
				return $result;
			}
			
			$this->error = '修改分类失败';return false;
		}
		return false;
	}

	// 动态分类
	public function newsClassifyList($flag='')
	{
		$where = [
			'company_id' => $this->userInfo['company_id'],
			'status'	 => ['neq', '-1'],
			'relevance_id' => $this->userInfo['relevance_id']
		];

		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 10);

		$list = $this->field('id, news_type_name, title, news_classify_logo, status')
				->where($where)
				->order('create_time desc')
				->limit($page->firstRow.','.$page->listRows)
				->select();
		foreach ($list as $v) {
			$v['count'] = $this->countNews($v['id']);
			$result['list'][] = $v;
		}
		$result['page']=$page->show();
		return $result;
	}

	// 动态分类详细信息
	public function selNewsClassifyInfo()
	{
		$where = [
			'id' 		=> I('get.id'),
			'status'	=> ['neq', '-1'],
		];

		return $this->field('id, news_type_name, title, news_classify_logo, status')->where($where)->find();
	}

	// 分类删除
	public function newsClassifyDel()
	{
		$where['id'] = I('get.id');

		if ($this->countNews(I('get.id'))) return '此分类下还存在动态数据,不能删除';

		return $this->where($where)->setField('status', '-1');
	}

	// 修改
	public function newsClassifyStatus()
	{
		if ($this->countNews(I('get.id')) && I('get.status') == 1) return '此分类下还存在动态数据,不能修改状态';

		return $this->where(['id' => I('get.id')])->setField('status', I('get.status'));
	}

	public function countNews($id)
	{
		$count = M('News')->where(['news_classify_id' => $id, 'status' => ['neq', '-1']])->count();
		return $count;
	}

	// ajax操作方法
	public function ajaxControl()
	{
		$flag = I('get.flag');
		return $this->$flag();
	}
}

 ?>