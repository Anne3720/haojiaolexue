<?php
/**
 * 多级路径model测试
 */
class Test_FooModel extends BaseModel {

    protected static $_instance = null;

    public function __construct() {
        $db_conf = RThink_Config::get('db.test');

        parent::__construct($db_conf);
    }

    public static function _model($table = '') {
        if (null == self::$_instance) {
            self::$_instance = new self();
        }

        if (!empty($table)) {
            self::$_instance->selectTable($table);
        }

        return self::$_instance;
    }

}