<?php

/**
 * 删除菜单
 * Class Admin_Menu_DeleteController
 */
class Admin_Menu_DeleteController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
//        $this->verify(__METHOD__);
        //@todo  $this->verify(__METHOD__);

//        $parent_menu = db_admin_menu::get_admin_menu_list_by_pid($id);
        $id = $this->getRequest()->getParam('id');

        $parent_menu = Admin_MenuModel::instance()->getAdminMenuListByPid($id);

        if (empty($parent_menu[0])) {
            //            db_admin_menu::delete_menu_list_by_id($id);
//            Admin_MenuModel::instance()->delete(array('id' => $id));
            Admin_MenuModel::instance()->update(array('status' => 0), array('id' => $id));
        } else {
            $this->sendMsg(-1, '该菜单下还有未删除的菜单,请先删除!');
        }

        $this->sendMsg(1, '删除成功');

//        output::url('/zpadmin/admin/menu_list');
    }

}