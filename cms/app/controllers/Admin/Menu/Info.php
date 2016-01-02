<?php
/**
 * 添加菜单
 * Class Admin_Menu_InfoController
 */
class Admin_Menu_InfoController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
//        $this->verify(__METHOD__);
        //@todo  $this->verify(__METHOD__);

        if (null != $this->getRequest()->getPost('id')) {
//            db_admin_menu::update_admin_menu_by_id($_POST['id'],$_POST);
            $params = $this->getRequest()->getPost();
            $id = $params['id'];
            unset($params['id']);
           $res = Admin_MenuModel::instance()->update($params, array('id' => $id));
        } else {
//            $parent_id = db_admin_menu::insert_admin_menu($_POST);
            $params = $this->getRequest()->getPost();
            $parent_id = Admin_MenuModel::instance()->insertAdminMenu($params);

            if (null == $this->getRequest()->getPost('parent_id')) {
                $_POST['parent_id'] = $parent_id;
                Admin_MenuModel::instance()->insertAdminMenu($_POST);
//                db_admin_menu::insert_admin_menu($_POST);
            }
        }

        $this->_redirect('/admin/menu/list');
    }

}