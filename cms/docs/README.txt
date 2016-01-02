README
======

[vhost]
=====================

<VirtualHost *:80>
   DocumentRoot "/var/www/htdocs/RThink/public"
   ServerName rthink.local

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development

   <Directory "/var/www/htdocs/RThink/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>

</VirtualHost>


[Debug]

关于Debug说明

目前支持3个Debug方法

先打开配置文件 debug=on

rtDebug() - 用于页面调试，输出内容会追加到页面源代码中，不在页面显示
调用方法 - RThink_Debug::rtDebug(调试输出内容);

dbDebug() - 用于查看本次请求执行的sql语句 ，输出内容会追加到页面源代码中，不在页面显示
调用方法 http://url?db_debug=1

fbDebug() - 用于页面调试, 输出内容在firbug控制台显示，需要使用firefox浏览器。并安装 Firebug 、Firephp 两个扩展
调用方法 - RThink_Debug::fbDebug(调试输出内容);


[app.ini]
config_parser - 配置文件解析器类型
config_file - 配置文件路径
config_section - 配置文件节点如[development], [production]



具体使用代码参见
UserGuideController.php

