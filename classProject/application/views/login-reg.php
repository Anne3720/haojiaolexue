<script type="text/javascript" src="http://www.imooc.com/data/jquery.form.js"></script>
    <!-- Bootstrap -->
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
<link rel="stylesheet" href="../public/css/login-reg.css" type="text/css" />
              <div class="login login-reg-off">
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
                           <p><a class="btnlogin-reg-reg" >注 册</a></p>              
                  </span>     
                  </form>
                  <div id="login-reback"></div>
              </div>
            </div>         
            <div class="register login-reg-off">
              <div class="register-title">注 册</div>
              <div class="register-center">
                <form id="Register" name="register" method="post">
                  <p class="reg-group-addon"> <span> <img src="../public/img/phone.svg" alt="" /></span><input type="text" id="Mobile" name="Mobile" placeholder="请输入手机号码"/> </p>
                  <p class="reg-group-addon"> <span> <img src="../public/img/mail.svg" alt="" />          </span><input type="text" id="Email" name="Email" placeholder="请输入邮箱" /></p>
                  <p class="reg-group-addon"> <span> <img src="../public/img/lock.svg" alt="" /></span><input type="password" id="PassWord" name="PassWord" placeholder="请输入密码" /></p>
                  <p class="reg-group-addon"> <span> <img src="../public/img/lock.svg" alt="" /></span><input type="password" id="confirm_PassWord" name="confirm_PassWord" placeholder="请重复输入密码"/></p>
                  <span class="zhuce" >
                         <input id="btn-reg"  type="submit"  value="注 册"/> 
                         <p><a class="btnlogin-reg-login">登 录</a></p>              
                  </span>       
                </form>
                <div id="reg-reback"></div>
              </div>
            </div>
<script type="text/javascript" src="/public/js/login-reg.js"></script>   