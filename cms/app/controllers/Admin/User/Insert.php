<?php

/**
 *  添加管理员
 * Class Admin_User_InsertController
 */
class Admin_User_InsertController extends Admin_AbstractController
{

    public function indexAction()
    {
        $this->verify(__METHOD__);

        $id = $this->getRequest()->getPost('id');
        $username = $this->getRequest()->getPost('username', '');
        $username = trim($username);
        $password = $this->getRequest()->getPost('password', '');
        $password = trim($password);
        $gid = $this->getRequest()->getPost('gid', array());

        $admin = $this->session->get('admin_user');

        if (empty($username)) {
            $this->sendMsg(-1, '账号不能为空');
        }

        /* 如果$POST['id']为空,则为新增用户 */
        if (empty($id)) {
            $admin_user = Admin_AdminModel::instance()->fetchRow(
                array('condition' => 'username = ? and status = 1', 'bind' => array($username)));

            if (!empty($admin_user['id'])) {
                $this->sendMsg(-1, "帐号重复,不允许添加!");
            }


            $data = array(
                'username' => $username,
                'gid' => join(',', $gid),
                'password' => md5($password. md5($password)),
                'createtime' => date('Y-m-d H:i:s'),
            );

            /* 写入账号 */
            Admin_AdminModel::instance()->add($data);

        } else {
            //更新账号
            $data = array(
                'username' => $username,
                'gid' => join(',', $gid),
            );
            if($password){
                $data['password'] = md5($password. md5($password));
            }
            Admin_AdminModel::instance()->update($data, array('id' => $id));
        }


        if ($admin['id'] == $id) {
            $this->session->add('admin_user', '');
        }

        $this->sendMsg(1, "操作成功");
    }
}
