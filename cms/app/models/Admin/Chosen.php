<?php

/**
 * 多级路径model测试
 */
class Admin_ChosenModel extends BaseModel
{

    protected static $_instance = null;

    protected static $_table = 'tbl_chosenclass';

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

    public static function getChosenClassList($option){
        $option = self::$_instance->handleOpt($option);
        $sql = "SELECT A.ChosenID,A.MemberID,A.ClassID,A.CreateTime,B.ClassNo,B.Grade,B.SubjectID,B.Image,B.Video,B.Price,C.Title 
                FROM tbl_Chosenclass A LEFT JOIN tbl_class B ON A.ClassID=B.ClassID LEFT JOIN tbl_subject C ON B.SubjectID=C.SubjectID ".$option['condition'];
        $res = self::$_instance->_db->fetchAll($sql, $option['bind'], self::$_instance->_fetch_mode);
        return $res;
    }
    public static function getChosenCount($option){
        $option = self::$_instance->handleOpt($option);
        $sql = "SELECT count(*) as count 
                FROM tbl_Chosenclass A LEFT JOIN tbl_class B ON A.ClassID=B.ClassID LEFT JOIN tbl_subject C ON B.SubjectID=C.SubjectID ".$option['condition'];
        $res = self::$_instance->_db->fetchAll($sql, $option['bind'], self::$_instance->_fetch_mode);
        return $res;
    }
}