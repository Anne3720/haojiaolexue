<?php

/**
 * 用户使用向导 控制器
 *
 * Class UserGuideController
 */
class Userguide_ViewController extends RThink_Controller_Action
{
    public function indexAction()
    {
        $data = array();

        $data['title'] = '视图渲染';
        $key = $this->getRequest()->getParam('key');
        $data['key'] = $key;

        $this->render($data);
    }

}