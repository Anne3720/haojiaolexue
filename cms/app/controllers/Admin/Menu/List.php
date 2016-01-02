<?php
/**
 * 菜单列表
 * Class Admin_Menu_ListController
 */
class Admin_Menu_ListController extends Admin_AbstractController
{

    public function indexAction()
    {

//
//        $show['menu_list'] = db_admin_menu::get_admin_menu_list(array(),'orders asc','all');
//        $show['menu_list'] = $this->load_fun('tree',$show['menu_list'],'parent_id');
//        //$this->cache->flush('admin_menu');
//        $this->display($show);

//        var_dump($this->getRequest()->getModuleName(), $this->getRequest()->getControllerName());
//        exit;


        //        /** 验证是否登录 **/
//        $this->verify(__METHOD__);
        //@todo $this->verify(__METHOD__);
        $data = array();

        $data['tips'] = '请在添加、修改、排序菜单全部完成后，更新菜单缓存';
        $data['menu_list'] = Admin_MenuModel::instance()->getAdminMenuList(array(), 'orders asc');
        $data['menu_list'] = Widget_Admin_MenuModel::tree($data['menu_list'], 'parent_id');
        $data['menu'] = Admin_MenuModel::instance()->getAdminHeaderMenu($data['menu_list'], $this->getRequest()->getModuleName(), $this->getRequest()->getControllerName());

        $this->setInvokeArg('layout', 'admin1_layout');
        $this->render($data);
    }

}