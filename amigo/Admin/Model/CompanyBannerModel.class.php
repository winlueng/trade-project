<?php 
namespace Admin\Model;

use Think\Model;

class CompanyBannerModel extends CommonModel
{
	protected $_validate = array( 
			array('banner_url', 'require', '跳转地址不能空'),
			array('start_time', 'require', '请选择开始时间'),
			array('end_time', 'require', '请选择结束时间'),
			array('banner_title', 'require', '广告标题不能空'),
			array('banner_type', 'require', '请选择广告位置'),
		);

	public function __construct()
	{
		parent::__construct();
		$this->_auto = [
			array('start_time', 'strtotime', 3, 'function'),
			array('end_time', 'strtotime', 3, 'function'),
			array('create_time', 'time', 1, 'function'),
			array('sort', 'time', 3, 'function'),
			array('company_id', $this->userInfo['company_id'], 1 ),
		];
	}

	/**
	 * 查询广告表
	 * @return array 返回广告列表数组
	 */
	public function showList()
	{
		$where = [
			'status' => ['neq', '-1'],
			'company_id' => $this->userInfo['company_id']
		];

		$count = $this->where($where)->count();

		$page  = new \Think\Page($count, 10);

		$list = $this->where($where)
						->order('create_time desc')
						->limit($page->firstRow.','.$page->listRows)
						->select();

		foreach ($list as $v) {
			$v['visit_total'] = M('CompanyBannerStatistics')->where(['relevance_id' => $v['id']])->sum('visit_total');
			$result['list'][] = $v;
		}

		$result['page'] = $page->show();
		return $result;
	}

	/**
	 * [posterAdd 广告添加]
	 * @param  [type] $type [description]
	 * @return [type]       [description]
	 */
	public function posterAdd()
	{
		if ($data = $this->create()) 
		{
			if ($_FILES['banner_pic']['size']) 
			{
				$path = fileUpload('/Uploads/poster/', 'banner_pic');
				if (isset($path['error_msg'])){
					$this->error = $path['error_msg'];return false;
				}
				// $data['banner_pic'] = thumbImage($path);
				$data['banner_pic'] = $path;

				$state = $this->add($data);

				if ($state) return $state;

				$this->error = '添加广告失败';return false;
			}
			$this->error = '请上传广告图片';return false;
		}
		return false;
	}

	/**
	 * [selPoster 广告修改查询信息]
	 * @return $res 广告分类和广告信息的数组
	 */
	public function selPoster()
	{
		$res['list'] = $this->field('banner_title,type_id,banner_url,banner_pic,start_time,end_time,banner_type')->where(['id'=>I('get.id')])->find();
		$res['list']['start_time'] = date('Y-m-d',$res['list']['start_time']);
		$res['list']['end_time'] = date('Y-m-d',$res['list']['end_time']);
		return $res;
	}

	/**
	 * [posterUpdate 广告信息更新]
	 */
	public function posterUpdate()
	{
		$where = ['id'=>I('get.id'),'relevance_id' => $this->userInfo['relevance_id']];

		if ($data = $this->create()){

			if ($_FILES['banner_pic']['size'] != 0) 
			{
				$path = fileUpload('/Uploads/poster/', 'banner_pic');

				if (isset($path['error_msg'])){
					$this->error = $path['error_msg'];return false;
				}
				// $data['banner_pic'] = thumbImage($path);
				$data['banner_pic'] = $path;
				$logoPath = $this->where($where)->getField('banner_pic');
				unlink(C('IMG_DIR').$logoPath);
				unlink(C('IMG_DIR').getArtwork($logoPath));
			}

			$res = $this->where($where)->save($data);

			return $res;
		}
		return false;
	}

	/**
	 * [posterDel 广告删除]
	 * @return [fixed] [删除信息]
	 */
	protected function posterDel()
	{
		$link = $this->field('banner_pic')->where(['id'=> I('get.id')])->find();
		unlink(C('IMG_DIR').$link['banner_pic']);
		return $this->where(['id'=> I('get.id')])->delete();
	}

	public function ajaxControl()
	{
		$flag = I('get.flag');
		$id = I('get.id');
		switch ($flag)
		{
			case 'change':
				$change = $this->where(['id'=>$id])->save(['status'=>1]);
				$res=$change?'更改成功':'本来就禁用';
				break;
			case 'del':
				$res = $this->posterDel();
				break;
			case 'show':
				$change = $this->where(['id'=>$id])->save(['status'=>0]);
				$res=$change?'更改成功':'本来就启用';
				break;
			case 'sel':
				$res = $this->field('id,poster_pic,poster_url,start_time,end_time')->where(['type_id'=>$id])->select();
				$posterType = M('Postertype');
				$typeName = $posterType->where(['id'=>$id])->getField('type_name');
				foreach($res as $k => $v)
				{
					$res[$k]['typename'] = $typeName;
					$res[$k]['start_time'] = date('Y-m-d H:i:s',$v['start_time']);
					$res[$k]['end_time'] = date('Y-m-d H:i:s',$v['end_time']);
				}
				break;
			case 'selPosterInfo':
				$res = $this->selPosterInfo();
				break;
			case 'selPosterTypeInfo':
				$res = $this->selPosterTypeInfo();
				break;
			case 'posterTypeDel':
				$res = $this->posterTypeDel();
				break;
		}
		return $res;
	}

	protected function selPosterInfo()
	{
		$id = I('get.id');
		$result = $this->field('id,banner_title,banner_pic,banner_url,start_time,end_time,banner_type')->where(['id' => $id])->select();
		return $result;
	}

	protected function posterTypeDel()
	{
		$where = array(
				'id' => I('get.id'),
				'type_name' => I('get.type_name'),
			);
		$result = M('Postertype')->where($where)->delete();
		if (!$result) 
		{
			return '删除失败';			
		}
		return '删除成功';
	}
}
 ?>