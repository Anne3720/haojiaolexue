<?php

/**
 * 缓存操作类
 *
 * Class cache
 */
class Cache
{

    /**
     * clean() 方法常量
     */
    const CLEANING_MODE_ALL = 'all';
    const CLEANING_MODE_OLD = 'old';


    /**
     * 每种cache一个单例
     *
     * @var array
     */
    protected static $_cache = array();

    /**
     * 工厂, 创建操作各种缓存的对象.
     *
     * @param string|null $cache_type 缓存类型
     *            db_type
     * @param array $options 缓存库配置参数
     * @return object 操作相应缓存对象
     */
    public static function factory($options, $adapter)
    {
        $class_name = self::_formatAdaperName($adapter);
        class_exists($class_name, false) || require 'Cache/' . $class_name . '.php';
        return new $class_name ($options);
    }

    /**
     * 单例工厂, 以单例模式创建操作各种数据库的对象, 每种数据库操作对象为一个单例. 由于是单例模式, 所以当引用单例的时候, $options
     * 参数将会失去意义, 也就是说 只有在创建单例的第一次调用的时候, $options 才有意义.
     *
     * @param array $options 缓存参数接结构
     * array(
     *  'adapter' => 'memcache', //缓存类型 默认为memcache
     * 'params' => array(), //初始化缓存需要的参数
     * )
     * @return object 操作相应缓存对象
     */
    public static function singleton(array $options)
    {

        $options += array('adapter' => 'memcache');

        // 实现每种缓存的单例
        if (isset (self::$_cache[$options['adapter']]) && self::$_cache[$options['adapter']] instanceof Cache_Adapter) {
            return self::$_cache[$options['adapter']];
        }

        self::$_cache[$options['adapter']] = self::factory($options['params'], $options['adapter']);

        return self::$_cache[$options['adapter']];
    }


    /**
     * 格式化缓存适配器名称
     *
     * @param $un_formate_adaper
     * @return string
     */
    protected static function _formatAdaperName($un_formate_adaper)
    {
        return ucfirst($un_formate_adaper) . 'Adapter';
    }

}