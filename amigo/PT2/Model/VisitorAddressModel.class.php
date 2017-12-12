<?php 
namespace PT2\Model;

use Think\Model;

class VisitorAddressModel extends CommonModel
{
	protected $insertFields = ['visitor_id', 'address_str','consignee','phone','create_time','status'];

	protected $updateFields = ['address_str','consignee','phone','update_time'];

	protected $_validate 	= [
		// ['address_str','require','请填写收货地址'],
		['consignee','require','请填写收货人姓名'],
		['phone','require','请填写收货人电话'],
	];

	public function __construct()
	{
		parent::__construct();
		$this->_auto = [
			['visitor_id', $this->userInfo['id']],
			['update_time', 'time', 3, 'function'],
		];
	}

	public function insert()
	{
		if ($data = $this->create()) {

			if ($data['status'] == '1') {
				$this->where(['visitor_id' => $this->userInfo['id']])->setField('status','0');
			}elseif(!$this->where(['visitor_id' => $this->userInfo['id']])->find()){
				$data['status'] = 1;
			}

			$city = implode(' ', explode(',', I('post.city')));
			$data['create_time'] = time();
			$data['address_str'] = $city.' '.$data['address_str'];

			$res = $this->add($data);
			if($res) return $res;

			$this->error = '添加失败';return false;
		}
		return false;
	}
	
	public function addrList()
	{
		$result = $this->where([
					'visitor_id' => $this->userInfo['id'],
					'status' => ['neq','-1']
				])->order('update_time desc')
				->select();

		return $result;
	}

	public function update()
	{
		if ($data = $this->create()) {
			if ($data['status'] == '1') {
				$this->where(['visitor_id' => $this->userInfo['id'], 'id' => I('get.id')])->setField('status','0');
			}

			$city = implode(' ', explode(',', I('post.city')));

			$data['address_str'] = $city.' '.$data['address_str'];

			$res = $this->where(['visitor_id' => $this->userInfo['id'],'id' => I('get.id')])->save($data);

			if($res) return $res;

			$this->error = '修改失败';return false;
		}
		return false;
	}

	public function info($id = '')
	{
		$selID = I('get.addr_id');
		if($id) $selID = $id;
		$info = $this->where(['visitor_id' => $this->userInfo['id'],'id' => $selID])->find();
		$arr = explode(' ', $info['address_str']);
		$info['address'] = array_pop($arr);
		$info['city'] = implode(',', $arr);
		return $info;
	}

	public function del()
	{
		return $this->where(['visitor_id' => $this->userInfo['id'],'id' => I('get.id')])->delete();
	}

	// 设为默认地址
	public function saveDefault()
	{
		$this->where(['visitor_id' => $this->userInfo['id']])->setField('status','0');
		return $this->where(['visitor_id' => $this->userInfo['id'],'id' => I('get.id')])->setField('status','1');
	}

	public function sel_default_address()
	{
		$where = [
            	'visitor_id' => $this->userInfo['id'], 
            	'status' => 1,
            ];

        if (I('get.addr_id')) {
        	$where = ['id' => I('get.addr_id')];
        }

		return $this->field('consignee,phone,address_str')
		            ->where($where)
		            ->find();
	}

	public function set_order_pay_address()
	{
		return $this->redis->setex('pay_address'. session('order_no'), 3600, I('get.addr_id'));
	}

	public function get_order_pay_address()
	{
		$res = $this->redis->get('pay_address'. session('order_no'));
		if (!$res) {
			$res = M('VisitorAddress')->where(['visitor_id' => $this->userInfo['id'], 'status' => 1])->getField('id');
		}
		return $res;
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}
}

?>