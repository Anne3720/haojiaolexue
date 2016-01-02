<?php

/**
 * 用户使用向导 控制器
 *
 * Class UserGuideController
 */
class Userguide_RouterController extends RThink_Controller_Action
{
    public function indexAction()
    {
        $dirs = $this->getFrontController()->getControllerDirectory();

        echo '<pre>';
        print_r($dirs);
    }

}