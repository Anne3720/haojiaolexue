<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
<title>login</title>

    <link rel="stylesheet" type="text/css" href="../public/css/login.css" />
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.imooc.com/data/jquery.form.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
    
</head>

<body>
<div class="box">
  <div class="login">
    <div class="login-title">登录</div>
  	<div class="login-center">
  		<form id="login" name="login" method="post" >
  			<p> <span class="input-group-addon">用&nbsp;户&nbsp;名</span>
				<input type="text" id="username" name="username" class="form-control" placeholder="请输入邮箱或者手机号码">
			</p>
            <p> <span class="input-group-addon">密 &nbsp;&nbsp; 码</span>
				<input type="password" id="password" name="password" class="form-control" placeholder="请输入密码">
			</p>
  		
      <span class="denglu" >
               <input id="btn-login"  type="submit"  value="登 录"/>               
      </span>     
  		</form>
  		<div id="hehe"></div>
            
  	    <p class="text-center "><small>忘记密码？</small> <a href="javascript:void(0)" ><small>找回</small></a></p>
	    <p class="text-center"><small>还没注册?</small> <a href="reg" ><small>注册</small></a></p>


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
console.log(!demo.valid());
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
                            window.location= '..' ;   
                          } 
                      }
                  else if(statusText='null'){
                    $("#hehe").empty();
                      
                  } 
    };   
  
});
         
            
                 /*
                  $.ajax({
                      url:"/User/doLogin",
                      dataType:'json',     
                      type:'POST',
                      data: ,     
                      error:function(){     
                           alert('error');     
                      },     
                      success:showResponse,
                  });
              
                function showResponse(data,msg,status){     
                      //清空resText里面的所有内容  
                        

                       if (status=='2') {
                          $('#hehe').html(msg);  
                       }
                         //showResponse;
                         //$.getJSON()
                         //$("#hehe").append(responseText.msg);
                             
                } ;         
                     
            });
           */ 
   </script> 
</body>

</html>