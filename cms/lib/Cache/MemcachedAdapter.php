<?php
require 'Cache/Adapter.php';


class Cache_MemcachedAdapter extends Cache_Adapter
{
    /**
     * Memcached服务器默认设置
     */
    const DEFAULT_HOST = '127.0.0.1';
    const DEFAULT_PORT = 11211;
    const DEFAULT_WEIGHT = 1;

    /**
     * Available options
     *
     * =====> (array) servers :
     * an array of memcached server ; each memcached server is described by an associative array :
     * 'host' => (string) : the name of the memcached server
     * 'port' => (int) : the port of the memcached server
     * 'weight' => (int) : number of buckets to create for this server which in turn control its
     *                     probability of it being selected. The probability is relative to the total
     *                     weight of all servers.
     * =====> (array) client :
     * an array of memcached client options ; the memcached client is described by an associative array :
     * @see http://php.net/manual/memcached.constants.php
     * - The option name can be the name of the constant without the prefix 'OPT_'
     *   or the integer value of this option constant
     *
     * @var array available options
     */
    protected $_options = array(
        'servers' => array(array(
            'host' => self::DEFAULT_HOST,
            'port' => self::DEFAULT_PORT,
            'weight' => self::DEFAULT_WEIGHT,
        )),
        'client' => array()
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
        if (!extension_loaded('memcached')) {
            class_exists('RThink_Controller_Exception', false) || require 'RThink/Controller/Exception.php';
            throw new RThink_Controller_Exception ('memcached扩展没有加载！');
        }

        // override default client options
        $this->_options['client'] = array(
            Memcached::OPT_DISTRIBUTION => Memcached::DISTRIBUTION_CONSISTENT,
            Memcached::OPT_HASH => Memcached::HASH_MD5,
            Memcached::OPT_LIBKETAMA_COMPATIBLE => true,
        );

        parent::__construct($options);

        if (isset($this->_options['servers'])) {
            $value = $this->_options['servers'];
            if (isset($value['host'])) {
                // in this case, $value seems to be a simple associative array (one server only)
                $value = array(0 => $value); // let's transform it into a classical array of associative arrays
            }
            $this->setOption('servers', $value);
        }
        $this->_memcache = new Memcached;

        // 配置memcached客户端操作项
        foreach ($this->_options['client'] as $name => $value) {
            $optId = null;
            if (is_int($name)) {
                $optId = $name;
            } else {
                $optConst = 'Memcached::OPT_' . strtoupper($name);
                if (defined($optConst)) {
                    $optId = constant($optConst);
                } else {
                    $this->_log("Unknown memcached client option '{$name}' ({$optConst})");
                }
            }
            if ($optId) {
                if (!$this->_memcache->setOption($optId, $value)) {
                    $this->_log("Setting memcached client option '{$optId}' failed");
                }
            }
        }

        // 配置memcached服务
        $servers = array();

        foreach ($this->_options['servers'] as $server) {
            if (!array_key_exists('port', $server)) {
                $server['port'] = self::DEFAULT_PORT;
            }
            if (!array_key_exists('weight', $server)) {
                $server['weight'] = self::DEFAULT_WEIGHT;
            }

            $servers[] = array($server['host'], $server['port'], $server['weight']);
        }

        $this->_memcache->addServers($servers);
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

        // ZF-8856: using set because add needs a second Request if item already exists
        $result = $this->_memcache->set($id, array($data, time(), $lifetime), $lifetime);

//        if ($result === false) {
//            $rsCode = $this->_memcache->getResultCode();
//            $rsMsg  = $this->_memcache->getResultMessage();
//            $this->_log("Memcached::set() failed: [{$rsCode}] {$rsMsg}");
//        }

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
        return $this->_memcache->delete($id);
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

        if (isset($tmp[0], $tmp[1], $tmp[2])) {
            $data = $tmp[0];
            $mtime = $tmp[1];
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
        $tmp = $this->_memcache->get($id);

        if (isset($tmp[0], $tmp[1], $tmp[2])) {
            $data = $tmp[0];
            $mtime = $tmp[1];
            $lifetime = $tmp[2];

            $new_lifetime = $lifetime - (time() - $mtime) + $extra_lifetime;

            if ($new_lifetime <= 0) {
                return false;
            }
            // #ZF-5702 : we try replace() first becase set() seems to be slower
            $result = $this->_memcache->replace($id, array($data, time(), $new_lifetime), $new_lifetime);

            if (!$result) {
                $result = $this->_memcache->set($id, array($data, time(), $new_lifetime), $new_lifetime);
            }

            return $result;
        }

        return false;
    }

}