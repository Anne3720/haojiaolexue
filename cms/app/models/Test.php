<?php
/**
 * Class TestModel 数据test的操作类
 */
class TestModel extends BaseModel {

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