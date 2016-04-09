<?php

/**
 * 修改密码
 *
 * Class Admin_ModifyController
 */
class Admin_ModifyController extends Admin_AbstractController
{

    public function indexAction()
    {
        $admin = unserialize($admin);
        if ($this->getRequest()->getMethod() != 'POST') {
            $params = array('title' => '好教乐学');
            $this->render($params);
        } else {
            $admin = $this->session->get('admin_user');
            $admin = unserialize($admin);
            if(!$admin){
                $this->sendMsg(-1, "请重新登陆");
            }
            $params = $this->getRequest()->getPost();
            if($params['password']!==$params['password1']){
                $this->sendMsg(1, "两次输入密码不一致");
            }else{
                $data['password'] = md5($params['password']. md5($params['password']));
            }
            Admin_AdminModel::instance()->update($data, array('id' => $admin['id']));
            $this->sendMsg(0,"修改成功");
        }
    }

}