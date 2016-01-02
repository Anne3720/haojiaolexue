<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
<title>loglin</title>

    <link rel="stylesheet" type="text/css" href="../public/css/login.css" />
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.imooc.com/data/jquery.form.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
    <script src="../public/js/messages_cn.js" type="text/javascript"></script>
</head>

<body>
<div class="box">
  <div class="login">
    <div class="login-title">登录</div>
  	<div class="login-center">
  		<form id="Login" name="login" method="post">
  			<p> <span class="input-group-addon">用&nbsp;户&nbsp;名</span>
				<input type="text" id="username" name="username" class="form-control" placeholder="请输入邮箱或者手机号码">
			</p>
            <p> <span class="input-group-addon">密 &nbsp;&nbsp; 码</span>
				<input type="password" id="password" name="password" class="form-control" placeholder="请输入密码">
			</p>
  		
            <span class="denglu" >
              <input id="btnLogin" type="submit" value="登录"> 
            </span>     
  		</form>
  		<ul>
            <li id="hehe"></li>
        </ul>
  	    <p class="text-center "><small>忘记密码？</small> <a href="javascript:void(0)" ><small>找回</small></a></p>
	    <p class="text-center"><small>还没注册?</small> <a href="reg" ><small>注册</small></a></p>


  	</div>
  </div>
</div>
<script type="text/javascript">

         $(document).ready(function(){
              $("#Login").validate({
                debug:true, 
               //errorClass: "label.error", //默认为错误的样式类为：error
               //提交表单//表单提交句柄,为一回调函数，带一个参数：form               
                rules: {  
                    username: {  
                        required: true,  
                        minlength: 2 
                    },    
                    password: {
                        required: true,
                        minlength: 6
                    }
                },    
                messages: { 
                    username: {  
                        required: '请输入正确的用户名',  
                        minlength: '请至少输入两个字符'  
                    },  
                    password: {
                        required: "请输入密码",
                        minlength: "密码不能小于6个字符"
                    }
                }, 
              });

              formSubmit("#Login","#btnLogin");
              function formSubmit(form,btn){
                var options = { 
                  url:"/User/doLogin",
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
          
             function showResponse(responseText, statusText){  
                  //dataType=xml  
                  //var name = $('name', responseXML).text();  
                  //var address = $('address', responseXML).text();  
                  //$("#xmlout").html(name + "  " + address);  
                  //dataType=json ;
                  $("#hehe").html("");
                  if (statusText=='success') {
                         //showResponse;
                         //$.getJSON()
                         //$("#hehe").append(responseText.msg);
                      if (responseText.status!=0) {
                            $("#hehe").html("");
                            $("#hehe").append(responseText.msg);
                      }else if (responseText.status==0) {
                            $("#hehe").html(""); 
                            window.location= '..' ;   
                          } 
                      }
                  else if(statusText='null'){
                      $("#hehe").html("");
                  } 
               };  
             
          
             function showRequest(formData, jqForm, options) {
             //在这里对表单进行验证，如果不符合规则，将返回false来阻止表单提交，直到符合规则为止
             //方式一：利用formData参数 
               for (var i=0; i < formData.length; i++) {  
                  if (!formData[i].value) {    
                  return false;  
                   }  
                } 

                  return true; 
               } ;
            
               /* $("#Login").ajax({     
                 url:"/User/doLogin",
                 dataType:json,     
                 type:'post',     
                 data:data,     
                 async : false, //默认为true 异步     
                 error:function(){     
                 alert('error');     
                  },     
                 success:function(msg){     
                 $("#hehe").html(msg);     
                 }  
            });     
           */
         });    
   </script> 
</body>

</html>