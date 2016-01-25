<?php
/**
 * 添加课程
 * Class Admin_Classes_InfoController
 */
class Admin_Classes_InfoController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
        $this->verify(__METHOD__);
        if (null != $this->getRequest()->getPost('ClassID')) {
            $params = $this->getRequest()->getPost();
            $ClassID = $params['ClassID'];
            unset($params['ClassID']);
            Admin_ClassesModel::instance()->update($params, array('ClassID' => $ClassID));
        } else {
            $params = $this->getRequest()->getPost();
            Admin_ClassesModel::instance()->insertAdminClasses($_POST);
        }
        $this->sendMsg(1, "操作成功");
        // $this->_redirect('/admin/classes/list');
    }

}