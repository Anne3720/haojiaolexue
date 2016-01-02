<?php

/**
 * 退出
 *
 * Class Admin_LogoutController
 */
class Admin_LogoutController extends Admin_AbstractController
{
    public function indexAction()
    {
        $this->session->clear();
        $this->session->destroy();

        $this->_forward('index', 'login', 'admin');
    }

}