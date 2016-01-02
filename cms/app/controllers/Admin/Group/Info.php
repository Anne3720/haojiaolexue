<?php

/**
 * 编辑账号组
 * Class Admin_Group_InfoController
 */
class Admin_Group_InfoController extends Admin_AbstractController
{

    public function indexAction()
    {
//        $this->verify(__METHOD__);
        //@todo $this->verify(__METHOD__);

        $menu_id = $this->getRequest()->getPost('menu_id');
        $menu_id = join(',', $menu_id);

        $id = $this->getRequest()->getPost('id');
        $group_name = $this->getRequest()->getPost('group_name');

//        $_POST['menu_id'] = implode(',',$_POST['menu_id']);

        if (!empty($menu_id)) {
            $menu_id = ',' . $menu_id . ',';
        }

        if (empty($id)) {
            /* 插入 */
//            db_admin_group::insert_admin_group($_POST['group_name'], $_POST['menu_id']);
            Admin_GroupModel::instance()->add(array('group_name' => $group_name, 'menu_id' => $menu_id, 'status' => 1));
        } else {
            /* 更新 */
//            db_admin_group::update_admin_group_by_id($_POST['id'], $_POST['group_name'], $_POST['menu_id']);
            Admin_GroupModel::instance()->update(array('group_name' => $group_name, 'menu_id' => $menu_id, 'status' => 1), array('id' => $id));
        }

        $this->_redirect('/admin/group/list');
    }

}