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
    <div class="login-title">登 录</div>
  	<div class="login-center">
  		<form id="login" name="login" method="post" >
  			<p class="input-group-addon"> <span><img src="../public/img/head.svg" alt="" /></span>
				<input type="text" id="username" name="username" class="form-control" placeholder="请输入邮箱或者手机号码">
			</p>
            <p class="input-group-addon"> <span><img src="../public/img/lock.svg" alt="" /></span>
				<input type="password" id="password" name="password" class="form-control" placeholder="请输入密码">
			</p>
  		
      <span class="denglu" >
               <input id="btn-login"  type="submit"  value="登 录"/> 
               <p><a href="reg" >注 册</a></p>              
      </span>     
  		</form>
  		<div id="hehe"></div>
            
  	  <p class="text-center"><small>忘记密码？</small> <a href="javascript:void(0)" ><small>找回</small></a></p> 
	    


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