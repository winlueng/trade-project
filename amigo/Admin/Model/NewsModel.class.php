<?php 
namespace Admin\Model;

use Think\Model;
use Think\Exception;

class NewsModel extends CommonModel
{	
	protected $_validate = array(
		array('news_name', 'require', '动态名不能为空！'),
		array('title', 'require', '动态标题不能为空！'),
		// array('news_author', 'require', '请填写作者笔名！'),
		array('news_classify_id', 'require', '请选择动态分类'),
		array('is_video', 'require', '请选择是否视频选项'),
		array('img_path', 'require', '请填写动态详情'),
	);

	public function __construct()
	{
		parent::__construct();
		$this->_auto = array(
			array('addtime', 'time', 1, 'function'),
			array('control_time', 'time', 3, 'function'),
			array('relevance_id', $this->userInfo['relevance_id'],1),
			array('category_id', $this->userInfo['category_id'],1),
			array('company_id', ($this->userInfo['company_id']?$this->userInfo['company_id']:0),1),
		);
	}

	// 动态列表
	public function showNewsList()
	{
		$where  = [
			'company_id' => $this->userInfo['company_id'],
			'status'     => ['neq', '-1']
		];
		
		if (I('get.news_classify_id')) 
		{
			$where['news_classify_id'] = I('get.news_classify_id');
		}

		if (I('get.news_name')) {
			$where['news_name'] = ['like','%'.I('get.news_name').'%'];
		}

		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 8);

		$newsList = $this->field('id,title,news_name,news_logo,status,addtime,news_classify_id,is_video,is_top')
					->where($where)
					->order('addtime desc')
					->limit($page->firstRow.','.$page->listRows)
					->select();
		// return $this->getLastSql();
		$list = findStatistics($newsList, 'news', 'news_id');

		foreach ($list as $v) 
		{
			$v['classify_name'] = M('NewsClassify')->where(['id' => $v['news_classify_id']])->getField('news_type_name');
			$v['visit_total']   = M('NewsStatistics')->where(['relevance_id' => $v['id']])->sum('visit_total');
			$newList[] = $v;
		}

		$result['list'] = $newList;

		$result['page'] = $page->show();

		return $result;
	}

	public function getGoodsList()
	{
		return M('Goods')->field('goods_name, id')->where(['classify_id' => I('get.classify_id'), 'status' => ['not in','-1,3']])->select();
	}

	// ajax操作方法
	public function ajaxControl()
	{
		$flag = I('get.flag');
		return $this->$flag();
	}

	// 
	public function passOrRefuse()
	{
		$where['id'] = I('get.id');
		if (I('get.stick') == 1) 
		{
			$this->where(['set_end_time' => ['lt', time()]])->save(['stick' => 0]);

			$sum = $this->where(['stick' => 1, 'relevance_id' => $this->userInfo['relevance_id']])->count();
			
			if ($sum > 4) return '动态置顶最多只能添加5个.';

			if (!I('get.set_end_time')) return '请选择置顶动态结束时间';

			$data['set_end_time'] = strtotime(I('get.set_end_time'));
		}

		$result = $this->where($where)->save('stick', I('get.stick'));

		if ($result) return '操作成功';
		
		return '操作失败';
	}

	public function changeNewsStick()
	{
		$where['id'] = I('get.id');

		$stick['stick'] = I('get.stick');
		$stick['control_time'] =  strtotime('+1 month');
		$status = $this->field('status,is_top')->where($where)->find();
		if (!$status['status']) 
		{
			if (!$status['is_top']) 
			{
				$companyId = $this->userInfo['company_id'];

				$what = array(
					'company_id' => $companyId,
					'stick' => ['in', '1,2,3'],
					'control_time' => ['gt', time()],
				);

				$count = $this->where($what)->count();

				if ($count > 10) 
				{
					$time = $this->where($what)->order('control_time desc')->getField('control_time');
					return '您本月已申请超过10次置顶动态到大门户,下次可再申请时间为'.date('Y年m月d日 H:i:s', $time);
				}

				$result = $this->where($where)->save($stick);

				if ($result) return '操作成功';
				
				return '操作失败';
			}
			return '此动态还没置顶到微官网动态页,不能做申请操作';
		}
		return '动态处于禁用状态,不能做申请操作';
	}

	// 添加动态
	public function newsAdd()
	{
		if ($data = $this->create()) 
		{
			if ($_FILES['news_logo']['size'] || $_FILES['video']['size']) 
			{

				if ($_FILES['video']['size'] && $data['is_video']) {
					$path = fileUpload('/Uploads/newsVideo/', 'video', 'one', 104857600);

					if (isset($path['error_msg'])) {
						$this->error = $path['error_msg'];return false;
					}

					unset($_FILES['video']);

					$data['video'] = $path;
					
				}else{
					$path = fileUpload('/Uploads/news/', '', 'more');

					if (isset($path['error_msg'])) 
					{
						$this->error = $path['error_msg'];return false;
					}

					/*foreach ($path as $v) 
					{
						$arr[] = thumbImage($v);
					}*/
					$data['news_logo'] 	= json_encode($path);
				}

				$result = $this->add($data);

				if ($result) return $result;

				$this->error = '添加动态失败';return false;
				
			}
			
			$this->error = '请上传动态封面或视频文件';return false;
		}
		
		return false;
	}

	// 删除动态
	public function newsDel()
	{
		$where['id'] = I('get.id');

		/*$newsInfo = $this->field('is_top')->where($where)->find();

		if (!$newsInfo['is_top']) 
		{
			return '动态正在置顶,不能被删除';
		}elseif($newsInfo['stick'] == 1){
			return '此动态为推荐动态,不能被删除';
		}elseif($newsInfo['stick'] == 2){
			return '动态正在申请中,不能被删除';
		}*/

		return $this->where($where)->setField('status', '-1');
	}

	// 查询动态详情
	public function selNewsInfo()
	{
		$field = 'id,title,news_name,news_logo,img_path,status,addtime,news_author,is_video,news_classify_id,video,goods_id';

		$result = $this->field($field)->where(['id' => I('get.id')])->find();

		$result['img_path'] = htmlspecialchars_decode(html_entity_decode($result['img_path']));
		if ($result['goods_id']) {
			$result['goods_name'] = M('Goods')->where(['id' => $result['goods_id']])->getField('goods_name');
		}
		$result['news_logo'] = json_decode($result['news_logo'], true);
		return $result;
	}

	// 修改动态信息
	public function newsUpdate()
	{
		$where['id'] = I('get.id');

		if ($data = $this->create()) 
		{ 

			if ($_FILES['news_logo']['size'][0] || $_FILES['video']['size']) 
			{

				if ($_FILES['video']['size'] && $data['is_video']) {
					$path = fileUpload('/Uploads/newsVideo/', 'video', 'one', 104857600);

					if (isset($path['error_msg'])) {
						$this->error = $path['error_msg'];return false;
					}

					unset($_FILES['video']);

					$data['video'] = $path;
					
				}else{
					$path = fileUpload('/Uploads/news/', '', 'more');

					if (isset($path['error_msg'])) 
					{
						$this->error = $path['error_msg'];return false;
					}

					/*foreach ($path as $v) 
					{
						$arr[] = thumbImage($v);
					}*/
					$data['news_logo'] 	= json_encode($path);
				}
			}

			$result = $this->where($where)->save($data);

			if ($result) {
				return true;
			}
			
			$this->error = '更新动态失败';return false;
		}
		return false;
	}

	// 修改动态状态
	public function changeNewsStatus()
	{
		$where['id'] = I('get.id');

		return  $this->where($where)->setField('status', I('get.status'));
	}

	public function changeNewsTop()
	{

		try {
			if (I('get.is_top') == '1') {
				$where = [
					'relevance_id' 	=> $this->userInfo['relevance_id'],
					'company_id' 	=> $this->userInfo['company_id'],
					'is_top'	   	=> 1,
				];

				$count = $this->where($where)->count();
				if ($count > 7) throw new Exception("当前已置顶6个动态");
			}
				
			$res = $this->where([
					'id' => I('get.id'),
					'relevance_id' => $this->userInfo['relevance_id']
				])->save(['is_top' => I('get.is_top')]);
			if (!$res) throw new Exception("操作失败");
			
			return '操作成功';
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	// 动态置顶审核列表
	public function showNewsAuditList()
	{
		$where = array(
				'stick' => 2,
				'relevance_id' => $this->userInfo['relevance_id'],
				'is_top' => 0,
				'status' => 0,
			);

		if (I('get.stick')) 
		{
			$where['stick'] = I('get.stick');
			if (I('get.stick') == 3) $where['stick'] = ['in', '1,2,3'];

			if (I('get.stick') == 4) $where['stick'] = ['in', '1,3'];
		}
		
		$count = $this->where($where)->count();

		$page = new \Think\Page($count, 10);
		
		$list = $this->field('id, news_name, news_logo, news_name, company_id, addtime, news_link, stick')->where($where)->limit($page->firstRow.','.$page->listRows)->select();

		foreach ($list as $v) 
		{
			$v['company_name'] = M('Company')->where(['id' => $v['company_id'], 'status' => 0])->getField('company_name');

			if (!$v['company_name']) unset($v);
			
			$newList[] = $v;
		}

		$result['list'] = $newList;

		$result['page'] = $page->show();

		return $result;

	}

		// 删除商品图片
	protected function delNewsPicture()
	{
		$pic = $this->where(['id' => I('get.id'),'relevance_id' => $this->userInfo['relevance_id']])->getField('news_logo');
		$pic = json_decode($pic, true);
		foreach ($pic as $v) {
			if (I('get.news_logo') != $v) {
				$save[] = $v;
			}
		}
		$res = $this->where(['id' => I('get.id')])->save(['goods_picture' => json_encode($save)]);
		
		if ($res) {
			return 1;
		}
		return 0;
	}

}