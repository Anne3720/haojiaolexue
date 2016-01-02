<?php

/**
 * 管理员编辑
 * Class Admin_User_EditController
 */
class Admin_User_EditController extends Admin_AbstractController
{

    public function indexAction()
    {
        $id = $this->getRequest()->getParam('id');
        $admin = $this->session->get('admin_user');
        $admin = unserialize($admin);

        if ($id != $admin['id']) {
            $admin = $this->verify(__METHOD__);
        }


        $data = array();

        $data['self'] = 1;

        /* 取全部管理组 */
//        $show['group_list'] = db_admin_group::get_admin_group_list(' id desc ', 'all');
        $data['group_list'] = Admin_GroupModel::instance()->fetchAll(array('order' => 'id desc'));

        /* 取全部项目 */
//        $show['porject_list'] = db_fqa_project::get_fqa_project_list();
        $data['project_list'] = Admin_ProjectModel::instance()->fetchAll();

        if (empty($id)) {
            $data['pagename'] = '添加管理员';
            $data['url'] = '/admin/user/list';
        } else {
            $data['pagename'] = '编辑管理员';
//            $data['info'] = db_admin::get_admin_by_id($id);
            $data['info'] = Admin_AdminModel::instance()->fetchRow(array('condition' => 'id = ?', 'bind' => array($id)));
            $data['info']['gid'] = explode(',', $data['info']['gid']);
            $data['info']['project_id'] = explode(',', $data['info']['project_id']);

            if ($data['info']['id'] == $admin['id']) {
                $data['self'] = 0;
            }

            $data['id'] = $id;
            $data['url'] = $this->getRequest()->getParam('url');
        }



        $data['menu'] = Widget_Admin_MenuModel::headerMenu();

        $this->setInvokeArg('layout', 'admin2_layout');
        $this->render($data);
    }

}