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
    <h1>注册</h1>
    <form id="reg"  method="post" onSubmit="return false;" >
    <ul>      
        <li>
            <label for="tel"></label>
            <input name="Mobile" id="tel" type="text" valid="required|isChinaPhone" errmsg="手机不能为空|手机格式不对!" placeholder="请输入手机号码"/>
            <span class="hint" id="errMsg_Mobile"></span> 
        </li>      
        <li>
            <label for="email"></label>
            <input name="Email" id="email"type="text" valid="required|isEmail" errmsg="Email不能为空|Email格式不对!" placeholder="请输入邮箱"/>
            <span class="hint" id="errMsg_Email"></span> 
        </li>              
        <li>
            <label for="password"></label>
            <input name="Password" id="password" type="password" valid="required|isPassword" errmsg="密码不能为空!|以字母开头，长度在6-18之间，只能包含字符、数字和下划线" placeholder="请输入密码(字母开头，长度在6-18之间)"/>
            <span class="hint"  id="errMsg_Password"></span>    
        </li>       
        <li>
            <label for="password2"></label>
            <input name="confirm_PassWord" id="password2"　type="text" type="password" valid="eqaul" eqaulName="password" errmsg="两次密码不同!" placeholder="请重复输入密码"/>
            <span class="hint" id="errMsg_confirm_PassWord"></span>   
        </li>
        <li class="button">
            <input type="submit" onclick="ajaxSubmitReg()" id="regSubmit" name="Submit" value="注 册" class="button2"/>
            <input type="button" name="Submit" value="登 录" class="button1" />
        </li>
        <li class="reback"></li>
    </ul>
    </form>
</div>
<script>
function ajaxSubmitReg() {
    var tel = document.getElementById("tel").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var form = document.getElementById("reg");
    if(validator(form)){
        $.ajax({
      
            method:'post',
            url:'/user/doReg',
            data:{'Mobile':tel,'Email':email,'Password':password},
            success: function(data){
                var cdata = $.parseJSON(data);
                $('.reback').html( cdata.msg )
                if (cdata.status==0) {
                    $('.reback').append( "请去邮箱激活" )   
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