<?php

/**
 * 用户使用向导 控制器
 *
 * Class UserGuideController
 */
class UserGuideController extends RThink_Controller_Action
{

    public function indexAction()
    {
//        $methodes = Model_Widget_User::getMethodes($this);

        $methodes = array();
        $data = array(
            'title' => 'RThinkPHP使用向导',
            'methods' => $methodes
        );

        $this->getResponse()->setHeader('Content-Type', 'text/html; charset=utf8');

        $this->setInvokeArg('layout', 'mainLayout');
        $this->render($data);
    }


    public function viewAction()
    {
        $data = array();

        $data['title'] = '视图渲染';
        $key = $this->getRequest()->getParam('key');
        $data['key'] = $key;

        $this->render($data);
    }

    public function viewLayoutAction()
    {
        $data = array();

        $data['title'] = '视图渲染';
        $key = $this->getRequest()->getParam('key');
        $data['key'] = $key;
        $this->setInvokeArg('layout', 'mainLayout');

        $this->render($data);
    }

    public function routerAction()
    {
        $dirs = $this->getFrontController()->getControllerDirectory();

        echo '<pre>';
        print_r($dirs);
    }


    /**
     * model 测试方法 - 取回结果集中所有字段的值,作为连续数组返回
     *
    旧的model调用方式 - 已经废弃
    $model_test = ModelLoader::factory('test');
    $data['story_list'] = $model_test->selectTable('story')->fetchAll($condition);

    新的model调用方式
    $model_test = new Model_Test();
    Model_Test::_model('story');
    Model_Test::_model()->selectTable('story');

     废弃 condition中的where 用更简洁方便的condition来替代 以使用内部bind()方法
    $condition = array(
    'fields' => array('id', 'title', 'author', 'create_time'),
    'where' => array(
    'id >= ? and id <= ? or id >= ? and id<= ?' => array(1, 2, 3, 4),
    //                   'id in (?) or title = ?' => array(array(1,2,'St John"s Wort'), 'St John"s Wort')
    ),
    'limit' => array('count' => 5)
    //            'limit' => array('count' => 2, 'offset' => 0)
    );
     */
    public function listAction()
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


        $data['story_list'] = Model_Test::_model('story')->fetchAll($condition);


        $this->setInvokeArg('layout', 'mainLayout');

        $this->render($data, 'list');
    }


    public function addAction()
    {
        $data = array();

        $data['title'] = '数据添加';
        $this->setInvokeArg('layout', 'mainLayout');

        $this->render($data);
    }


    /**
     * @return int 返回新增的id
     */
    public function addDoAction()
    {
        $title = $this->getRequest()->getPost('title');
        $author = $this->getRequest()->getPost('author');
        $content = $this->getRequest()->getPost('content');

        $test_model = Model_Test::_model();
        $test_model->selectTable('story');

        $data = array(
            'title' => $title,
            'author' => $author,
            'content' => $content,
            'create_time' => date('Y-m-d H:i:s')
        );

        $res = $test_model->add($data);

        var_dump($res);

    }


    /**
     * @return int 返回sql影响的行数
     */
    public function updateAction()
    {
        $data = array(
            'title' => 'he',
            'content' => 'heh'
        );

        $condition = array(
            'id > ? ' => '1 and id < 5',
            'create_time > ?' => "2014-05-12 20:14:21"
        );

        $upd_res = Model_Test::_model('story')->update($data, $condition);
    }


    /**
     * @retrun int 返回sql影响的行数
     */
    public function deleteAction()
    {
        $condition = array(
            'id > ?' => 1,
        );

        $upd_res = Model_Test::_model('story')->delete($condition);

        var_dump($upd_res);
    }



    /**
     * db类 使用示例
     */
    public function dbAction()
    {
//        $db_conf = RThink_Config::get('db.test');

          $db_conf = array(
              'host' => 'localhost',
              'dbname' => 'test',
              'username' => 'root',
              'password' => '',
          );


        $db = Db::singleton($db_conf);
        $db->getProfiler()->setEnabled(true);

        $db_profilers[] = $db->getProfiler();

        $this->getFrontController()->getRequest()->setParam('db_profilers', $db_profilers);

        $stmt = $db->query(
            'SELECT * FROM story where id > :id limit 1',
            array("id" => 0)
        );

        $res = $stmt->fetchAll();
    }


    /**
     * 只取回结果集的第一行
     */
    public function listRowAction()
    {
        $data = array();

        $data['title'] = '列表页面';

        $condition = array(
            'fields' => array('title', 'author', 'create_time'),
        );

        $data['test'] = Model_Test::_model('story')->fetchRow($condition);
        $this->setInvokeArg('layout', 'mainLayout');

        $this->render($data);
    }


    /**
     * 取回结果集中所有字段的值,作为关联数组返回
     * 第一个字段作为key
     */
    public function listAssocAction()
    {
        $data = array();

        $data['title'] = '列表页面';


        $condition = array(
            'fields' => array('title', 'author', 'create_time'),
        );

        $data['story_list'] = Model_Test::_model('story')->fetchAssoc($condition);
        $this->setInvokeArg('layout', 'mainLayout');

        $this->render($data, 'list');
    }


    /**
     * 取回所有结果行的第一个字段名
     */
    public function listColAction()
    {
        $data = array();

        $data['title'] = '列表页面';


        $condition = array(
            'fields' => array('id'),
        );

        $data['story_list'] = Model_Test::_model('story')->fetchCol($condition);
        $this->setInvokeArg('layout', 'mainLayout');

        var_dump($data);
    }


    /**
     * 读取配置文件
     */
    public function configAction()
    {
        var_dump(RThink_Config::get('db'));
        // 可以直接以数组形式获取一级、二级的配置参数
        var_dump(RThink_Config::get('db.test'));
    }

    /**
     * 302 重定向
     */
    public function forwardAction()
    {
        $this->session->init();

        $this->_forward('session');
    }


    /**
     * 请求转发
     */
    public function redirectAction()
    {
        $this->_redirect('http://www.baidu.com');
    }


    /**
     * 数据缓存
     */
    public function cacheAction()
    {

        $mc_conf = RThink_Config::get('memcache');

        // var_dump($mc_conf);


        $mc = LibLoader::factory('cache', array('adapter' => 'memcache', 'params' => $mc_conf), true);


        $key = 'lang';
        $val = 'php';
        $mc->save($val, $key);
//
//        $mc->remove($key);
//        $mc->touch($key, 10);
//
        $res = $mc->load($key);
//
        $metata = $mc->getMetadatas($key);
//
        var_dump($res, $metata);
    }


    public function sessionAction()
    {
        $this->session->init();
//        $session = LibLoader::factory('session');
//
//        $session = new Session();
//
//        $session->open();
//        $session->getCookieParams();
//
//        var_dump($session->getCookieParams());

    }
}