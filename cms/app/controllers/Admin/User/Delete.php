<?php

/**
 *  删除管理员
 * Class Admin_User_DeleteController
 */
class Admin_User_DeleteController extends Admin_AbstractController
{

    public function indexAction()
    {
        $this->verify(__METHOD__);

        $id = $this->getRequest()->getParam('id');

        Admin_AdminModel::instance()->update(array('status' => 0), array('id' => $id));

        $this->sendMsg(1, "操作成功");
    }
}
