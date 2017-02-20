
    <div class="navtop">
       <div class="navtop-logo col-md-2" ><img width="100%" height="100%" src="/public/img/logo.png" alt="" /></div>
       <div class="navtop-content col-md-10" >
       	    <ul class="navtop-class">
        	    <li class="navtop-class col-md-2"><a href="/classes/classList">课程</a></li>
            <?php if(!isset($_SESSION['userInfo'])&&empty($_SESSION['userInfo'])){ ?>
		            <li class="col-md-2 col-md-offset-6 btnlogin-reg-login" data-toggle="modal" data-target="#modal">登录</li>
		            <li class="col-md-2 btnlogin-reg-reg" data-toggle="modal" data-target="#modal">注册</li>
	          <?php }else{ ?>
	            <li class="col-md-2 col-md-offset-4"><a href="" >学习中心</a></li>
	            <li class="col-md-2 col-md-offset-0"><a href="/user/information" >个人信息</a></li>
		          <li class="col-md-2 col-md-offset-0"><a href="/user/doLogout" >退出</a></li>
		    <?php } ?>
	          </ul>
       </div>
        
	    
	</div>
  <div id="modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <?php include('login-reg.php');?>                    
            </div>
        </div>
    </div>

  



          
   