<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
	<title>好教乐学</title>
	<link rel="stylesheet" href="/public/css/main.css" type="text/css" />
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/public/css/bootstrap.css"/> 
    <script src="/public/js/bootstrap-transition.js"></script>
    <script src="/public/js/bootstrap-modal.js"></script>
    <script type="text/javascript" src="http://www.imooc.com/data/jquery.form.js"></script>
    <!-- Bootstrap -->
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="../public/css/login-reg.css" type="text/css" />
</head>
<body>
    <div class="navtop">
       <div class="navtop-logo">好教乐学</div>
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
	            <li><a href="#" >个人信息</a></li>
		        <li><a href="/user/doLogout" >退出</a></li>
		    <?php } ?>
	        </ul>
       </div>
        
	    
	</div>
    <div id="modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
              
              <div class="login login-reg-off">
                <div class="login-title">登 录</div>
  	            <div class="login-center">
  		            <form id="login" name="login" method="post" >
  			            <p class="input-group-addon"> <span><img src="../public/img/head.svg" alt="" /></span>
			            	<input type="text" id="username" name="username" class="form-control" placeholder="请输入邮箱或者手机号码">
			            </p>
                        <p class="input-group-addon"> <span><img src="../public/img/lock.svg" alt="" /></span>
		            		<input type="password" id="password" name="password" class="form-control" placeholder="请输入密码">
		            	</p>
  		
                  <span class="denglu" >
                           <input id="btn-login"  type="submit"  value="登 录"/> 
                           <p><a class="btnlogin-reg-reg" >注 册</a></p>              
                  </span>     
              		</form>
  		            <div id="login-reback"></div>
              </div>
            </div>         
            <div class="register login-reg-off">
              <div class="register-title">注 册</div>
            	<div class="register-center">
  	          	<form id="Register" name="register" method="post">
  	          		<p class="reg-group-addon"> <span> <img src="../public/img/phone.svg" alt="" /></span><input type="text" id="Mobile" name="Mobile" placeholder="请输入手机号码"/> </p>
                  <p class="reg-group-addon"> <span> <img src="../public/img/mail.svg" alt="" />          </span><input type="text" id="Email" name="Email" placeholder="请输入邮箱" /></p>
  		          	<p class="reg-group-addon"> <span> <img src="../public/img/lock.svg" alt="" /></span><input type="password" id="PassWord" name="PassWord" placeholder="请输入密码" /></p>
  			          <p class="reg-group-addon"> <span> <img src="../public/img/lock.svg" alt="" /></span><input type="password" id="confirm_PassWord" name="confirm_PassWord" placeholder="请重复输入密码"/></p>
                  <span class="zhuce" >
                         <input id="btn-reg"  type="submit"  value="注 册"/> 
                         <p><a class="btnlogin-reg-login">登 录</a></p>              
                  </span>       
  	          	</form>
                <div id="reg-reback"></div>
  	          </div>
            </div>
                    
            </div>
        </div>
    </div>
<script type="text/javascript" src="/public/js/login-reg.js"></script>   



          
   