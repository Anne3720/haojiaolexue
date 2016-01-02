<?php

/**
 * 用户使用向导 控制器
 *
 * Class UserGuideController
 */
class Userguide_HttpController extends RThink_Controller_Action
{
    public function indexAction()
    {
        $http = new CurlHttp();

        $res = $http->get('http://www.baidu.com', array(
            'q' => 'keyword',
        ));


        var_dump($res);
        $http->close();

    }

}