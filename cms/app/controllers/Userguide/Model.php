<?php

/**
 * 用户使用向导 控制器
 *
 * Class UserGuideController
 */
class Userguide_ModelController extends RThink_Controller_Action
{
    public function indexAction()
    {
        echo '多级Model测试 - Test_FooModel';
        Test_FooModel::_model('story');

        $this->test();
    }


    public function test()
    {
        Test_FooModel::_model('story');
    }

}