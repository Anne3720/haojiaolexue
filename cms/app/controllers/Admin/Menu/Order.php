<?php
/**
 * 菜单排序
 * Class Admin_Menu_OrderController
 */
class Admin_Menu_OrderController extends Admin_AbstractController
{

    public function indexAction()
    {

        /** 验证是否登录 **/
        //@todo  $this->verify(__METHOD__);

        $orders = $this->getRequest()->getPost('orders');

        foreach ($this->getRequest()->getPost('id') as $key => $val) {
            Admin_MenuModel::instance()->update(array('orders' => $orders[$key]), array('id' => $val));
        }

        $this->_redirect('/admin/menu/list');
    }

}