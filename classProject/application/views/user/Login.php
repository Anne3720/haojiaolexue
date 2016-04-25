<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
<title>登录页面</title>
    <link rel="stylesheet" href="../public/css/login-reg.css" type="text/css" />
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.imooc.com/data/jquery.form.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
    
</head>

<body>

<div class="login-box">
     <div class="login">
                <div class="login-title">登 录</div>
                <div class="login-center">
                  <form id="login" name="login" method="post" >
                    <p class="input-group-addon"> 
                      <i id="loginUserName"></i>
                    <input type="text" id="username" name="username" class="form-control" placeholder="请输入邮箱或者手机号码">
                  </p>
                        <p class="input-group-addon"> 
                        <i id="loginPassword"></i>
                    <input type="password" id="password" name="password" class="form-control" placeholder="请输入密码">
                  </p>
      
                  <span class="denglu" >
                           <input id="btn-login"  type="submit"  value="登 录"/> 
                           <p><a href="reg" >注 册</a></p>              
                  </span>     
                  </form>
                  <div id="login-reback"></div>
              </div>
      </div>   
</div>

</body>

</html>