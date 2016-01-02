<?php

class RThink_Db_ProfilerQuery
{

    /**
     * 存储查询的 SQL 语句字符串
     *
     * @var string
     */
    protected $_query = '';

    /**
     * 记录此查询的类型
     *
     * @var integer
     */
    protected $_query_type = 0;

    /**
     * 记录查询的起始时间. 此时间是使用 microtime(true) 获取到的精确时间.
     *
     * @var float
     */
    protected $_started_microtime = null;

    /**
     * 记录查询的结束时间.
     * 此时间是使用 microtime(true) 获取到的精确时间.
     *
     * @var integer
     */
    protected $_ended_microtime = null;

    /**
     *记录查询中被绑定的数据
     *
     * @var array
     */
    protected $_bound_params = array();

    /**
     * 构造方法
     *
     * @param string $query_sql 查询 SQL 语句字符串
     * @param integer $query_type 查询类型
     *
     * @return void
     */
    public function __construct($query, $queryType)
    {
        $this->_query = $query;
        $this->_query_type = $queryType;
        // by default, and for backward-compatibility, start the click ticking
        $this->start();
    }

    /**
     * Clone handler for the query object.
     *
     * @return void
     */
    public function __clone()
    {
        $this->_bound_params = array();
        $this->_ended_microtime = null;
        $this->start();
    }

    /**
     * Starts the elapsed time click ticking. This can be called subsequent to
     * object creation, to restart the clock. For instance, this is useful right
     * before executing a prepared query.
     *
     * @return void
     */
    public function start()
    {
        $this->_started_microtime = microtime(true);
    }

    /**
     * Ends the query and records the time so that the elapsed time can be
     * determined later.
     *
     * @return void
     */
    public function end()
    {
        $this->_ended_microtime = microtime(true);
    }

    /**
     * Returns true if and only if the query has ended.
     *
     * @return boolean
     */
    public function hasEnded()
    {
        return $this->_ended_microtime !== null;
    }

    /**
     * Get the original SQL text of the query.
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->_query;
    }

    /**
     * Get the type of this query (one of the RThink_Db_Profiler::* constants)
     *
     * @return integer
     */
    public function getQueryType()
    {
        return $this->_query_type;
    }

    /**
     *
     * @param string $param
     * @param mixed $variable
     * @return void
     */
    public function bindParam($param, $variable)
    {
        $this->_bound_params [$param] = $variable;
    }

    /**
     *
     * @param array $param
     * @return void
     */
    public function bindParams(array $params)
    {
        if (array_key_exists(0, $params)) {
            array_unshift($params, null);
            unset ($params [0]);
        }
        foreach ($params as $param => $value) {
            $this->bindParam($param, $value);
        }
    }

    /**
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->_bound_params;
    }

    /**
     * Get the elapsed time (in seconds) that the query ran. If the query has
     * not yet ended, false is returned.
     *
     * @return float false
     */
    public function getElapsedSecs()
    {
        if (null === $this->_ended_microtime) {
            return false;
        }

        return $this->_ended_microtime - $this->_started_microtime;
    }

    /**
     * Get the time (in seconds) when the profiler started running.
     *
     * @return bool float
     */
    public function getStartedMicrotime()
    {
        if (null === $this->_started_microtime) {
            return false;
        }

        return $this->_started_microtime;
    }
}

