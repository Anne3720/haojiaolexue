<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
    <title>注册页面</title>
    <link rel="stylesheet" href="../public/css/register.css" type="text/css" />
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.imooc.com/data/jquery.form.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
    <script src="../public/js/messages_cn.js" type="text/javascript"></script>
    

</head>
<body>
<div class="box">
  <div class="register">
    <div class="register-title">注册</div>
  	<div class="register-center">
  		<form id="Register" name="register" method="post">
  			<p class="reg-group-addon"> <span> <img src="../public/img/phone.svg" alt="" /></span><input type="text" id="Mobile" name="Mobile" placeholder="请输入手机号码"/> </p>
        <p class="reg-group-addon"> <span> <img src="../public/img/mail.svg" alt="" /></span><input type="text" id="Email" name="Email" placeholder="请输入邮箱" /></p>
  			<p class="reg-group-addon"> <span> <img src="../public/img/lock.svg" alt="" /></span><input type="password" id="PassWord" name="PassWord" placeholder="请输入密码" /></p>
  			<p class="reg-group-addon"> <span> <img src="../public/img/lock.svg" alt="" /></span><input type="password" id="confirm_PassWord" name="confirm_PassWord" placeholder="请重复输入密码"/></p>
        <span class="zhuce" >
               <input id="btn-reg"  type="submit"  value="注 册"/> 
               <p><a href="login" >登 录</a></p>              
        </span>       
  		</form>
      <ul>
        <li id="hehe"></li>
        <li><a id="btnLogin" href="login" >点此返回登录</a></li>
      </ul>
  	</div>
  </div>
</div>

   <script type="text/javascript" src="/public/js/reg.js"></script> 
</body>
</html>