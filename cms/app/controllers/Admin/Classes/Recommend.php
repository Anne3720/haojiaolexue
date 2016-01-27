<?php
/**
 * 推荐课程
 * Class Admin_Classes_RecommendController
 */
class Admin_Classes_RecommendController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
        $this->verify(__METHOD__);
        $classID = $this->getRequest()->getQuery('ClassID');
        $memberID = $this->getRequest()->getQuery('MemberID');
        print_r($memberID);exit;
        $params = array(
            'ClassID'=>$classID,
            'MemberID'=>$memberID,
            'CreateTime'=>date('Y-m-d H:i:s'),
        );
        Admin_RecommendClassModel::instance()->add($params);
        $this->sendMsg(1, "操作成功");
    }

}