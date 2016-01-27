<?php

/**
 * 删除学员信息
 * Class Admin_Member_DeleteController
 */
class Admin_Member_DeleteController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
        $this->verify(__METHOD__);
        $MemberID = $this->getRequest()->getParam('MemberID');
        $params = array(
            'Status'=>1,
        );
        Admin_MemberModel::instance()->update($params, array('MemberID' => $MemberID));

        $this->sendMsg(1, '删除成功');
    }

}