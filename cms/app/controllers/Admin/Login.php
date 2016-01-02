<?php

/**
 * 登陆
 *
 * Class Admin_LoginController
 */
class Admin_LoginController extends Admin_AbstractController
{

    public function indexAction()
    {
        if ($this->getRequest()->getMethod() != 'POST') {
            $params = array('title' => '腾跃CMS');
            $this->render($params);
        } else {

            $params = $this->getRequest()->getPost();

            $params['password'] = md5($params['password']. md5($params['password']));

            /* 先查询帐号是否再库里,不在的话再查询RTX */
//            $admin_user = db_admin::get_admin_by_username_password($_POST['username'], $_POST['password']);
            $admin_user = Admin_AdminModel::instance()->fetchRow(
                array('condition' => 'username = ? and password = ? and status = 1',
                    'bind' => array($params['username'], $params['password']))
            );

            /* 查询帐号
            $admin_user = db_admin::get_admin_by_username_password($_POST['username'],$_POST['password']);
             */

            if ($admin_user === false) {
                throw new Exception("帐号或密码错误!", -1);
            }

            if (!empty($admin_user['gid'])) {
                /* 查询账号组 */
//                $admin_group = db_admin_group::get_admin_group_gid($admin_user['gid']);
                $admin_group = Admin_GroupModel::instance()->getAdminGroupByIds($admin_user['gid']);

                foreach ($admin_group as $val) {
                    $menu_id[] = $val['menu_id'];
                }

                $admin_group['menu_id'] = implode(',', $menu_id);

                /* 删除menu_id 第一位和最后一位 */
                $admin_group['menu_id'] = substr($admin_group['menu_id'], 1, (strlen($admin_group['menu_id']) - 2));


                /* 查询菜单 */
                if (!empty($admin_group['menu_id'])) {
//                    $admin_menu_list = db_admin_menu::get_admin_menu_list_by_ids($admin_group['menu_id']);
                    $admin_menu_list = Admin_MenuModel::instance()->getAdminMenuListByIds($admin_group['menu_id']);
                }

                /* 转换菜单数组,取出action和fun */
                $admin_menu_list_temp = array();

                foreach ($admin_menu_list as $key => $val) {
//                    $admin_menu_list_temp[$val['modle'] . '_' . $val['action']] = 1;
                    $admin_menu_list_temp[$val['modle'] . '/' . $val['action']] = 1;
                }

                /* 设置默认菜单,此方法不需要后台赋予权限 */
                $admin_menu_list_temp['admin/index'] = 1;
                $admin_menu_list_temp['admin/right'] = 1;
                $admin_menu_list_temp['admin/menu'] = 1;

                /* 日志 */
                $admin_menu_list_temp['daily_lists'] = 1;
                $admin_menu_list_temp['daily_edit'] = 1;
                $admin_menu_list_temp['api_json_insert_daily'] = 1;

                $admin_menu_list = $admin_menu_list_temp;

                /* 设置COOKIE */
                $admin_user['menu_id'] = $admin_group['menu_id'];
                $admin_user['menu_list'] = $admin_menu_list;
//var_dump($admin_user);exit;
//                cookie::set_cookie('admin_user', $admin_user);
                $this->session->add('admin_user', serialize($admin_user));

                /*　更新登陆时间和登陆ip */
//                db_admin::update_admin_login_by_id($admin_user['id']);

                $data = array(
                    'logintime' => date("Y-m-d H:i:s"),
                    'login_ip' => $this->getRequest()->getClientIp(),
                );

                Admin_AdminModel::instance()->update($data, array('id' => $admin_user['id']));
            }

            $callback_url = $this->getRequest()->getPost('url');

            if (empty($callback_url)) {
                $callback_url = '/admin/index';
            }

            $this->_redirect($callback_url);
        }


    }

}