<?php
/**
 * 编辑菜单
 * Class Admin_Menu_EditController
 */
class Admin_Menu_EditController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
//        $this->verify(__METHOD__);
        //@todo  $this->verify(__METHOD__);

        $id = $this->getRequest()->getParam('id');
        $parent_id = $this->getRequest()->getParam('parent_id');

        $data = array();


        /* 读取后台菜单数据 */
//        $show['list'] = db_admin_menu::get_admin_menu_list(array(),'orders asc','all');
        $data['list'] = Admin_MenuModel::instance()->getAdminMenuList(array(),'orders asc');

        if (empty($id)) {
            $data['pagename'] = '菜单添加';
//            $parent = db_admin_menu::get_admin_menu_list_by_ids($parent_id);
            $parent = Admin_MenuModel::instance()->getAdminMenuListByIds($parent_id);

            $parent = isset($parent[0]) ? $parent[0] : array('id' => '', 'modle' => '');
            $data['parent_id'] = $parent['id'];
            $data['info']['modle'] = $parent['modle'];
            $data['info']['orders'] = 0;

        } else {
            $data['pagename'] = '菜单编辑';
            $data['info'] = Admin_MenuModel::instance()->getAdminMenuListByIds($id);
            $data['info'] = $data['info'][0];
            $data['parent_id'] = $data['info']['parent_id'];
        }

        $data['info'] += array('hidden' => 0, 'target' => 0, 'top' => 0, 'ajax' => 0);

        $this->render($data);
    }

}