<?php 
namespace Admin\Model;

use Think\Model;

class ActivityModel extends Model
{
	protected $_validate = array(
		array('activity_name', 'require', '请填写活动名称！', 1, 'regex', 3),
		array('activity_details', 'require', '请填写活动详情', 1, 'regex', 3),
		array('start_time', 'require', '请选择开始时间', 1, 'regex', 3),
		array('end_time', 'require', '请选择结束时间', 1, 'regex', 3),
		// array('price', 'require', '请填写商品价格', 1, 'regex', 3),
	);

	protected $_auto = array(
		array('start_time', 'strtotime', 3, 'function'),
		array('end_time', 'strtotime', 3, 'function'),
		array('status', '0', 3), //活动状态,默认显示
		array('activity_type', '1', 3),//activity_type 活动状态(1=>普通活动,2=>精选活动)
	);

	// 添加活动
	public function activityAdd()
	{
		if ($data = $this->create()) 
		{
			if ($_FILES['activity_cover']['size'] != 0) 
			{
				$path = D('Poster')->picUpload('/Uploads/activityCover', 'one', 'activity_cover');

				if ($path) 
				{
					$data['activity_cover'] = $path;
				}else{
					$this->error = D('Poster')->getError();return false;
				}
				$data['relevance_id'] = $_SESSION['marketInfo']['relevance_id'];
				$data['category_id']  = $_SESSION['marketInfo']['category_id'];
				$result = $this->add($data);

				if (!$result) 
				{
					$this->error = '添加活动失败';return false;
				}
				return $result;
			}else{
				$this->error = '请上传活动封面';return false;
			}

		}else{
			return false;
		}
	}

	// 活动列表
	public function activityList()
	{
		$where['relevance_id'] = $_SESSION['marketInfo']['relevance_id'];
		$where['category_id']  = $_SESSION['marketInfo']['category_id'];
		$this->where(['end_time' => ['lt', time()]])->setField(['activity_type' => 3]);
		if (I('get.activity_type')) 
		{
			$where['activity_type'] = I('get.activity_type');
		}
		$field = 'id, activity_name, activity_type, end_time, status';
		$count = $this->where($where)->count();
		$page = new \Think\Page($count, 8);
		$list  = $this->field($field)->where($where)->order('end_time desc')->limit($page->firstRow.','.$page->listRows)->select();
		$result['list'] = findStatistics($list,'activity', 'activity_id');
		$result['page'] = $page->show();
		return $result;
	}

	public function ajaxControl()
	{

		switch (I('get.flag')) 
		{
			case 'selActivityInfo':
				$result = $this->selActivityInfo();//查询活动详细信息
				break;
			case 'activityDel':
				$result = $this->activityDel();//删除活动信息
				break;
			case 'changeActivityStatus':
				$result = $this->changeActivityStatus();//修改活动状态
				break;
			case 'changeActivityType':
				$result = $this->changeActivityType();
				break;
		}
		return $result;
	}

	// 查询活动详细信息
	protected function selActivityInfo()
	{
		$id['id'] = I('get.id');
		$info = $this->field('activity_name, activity_link, activity_cover, start_time, end_time, activity_details')->where($id)->select();
		$result = findStatistics($info,'activity', 'activity_id')[0];
		// 活动详情需要转义
		$result['activity_details'] = htmlspecialchars_decode(html_entity_decode($result['activity_details']));

		return $result;
	}

	// 删除活动信息
	protected function activityDel()
	{
		$where['id'] = I('get.id');

		$path = $this->where($where)->getField('activity_cover');

		if (unlink('./Public'.$path)) 
		{
			$result = $this->where($where)->delete();
			if ($result) 
			{
				return '删除成功';
			}else{
				return '删除失败';
			}
		}
		return '删除图片文件失败';
	}

	// 修改活动状态
	protected function changeActivityType()
	{
		$where['id'] = I('get.id');
		$status['activity_type'] = I('get.activity_type');
		if (I('get.activity_type') == 2) 
		{
			$result = $this->where($where)->getField('status');
			if ($result) 
			{
				return '请启用此活动再进行精选';
			}
		}
		$result = $this->where($where)->save($status);
		if ($result) 
		{
			return '操作成功';
		}else{
			return '操作失败';
		}
	}

	public function changeActivityStatus()
	{
		$where['id'] = I('get.id');
		$status['status'] = I('get.status');
		if (I('get.status') == 1) {
			$status['activity_type'] = 1;
		}
		$result = $this->where($where)->save($status);
		if ($result) 
		{
			return '操作成功';
		}else{
			return '操作失败';
		}
	}

	// 修改活动信息
	public function activityUpdate()
	{
		$where['id'] = I('get.id');
		if ($data = $this->create()) 
		{
			if ($_FILES['activity_cover']['size'] != 0) 
			{
				$resPath = D('Poster')->picUpload('/Uploads/activityCover', 'one', 'activity_cover');
				if ($resPath) 
				{
					$path = $this->where($where)->getField('activity_cover');

					if (unlink('./Public'.$path)) 
					{
						$data['activity_cover']	= $resPath;			
					}else{
						$this->error = '修改时删除原图文件失败';return false;
					}
				}else{
					$this->error = D('Poster')->getError();return false;
				}
			}

			$result = $this->where($where)->save($data);
			if (!$result) 
			{
				$this->error = '修改失败';return false;
			}
			return $result;
		}else{
			return false;
		}
	}
}