<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
<title>登录页面</title>
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.imooc.com/data/jquery.form.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="/public/css/log_reg.css" />
</head>

<body>

<div class="login-reg-wrap">
    <h1>登录</h1>
    <form id="login"  method="post" onSubmit="return false;" >
    <ul>      
        <li>
            <label for="username"></label>
            <input name="username" id="username" type="text" valid="required|isUsername" errmsg="账号不能为空|账号格式不对!" placeholder="请输入邮箱或手机号码"/>
            <span class="hint" id="errMsg_username"></span> 
        </li>                   
        <li>
            <label for="password"></label>
            <input name="password" id="password" type="password" valid="required|isPassword" errmsg="密码不能为空!|以字母开头,只能包含6-18位的字符、数字和下划线" placeholder="请输入密码(字母开头，长度在6-18之间)"/>
            <span class="hint"  id="errMsg_password"></span>    
        </li>       
        <li class="button">
            <input type="button" onclick="ajaxSubmitLogin()" id="regSubmit" name="Submit" value="登 录" class="button2" />
            <input type="button" onclick="refresh('/user/reg')"  value="注 册" class="button1" />
            
        </li>
        <li class="reback"></li>
    </ul>
    </form>
</div>
<script>

function ajaxSubmitLogin() {
    var form = document.getElementById("login");
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    alert(password)
    if(validator(form)){
      $.ajax({
      
        method:'post',
        url:'/user/doLogin',
        data:{'username':username,'password':password},
        success: function(data){
            var cdata = $.parseJSON(data);
             $('.reback').html(cdata.msg);
             if (cdata.status==0) {
                setTimeout('refresh("/")',1000);   
             }
          }
      })    
    } 
}
function refresh(url){window.location=url}
</script>
<script type="text/javascript" src="/public/js/formValidator.js"></script>   
</body>

</html>