<?php

/**
 * 删除推荐课程
 * Class Admin_Recommend_DeleteController
 */
class Admin_Recommend_DeleteController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
        $this->verify(__METHOD__);
        $RecommendID = $this->getRequest()->getParam('RecommendID');
        Admin_RecommendModel::instance()->delete(array('RecommendID' => $RecommendID));

        $this->sendMsg(1, '删除成功');
    }

}