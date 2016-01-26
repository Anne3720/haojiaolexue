<?php

/* 开发环境配置  - [development] */
$development = array(

    /* app 配置项  */
    'app' => array(
        #debug参数, false - 关闭、 true - 打开;可以控制RThink_Debug::rtDebug(), fbDebug(), dbDebug
        'debug' => true,
        'name' => 'RThink CMS',
        #是否在error页面展示异常;只有在debug=true时,对当前选项的配置才会生效
        'display_exceptions' => true,
        'grade' =>array(
            '1'=>'一年级',
            '2'=>'二年级',
            '3'=>'三年级',
            '4'=>'四年级',
            '5'=>'五年级',
            '6'=>'六年级',
            '7'=>'初一',
            '8'=>'初二',
            '9'=>'初三',
            '10'=>'高一',
            '11'=>'高二',
            '12'=>'高三',
        ),
        'imagePath'=>dirname(dirname(dirname(__FILE__))).'\resource\image',
        'videoPath'=>dirname(dirname(dirname(__FILE__))).'\resource\video',
    ),

    //数据库参数
    'db' => array(
        'default' => array(
            'host' => 'localhost',
            'dbname' => 'cms_admin',
            'username' => 'root',
            'password' => '',
        ),
        'db' => array(
            'host' => 'localhost',
            'dbname' => 'db',
            'username' => 'root',
            'password' => '',
        ),
        'test' => array(
            'host' => 'localhost',
            'dbname' => 'test',
            'username' => 'root',
            'password' => '',
        ),
    ),

//    ;多台memcahe机器的配置方式
    'memcache' => array(
        'servers' => array(
            array(
                'host' => '10.52.176.31',
                'port' => 8211,
            ),
            array(
                'host' => '10.58.128.39',
                'port' => 8211,
            ),
        ),
    ),

    //;单台memcahe机器的配置方式
//;memcache.servers.host=10.52.176.31
//;memcache.servers.port=8211

);


/* 开发环境配置  - [development], production 继承 development节点 */
$production = array(
        'app' => array(
            #debug参数, false - 关闭、 true - 打开;可以控制RThink_Debug::rtDebug(), fbDebug(), dbDebug
            'debug' => false,
            #是否在error页面展示异常;只有在debug=true时,对当前选项的配置才会生效
            'display_exceptions' => false,
        ),

) + $development;