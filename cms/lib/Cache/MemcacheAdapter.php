<?php
require 'Cache/Adapter.php';

/**
 * Class MemcacheAdapter Memcache适配器
 *
 * 构造方法接收memcache配置信息格式说明
 *
 * #单台mecache服务器的参数格式
 * $single_config = array(
 * 'servers' => array('host' => '10.58.128.39', 'port' => 8211)
 * );
 *
 * #标准(多台)memcahe配置信息格式
 * $multi_options = array(
 * 'servers' => array(
 * array(
 * 'host' => 127.0.0.1,
 * 'port' => 11211,
 * 'persistent' => true,
 * 'weight'  => 1,
 * 'timeout' => 1,
 * 'retry_interval' => 15,
 * ),
 * array(
 * ...........
 * ),
 * ),
 * 'compression' => false,
 * );
 */
class Cache_MemcacheAdapter extends Cache_Adapter
{
    /**
     * Memcached服务器默认设置
     */
    const DEFAULT_HOST = '127.0.0.1';
    const DEFAULT_PORT = 11211;
    const DEFAULT_PERSISTENT = true;
    const DEFAULT_WEIGHT = 1;
    const DEFAULT_TIMEOUT = 1;
    const DEFAULT_STATUS = true;
    const DEFAULT_RETRY_INTERVAL = 15;
    const DEFAULT_FAILURE_CALLBACK = null;


    /**
     * 操作项
     *
     * =====> (array) servers :
     * an array of memcached server ; each memcached server is described by an associative array :
     * 'host' => (string) : the name of the memcached server
     * 'port' => (int) : the port of the memcached server
     * 'persistent' => (bool) : use or not persistent connections to this memcached server
     * 'weight' => (int) : number of buckets to create for this server which in turn control its
     *                     probability of it being selected. The probability is relative to the total
     *                     weight of all servers.
     * 'timeout' => (int) : value in seconds which will be used for connecting to the daemon. Think twice
     *                      before changing the default value of 1 second - you can lose all the
     *                      advantages of caching if your connection is too slow.
     * 'retry_interval' => (int) : controls how often a failed server will be retried, the default value
     *                             is 15 seconds. Setting this parameter to -1 disables automatic retry.
     * 'status' => (bool) : controls if the server should be flagged as online.
     *
     * =====> (boolean) compression :
     * true if you want to use on-the-fly compression
     *
     * =====> (boolean) compatibility :
     * true if you use old memcache server or extension
     *
     * @var array available options
     */
    protected $_options = array(
        'servers' => array(
            array(
                'host' => self::DEFAULT_HOST,
                'port' => self::DEFAULT_PORT,
                'persistent' => self::DEFAULT_PERSISTENT,
                'weight' => self::DEFAULT_WEIGHT,
                'timeout' => self::DEFAULT_TIMEOUT,
                'retry_interval' => self::DEFAULT_RETRY_INTERVAL,
            )
        ),
        'compression' => false,
        'compatibility' => false,
    );

    /**
     * Memcache 实例
     *
     * @var mixed memcache object
     */
    protected $_memcache = null;

    /**
     * 构造方法
     *
     * @param array $options associative array of options
     * @throws RThink_Controller_Exception
     * @return void
     */
    public function __construct(array $options = array())
    {
        if (!extension_loaded('memcache')) {
            class_exists('RThink_Controller_Exception', false) || require 'RThink/Controller/Exception.php';
            throw new RThink_Controller_Exception ('memcache扩展没有加载！');
        }

        parent::__construct($options);

        $this->_memcache = new Memcache();

        //处理单台mecache服务器的参数的情况
        if (isset($this->_options['servers'])) {
            $value = $this->_options['servers'];

            if (isset($value['host'])) {
                //单台服务器的情况
                $value = array(0 => $value); // 构造memcache适配器需要的参数格式
            }

            $this->setOption('servers', $value);
        }

        foreach ($this->_options['servers'] as $server) {

            array_key_exists('port', $server) || $server['port'] = self::DEFAULT_PORT;
            array_key_exists('persistent', $server) || $server['persistent'] = self::DEFAULT_PERSISTENT;
            array_key_exists('weight', $server) || $server['weight'] = self::DEFAULT_WEIGHT;
            array_key_exists('timeout', $server) || $server['timeout'] = self::DEFAULT_TIMEOUT;
            array_key_exists('retry_interval', $server) || $server['retry_interval'] = self::DEFAULT_RETRY_INTERVAL;
            array_key_exists('status', $server) || $server['status'] = self::DEFAULT_STATUS;
            array_key_exists('failure_callback', $server) || $server['failure_callback'] = self::DEFAULT_FAILURE_CALLBACK;

            if ($this->_options['compatibility']) {
                $this->_memcache->addServer(
                    $server['host'],
                    $server['port'],
                    $server['persistent'],
                    $server['weight'],
                    $server['timeout'],
                    $server['retry_interval']
                );
            } else {
                $this->_memcache->addServer(
                    $server['host'],
                    $server['port'],
                    $server['persistent'],
                    $server['weight'],
                    $server['timeout'],
                    $server['retry_interval'],
                    $server['status'],
                    $server['failure_callback']);
            }

        }
    }


    /**
     * 获取指定id的缓存
     *
     * @param  string $id 缓存id
     * @return string|false cached datas
     */
    public function load($id)
    {
        $tmp = $this->_memcache->get($id);
        if (is_array($tmp) && isset($tmp[0])) {
            return $tmp[0];
        }
        return false;
    }

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
    public function save($data, $id, $specific_lifetime = false)
    {
        $lifetime = $this->getLifetime($specific_lifetime);

        if ($this->_options['compression']) {
            $flag = MEMCACHE_COMPRESSED;
        } else {
            $flag = 0;
        }

        // ZF-8856: using set because add needs a second Request if item already exists
        $result = $this->_memcache->set($id, array($data, time(), $lifetime), $flag, $lifetime);

        return $result;
    }

    /**
     * 删除缓存数据
     *
     * @param  string $id 缓存id
     * @return boolean
     */
    public function remove($id)
    {
        return $this->_memcache->delete($id, 0);
    }

    /**
     * 清除缓存记录
     *
     * @param  string $mode all | old
     * @throws RThink_Controller_Exception
     * @return boolean
     */
    public function clean($mode = Cache::CLEANING_MODE_ALL)
    {
        switch ($mode) {
            case Cache::CLEANING_MODE_ALL:
                return $this->_memcache->flush();
                break;
            default:
                class_exists('RThink_Controller_Exception', false) || require 'RThink/Controller/Exception.php';
                throw new RThink_Controller_Exception ('clean()方法无效的清除模式[' . $mode . ']');
                break;
        }
    }


    /**
     * 获取指定缓存id的元数据
     *
     * 返回数据结构 :
     * - expire : 过期时间
     * - mtime : 最后修改时间
     *
     * @param string $id 缓存id
     * @return array | false
     */
    public function getMetadatas($id)
    {
        $tmp = $this->_memcache->get($id);

        if (is_array($tmp)) {
            $data = $tmp[0];
            $mtime = $tmp[1];
            if (!isset($tmp[2])) {
                // because this record is only with 1.7 release
                // if old cache records are still there...
                return false;
            }
            $lifetime = $tmp[2];
            return array(
                'expire' => $mtime + $lifetime,
                'mtime' => $mtime
            );
        }
        return false;
    }

    /**
     * 增加指定id的缓存的过期时间
     *
     * @param string $id cache id
     * @param int $extra_lifetime
     * @return boolean
     */
    public function touch($id, $extra_lifetime)
    {
        $flag = $this->_options['compression'] ? MEMCACHE_COMPRESSED : 0;
        $tmp = $this->_memcache->get($id);

        if (is_array($tmp)) {
            $data = $tmp[0];
            $mtime = $tmp[1];
            if (!isset($tmp[2])) {
                // because this record is only with 1.7 release
                // if old cache records are still there...
                return false;
            }
            $lifetime = $tmp[2];
            $new_lifetime = $lifetime - (time() - $mtime) + $extra_lifetime;
            if ($new_lifetime <= 0) {
                return false;
            }
            // #ZF-5702 : we try replace() first becase set() seems to be slower
            $result = $this->_memcache->replace($id, array($data, time(), $new_lifetime), $flag, $new_lifetime);

            if (!$result) {
                $result = $this->_memcache->set($id, array($data, time(), $new_lifetime), $flag, $new_lifetime);
            }
            return $result;
        }
        return false;
    }

}