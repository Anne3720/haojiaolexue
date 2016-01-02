<?php

/**
 *  db profile 处理类. 用于记录并统计查询.
 */
class RThink_Db_Profiler
{
    /**
     * 操作常量
     */
    const CONNECT = 1, QUERY = 2, INSERT = 4, UPDATE = 8, DELETE = 16, SELECT = 32, TRANSACTION = 64;

    /**
     * RThink_Db_ProfilerQuery 对象数组
     *
     * @var array
     */
    protected $_query_profiles = array();

    /**
     * 查询分析器开关，如果设置为false则执行queryStart()会被忽略
     *
     * @var boolean
     */
    protected $_enabled = false;

    /**
     * 存储过滤的限制时间,如果为null使用时间的过滤器将被限制。
     * 小该时间的分析器将会被从self::$_query_profiles中删除
     *
     * @var integer
     */
    protected $_filter_elapsed_secs = null;

    /**
     * 存储查询类型过滤器, 此过滤器中存储的是需要保留的查询类型.
     *
     * 如果值为 null, 则过滤器不生效.
     * 如果生效, 那么所有不需要被保留的的查询对象 DbProfileQuery
     * 将从 self::$_query_profiles 中被 unset.
     *
     * @var integer
     */
    protected $_filter_types = null;

    /**
     * 构造函数 此 profile 默认是被关闭的. 如果想开启, 必须直接或者间接调用 setEnabled().
     *
     * @param boolean $enabled 是否开启 profile
     */
    public function __construct($enabled = false)
    {
        $this->setEnabled($enabled);
    }

    /**
     * 查询分析器开关
     *
     * @param boolean $enable
     * @return RThink_Db_Profiler
     */
    public function setEnabled($enable)
    {
        $this->_enabled = ( boolean )$enable;

        return $this;
    }

    /**
     * 设置查询消耗时间过滤器
     *
     * @param integer $minimu_seconds
     * @return RThink_Db_Profiler
     */
    public function setFilterElapsedSecs($minimu_seconds = null)
    {
        if (null === $minimu_seconds) {
            $this->_filter_elapsed_secs = null;
        } else {
            $this->_filter_elapsed_secs = intval($minimu_seconds);
        }

        return $this;
    }

    /**
     * 设置查询类型过滤器
     *
     * @param integer $query_types OPTIONAL
     * @return RThink_Db_Profiler
     */
    public function setFilterQueryType($query_types = null)
    {
        $this->_filter_types = $query_types;

        return $this;
    }


    /**
     *  清除 profile 中记录的所有的RThink_Db_Profiler记录
     *
     * @return RThink_Db_Profiler
     */
    public function clear()
    {
        $this->_query_profiles = array();

        return $this;
    }

    /**
     * clone 一个 传入的 DbProfileQuery 对象, 并存储起来.
     * 如果不想引用传入的对象, 而需要复制, 那么此方法将会帮助你.
     *
     * 注意: 此方法将会使 self::$_query_profiles 的内部指针指向末尾.
     * @param $query RThink_Db_ProfilerQuery对象
     * @return  被 clone 的 profile 查询对象
     */
    public function queryClone(RThink_Db_ProfilerQuery $query)
    {
        $this->_query_profiles [] = clone $query;

        end($this->_query_profiles);

        return key($this->_query_profiles);
    }

    /**
     * 开始进行一个 em_db_profile_query
     *
     * 注意: 此方法将会使 self::$__query_profiles 的内部指针指向末尾.
     *
     * @param string $query_sql 查询 SQL 语句字符串
     * @param integer|null $query_type 查询类型
     * @return integer|null 如果已经开启 profile 则返回对应的 query id | 否则返回 null
     */
    public function queryStart($query_text, $query_type = null)
    {
        if (!$this->_enabled) {
            return null;
        }

        // make sure we have a query type
        if (null === $query_type) {
            switch (strtolower(substr(ltrim($query_text), 0, 6))) {
                case 'insert' :
                    $query_type = self::INSERT;
                    break;
                case 'update' :
                    $query_type = self::UPDATE;
                    break;
                case 'delete' :
                    $query_type = self::DELETE;
                    break;
                case 'select' :
                    $query_type = self::SELECT;
                    break;
                default :
                    $query_type = self::QUERY;
                    break;
            }
        }

        /**
         * @see RThink_Db_ProfilerQuery
         */
        class_exists('RThink_Db_ProfilerQuery', false) || require 'RThink/Db/ProfilerQuery.php';
        $this->_query_profiles [] = new RThink_Db_ProfilerQuery ($query_text, $query_type);

        end($this->_query_profiles);

        return key($this->_query_profiles);
    }

    /**
     * 结束一个 DbprofileQuery,传入queryStart()返回的操作标识
     * 它将会标识查询结束并保存查询时间
     *
     * @param integer $query_id
     * @throws RThink_Db_Exception
     * @return void
     */
    public function queryEnd($query_id)
    {
        if (!$this->_enabled) {
            return;
        }

        // 判断 query_id 是否存在
        if (!isset ($this->_query_profiles [$query_id])) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ("Profiler has no query with handle '$query_id'.");
        }

        $qp = $this->_query_profiles [$query_id];

        // 如果已经结束了则不能重复结束
        if ($qp->hasEnded()) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ("Query with profiler handle '$query_id' has already ended.");
        }

        // 结束查询分析以便计算查询消耗时间
        $qp->end();

        // 如果设置了查询消耗时间过滤器, 则判断是否需要过滤
        if (null !== $this->_filter_elapsed_secs && $qp->getElapsedSecs() < $this->_filter_elapsed_secs) {
            unset ($this->_query_profiles [$query_id]);
            return;
        }

        // 如果设置了查询类型过滤器, 则判断是否需要过滤
        if (null !== $this->_filter_types && !($qp->getQueryType() & $this->_filter_types)) {
            unset ($this->_query_profiles [$query_id]);
            return;
        }

        return;
    }

    /**
     * Get a profile for a query. Pass it the same handle that was returned by
     * queryStart() and it will return a RThink_Db_ProfilerQuery object.
     *
     * @param integer $query_id
     * @throws RThink_Db_Exception
     * @return RThink_Db_ProfilerQuery
     */
    public function getQueryProfile($query_id)
    {
        if (!array_key_exists($query_id, $this->_query_profiles)) {
            /**
             *
             * @see RThink_Db_Exception
             */
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ("Query handle '$query_id' not found in profiler log.");
        }

        return $this->_query_profiles [$query_id];
    }

    /**
     * Get an array of query profiles (RThink_Db_ProfilerQuery objects). If
     * $query_type is set to one of the RThink_Db_Profiler::* constants then only
     * queries of that type will be returned. Normally, queries that have not
     * yet ended will not be returned unless $showUnfinished is set to True. If
     * no queries were found, False is returned. The returned array is indexed
     * by the query profile handles.
     *
     * @param integer $query_type
     * @param boolean $showUnfinished
     * @return array false
     */
    public function getQueryProfiles($query_type = null, $showUnfinished = false)
    {
        $queryProfiles = array();
        foreach ($this->_query_profiles as $key => $qp) {
            if ($query_type === null) {
                $condition = true;
            } else {
                $condition = ($qp->getQueryType() & $query_type);
            }

            if (($qp->hasEnded() || $showUnfinished) && $condition) {
                $queryProfiles [$key] = $qp;
            }
        }

        if (empty ($queryProfiles)) {
            $queryProfiles = false;
        }

        return $queryProfiles;
    }

    /**
     * Get the total elapsed time (in seconds) of all of the profiled queries.
     * Only queries that have ended will be counted. If $query_type is set to one
     * or more of the RThink_Db_Profiler::* constants, the elapsed time will be
     * calculated only for queries of the given type(s).
     *
     * @param integer $query_type OPTIONAL
     * @return float
     */
    public function getTotalElapsedSecs($query_type = null)
    {
        $elapsedSecs = 0;
        foreach ($this->_query_profiles as $key => $qp) {
            if (null === $query_type) {
                $condition = true;
            } else {
                $condition = ($qp->getQueryType() & $query_type);
            }
            if (($qp->hasEnded()) && $condition) {
                $elapsedSecs += $qp->getElapsedSecs();
            }
        }
        return $elapsedSecs;
    }

    /**
     * Get the total number of queries that have been profiled. Only queries
     * that have ended will be counted. If $query_type is set to one of the
     * RThink_Db_Profiler::* constants, only queries of that type will be counted.
     *
     * @param integer $query_type OPTIONAL
     * @return integer
     */
    public function getTotalNumQueries($query_type = null)
    {
        if (null === $query_type) {
            return count($this->_query_profiles);
        }

        $num_queries = 0;
        foreach ($this->_query_profiles as $qp) {
            if ($qp->hasEnded() && ($qp->getQueryType() & $query_type)) {
                $num_queries++;
            }
        }

        return $num_queries;
    }

    /**
     * Get the RThink_Db_ProfilerQuery object for the last query that was run,
     * regardless if it has ended or not. If the query has not ended, its end
     * time will be null. If no queries have been profiled, false is returned.
     *
     * @return RThink_Db_ProfilerQuery false
     */
    public function getLastQueryProfile()
    {
        if (empty ($this->_query_profiles)) {
            return false;
        }

        end($this->_query_profiles);

        return current($this->_query_profiles);
    }
}