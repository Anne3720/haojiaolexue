<?php

/**
 * 多级路径model测试
 */
class Admin_ClassesModel extends BaseModel
{

    protected static $_instance = null;

    protected static $_table = 'tbl_class';

    public function __construct()
    {
        $db_conf = RThink_Config::get('db.db');

        parent::__construct($db_conf);
    }

    public static function instance()
    {
        if (null == self::$_instance) {
            self::$_instance = new self();
        }

        self::$_instance->selectTable(self::$_table);

        return self::$_instance;
    }

    public static function getMaxNo($option){
        $option = self::$_instance->handleOpt($option);
        $sql = "SELECT Max(No) AS maxNo
                FROM tbl_class ".$option['condition'];
        $res = self::$_instance->_db->fetchAll($sql, $option['bind'], self::$_instance->_fetch_mode);
        return $res;
    }
}