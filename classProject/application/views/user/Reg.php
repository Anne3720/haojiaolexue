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
                  <p class="reg-group-addon"> <span> <img src="../public/img/phone.svg" alt="" /></span><input type="text" id="Mobile" name="Mobile" placeholder="请输入手机号码"/> </p>
                  <p class="reg-group-addon"> <span> <img src="../public/img/mail.svg" alt="" />          </span><input type="text" id="Email" name="Email" placeholder="请输入邮箱" /></p>
                  <p class="reg-group-addon"> <span> <img src="../public/img/lock.svg" alt="" /></span><input type="password" id="PassWord" name="PassWord" placeholder="请输入密码" /></p>
                  <p class="reg-group-addon"> <span> <img src="../public/img/lock.svg" alt="" /></span><input type="password" id="confirm_PassWord" name="confirm_PassWord" placeholder="请重复输入密码"/></p>
                  <span class="zhuce" >
                         <input id="btn-reg"  type="submit"  value="注 册"/> 
                         <p><a href="login">登 录</a></p>              
                  </span>       
                </form>
                <div id="reg-reback"></div>
              </div>
            </div>
 <script type="text/javascript" >
     
//注册页面js
$(document).ready(function(){
              $("#Register").validate({
                debug:true,  
                rules: { 
                    Mobile: {
                        required: true,  
                        minlength: 11, 
                        digits:true
                    }, 
                    Name: {  
                        required: true,  
                        minlength: 2  
                    },  
                    Email: {  
                        required: true,  
                        email: true  
                    },  
                    PassWord: {
                        required: true,
                        minlength: 6
                    },
                    confirm_PassWord: {
                        required: true,
                        equalTo: "#PassWord",
                        minlength: 6
                        
                    },
                    School:{
                        required: true,                      
                    },
                    Grade:{
                        required: true, 
                    }
                },  
                messages: { 
                    Mobile: {
                        required: '请输入手机号码',  
                        minlength: '请输入正确的手机号码',
                        digits: '请输入正确的手机号码',
                    },  
                    Name: {  
                        required: '请输入姓名',  
                        minlength: '请至少输入两个字符'  
                    },  
                    Email: {  
                        required: '请输入电子邮件',  
                        email: '请检查电子邮件的格式'  
                    },  
                    PassWord: {
                        required: "请输入密码",
                        minlength: "密码不能小于6个字符"
                    },
                    confirm_PassWord: {
                        required: "请输入确认密码",
                        minlength: "确认密码不能小于6个字符",
                        equalTo: "两次输入密码不一致"
                    },
                    School: {
                        required: "请输入学校",                       
                    },
                    Grade:{
                        required: "请输入年级", 
                    }
                } 
                  
             });
         });  
         $(document).ready(function(){
              var options = { 
                  url:"/user/doReg",
                  type:"POST",
                  target: '#reg-reback',
                  beforeSubmit: showRequest,  //提交前的回调函数  
                  success: showResponse,      //提交后的回调函数  
                  dataType:  'json',

              };            
             // ajaxSubmit
              $("#btn-reg").click(function () {
                  $("#Register").ajaxSubmit(options);
              });
           
             function showResponse(responseText, statusText){  
                  //dataType=xml  
                  //var name = $('name', responseXML).text();  
                  //var address = $('address', responseXML).text();  
                  //$("#xmlout").html(name + "  " + address);  
                  //dataType=json ;
                  $("#reg-reback").html("");
                  if (statusText=='success') {
                         //showResponse;
                         //$.getJSON()
                         //$("#hehe").append(responseText.msg);
                        
                        if (responseText.status==0) {
                          $("#reg-reback").append(responseText.msg);
                          
                        }
                        else{
                          $("#reg-reback").append(responseText.msg);
                        }
                        
                    } 
               };  

             function showRequest(formData, jqForm, options) {//在这里对表单进行验证，如果不符合规则，将返回false来阻止表单提交，直到符合规则为止
             //方式一：利用formData参数 
               for (var i=0; i < formData.length; i++) {  
                  if (!formData[i].value) {    
                  return false;  
                   }  
                } 
                   var form=$('#Register') ;
                   if(!form.validate().successList.length){
                    $("#reg-reback").html("");
                    return false;
                   }              
                  $("#reg-reback").html("提交中。。。");
                  return true; 
           } 

         });
   </script> 
</body>
</html>