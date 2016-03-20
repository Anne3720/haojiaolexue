
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
                            window.location= '';   
                          } 
                      }
                  else if(statusText='null'){
                    $("#hehe").empty();
                      
                  } 
    };   
    
    });
//点击切换
$(document).ready(function(){
        $('.btnlogin-reg-login').click(function(){
            $('.register').addClass("login-reg-off");
            $('.login').removeClass("login-reg-off");
            
        });
        $('.btnlogin-reg-reg').click(function(){
            $('.login').addClass("login-reg-off");
            $('.register').removeClass("login-reg-off");
           
        });
       
   });

//登录页面js
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
            target: '#login-reback',
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
                  
                  $("#login-reback").empty();
                  if (statusText=='success') {
                         //showResponse;
                         //$.getJSON()
                         //$("#login-reback").append(responseText.msg);
                      if (responseText.status!=0) {
                            $("#login-reback").empty();
                            $("#login-reback").append(responseText.msg);


                      }else if (responseText.status==0) {
                            $("#login-reback").empty();
                            window.location.reload();   
                          } 
                      }
                  else if(statusText='null'){
                    $("#login-reback").empty();
                      
                  } 
    };   
  
});
         //setTimeout(time, 1000);
         //var time=function(){ window.location.reload();}