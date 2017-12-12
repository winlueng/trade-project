<?php 
namespace Template00003\Controller;

use Think\Controller;

/**
 * 个人中心控制器
 */
class MyCenterController extends CommonController
{
    private $visitorId;

    public function __construct()
    {
        parent::__construct();
        $this->visitorId = $_SESSION['visitorInfo']['id'];
        // dump(session());exit;
    }

	// 个人中心信息更新
    public function myCenterInfoUpdate()
    {
        $visitorObj = new \Template00002\Model\VisitorInfoModel();
        if (IS_POST) 
        {
            $result = $visitorObj->myCenterInfoUpdate();
        // dump($_FILES);exit;
        // dump($result);exit;
            if ($result) 
            {
                $this->success('保存成功!');exit;
            }else{
                $this->error($visitorObj->getError());exit;
            }
        }else{
            if (!$this->visitorId) 
            {
                $this->redirect(MODULE_NAME.'/Login/visitorLogin');exit;
            }
            
            $this->assign('visitorInfo', $this->userInfo);
            $this->display();
        }
    }
}
?>