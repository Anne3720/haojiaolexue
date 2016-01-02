<?php

/**
 * Class Cache_Adapter 缓存适配器
 */
abstract class Cache_Adapter
{
    /**
     * 缓存失效时间 单位秒
     *
     * @var int
     */
    protected $_lifetime = 3600;


    /**
     * 缓存操作项
     *
     * @var array
     */
    protected $_options = array();

    /**
     * 构造方法
     *
     * @param  array $options
     * @return void
     */
    public function __construct(array $options = array())
    {
        while (list($name, $value) = each($options)) {
            $this->setOption($name, $value);
        }
    }


    /**
     * 设置操作项
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function setOption($name, $value)
    {
        $name = strtolower($name);

        if (array_key_exists($name, $this->_options)) {
            $this->_options[$name] = $value;
        }
    }

    /**
     * 获取缓存失效时间
     *
     * 如果$specific_lifetime为false将使用全局失效时间
     *
     * @param int $specific_lifetime 缓存失效时间
     * @return int
     */
    public function getLifetime($specific_lifetime)
    {
        if ($specific_lifetime === false) {
            return $this->_lifetime;
        }
        return $specific_lifetime;
    }


    /**
     * 获取指定缓存id的缓存
     *
     * @param  string $id 缓存内容
     * @return string|false cached datas
     */
    abstract public function load($id);

    /**
     * 保存数据到缓存中
     *
     * Note : $data is always "string" (serialization is done by the
     * core not by the backend)
     *
     * @param  string $data 保存的数据
     * @param  string $id 缓存id
     * @param  int 缓存过期时间
     *
     * @return boolean
     *
     */
    abstract public function save($data, $id, $specific_lifetime = false);

    /**
     * 删除缓存数据
     *
     * @param  string $id 缓存id
     * @return boolean
     */
    abstract public function remove($id);

    /**
     * 清除缓数据
     *
     * @param  string $mode all | old
     * @throws RThink_Controller_Exception
     * @return boolean
     */
    abstract public function clean($mode = Cache::CLEANING_MODE_ALL);

}