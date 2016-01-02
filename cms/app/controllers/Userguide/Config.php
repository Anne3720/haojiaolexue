<?php

/**
 * 用户使用向导 控制器
 *
 * Class UserGuideController
 */
class Userguide_ConfigController extends RThink_Controller_Action
{
    public function indexAction()
    {
        var_dump(RThink_Config::get('db'));
        // 可以直接以数组形式获取一级、二级的配置参数
        var_dump(RThink_Config::get('db.test'));

    }

}