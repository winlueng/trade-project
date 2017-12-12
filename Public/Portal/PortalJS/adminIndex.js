$(function(){
	$('.kbVipAdmin_center_nav .special').on('click',function(){
		var $this =$(this);
		$this.siblings('li').slideToggle();
	})
})