<?php

/**
 * 用户使用向导 控制器
 *
 * Class UserGuideController
 */
class Userguide_SessionController extends RThink_Controller_Action
{
    public function indexAction()
    {

        $session = new Session();

        $session->add('name', 'php');
        $session->add('type', 'web');

        var_dump($_SESSION);

        $session->remove('name');

        var_dump($_SESSION);


        // 移去所有session变量
        $session->clear();

        // 移去存储在服务器端的数据
        $session->destroy();

//        $session->close();

        var_dump($_SESSION);
    }

}