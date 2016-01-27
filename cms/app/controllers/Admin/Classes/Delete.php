<?php

/**
 * 删除课程
 * Class Admin_Classes_DeleteController
 */
class Admin_Classes_DeleteController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
        $this->verify(__METHOD__);
        $ClassID = $this->getRequest()->getParam('ClassID');
        Admin_ClassesModel::instance()->delete(array('ClassID' => $ClassID));

        $this->sendMsg(1, '删除成功');
    }

}