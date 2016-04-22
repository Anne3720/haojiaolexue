<?php
//以下设置Email参数
$config['email']['protocol'] = 'smtp';
$config['email']['smtp_host'] = 'smtp.163.com';
$config['email']['smtp_user'] = 'zxybuaa@163.com';
$config['email']['smtp_pass'] = '1234qwer1234';
$config['email']['smtp_port'] = '25';
$config['email']['charset'] = 'utf-8';
$config['email']['wordwrap'] = TRUE;
$config['email']['mailtype'] = 'html';


$config['STATUS_LOGIN_SUCCESS'] = 0;
$config['STATUS_LOGIN_UNACTIVATED'] = 1;
$config['STATUS_LOGIN_ERROR'] = 2;
$config['STATUS_REG_SUCCESS'] = 0;
$config['STATUS_REG_USEREXISTS'] = 1;
$config['STATUS_ACTIVATED_SUCCESS'] = 0;
$config['STATUS_ACTIVATED_FAIL'] = 1;

$config['MSG_LOGIN_SUCCESS'] = '登陆成功';
$config['MSG_LOGIN_UNACTIVATED'] = '账户未激活';
$config['MSG_LOGIN_ERROR'] = '用户名或密码错误';
$config['MSG_REG_SUCCESS'] = '注册成功';
$config['MSG_REG_USEREXISTS'] = '邮箱或手机号已经在本网站注册过';
$config['MSG_ACTIVATED_SUCCESS'] = '账户激活成功';
$config['MSG_ACTIVATED_FAIL'] = '账户激活失败';

$config['grade'] = array(
	'primary'=>array(
		'1'=>'一年级',
		'2'=>'二年级',
		'3'=>'三年级',
		'4'=>'四年级',
		'5'=>'五年级',
		'6'=>'六年级',
	),
	'middle'=>array(
		'7'=>'初一',
		'8'=>'初二',
		'9'=>'初三',
	),
	'high'=>array(
		'10'=>'高一',
		'11'=>'高二',
		'12'=>'高三',
	)
);
$config['resourceUrl'] = 'www.admin.haojiaolexue.com';
$config['subject'] = array(
	1=>'语文',
	2=>'数学',
	3=>'英语',
	4=>'化学',
	5=>'物理',
	6=>'生物',
	7=>'历史',
	8=>'地理',
);
?>