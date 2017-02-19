<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
	  <title>好教乐学</title>
	  <link rel="stylesheet" href="/public/css/main.css" type="text/css" />
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    
    <script src="/public/js/bootstrap-transition.js"></script>
    <script src="/public/js/bootstrap-modal.js"></script>
    <script type="text/javascript" src="/public/easyUI/jquery.easyui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/public/easyUI/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/public/easyUI/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="/public/easyUI/demo/demo.css">
    
</head>
<body>
    <div class="navtop">
       <div class="navtop-logo"><img width="230px" src="/public/img/logo.png" alt="" /></div>
       <div class="navtop-content">
       	    <ul class="navtop-class">
        	    <li><a href="/classes/classList">课程</a></li>
            </ul>
            <ul class="navtop-login">
            <?php if(!isset($_SESSION['userInfo'])&&empty($_SESSION['userInfo'])){ ?>
		        <li class="btnlogin-reg-login" data-toggle="modal" data-target="#modal">登录</li>
		        <li class="btnlogin-reg-reg" data-toggle="modal" data-target="#modal">注册</li>
	        </ul>
	        <?php }else{ ?>
	        <ul class="navtop-login">
	            <li><a href="" >学习中心</a></li>
	            <li><a href="/user/information" >个人信息</a></li>
		        <li><a href="/user/doLogout" >退出</a></li>
		    <?php } ?>
	        </ul>
       </div>
        
	    
	</div>
  <div id="modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
              
              <?php include('login-reg.php');?> 
                    
            </div>
        </div>
    </div>
   



          
   