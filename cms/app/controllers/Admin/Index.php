<?php

/**
 * index 控制器
 *
 * Class IndexController
 */
class Admin_IndexController extends Admin_AbstractController
{

    public function indexAction()
    {
        $data = array();

        /** 验证是否登录 **/
        $data['admin'] = $this->verify(__METHOD__);

//        $data['admin'] = array(
//            'username' => 'zhangsan',
//            'nick' => '张三',
//            'logintime' => date('Y-m-d H:i:s')
//        );


        $data['webname'] = 'test';
        $data['weburl'] = 'rthink.local';

        $data['url'] = $this->getRequest()->getQuery('url', '');

        /* 查询菜单 */
        $data['menu_list'] = Admin_MenuModel::instance()->getAdminMenuListByIds($data['admin']['menu_id'], 0);// db_admin_menu::get_admin_menu_list_by_ids($show['admin']['menu_id'],'0','','','orders asc');
        $data['text'] = '测试环境';

        $data['is_guest'] = 0;// boolean值

        $this->render($data);
    }

}