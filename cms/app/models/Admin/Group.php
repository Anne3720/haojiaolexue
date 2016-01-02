<?php

/**
 * 多级路径model测试
 */
class Admin_GroupModel extends BaseModel
{

    protected static $_instance = null;

    protected static $_table = 'admin_group';

    public function __construct()
    {
        $db_conf = RThink_Config::get('db.default');

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

    public function getAdminGroupByIds($ids)
    {
        if (!is_array($ids)) {
            $ids = explode(',', $ids);
        }

        // $where 现在为 'id IN("1", "2", "3")' (一个逗号分隔的字符串)
        $condition = $this->getDbInstance()->quoteInto('id IN(?)', $ids) . ' and status = 1';
        return $this->fetchAll(array('condition' => $condition));
    }

}