<?php

/**
 * admin 抽象类 - 后台所控制机器的基类
 *
 * Class Admin_AbstractController
 */
abstract class Admin_AbstractController extends RThink_Controller_Action
{

    public $session = null;


    public function __construct($request, $response, $_invoke_args)
    {
        parent::__construct($request, $response, $_invoke_args);
        $this->session = new Session();
    }

    public function preDispatch()
    {
        if ($this->getRequest()->getActionName() == 'index' &&
            $this->getRequest()->getControllerName() == 'login' &&
            $this->getRequest()->getModuleName() == 'admin'
        ) {
            return;
        }

        if (!$this->session->contains('admin_user')) {
            $this->_forward('index', 'login', 'admin');
        }

    }

    /*  验证是否登录 */
    public function verify($modle = '')
    {
//        Admin_IndexController::indexAction
        $admin = $this->session->get('admin_user');
        $admin = unserialize($admin);

        list($select_menu,) = explode("::", $modle);
        $select_menu = strtolower(str_replace('_', '/', substr($select_menu, 0, -10)));
//        var_dump($select_menu);exit;
//        if (substr($modle,0,4) == 'json')
//        {
//            $select_menu = 'api_'.$select_menu[0];
//        }
//        else
//        {
//            $select_menu[0] = explode('_',$select_menu[0],2);
//
//            $select_menu[0] = $select_menu[0][0];
//
//            $select_menu = $select_menu[0].'_'.$select_menu[2];
//        }
        //var_dump($admin['menu_list']);die();

        if (empty($admin['id'])) {
            return $this->_redirect('/admin/login?url='. $this->getRequest()->getServer('REQUEST_URI'));
        } else if (!isset($admin['menu_list'][$select_menu])) {
            throw new Exception("您没有此页面管理权限", -1);
        }

        return $admin;
    }

    public function sendMsg($code = 0, $msg = '', $data = array())
    {
        $this->getResponse()->sendHeaders('Content-type: application/json');
        echo json_encode(array('code' => $code, 'msg' => $msg, 'data' => $data));
        exit(0);
    }

}