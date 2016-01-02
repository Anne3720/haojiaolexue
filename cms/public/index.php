<?php
/**
 * app 入口文件
 */
header("Content-Type:text/html;Charset=utf-8");
//app路径
define('APP_PATH', realpath(dirname(__FILE__) . '/../'));
//库文件路径
ini_set('include_path', APP_PATH . '/lib');
include 'RThink/Controller/Front.php';


/*  {xhproc 测速 */
// include APP_PATH . '/public/xhprof/xhprof_lib/utils/xhprof_lib.php';
// include APP_PATH . '/public/xhprof/xhprof_lib/utils/xhprof_runs.php';

// xhprof_enable(XHPROF_FLAGS_MEMORY);

/* xhproc} */
$controller_front = RThink_Controller_Front::getInstance();
$controller_front->throwExceptions(false);

$controller_front->setParams(array(
        'config_file' => APP_PATH . '/conf/app.php',
        'config_section' => 'development',
//        'plugins' => array('Test'),
    )
);

$controller_front->dispatch();

/* {xhproc */
// $xhprof_data = xhprof_disable();
// $xhprof_runs = new XHProfRuns_Default();
// $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");
// echo "性能报告地址===="."<a href=/xhprof/xhprof_html/index.php?run=$run_id&source=xhprof_foo>点击查看报告</a>";

/* xhproc} */