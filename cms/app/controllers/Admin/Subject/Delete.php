<?php

/**
 * 删除科目
 * Class Admin_Subject_DeleteController
 */
class Admin_Subject_DeleteController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
        $this->verify(__METHOD__);
        $SubjectID = $this->getRequest()->getParam('SubjectID');
        Admin_SubjectModel::instance()->delete(array('SubjectID' => $SubjectID));

        $this->sendMsg(1, '删除成功');
    }

}