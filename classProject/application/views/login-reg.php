

    <div class="login-reg-wrap login login-reg-off">
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
                <input type="button"  value="注 册" class="button1 btnlogin-reg-reg" />
                
            </li>
            <li class="reback"></li>
        </ul>
        </form>
    </div>     
    <div class="login-reg-wrap register login-reg-off">
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
                <input name="Password" id="password" type="password" valid="required|isPassword" errmsg="密码不能为空!|以字母开头,只能包含6-18位的字符、数字和下划线" placeholder="请输入密码(字母开头，长度在6-18之间)"/>
                <span class="hint"  id="errMsg_Password"></span>    
            </li>       
            <li>
                <label for="password2"></label>
                <input name="confirm_PassWord" id="password2"　type="text" type="password" valid="eqaul" eqaulName="password" errmsg="两次密码不同!" placeholder="请重复输入密码"/>
                <span class="hint" id="errMsg_confirm_PassWord"></span>   
            </li>
            <li class="button">
                <input type="submit" onclick="ajaxSubmitReg()" id="regSubmit" name="Submit" value="注 册" class="button2"/>
                <input type="button"  name="Submit" value="登 录" class="button1 btnlogin-reg-login" />
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
    if(validator(form)){
      $.ajax({
      
        method:'post',
        url:'/user/doLogin',
        data:{'username':username,'password':password},
        success: function(data){
            var cdata = $.parseJSON(data);
             $('.reback').html(cdata.msg);
             if (cdata.status==0) {
                 refresh(location.href);   
             }else if(cdata.status==1){
                $('.reback').append("，请去邮箱激活");
             }else{
                $('.reback').append("，请重新输入");
             }
             setTimeout(function(){
                 $('.reback').html('');
             },3000);
          }
      })    
    } 
}

function ajaxSubmitReg() {
    var tel = document.getElementById("tel").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var form = document.getElementById("reg");
    if(validator(form)){
        $.ajax({
      
            method:'post',
            url:'/user/doReg',
            data:{'Mobile':tel,'Email':email,'PassWord':password},
            success: function(data){
                var cdata = $.parseJSON(data);
                $('.reback').html( cdata.msg )
                if (cdata.status==0) {
                    $('.reback').append( "请去邮箱激活" );   
                }else{
                    $('.reback').append( "请返回登录" );
                }
                setTimeout(function(){
                 $('.reback').html('');
                },3000);                     
            }
        })  
    }    
}
function refresh(url){window.location=url}
</script>
<script>
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

</script>
<script type="text/javascript" src="/public/js/formValidator.js"></script>
   