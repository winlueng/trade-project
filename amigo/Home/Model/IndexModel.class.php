<?php 
namespace Home\Model;

use Think\Model\AdvModel;

class IndexModel extends AdvModel
{	
	protected $autoCheckFields = false;

	public function selPoster($relevance_id,$typeid=0)
	{
		// typeid类型属性(0=>广告位置投放,1=>商户位置投放,2=>商圈位置投放,3=>行业位置投放,4=>商户微官网位置)
		$poster = M('Poster');
		$list = $poster->field('id,poster_pic,poster_url')->where(['type_id'=>$typeid,'relevance_id' => $relevance_id,'start_time'=>['lt',time()],'end_time'=>['gt',time()],'status'=>0])->select();
		return $list;
	}

	
}


 ?>