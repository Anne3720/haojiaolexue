<?php

/**
 * 对PDOStatment的封装
 */
class RThink_Db_Statement
{
    /**
     *
     * @var RThink_Db_Adapter对象
     */
    protected $_adapter = null;

    /**
     *
     * @var PDOStmt对象
     */
    protected $_stmt = null;

    /**
     * 获取模式
     *
     * @var int
     */
    protected $_fetch_mode = PDO::FETCH_ASSOC;

    /**
     * 查询中绑定的参数,赋值于bindParam() and bindValue()
     *
     * @var array
     */
    protected $_bind_param = array();

    /**
     *
     * @var RThink_Db_Profiler查询分析器
     */
    protected $_query_id = null;

    /**
     * Constructor for a statement.
     *
     * @param RThink_Db_Adapter $adapter
     * @param mixed $sql sql语句
     */
    public function __construct($adapter, $sql)
    {
        $this->_adapter = $adapter;
        $this->_prepare($sql);

        $this->_query_id = $this->_adapter->getProfiler()->queryStart($sql);
    }

    /**
     * 预处理sql语句并创建一个statment
     *
     * @param string $sql
     * @return void
     * @throws RThink_Db_Exception
     */
    protected function _prepare($sql)
    {
        try {
            $this->_stmt = $this->_adapter->getConnection()->prepare($sql);
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 给结果集中的一列绑定一个PHP变量
     *
     * @param string $column 列名或者列的序号
     * @param mixed $param php变量的引用
     * @param mixed $type 参数类型
     * @return bool
     * @throws RThink_Db_Exception
     */
    public function bindColumn($column, &$param, $type = null)
    {
        try {
            if ($type === null) {
                return $this->_stmt->bindColumn($column, $param);
            } else {
                return $this->_stmt->bindColumn($column, $param, $type);
            }
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 给指定的参数绑定PHP变量
     *
     * @param mixed $parameter 参数的名字或者序号
     * @param mixed $variable [引用并改变] 参数的值
     * @param mixed $type 参数的类型
     * @param mixed $length 参数值的长度
     * @param mixed $options 配置选项
     * @return boolean 绑定成功返回 true | 绑定失败返回 false
     * @return bool
     * @throws RThink_Db_Exception
     */
    public function bindParam($parameter, &$variable, $type = null, $length = null, $options = null)
    {
        // 存储绑定的数据
        $this->_bind_param [$parameter] = & $variable;

        try {
            if ($type === null) {
                if (is_bool($variable)) {
                    $type = PDO::PARAM_BOOL;
                } else if ($variable === null) {
                    $type = PDO::PARAM_NULL;
                } else if (is_integer($variable)) {
                    $type = PDO::PARAM_INT;
                } else {
                    $type = PDO::PARAM_STR;
                }
            }
            return $this->_stmt->bindParam($parameter, $variable, $type, $length, $options);
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 给指定的参数绑定一个值
     *
     * @param string|integer $parameter 需要被绑定的参数名或者序号
     * @param mixed $value 参数的值
     * @param mixed $type 数据类型
     * @return boolean 绑定成功返回 true | 绑定失败返回 false
     * @return bool
     * @throws RThink_Db_Exception
     */
    public function bindValue($parameter, $value, $type = null)
    {
        // 存储绑定的数据
        $this->_bind_param [$parameter] = $value;

        try {
            if ($type === null) {
                return $this->_stmt->bindValue($parameter, $value);
            } else {
                return $this->_stmt->bindValue($parameter, $value, $type);
            }
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 返回当前结果集的列数
     *
     * @return int The number of columns.
     * @throws RThink_Db_Exception
     */
    public function columnCount()
    {
        try {
            return $this->_stmt->columnCount();
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 返回当前的错误代码
     *
     * @return string error code.
     * @throws RThink_Db_Exception
     */
    public function errorCode()
    {
        try {
            return $this->_stmt->errorCode();
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 返回当前的错误信息
     *
     * @return array
     * @throws RThink_Db_Exception
     */
    public function errorInfo()
    {
        try {
            return $this->_stmt->errorInfo();
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 执行一个预处理
     *
     * @param array $params 绑定到预处理参数的值
     * @return bool
     */
    public function execute(array $params = null)
    {
        /*
         * 查询分析器为空则直接执行并返回
         */
        if ($this->_query_id === null) {
            return $this->_execute($params);
        }

        $prof = $this->_adapter->getProfiler();
        $qp = $prof->getQueryProfile($this->_query_id);

        // 如果 query profile 已结束, 说明重复执行了此方法, 则 clone 一个 query profile.
        if ($qp->hasEnded()) {
            $this->_query_id = $prof->queryClone($qp);
            $qp = $prof->getQueryProfile($this->_query_id);
        }

        // 设置 query profile 的绑定参数
        if ($params !== null) {
            $qp->bindParams($params);
        } else {
            $qp->bindParams($this->_bind_param);
        }
        $qp->start($this->_query_id);

        $retval = $this->_execute($params);

        $prof->queryEnd($this->_query_id);

        return $retval;
    }

    /**
     * 执行一个预处理
     *
     * @param array $params 绑定到预处理参数的值
     * @return bool
     * @throws RThink_Db_Exception
     */
    protected function _execute(array $params = null)
    {
        try {
            if ($params !== null) {
                return $this->_stmt->execute($params);
            } else {
                return $this->_stmt->execute();
            }
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), ( int )$e->getCode(), $e);
        }
    }

    /**
     * 从结果集中获取一条记录
     *
     * @param integer $style 获取方式
     * @param integer $cursor_orientation 游标定位方向
     * @param integer $cursor_offset 游标偏移量
     * @return mixed 结果集, 根据获取的方式不同而类型不同.
     * @throws RThink_Db_Exception
     */
    public function fetch($style = null, $cursor = null, $offset = null)
    {
        if ($style === null) {
            $style = $this->_fetch_mode;
        }
        try {
            return $this->_stmt->fetch($style, $cursor, $offset);
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 获取结果集中的所有记录
     *
     * @param integer $style 获取方式
     * @param integer $col 如果获取方式设置为 PDO::FETCH_COLUMN, 则通过此参数设置获取第几列, 偏移从 0 开始.
     * @return mixed 结果集, 根据获取的方式不同而类型不同.
     * @throws RThink_Db_Exception
     */
    public function fetchAll($style = null, $col = null)
    {
        if ($style === null) {
            $style = $this->_fetch_mode;
        }
        try {
            if ($style == PDO::FETCH_COLUMN) {
                if ($col === null) {
                    $col = 0;
                }
                return $this->_stmt->fetchAll($style, $col);
            } else {
                return $this->_stmt->fetchAll($style);
            }
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 获取结果集中下一条记录的一列
     *
     * @param int $col 获取具体列的位置
     * @return string
     * @throws RThink_Db_Exception
     */
    public function fetchColumn($col = 0)
    {
        try {
            return $this->_stmt->fetchColumn($col);
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 获取结果集中的下一条记录并对象的形式返回
     *
     * @param string $class 返回的类的名字, 默认是 'stdClass'
     * @param array $config 传递给返回的对象的构造函数的参数
     * @return object boolean | 获取失败返回 false
     * @throws RThink_Db_Exception
     */
    public function fetchObject($class = 'stdClass', array $config = array())
    {
        try {
            return $this->_stmt->fetchObject($class, $config);
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 获取PDOStatement对象指定属性的值
     *
     * @param integer $key 属性的名字
     * @return mixed
     * @throws RThink_Db_Exception
     */
    public function getAttribute($key)
    {
        try {
            return $this->_stmt->getAttribute($key);
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 设置PDOStatement对象指定属性的值
     *
     * @param string $key Attribute name.
     * @param mixed $val Attribute value.
     * @return bool
     * @throws RThink_Db_Exception
     */
    public function setAttribute($key, $val)
    {
        try {
            return $this->_stmt->setAttribute($key, $val);
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 设置PDOStatement获取模式
     *
     * @param int $mode
     * @return bool
     * @throws RThink_Db_Exception
     */
    public function setFetchMode($mode)
    {
        $this->_fetch_mode = $mode;
        try {
            return $this->_stmt->setFetchMode($mode);
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 获取在执行 INSERT, DELETE 或 UPDATE 查询之后的影响行
     *
     * @return int 影响的行数
     * @throws RThink_Db_Exception
     */
    public function rowCount()
    {
        try {
            return $this->_stmt->rowCount();
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }
}