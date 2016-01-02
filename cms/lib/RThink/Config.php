<?php

/**
 * 配置文件处理类
 */
class RThink_Config
{

    /**
     * 配置信息缓存
     *
     * @var array
     */
    protected static $_config_cache = array();

    protected static $_config_struct = array();


    /**
     * 获取指定键值的配置参数
     *
     * @param string $key
     * @return null string array
     */
    public static function get($key = '')
    {
        if ('' != $key) {
            if (isset (self::$_config_cache [$key])) {
                return self::$_config_cache [$key];
            }
        } else {
            if (!empty(self::$_config_struct)) {
                return self::$_config_struct;
            }
        }


        class_exists('RThink_Controller_Front', false) || require 'RThink/Controller/Front.php';

        $config_file = RThink_Controller_Front::getInstance()->getParam('config_file');
        $config_section = RThink_Controller_Front::getInstance()->getParam('config_section');

        if (empty(self::$_config_struct)) {
            include $config_file;
            self::$_config_struct = $$config_section;
        }

        if ('' == $key) {
            return self::$_config_struct;
        }

        $key_list = explode('.', $key);

        foreach ($key_list as $key_node) {

                if (isset(self::$_config_cache [$key])) {

                    if (!isset(self::$_config_cache[$key][$key_node])) {
                        class_exists('RThink_Config_Exception', false) || require 'RThink/Config/Exception.php';
                        throw new RThink_Config_Exception ('配置文件节点链{' . $key . '}中[' . $key_node . ']节点不存在');
                    }

                    self::$_config_cache [$key] = self::$_config_cache [$key][$key_node];
                } else {

                    if (!isset(self::$_config_struct[$key_node])) {
                        class_exists('RThink_Config_Exception', false) || require 'RThink/Config/Exception.php';
                        throw new RThink_Config_Exception ('配置文件节点链{' . $key . '}中[' . $key_node . ']节点不存在');
                    }

                    self::$_config_cache [$key] = self::$_config_struct[$key_node];
                }
        }

        return self::$_config_cache [$key];
    }

    public static function set()
    {
        // @todo
    }
}