<?php

/**
 * 用户使用向导 控制器
 *
 * Class UserGuideController
 */
class Userguide_ListController extends RThink_Controller_Action
{
    public function indexAction()
    {
        $data = array();

        $data['title'] = '列表页面';

        $condition = array(
            'fields' => array('id', 'title', 'author', 'create_time'),
//            'condition' => 'id >= ? and id <= ?',
            'condition' => 'id in (?, ?) or title=?',
            'bind' => array(1, 2, 'c'),
            'limit' => array('count' => 5)
        );



//        $data['story_list'] = Model_Test::_model('story')->fetchAll($condition);
        $data['story_list'] = TestModel::_model('story')->fetchAll($condition);

        $this->setInvokeArg('layout', 'mainLayout');

        $this->render($data, 'list');
    }

}