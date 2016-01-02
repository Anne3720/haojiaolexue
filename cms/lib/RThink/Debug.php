<?php

/**
 * Class Debug
 */
class RThink_Debug
{
    protected static $_front_controller = null;

    /**
     * rthinkphp debug
     *
     * @param string $info debug信息
     */
    public static function rtDebug($info = '')
    {
        if (!RThink_Config::get('app.debug')) {
            return;
        }

        $backtrace = debug_backtrace();
        $backtrace = array_shift($backtrace);

        self::getFrontController()->getResponse()->prepend('rt_debug_footer', '-->' . PHP_EOL);
        self::getFrontController()->getResponse()->prepend('rt_debug_file', 'Debug文件: ' . $backtrace['file'] . PHP_EOL);
        self::getFrontController()->getResponse()->prepend('rt_debug_line', '文件行号: ' . $backtrace['line'] . PHP_EOL);
        self::getFrontController()->getResponse()->prepend('rt_debug_content', 'Debug输出: ' . var_export($info, true) . PHP_EOL);
        self::getFrontController()->getResponse()->prepend('rt_debug_header', '<!--' . PHP_EOL);
    }

    /**
     * firephp debug
     *
     * @param string $info debug信息
     */
    public static function fbDebug($info = '')
    {
        if (!RThink_Config::get('app.debug')) {
            return;
        }

        require_once 'Debug/Firephp/Fb.php';

        fb($info, FirePHP::TRACE);
    }

    /**
     * 请求debug查看sql信息和请求参数
     */
    public static function dbDebug()
    {
        if (!RThink_Config::get('app.debug')) {
            return;
        }

        $debug_info = array();

        $db_profilers = self::getFrontController()->getRequest()->getParam('db_profilers');

        $total_query = 0;
        $total_time = 0.0;

        $query_detail = array();

        is_array($db_profilers) || $db_profilers = array();

        foreach ($db_profilers as $db_profiler) {
            $query_profiles = $db_profiler->getQueryProfiles();

            foreach ($query_profiles as $query_profile) {
                $query_detail[$query_profile->getQueryType()][] = array(
                    'sql' => $query_profile->getQuery(),
                    'time' => $query_profile->getElapsedSecs(),
                );
            }

            $total_query += $db_profiler->getTotalNumQueries();
            $total_time += $db_profiler->getTotalElapsedSecs();
        }

        if (!empty($db_profilers)) {
            foreach ($query_detail as $detail_item) {
                foreach ($detail_item as $item_val) {
                    $debug_info[] = sprintf('执行时间: %f; SQL: %s' . PHP_EOL, $item_val['time'], $item_val['sql']);
                }
            }

            $debug_info[] = sprintf('SQL语句总数: %d 总花费时间: %f 秒' . PHP_EOL, $total_query, $total_time);
        }

        self::getFrontController()->getResponse()->prepend('db_debug_footer', PHP_EOL . '-->');

        foreach ($debug_info as $key => $debug_item) {
            self::getFrontController()->getResponse()->prepend('db_debug_body_' . $key, $debug_item);
        }

        self::getFrontController()->getResponse()->prepend('db_debug_header', '<!--' . PHP_EOL);
    }

    /**
     * 获取前端控制器
     *
     * @return RThink_Controller_Front
     */
    protected static function getFrontController()
    {
        // Used cache version if found
        if (null === self::$_front_controller) {
            class_exists('RThink_Controller_Front') || require 'RThink/Controller/Front.php';
            self::$_front_controller = RThink_Controller_Front::getInstance();
        }

        return self::$_front_controller;
    }
}