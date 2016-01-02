<?php

class User_FooController extends RThink_Controller_Action
{

    public function indexAction()
    {

        $id = $this->getRequest()->getParam('id');

        $data = array(
            'id' => $id,
            'title' => '多路径控制器路由测试',
        );
        //参数 - layout
        //取值 - xxx.xxx.layout 使用布局模版，默认情况 default.mainLayout
        $this->setInvokeArg('layout', 'mainLayout');

        $this->render($data);

//        $this->_forward('index', 'index', 'default');
//         echo   '用户列表页面;
//
//        $this->_response->append('prepend1', 'prepend1');
//        $this->_response->prepend('prepend2', 'prepend2');
//        $res = $this->_response->getBody();
    }
}
