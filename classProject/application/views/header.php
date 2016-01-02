<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
	<title>好教乐学</title>
	<link rel="stylesheet" href="/public/css/main.css" type="text/css" />
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
    <div class="navtop">
        <span class="navtop-logo">好教乐学</span>
        <?php if(!$_SESSION['userInfo']){ ?>
	    <ul>
		    <li><a href="User/login" >登录</a></li>
		    <li><a href="User/reg" >注册</a></li>
	    </ul>
	    <?php }else{ ?>
	    <ul>
		    <li><a href="User/doLogout" >退出</a></li>
	    </ul>
	    <?php } ?>
	</div>
</body>
</html>