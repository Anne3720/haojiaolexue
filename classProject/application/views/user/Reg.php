<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
    <title>注册页面</title>
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.imooc.com/data/jquery.form.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="http://www.imooc.com/data/jquery.form.js"></script>
    <link rel="stylesheet" href="../public/css/login-reg.css" type="text/css" />

</head>
<body>
 

<div class="reg-box">
             <div class="register">
              <div class="register-title">注 册</div>
              <div class="register-center">
                <form id="Register" name="register" method="post">
                  <p class="reg-group-addon"> 
                      <i id="regPhone"></i>
                      <input type="text" id="Mobile" name="Mobile" placeholder="请输入手机号码"/> 
                  </p>
                  <p class="reg-group-addon">
                      <i id="regEmail"></i>  
                       <input type="text" id="Email" name="Email" placeholder="请输入邮箱" />
                  </p>
                  <p class="reg-group-addon"> 
                      <i id="regPassword"></i> 
                      <input type="password" id="PassWord" name="PassWord" placeholder="请输入密码" />
                  </p>
                  <p class="reg-group-addon"> 
                      <i id="regConfirmPassWord"></i> 
                      <input type="password" id="confirm_PassWord" name="confirm_PassWord" placeholder="请重复输入密码"/></p>
                  <span class="zhuce" >
                         <input id="btn-reg"  type="submit"  value="注 册"/> 
                         <p><a href="login">登 录</a></p>              
                  </span>       
                </form>
                <div id="reg-reback"></div>
              </div>
            </div>
<script type="text/javascript" src="/public/js/login-reg.js"></script>   
</body>
</html>