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
<!-- svg icons -->
<svg aria-hidden="true" style="display: none;" >
    
    <symbol id="icon-lock" width="20" height="20" viewBox="0 0 24 24" >
        <path fill="#00f" d="M12 1q1.633 0 3.012 0.805t2.184 2.184 0.805 3.012v4h2q1.242 0 2.121 0.879t0.879 2.121v6q0 1.242-0.879 2.121t-2.121 0.879h-16q-1.242 0-2.121-0.879t-0.879-2.121v-6q0-1.242 0.879-2.121t2.121-0.879h2v-4q0-1.633 0.805-3.012t2.184-2.184 3.012-0.805zM20 13h-16q-0.414 0-0.707 0.293t-0.293 0.707v6q0 0.414 0.293 0.707t0.707 0.293h16q0.414 0 0.707-0.293t0.293-0.707v-6q0-0.414-0.293-0.707t-0.707-0.293zM12 3q-1.656 0-2.828 1.172t-1.172 2.828v4h8v-4q0-1.656-1.172-2.828t-2.828-1.172z">
        </path>
    </symbol>
    <symbol id="icon-head" width="20" height="20" viewBox="0 0 24 24" >
        <path fill="#00f" d="M12 0q1.633 0 3.012 0.805t2.184 2.184 0.805 3.012v3q0 1.25-0.484 2.367t-1.352 1.945q2.281 0.359 4.055 1.059t2.777 1.652 1.004 2.008v1.969q0 1.242-0.879 2.121t-2.121 0.879h-18q-1.242 0-2.121-0.879t-0.879-2.121v-1.977q0-1.055 1.004-2.008t2.773-1.652 4.051-1.051q-0.859-0.836-1.344-1.949t-0.484-2.363v-3q0-1.633 0.805-3.012t2.184-2.184 3.012-0.805zM12 15q-2.172 0-4.191 0.348t-3.52 0.973q-0.602 0.25-1.074 0.531t-0.719 0.508-0.371 0.395-0.125 0.27v1.977q0 0.414 0.293 0.707t0.707 0.293h18q0.414 0 0.707-0.293t0.293-0.707v-1.969q0-0.102-0.125-0.27t-0.371-0.395-0.719-0.508-1.074-0.539q-1.5-0.625-3.52-0.973t-4.191-0.348zM12 2q-1.656 0-2.828 1.172t-1.172 2.828v3q0 1.656 1.172 2.828t2.828 1.172 2.828-1.172 1.172-2.828v-3q0-1.656-1.172-2.828t-2.828-1.172z">
        </path>
    </symbol>
</svg>

<div class="login-box">
     <div class="login">
                <div class="login-title">登 录</div>
                <div class="login-center">
                  <form id="login" name="login" method="post" >
                    <p class="input-group-addon"> 
                      <svg aria-hidden='true'>
                         <use xlink:href="#icon-head" />
                      </svg>
                    <input type="text" id="username" name="username" class="form-control" placeholder="请输入邮箱或者手机号码">
                  </p>
                        <p class="input-group-addon"> 
                        <svg aria-hidden='true'>
                          <use xlink:href="#icon-lock" />
                        </svg>
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

<script type="text/javascript">
    //表单验证
    var demo = $("#login").validate({
            debug:true, 
            focusInvalid: false, //当为false时，验证无效时，没有焦点响应  
            onkeyup: false, 
        //errorClass: "label.error", //默认为错误的样式类为：error
        //提交表单//表单提交句柄,为一回调函数，带一个参数：form               
            rules: {  
                username: {  
                    required: true,  
                    minlength: 2 
                },    
                password: {
                    required: true,
                    minlength: 6,
                }
            },    
            messages: { 
                username: {  
                    required: '',  
                    minlength: '请至少输入两个字符'  
                },  
                password: {
                    required: "",
                    minlength: "密码不能小于6个字符"
                }
            },   
      });
    //提交表单
$(document).ready(function(){
    formSubmit('#login','#btn-login');
    //提交表单函数
    function formSubmit(form,btn){
        var options = { 
            url:"/user/doLogin",
            type:"POST",
            target: '#hehe',
            beforeSubmit: showRequest,  //提交前的回调函数  
            success: showResponse,      //提交后的回调函数  
            dataType:  'json',
          };            
        // ajaxSubmit
        $(btn).click(function () {
            $(form).ajaxSubmit(options);

        });

    };
    //提交前的回调函数
    function showRequest(formData, jqForm, options){
        if (demo.valid()) { 
            //验证通过
            return true;
        }
            return false;
        

    };
    //提交后的回调函数
    function showResponse(responseText, statusText){  
                  
                  $("#hehe").empty();
                  if (statusText=='success') {
                         //showResponse;
                         //$.getJSON()
                         //$("#hehe").append(responseText.msg);
                      if (responseText.status!=0) {
                            $("#hehe").empty();
                            $("#hehe").append(responseText.msg);
                      }else if (responseText.status==0) {
                            $("#hehe").empty();
                            window.location= '/'+GetRequest();   
                          } 
                      }
                  else if(statusText='null'){
                    $("#hehe").empty();
                      
                  } 
    };   
    
       function GetRequest() {
         var url = location.search; //获取url中"?"符后的字串
          if (url.indexOf("?") != -1) {    //判断是否有参数
           var str = url.substr(1); //从第一个字符开始 因为第0个是?号 获取所有除问号的所有符串
            strs = str.split("=");   //用等号进行分隔 （因为知道只有一个参数 所以直接用等号进分隔 如果有多个参数 要用&号分隔 再用等号进行分隔）
            return strs[1];
        }
        return '';
       }
    });
         
          
   </script> 
</body>

</html>