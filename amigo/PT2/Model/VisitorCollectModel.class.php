<?php
namespace PT2\Model;

use Think\Model;

class VisitorCollectModel extends CommonModel
{
	// 商品收藏
	public function goodsCollect()
	{
		$goodsList = $this->where(['visitor_id' => $this->userInfo['id']])->getField('goods_collect');
		$goodsList = implode(',', json_decode($goodsList,true));
		if (!$goodsList) return false;
		$where = [
			'status' 	 => ['not in','-1,3'],
			'id'		 => ['in', $goodsList],
		];
		$list = M('Goods')->field('id,goods_name, price,goods_logo,describe')->where($where)->select();
		foreach ($list as $v) {
			$v['salesTotal'] = M('GoodsSalesVolume')->where(['goods_id' => $v['id']])->sum('sales_total');
			$v['link']		 = $this->handleGoodsLink($v['id']);
			$result[] = $v;
		}
		return $result;
	}

	// 店铺关注
	public function companyCollect()
	{
		$company_list = $this->where(['visitor_id' => $this->userInfo['id']])->getField('company_collect');
		$company_list = implode(',', json_decode($company_list,true));
		if (!$company_list) return false;
		$where = [
			'status' 	 => ['neq','1'],
			'id'		 => ['in', $company_list],
		];
		$list = M('Company')->field('id,company_name, address_info, web_postfix')->where($where)->select();
		foreach ($list as $v) {
			$v['company_logo'] = M('CompanyPicture')->where(['company_id' => $v['id']])->getField('company_logo');
			$v['link'] = $_SERVER['HTTP_HOST']."/{$v['web_postfix']}";
			$result[] = $v;
		}
		return $result;
	}

	// 收藏商品
	public function collectCompany()
	{
		$companyId = I('get.company_id');

		$status = I('get.status');

		$where = ['visitor_id' => $this->userInfo['id']];

		// 查询用户收藏商品数据
		$info = $this->where($where)->find();
		// return $list;
		if (!$info && $status == '1') 
		{
			return $this->add(['visitor_id' => $this->userInfo['id'], 'company_collect' => json_encode([$companyId])]);
		}else if((!$info || !$info['company_collect']) && $status == '2'){
			return '非法操作';
		}else if(!$info['company_collect'] && $status == '1'){
			return $this->where($where)->setField('company_collect',json_encode([$companyId]));
		}

		$list = json_decode($info['company_collect'],true);
		if (!in_array((string)$companyId, $list) && $status == '1') // 判断是否已经收藏过
		{
			array_push($list, $companyId);
		}

		if (in_array((string)$companyId, $list) && $status == '2') // 判断是否已经收藏过
		{
			$list = array_diff($list, [$companyId]);
		}

		$data = json_encode(array_merge($list));
		
		$res = $this->where($where)->setField('company_collect',$data);

		if ($res && $status == '1') {
			return M('Company')->where(['id' => $companyId])->setInc('collect_total');
		}elseif($res && $status == '2'){
			return M('Company')->where(['id' => $companyId])->setDec('collect_total');
		}else{
			return 0;
		}
	}

	public function ajaxControl($flag)
	{
		return $this->$flag();
	}
}