<?php

/**
 * 账号组列表
 * Class Admin_Group_ListController
 */
class Admin_Group_ListController extends Admin_AbstractController
{

    public function indexAction()
    {

//        $this->verify(__METHOD__);
        //@todo $this->verify(__METHOD__);

        $data = array();

        $data['list'] = Admin_GroupModel::instance()->fetchAll(array('order' => 'group_name asc'));
        $data['menu'] = Widget_Admin_MenuModel::headerMenu();

        $this->setInvokeArg('layout', 'admin2_layout');
        $this->render($data);
    }

}