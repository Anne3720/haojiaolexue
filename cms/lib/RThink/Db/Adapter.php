<?php
require 'RThink/Db/Profiler.php';
require 'RThink/Db/Statement.php';


/**
 * 基于PDO的数据库连接和基本操作类
 */
abstract class RThink_Db_Adapter
{


    /**
     * 适配器配置信息
     *
     * @var array
     */
    protected $_config = array();

    /**
     * 适配器类型，默认为mysql
     *
     * @var string
     */
    protected $_pdo_type = 'mysql';

    /**
     * 默认获取模式
     *
     * @var integer
     */
    protected $_fetch_mode = PDO::FETCH_ASSOC;

    /**
     * 查询分析器
     *
     * @var RThink_Db_Profiler
     */
    protected $_profiler;

    /**
     * 默认 DB statement类名
     *
     * @var string
     */
    protected $_default_stmt_class = 'RThink_Db_Statement';

    /**
     * 数据库连接句柄
     *
     * @var object resource null
     */
    protected $_connection = null;

    /**
     * 支持的详细的数字类型 对应值 0 = 32-bit integer 1 = 64-bit integer 2 = float or decimal
     *
     * @var array
     */
    protected $_numeric_data_types = array(
        RThink_Db::TYPE_INT => RThink_Db::TYPE_INT,
        RThink_Db::TYPE_BIGINT => RThink_Db::TYPE_BIGINT,
        RThink_Db::TYPE_FLOAT => RThink_Db::TYPE_FLOAT
    );

    /**
     * 构造方法
     * $config类型关联数组，包含以下操作项
     * dbname => (string) 数据库名 username => (string) 数据库用户名 password => (string)
     * 数据库密码 host => (string) 数据库服务器默认为localhost
     * 可选项
     * port => (string) 数据库端口
     *
     * @param array
     * @throws RThink_Db_Exception
     * @return void
     */
    public function __construct(array $option)
    {
        $this->_config = $option;
        $this->_config += array(
            'driver_options' => array()
        );
        $this->_checkRequiredOptions();

        // 设置db分析器
        $this->_profiler = new RThink_Db_Profiler ();
    }

    /**
     * 检查必须参数， 不存在则抛出异常
     *
     * @throws RThink_Db_Exception
     */
    protected function _checkRequiredOptions()
    {
        if (!array_key_exists('dbname', $this->_config)) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ("RThink_Configuration array must have a key for 'dbname' that names the dbname instance");
        }

        if (!array_key_exists('password', $this->_config)) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ("RThink_Configuration array must have a key for 'password' for login credentials");
        }

        if (!array_key_exists('username', $this->_config)) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ("RThink_Configuration array must have a key for 'username' for login credentials");
        }

        if (array_key_exists('driver_options', $this->_config) && !is_array($this->_config ['driver_options'])) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ('driver_options must is a array');
        }
    }

    /**
     * 创建PDO DSN
     *
     * @return string
     */
    protected function _dsn()
    {
        $dsn = $this->_config;

        // 去掉dsn用不到的参数
        unset ($dsn ['username']);
        unset ($dsn ['password']);
        unset ($dsn ['driver_options']);

        foreach ($dsn as $key => $val) {
            $dsn [$key] = "$key=$val";
        }

        return sprintf('%s:%s', $this->_pdo_type, implode(';', $dsn));
    }

    /**
     * 创建pdo对象并连接数据库
     *
     * @return void
     * @throws RThink_Db_Exception
     */
    protected function _connect()
    {
        if (null !== $this->_connection) {
            return;
        }

        // 重新获取一下dsn，避免由于其它适配器修改了$_pdo_type而出错
        $dsn = $this->_dsn();

        try {
            $this->_connection = new PDO ($dsn, $this->_config ['username'], $this->_config ['password'], $this->_config ['driver_options']);

            // 结果集中的列名字的大小写设置: 根据驱动自动设置
            $this->_connection->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
            // 错误返回方式: 抛异常方式
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 强制关闭连接
     *
     * @return void
     */
    public function closeConnection()
    {
        $this->_connection = null;
    }


    /**
     * 返回当前适配器的分析器
     *
     * @return RThink_Db_Profiler
     */
    public function getProfiler()
    {
        return $this->_profiler;
    }


    /**
     * 开始进行一个预处理语句
     *
     * @param string $sql 带占位符的sql语句
     * @return PDOStatement
     */
    public function prepare($sql)
    {
        $this->_connect();
        $stmt_class = $this->_default_stmt_class;
        $stmt = new $stmt_class ($this, $sql);
        $stmt->setFetchMode($this->_fetch_mode);
        return $stmt;
    }

    /**
     * 对sql语句进行预处理，并用绑定的数据进行查询
     *
     * @param mixed $sql 可以是一条包含站位符的sql语句
     * @param mixed $bind 绑定到sql中的数据
     * @return RThink_Db_Statement
     */
    public function query($sql, $bind = array())
    {
        // 预处理并带分析器的statement
        $stmt = $this->prepare($sql);
        $stmt->execute($bind);

        $stmt->setFetchMode($this->_fetch_mode);

        return $stmt;
    }

    /**
     * 执行SQL statement并返回影响的行数
     *
     * @param mixed $sql 包含占位符的SQL statement
     * @return integer 修改或是删除操作影响的行数
     */
    public function exec($sql)
    {
        try {
            $affected = $this->getConnection()->exec($sql);

            if ($affected === false) {
                $error_info = $this->getConnection()->errorInfo();
                class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
                throw new RThink_Db_Exception ($error_info [2]);
            }

            return $affected;
        } catch (PDOException $e) {
            class_exists('RThink_Db_Exception') || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 插入一条数据
     *
     * @param string $table 操作表
     * @param array $bind 插入的数据(字段值对)
     * @return int 影响的行数
     * @throws RThink_Db_Exception
     */
    public function insert($table, $bind = array())
    {
        // 从数组键抽取和quote字段名
        $cols = array();
        $vals = array();

        foreach ($bind as $col => $val) {
            $cols [] = $this->quoteIdentifier($col);
            $vals [] = '?';
        }

        // build the statement
        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->quoteIdentifier($table), implode(', ', $cols), implode(', ', $vals));

        return $this->query($sql, array_values($bind))->rowCount();
    }

    /**
     * 修改表数据
     *
     * @param string $table 操作表
     * @param array $bind 修改的数据(字段值对)
     * @param mixed $where 条件
     * @throws RThink_Db_Exception
     */
    public function update($table, array $bind, $where = '')
    {
        /**
         * Build "col = ?" pairs for the statement
         */
        $set = array();

        foreach ($bind as $col => $val) {
            $val = '?';
            $set [] = $this->quoteIdentifier($col) . ' = ' . $val;
        }

        if (empty ($where)) {
            $where = '';
        } else {
            $where = 'WHERE ' . $this->_whereExpr($where);
        }

        $sql = sprintf('UPDATE %s SET %s %s', $this->quoteIdentifier($table, true), implode(', ', $set), $where);

        return $this->query($sql, array_values($bind))->rowCount();
    }

    /**
     * 删除表数据
     *
     * @param string $table 操作表
     * @param mixed $where where条件
     * @return int 影响的行数
     */
    public function delete($table, $where = '')
    {
        if (empty ($where)) {
            $where = '';
        } else {
            $where = 'WHERE ' . $this->_whereExpr($where);
        }

        $sql = sprintf(' DELETE FROM %s %s', $this->quoteIdentifier($table, true), $where);

        return $this->query($sql)->rowCount();
    }

    /**
     * 将数组,字符串或者DbExpr对象转换为存放where条件的字符串
     *
     * @param mixed $where
     * @return string
     */
    protected function _whereExpr($where)
    {
        if (empty ($where)) {
            return $where;
        }

        is_array($where) || $where = array(
            $where
        );

        foreach ($where as $cond => &$term) {
            // $cond 是包含占位符的条件，$term 是引用的条件
            $term = $this->quoteInto($cond, $term);
            $term = '(' . $term . ')';
        }

        return implode(' AND ', $where);
    }

    /**
     * 获取数据操作 *
     */

    /**
     * 获取结果集中所有记录
     *
     * @param string|DbSelect $sql 查询语句
     * @param mixed $bind 绑定到带站位符sql中的数据
     * @param mixed $fetch_mode 获取模式,不传则使用当前获取模式
     * @return array
     */
    public function fetchAll($sql, $bind = array(), $fetch_mode = null)
    {
        if ($fetch_mode === null) {
            $fetch_mode = $this->_fetch_mode;
        }
        return $this->query($sql, $bind)->fetchAll($fetch_mode);
    }

    /**
     * 获取结果集中第一条记录
     *
     * @param string|DbSelect $sql 查询语句
     * @param mixed $bind 绑定到带站位符sql中的数据
     * @param mixed $fetch_mode 获取模式,不传则使用当前获取模式
     * @return array
     */
    public function fetchRow($sql, $bind = array(), $fetch_mode = null)
    {
        if ($fetch_mode === null) {
            $fetch_mode = $this->_fetch_mode;
        }
        return $this->query($sql, $bind)->fetch($fetch_mode);
    }

    /**
     * 获取结果集中所有记录并以关联数组的形式返回
     * 此结果集数组以每条记录的第一列的值为 key, 以每一条记录为 value 的索引数组. 如果两条记录的第一列的值相同,
     * 那么后面那条记录会覆盖前面的记录.
     *
     * @param string|DbSelect $sql 查询语句
     * @param mixed $bind 绑定到带站位符sql中的数据
     * @return array
     */
    public function fetchAssoc($sql, $bind = array())
    {
        $stmt = $this->query($sql, $bind);
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data [reset($row)] = $row;
        }
        return $data;
    }

    /**
     * 获取结果集中所有记录以键值对形式返回 第一列字段做为数组的键第二列为数组的值
     * e.g <code> // fetch_all(PDO::FETCH_NUM) 的结果集为如下: array( array('1001',
     * 'php''), array('1002', 'js'), )
     * return array( '1001' => 'php', '1002' => 'js', ) </code>
     *
     * @param string|em_db_select $sql sql 查询语句
     * @param mixed 需要绑定的数据数组
     * @return array 结果数组
     */
    public function fetchPairs($sql, $bind = array())
    {
        $stmt = $this->query($sql, $bind);
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $data [$row [0]] = $row [1];
        }
        return $data;
    }

    /**
     * 获取结果集中所有记录的第一列以索引数组的形式返回
     *
     * @param string|DbSelect $sql 查询语句
     * @param mixed $bind 绑定到带站位符sql中的数据
     * @return array
     */
    public function fetchCol($sql, $bind = array())
    {
        return $this->query($sql, $bind)->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    /**
     * 获取结果集中第一行记录的第一列
     *
     * @param string|DbSelect $sql 查询语句
     * @param mixed $bind 绑定到带站位符sql中的数据
     * @return string
     */
    public function fetchOne($sql, $bind = array())
    {
        return $this->query($sql, $bind)->fetchColumn(0);
    }

    /**
     * 获取最后一个由 IDENTITY/AUTOINCREMENT 列自动生成的 ID.
     * 在支持 sequences 的数据库中, (例如 Oracle, PostgreSQL, DB2), 此方法将返回 $table_name
     * 参数指定 的 sequence 的最后一次生成的 ID.
     * 在支持 IDENTITY/AUTOINCREMENT 列的数据库中, 此方法将返回由 $primary_key 参数指定的列的最后一次 生成的
     * ID.
     * 在不支持 sequences 的数据库中, $table_name 和 $primary_key 两个参数将被忽略.
     *
     * @param string $table_name sequence 的名字
     * @param string $primary_key IDENTITY/AUTOINCREMENT 列的名字
     * @return string 最后一个生成的 ID
     */
    public function lastInsertId($tableName = null, $primaryKey = null)
    {
        $this->_connect();
        return $this->_connection->lastInsertId();
    }

    /**
     * 获取数据操作 END *
     */


    /**
     * 获取fetch模式
     *
     * @return int
     */
    public function getFetchMode()
    {
        return $this->_fetch_mode;
    }

    /**
     * 设置PDO的获取 mode.
     *
     * @param int $mode PDO的获取模式
     * @return void
     * @throws RThink_Db_Exception
     */
    public function setFetchMode($mode)
    {
        switch ($mode) {
            case PDO::FETCH_LAZY :
            case PDO::FETCH_ASSOC :
            case PDO::FETCH_NUM :
            case PDO::FETCH_BOTH :
            case PDO::FETCH_NAMED :
            case PDO::FETCH_OBJ :
                $this->_fetch_mode = $mode;
                break;
            default :
                class_exists('RThink_Db_Exception') || require 'RThink/Db/Exception.php';
                throw new RThink_Db_Exception ("Invalid fetch mode '$mode' specified");
                break;
        }
    }

    /**
     * 获取数据库链接，如果链接不存在则实例化链接
     *
     * @return object resource null
     */
    public function getConnection()
    {
        $this->_connect();
        return $this->_connection;
    }

    /**
     * 获取当前适配器的配置参数
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->_config;
    }


    /**
     * 获取默认的statement类
     *
     * @return string
     */
    public function getStatementClass()
    {
        return $this->_default_stmt_class;
    }

    /**
     * quote 字符串安全处理 *
     */

    /**
     * 安全的quote一个数据
     * 如果传递数组，数组元素会被quote，并返回一个逗号分割的字符串
     *
     * @param mixed $value 被quote的值
     * @param mixed $type 数据类型
     * @return mixed quote后的值
     */
    public function quote($value, $type = null)
    {
        if (is_array($value)) {
            foreach ($value as &$val) {
                $val = $this->quote($val, $type);
            }
            return implode(', ', $value);
        }

        if ($type !== null && isset ($this->_numeric_data_types [$type])) {
            $quoted_value = '0';
            switch ($this->_numeric_data_types [$type]) {
                case RThink_Db::TYPE_INT : // 32-bit 整数
                    $quoted_value = ( string )intval($value);
                    break;
                case RThink_Db::TYPE_BIGINT : // 64-bit整数
                    if (preg_match('!^([+-]?(?:0[Xx][\da-fA-F]+|\d+(?:[eE][+-]?\d+)?))!x', ( string )$value, $matches)) {
                        $quoted_value = $matches [1];
                    }
                    break;
                case RThink_Db::TYPE_FLOAT : // 浮点数
                    $quoted_value = sprintf('%F', $value);
            }
            return $quoted_value;
        }

        return $this->_quote($value);
    }

    /**
     * 将带占位符的字符串和对应的值进行拼装
     * e.g <code>
     *  $text = "WHERE date < ?";
     *  $date ="2005-01-02";
     *  $safe = $sql->quoteInto($text, $date);
     *  $safe == "WHERE date < '2005-01-02'"
     *  </code>
     *
     * @param string $text 带占位符的字符串
     * @param mixed $value 要引用的值
     * @param string $type OPTIONAL SQL datatype
     * @param integer $count OPTIONAL count of placeholders to replace
     * @return string An SQL-safe quoted value placed into the original text.
     */
    public function quoteInto($text, $value, $type = null, $count = null)
    {
        if ($count === null) {
            return str_replace('?', $this->quote($value, $type), $text);
        } else {
            while ($count > 0) {
                if (strpos($text, '?') !== false) {
                    $text = substr_replace($text, $this->quote($value, $type), strpos($text, '?'), 1);
                }
                --$count;
            }
            return $text;
        }
    }

    /**
     * 引用一个标识符
     * e.g:
     *  <code>
     *  $adapter->quoteIdentifier('myschema.mytable')
     * 返回:      `myschema .`mytable`
     * $adapter->quoteIdentifier(array('myschema','my.table'))
     * 返回:
     * `myschema`.`my.table`
     * </code>
     * 取用字符依赖于具体的数据库
     *
     * @param string|array $ident 需要引用的字符
     * @return string 引用后的字符
     */
    public function quoteIdentifier($ident)
    {
        return $this->_quoteIdentifierAs($ident);
    }

    /**
     * Quote a column identifier and alias.
     *
     * @param string|array|DbExpr $ident The identifier or expression.
     * @param string $alias An alias for the column.
     * @param boolean $auto If true, heed the AUTO_QUOTE_IDENTIFIERS config
     *            option.
     * @return string The quoted identifier and alias.
     */
    public function quoteColumnAs($ident, $alias, $auto = false)
    {
        return $this->_quoteIdentifierAs($ident, $alias, $auto);
    }

    /**
     * Quote a table identifier and alias.
     *
     * @param string|array|DbExpr $ident The identifier or expression.
     * @param string $alias An alias for the table.
     * @param boolean $auto If true, heed the AUTO_QUOTE_IDENTIFIERS config
     *            option.
     * @return string The quoted identifier and alias.
     */
    public function quoteTableAs($ident, $alias = null, $auto = false)
    {
        return $this->_quoteIdentifierAs($ident, $alias, $auto);
    }

    /**
     * quote 一个标识符并根据需要添加别名, 例如表名,字段名等
     *
     * @param string|array|DbExpr $ident 需要quote的字符
     * @param string $alias 需要添加的别名
     * @param string $as 添加在标识符和别名之间的操作符. 默认是 " AS "
     * @return string 引用后的字符
     */
    protected function _quoteIdentifierAs($ident, $alias = null, $as = ' AS ')
    {
        if (is_string($ident)) {
            $ident = explode('.', $ident);
        }

        if (is_array($ident)) {
            $segments = array();

            foreach ($ident as $segment) {
                $segments [] = $this->_quoteIdentifier($segment);
            } // end foreach

            if ($alias !== null && end($ident) == $alias) {
                $alias = null;
            }

            $quoted = implode('.', $segments);
        } else { // if is_array($ident)
            $quoted = $this->_quoteIdentifier($ident);
        }

        if ($alias !== null) {
            $quoted .= $as . $this->_quoteIdentifier($alias);
        }
        return $quoted;
    }

    /**
     * 引用一个标识符
     *
     * @param string $value 要引用的标识符
     * @return string
     */
    protected function _quoteIdentifier($value)
    {
        $q = $this->getQuoteIdentifierSymbol();
        return ($q . str_replace("$q", "$q$q", $value) . $q);
    }

    /**
     * 获取用来 quote 标识符的字符 一般都是 ("), 但是 MySQL 是 (`)
     *
     * @return string
     */
    public function getQuoteIdentifierSymbol()
    {
        return '"';
    }

    /**
     * Quote原始字符串
     *
     * @param string $value 未处理的字符串
     * @return string 经Quote后的字符串
     */
    protected function _quote($value)
    {
        if (is_int($value) || is_float($value)) {
            return $value;
        }
        $this->_connect();
        return $this->_connection->quote($value);
    }

    /**
     * quote操作 END *
     */

    /**
     * 事务操作 *
     */

    /**
     * Leave autocommit mode and begin a transaction.
     *
     * @return RThink_Db_Adapter
     */
    public function beginTransaction()
    {
        $this->_connect();
        $q = $this->_profiler->queryStart('begin', RThink_Db_Profiler::TRANSACTION);
        $this->_beginTransaction();
        $this->_profiler->queryEnd($q);
        return $this;
    }

    /**
     * Commit a transaction and return to autocommit mode.
     *
     * @return RThink_Db_Adapter
     */
    public function commit()
    {
        $this->_connect();
        $q = $this->_profiler->queryStart('commit', RThink_Db_Profiler::TRANSACTION);
        $this->_commit();
        $this->_profiler->queryEnd($q);
        return $this;
    }

    /**
     * Roll back a transaction and return to autocommit mode.
     *
     * @return RThink_Db_Adapter
     */
    public function rollBack()
    {
        $this->_connect();
        $q = $this->_profiler->queryStart('rollback', RThink_Db_Profiler::TRANSACTION);
        $this->_rollBack();
        $this->_profiler->queryEnd($q);
        return $this;
    }

    /**
     * 开始事务
     */
    protected function _beginTransaction()
    {
        $this->_connect();
        $this->_connection->beginTransaction();
    }

    /**
     * 提交事务
     */
    protected function _commit()
    {
        $this->_connect();
        $this->_connection->commit();
    }

    /**
     * 回滚事务
     */
    protected function _rollBack()
    {
        $this->_connect();
        $this->_connection->rollBack();
    }

    /**
     * 事务操作 END *
     */

    /**
     * 检查pdo驱动是否存在
     *
     * @throws RThink_Db_Exception
     * @return boolean
     */
    public function isPdoDriverExisted()
    {
        if (!extension_loaded('pdo')) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ('The PDO extension is required for this adapter but the extension is not loaded');
        }

        if (!in_array($this->_pdo_type, PDO::getAvailableDrivers())) {
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ('The ' . $this->_pdo_type . ' driver is not currently installed');
        }

        return true;
    }

    /**
     * 抽象方法
     */
    abstract public function limit($sql, $count, $offset = 0);
}
