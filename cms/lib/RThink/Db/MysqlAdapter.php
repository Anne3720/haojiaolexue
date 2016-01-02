<?php
/**
 * @see RThink_Db_Adapter
 */
require 'RThink/Db/Adapter.php';

/**
 * mysql连接操作类
 */
class RThink_Db_MysqlAdapter extends RThink_Db_Adapter
{

    /**
     * PDO type.
     *
     * @var string
     */
    protected $_pdo_type = 'mysql';

    /**
     * 支持的详细的数字类型
     *
     * @var array
     */
    protected $_numeric_data_types = array(
        RThink_Db::TYPE_INT => RThink_Db::TYPE_INT,
        RThink_Db::TYPE_BIGINT => RThink_Db::TYPE_BIGINT,
        RThink_Db::TYPE_FLOAT => RThink_Db::TYPE_FLOAT,
        'INT' => RThink_Db::TYPE_INT,
        'INTEGER' => RThink_Db::TYPE_INT,
        'MEDIUMINT' => RThink_Db::TYPE_INT,
        'SMALLINT' => RThink_Db::TYPE_INT,
        'TINYINT' => RThink_Db::TYPE_INT,
        'BIGINT' => RThink_Db::TYPE_BIGINT,
        'SERIAL' => RThink_Db::TYPE_BIGINT,
        'DEC' => RThink_Db::TYPE_FLOAT,
        'DECIMAL' => RThink_Db::TYPE_FLOAT,
        'DOUBLE' => RThink_Db::TYPE_FLOAT,
        'DOUBLE PRECISION' => RThink_Db::TYPE_FLOAT,
        'FIXED' => RThink_Db::TYPE_FLOAT,
        'FLOAT' => RThink_Db::TYPE_FLOAT
    );

    /**
     * Creates a PDO object and connects to the dbname.
     *
     * @return void
     * @throws RThink_Db_Exception
     */
    protected function _connect()
    {
        if ($this->_connection) {
            return;
        }

        parent::_connect();

        // 设置存取字符集
        $this->exec('SET NAMES utf8');
    }

    /**
     * 获取用来 quote 标识符的字符
     *
     * @return string
     */
    public function getQuoteIdentifierSymbol()
    {
        return "`";
    }

    /**
     * 获取当前数据库的数据表列表
     *
     * @return array
     */
    public function listTables()
    {
        return $this->fetchCol('SHOW TABLES');
    }

    /**
     * 处理 limit offset 的 sql 语句
     *
     * @param string $sql 需要被加上 limit offset 处理的 sql 语句
     * @param integer $count 需要获取的记录数
     * @param integer $offset 记录起始偏移量, 从 0 开始.
     * @return string 用于处理此功能的 SQL
     */
    public function limit($sql, $count, $offset = 0)
    {
        $count = intval($count);
        if ($count <= 0) {
            /**
             * @see RThink_Db_Exception
             */

            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/Exception.php';
            throw new RThink_Db_Exception ("LIMIT argument count=$count is not valid");
        }

        $offset = intval($offset);
        if ($offset < 0) {
            /**
             * @see RThink_Db_Exception
             */
            class_exists('RThink_Db_Exception', false) || require 'RThink/Db/RThink_Db_Exception';
            throw new RThink_Db_Exception ("LIMIT argument offset=$offset is not valid");
        }

        $sql .= " LIMIT $count";
        if ($offset > 0) {
            $sql .= " OFFSET $offset";
        }

        return $sql;
    }
}