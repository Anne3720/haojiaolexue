<?php

/**
 * index 控制器
 *
 * Class IndexController
 */
class Admin_Menu_GetlistController extends Admin_AbstractController
{

    public function indexAction()
    {

        $admin = $this->session->get('admin_user');

        if (empty($admin)) {
            //@todo
        }

        $admin = unserialize($admin);

        $id = $this->getRequest()->getParam('id');
//        $show = db_admin_menu::get_admin_menu_list_by_ids($admin['menu_id'],$id,'','','orders asc');
        $menu_list = Admin_MenuModel::instance()->getAdminMenuListByIds($admin['menu_id'], $id, '', '', 'orders asc');

        foreach ($menu_list as $key => $val) {
            $menu_list[$key]['menu_list'] = Admin_MenuModel::instance()->getAdminMenuListByIds($admin['menu_id'], $val['id'], '', '0', 'orders asc', $val['parent_no_verify']);
//                db_admin_menu::get_admin_menu_list_by_ids($admin['menu_id'], $val['id'], '', '0', 'orders asc', $val['parent_no_verify']);
        }

        $this->sendMsg(1, '', $menu_list);
    }

}