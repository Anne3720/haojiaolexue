<?php

/**
 * 用户使用向导 控制器
 *
 * Class UserGuideController
 */
class Userguide_DebugController extends RThink_Controller_Action
{
    public function indexAction()
    {
        $output = array('error' => 'shit');

        echo 'rtDebug - 查看页面源代码查看输出!';

        RThink_Debug::rtDebug($output);

        echo 'fbDebug - 打开火狐控制台查看输出！'. "\n";
        RThink_Debug::fbDebug($output);


    }

}