<?php

/**
 *  Model - 数据层抽象类
 *  提供对数据表进行CRUD功能
 */
abstract class BaseModel
{

    /**
     * 前端控制器实例
     *
     * @var RThink_Controller_Front
     */
    protected $_front_controller = null;

    /**
     * 当前操作数据库实例
     * @var null
     */
    protected $_db = null;

    /**
     * 当前操作的数据库表名
     * @var string
     */
    protected $_handle_table = '';

    /**
     * 结果集的获取模式
     * @var int
     */
    protected $_fetch_mode = PDO::FETCH_ASSOC;

    /**
     * 缓存实例
     * @var null
     */
    protected $_cache = null;


    /**
     * 构造方法
     *
     * @param $option array 数据库配置参数
     */
    public function __construct($option)
    {
        $this->_db = RThink_Db::singleton($option);
        $this->init();
    }


    protected function init()
    {
        if ($this->getFrontController()->getRequest()->getParam('db_debug')) {
            $db_profilers = $this->getFrontController()->getRequest()->getParam('db_profilers');
            $db_profilers || $db_profilers = array();
            $this->_db->getProfiler()->setEnabled(true);
            $db_profilers[] = $this->_db->getProfiler();
            $this->getFrontController()->getRequest()->setParam('db_profilers', $db_profilers);
        }

    }

    /**
     * 设置当前的操作表
     *
     * @return $this
     */
    public function selectTable($table)
    {
        $this->_handle_table = $table;
        return $this;
    }

    /**
     * 获取数据库实例
     *
     * @return null
     */
    public function getDbInstance()
    {
        return $this->_db;
    }


    /**
     *  添加记录
     *
     * @param array $bind
     * @return bool
     */
    public function add(array $bind)
    {
        $ins_res = $this->_db->insert($this->_handle_table, $bind);

        if ($ins_res > 0) {
            return $this->_db->lastInsertId();
        }

        return false;
    }

    /**
     * 修改记录
     *
     * @param array $fields array('name' => 'php', 'type' => 'web')
     * @param array $where array('id > ?' =>1, 'date = ?' => '2015')
     *              转为sql id > 1 and date = '2015'
     *              条件等于操作可以简写为 array('id' => 1, 'date' => '2015')
     *              转为sql id = 1 and date = '2015'
     * @return int 影响的行数
     */
    public function update(array $fields, $where)
    {
        foreach ($where as $key => $val) {
            if (!strstr($key, '?')) {
                $where[$key.' = ?'] = $val;
                unset($where[$key]);
            }
        }

        return $this->_db->update($this->_handle_table, $fields, $where);
    }

    /**
     * 删除记录
     *
     * @param string $table 操作表
     * @param array $where array('id > ?' =>1, 'date = ?' => '2015')
     *              转为sql id > 1 and date = '2015'
     *              条件等于操作可以简写为 array('id' => 1, 'date' => '2015')
     *              转为sql id = 1 and date = '2015'
     *
     * @return int 影响的行数
     */
    public function delete($where = array())
    {
        foreach ($where as $key => $val) {
            if (!strstr($key, '?')) {
                $where[$key.' = ?'] = $val;
                unset($where[$key]);
            }
        }

        return $this->_db->delete($this->_handle_table, $where);
    }

    /**
     * 获取结果集中所有记录
     *
     * @param array $option
     * @return array
     */
    public function fetchAll(array $option = array())
    {
        $option = $this->handleOpt($option);

        $option += array('fields' => '*', 'condition' => '', 'bind' => array(), 'cache' => false);

        $sql = 'SELECT ' . $option['fields'] . ' FROM ' .
               $this->_db->quoteIdentifier($this->_handle_table) . $option['condition'];

        if ($option['cache']) {
            $key = md5($sql . join('', $option['bind']));
            $_cache = $this->getCache();

            $res = $_cache->load($key);

            if (false === $res) {
                $res = $this->_db->fetchAll($sql, $option['bind'], $this->_fetch_mode);
            }

            $_cache->save($res, $key);

        } else {
            $res = $this->_db->fetchAll($sql, $option['bind'], $this->_fetch_mode);
        }


        return $res;
    }


    /**
     * 获取结果集中第一条记录
     *
     * @param array $option
     * @return array
     */
    public function fetchRow($option = array())
    {
        $opt_res = $this->handleOpt($option);
        $opt_res += array('fields' => '*', 'condition' => '', 'bind' => array(), 'quote' => true);

        /*
        过滤自定义字段qoute，支持如下操作
        $condition = array(
        'fields' => array('count(*) as total'),
        'quote' => false
        );
         */

        if ($opt_res['quote'] != false && $opt_res['fields'] != '*') {
            $opt_res['fields'] = $option['fields'][0];
        }

        $sql = 'SELECT ' . $opt_res['fields'] . ' FROM ' . $this->_db->quoteIdentifier($this->_handle_table) . $opt_res['condition'];

        return $this->_db->fetchRow($sql, $opt_res['bind'], $this->_fetch_mode);
    }

    /**
     * 获取结果集中所有记录并以关联数组的形式返回
     * 此结果集数组以每条记录的第一列的值为 key, 以每一条记录为 value 的索引数组. 如果两条记录的第一列的值相同,
     * 那么后面那条记录会覆盖前面的记录.
     *
     * @param array $option
     * @return array
     */
    public function fetchAssoc($option = array())
    {
        $opt_res = $this->handleOpt($option);
        $opt_res += array('fields' => '*', 'condition' => '', 'bind' => array());
        $sql = 'SELECT ' . $opt_res['fields'] . ' FROM ' . $this->_db->quoteIdentifier($this->_handle_table) . $opt_res['condition'];

        return $this->_db->fetchAssoc($sql, $opt_res['bind']);
    }


    /**
     * 获取结果集中所有记录的第一列以索引数组的形式返回
     *
     * @param array $option
     * @return array
     */
    public function fetchCol($option = array())
    {
        $opt_res = $this->handleOpt($option);
        $opt_res += array('fields' => '*', 'condition' => '', 'bind' => array(), 'quote' => true);

        if ($opt_res['quote'] != false && $opt_res['fields'] != '*') {
            $opt_res['fields'] = $option['fields'][0];
        }

        $sql = 'SELECT ' . $opt_res['fields'] . ' FROM ' . $this->_db->quoteIdentifier($this->_handle_table) . $opt_res['condition'];

        return $this->_db->fetchCol($sql, $opt_res['bind']);
    }

    public function count($option = array())
    {
        /*
        过滤自定义字段qoute，支持如下操作
        $condition = array(
        'fields' => array('count(*) as total'),
        'quote' => false
        );
         */
        if (isset($option['condition']) && isset($option['bind'])) {
            $option = array('condition' => $option['condition'], 'bind' => $option['bind']);
        }

        $option['fields'] = array('count(*)');

        $res = $this->fetchCol($option);

        if ($res) {
            return $res[0];
        }

        return 0;
    }

    /**
     *  设置结果集获取模式
     * @param $fetch_mode
     * @return $this
     */
    public function setFetchMode($fetch_mode)
    {
        $this->_fetch_mode = $fetch_mode;
        return $this;
    }

    /**
     *  处理sql查询条件
     *
     * @param array $option
     * @return array
     */
    protected function handleOpt($option)
    {
        //处理结果
        $handle_res = array();

        $condition = '';

        if (isset($option['fields'])) {
            $handle_res['fields'] = '';
            foreach ((array)$option['fields'] as $field) {
                $handle_res['fields'] .= $this->_db->quoteIdentifier($field) . ',';
            }
            $handle_res['fields'] = rtrim($handle_res['fields'], ',');
        }


        if (!empty($option['condition'])) {
            $condition .= 'WHERE ' . $option['condition'];
        }

        if (isset($option['order'])) {
            $condition .= ' ORDER BY ' . $option['order'];
        }

        if (isset($option['limit']['count'])) {
            $option['limit']['offset'] = isset($option['limit']['offset']) ? intval($option['limit']['offset']) : 0;
            $condition = $this->_db->limit($condition, intval($option['limit']['count']), $option['limit']['offset']);
        }


        empty($condition) ||
            $handle_res['condition'] = $condition;

        empty($option['bind']) ||
            $handle_res['bind'] = $option['bind'];

        return $handle_res;
    }


    /**
     * 获取前端控制器
     *
     * @return RThink_Controller_Front
     */
    protected function getFrontController()
    {
        // Used cache version if found
        if (null === $this->_front_controller) {
            class_exists('RThink_Controller_Front', false) || require 'RThink/Controller/Front.php';
            $this->_front_controller = RThink_Controller_Front::getInstance();
        }

        return $this->_front_controller;
    }


    /**
     * 获取cache对象
     * @return null|object
     */
    protected function getCache()
    {
        if (null == $this->_cache) {
            class_exists('Cache', false) || require 'Cache.php';

            //默认使用memcache缓存
            $mc_conf = RThink_Config::get('memcache');
            $this->_cache = Cache::singleton(array('params' => $mc_conf));
        }

        return $this->_cache;
    }

}