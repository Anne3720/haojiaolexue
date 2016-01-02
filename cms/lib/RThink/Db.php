<?php

/**
 * db 类
 */
class RThink_Db
{
    /**
     * 调用quote()方式使用的数据类型
     */
    const TYPE_INT = 1;
    const TYPE_BIGINT = 2;
    const TYPE_FLOAT = 3;

    /**
     * 每种数据库一个单例
     *
     * @var array
     */
    protected static $_db = array();

    /**
     * 工厂, 创建操作各种数据库的对象.
     *
     * @param string|null $db_type 数据库类型, 如果传递 null 或者不传递则默认为 local RThink_Config 的
     *            db_type
     * @param array $options 数据库配置参数
     * @return object 操作相应数据库的对象
     * @throws em_db_exception
     */
    public static function factory($options, $db_type)
    {
        $adapter_name = ucfirst($db_type) . 'Adapter';
        $class_name = 'RThink_Db_' . $adapter_name;
        class_exists($class_name, false) || require 'RThink/Db/' . $adapter_name . '.php';
        return new $class_name ($options);
    }

    /**
     * 单例工厂, 以单例模式创建操作各种数据库的对象, 每种数据库操作对象为一个单例. 由于是单例模式, 所以当引用单例的时候, $options
     * 参数将会失去意义, 也就是说 只有在创建单例的第一次调用的时候, $options 才有意义.
     *
     * @param string|null $db_type 数据库类型, 如果传递 null 或者不传递则默认为 local RThink_Config 的
     *            db_type
     * @param array $options 数据库配置参数
     * @return object 操作相应数据库的对象
     */
    public static function singleton(array $options, $db_type = 'mysql')
    {
        // 实现每种数据库的单例
        if (isset (self::$_db [$options['dbname']]) && self::$_db [$options['dbname']] instanceof RThink_Db_Adapter) {
            return self::$_db [$options['dbname']];
        }

        self::$_db [$options['dbname']] = self::factory($options, $db_type);

        return self::$_db [$options['dbname']];
    }
}