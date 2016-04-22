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
 <!-- svg icons -->
<svg aria-hidden="true" style="display: none;" >
    <symbol id="icon-stay_primary_portrait" width="20" height="20"  viewBox="0 0 24 24" >
        <path fill="#00f" d="M17.016 18.984v-13.969h-10.031v13.969h10.031zM17.016 1.031c1.078 0 1.969 0.891 1.969 1.969v18c0 1.078-0.891 2.016-1.969 2.016h-10.031c-1.078 0-1.969-0.938-1.969-2.016v-18c0-1.078 0.891-2.016 1.969-2.016z">
        </path>
    </symbol>
    <symbol id="icon-mail" width="20" height="20" viewBox="0 0 24 24" >
        <path fill="#00f" d="M4 3h16q1.242 0 2.121 0.879t0.879 2.121v12q0 1.242-0.879 2.121t-2.121 0.879h-16q-1.242 0-2.121-0.879t-0.879-2.121v-12q0-1.242 0.879-2.121t2.121-0.879zM21 18v-10.922l-8.375 6.703q-0.266 0.219-0.625 0.219t-0.625-0.219l-8.375-6.703v10.922q0 0.414 0.293 0.707t0.707 0.293h16q0.414 0 0.707-0.293t0.293-0.707zM20 5h-16q-0.148 0-0.328 0.055l8.328 6.664 8.328-6.664q-0.18-0.055-0.328-0.055z">
        </path>
    </symbol>
    <symbol id="icon-lock" width="20" height="20" viewBox="0 0 24 24" >
        <path fill="#00f" d="M12 1q1.633 0 3.012 0.805t2.184 2.184 0.805 3.012v4h2q1.242 0 2.121 0.879t0.879 2.121v6q0 1.242-0.879 2.121t-2.121 0.879h-16q-1.242 0-2.121-0.879t-0.879-2.121v-6q0-1.242 0.879-2.121t2.121-0.879h2v-4q0-1.633 0.805-3.012t2.184-2.184 3.012-0.805zM20 13h-16q-0.414 0-0.707 0.293t-0.293 0.707v6q0 0.414 0.293 0.707t0.707 0.293h16q0.414 0 0.707-0.293t0.293-0.707v-6q0-0.414-0.293-0.707t-0.707-0.293zM12 3q-1.656 0-2.828 1.172t-1.172 2.828v4h8v-4q0-1.656-1.172-2.828t-2.828-1.172z">
        </path>
    </symbol>
    <symbol id="icon-head" width="20" height="20" viewBox="0 0 24 24" >
        <path fill="#00f" d="M12 0q1.633 0 3.012 0.805t2.184 2.184 0.805 3.012v3q0 1.25-0.484 2.367t-1.352 1.945q2.281 0.359 4.055 1.059t2.777 1.652 1.004 2.008v1.969q0 1.242-0.879 2.121t-2.121 0.879h-18q-1.242 0-2.121-0.879t-0.879-2.121v-1.977q0-1.055 1.004-2.008t2.773-1.652 4.051-1.051q-0.859-0.836-1.344-1.949t-0.484-2.363v-3q0-1.633 0.805-3.012t2.184-2.184 3.012-0.805zM12 15q-2.172 0-4.191 0.348t-3.52 0.973q-0.602 0.25-1.074 0.531t-0.719 0.508-0.371 0.395-0.125 0.27v1.977q0 0.414 0.293 0.707t0.707 0.293h18q0.414 0 0.707-0.293t0.293-0.707v-1.969q0-0.102-0.125-0.27t-0.371-0.395-0.719-0.508-1.074-0.539q-1.5-0.625-3.52-0.973t-4.191-0.348zM12 2q-1.656 0-2.828 1.172t-1.172 2.828v3q0 1.656 1.172 2.828t2.828 1.172 2.828-1.172 1.172-2.828v-3q0-1.656-1.172-2.828t-2.828-1.172z">
        </path>
    </symbol>
</svg>

<div class="reg-box">
             <div class="register">
              <div class="register-title">注 册</div>
              <div class="register-center">
                <form id="Register" name="register" method="post">
                  <p class="reg-group-addon"> 
                      <svg aria-hidden='true'>
                         <use xlink:href="#icon-stay_primary_portrait" />
                      </svg>
                      <input type="text" id="Mobile" name="Mobile" placeholder="请输入手机号码"/> 
                  </p>
                  <p class="reg-group-addon">
                      <svg aria-hidden='true'>
                          <use xlink:href="#icon-mail" />
                      </svg>  
                       <input type="text" id="Email" name="Email" placeholder="请输入邮箱" />
                  </p>
                  <p class="reg-group-addon"> 
                      <svg aria-hidden='true'>
                          <use xlink:href="#icon-lock" />
                      </svg> 
                      <input type="password" id="PassWord" name="PassWord" placeholder="请输入密码" />
                  </p>
                  <p class="reg-group-addon"> 
                      <svg aria-hidden='true'>
                          <use xlink:href="#icon-lock" />
                      </svg> 
                      <input type="password" id="confirm_PassWord" name="confirm_PassWord" placeholder="请重复输入密码"/></p>
                  <span class="zhuce" >
                         <input id="btn-reg"  type="submit"  value="注 册"/> 
                         <p><a href="login">登 录</a></p>              
                  </span>       
                </form>
                <div id="reg-reback"></div>
              </div>
            </div>
 <script type="text/javascript" >
 <!--    
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
         //-->
   </script> 
</body>
</html>