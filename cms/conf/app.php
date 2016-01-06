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
    ),

    //数据库参数
    'db' => array(
        'default' => array(
            'host' => 'localhost',
            'dbname' => 'cms_admin',
            'username' => 'root',
            'password' => 'root',
        ),
        'db' => array(
            'host' => 'localhost',
            'dbname' => 'db',
            'username' => 'root',
            'password' => 'root',
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