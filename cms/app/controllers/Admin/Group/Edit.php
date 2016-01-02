<?php

/**
 * 编辑账号组
 * Class Admin_Group_EditController
 */
class Admin_Group_EditController extends Admin_AbstractController
{

    public function indexAction()
    {

//        $this->verify(__METHOD__);
        //@todo $this->verify(__METHOD__);

        $data = array();


        $id = $this->getRequest()->getParam('id');
        $data['menu_list'] = Admin_MenuModel::instance()->fetchAll(array('condition' => 'no_verify = 0', 'order' => 'id desc'));
        $data['menu_list'] = Widget_Admin_MenuModel::tree($data['menu_list'], 'parent_id');

        if (!empty($id)) {
            $data['info'] = Admin_GroupModel::instance()->fetchRow(array('condition' => 'id = ? and status = 1', 'bind' => array($id)));
            $data['info']['menu_id'] = explode(',',$data['info']['menu_id']);
            $data['info']['menu_id'] = array_unique($data['info']['menu_id']);
            $data['info']['menu_id'] = array_flip($data['info']['menu_id']);
            $data['pagename'] = '编辑账号组';
        } else {
            $data['pagename'] = '添加账号组';
        }

        $data['menu'] = Widget_Admin_MenuModel::headerMenu();

        $this->setInvokeArg('layout', 'admin2_layout');
        $this->render($data);
    }

}