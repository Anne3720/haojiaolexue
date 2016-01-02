<?php

/**
 * 编辑账号组
 * Class Admin_Group_EditController
 */
class Admin_Group_DeleteController extends Admin_AbstractController
{

    public function indexAction()
    {

//        $this->verify(__METHOD__);
        //@todo $this->verify(__METHOD__);

        $id = $this->getRequest()->getParam('id');

        Admin_GroupModel::instance()->delete(array('id' => $id));

        $this->sendMsg(1, '删除成功');
//        db_admin_group::delete_admin_group_by_id($id);
    }

}