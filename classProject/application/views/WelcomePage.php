<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
	<title>好教乐学</title>
	<link rel="stylesheet" href="/public/css/main.css" type="text/css" />
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
<div class="box">
    <div class="navtop">
        <span class="navtop-logo">好教乐学</span>
        <?php if(!$_SESSION['userInfo']){ ?>
	    <ul>
		    <li><a href="User/login" >登录</a></li>
		    <li><a href="User/reg" >注册</a></li>
	    </ul>
	    <?php }else{ ?>
	    <ul>
		    <li><a href="User/doLogout" >退出</a></li>
	    </ul>
	    <?php } ?>
	</div>
	
    <div class="navcenter">
	    <ul>
		    <li></li>
		    <li></li>
		    <li></li>
		    <li></li>
		    <li></li>
	    </ul>
	</div>
	<div class="navleft">
	   <ul>
		<div class="navleft-tittle">全部课程分类</div>
		<div class="navleft-content">
		    <li>高中</li>
		    <li class="grade">
		    	<?php foreach ($grade['high'] as $key => $value) {?>
		        <a href=""><?php echo($value);?></a>
		    	<?php }?>
		    </li>
		    <div class="navleft-hide">
		       <dl>
		       	<?php foreach ($grade['high'] as $key => $value) {?>
  					<dt><a href="#"><?php echo($value);?></a></dt>
					<dd>
						<?php foreach ($subject[$key] as $v) {?>
						<a href="Classes/getClassListByGradeAndSubject/<?php echo($key);?>/<?php echo($v['SubjectID']);?>"><?php echo($v['Title']);?></a>
						<?php } ?>
					</dd>
  		       	<?php }?>
		       </dl>
	        </div>
        </div>
        <div class="navleft-content">
            <li>初中</li>
		    <li class="grade">
		    	<?php foreach ($grade['middle'] as $key => $value) {?>
		        <a href=""><?php echo($value);?></a>
		    	<?php }?>
		    </li>
		    <div class="navleft-hide">
		       <dl>
		       	<?php foreach ($grade['middle'] as $key => $value) {?>
  					<dt><a href="#"><?php echo($value);?></a></dt>
					<dd>
						<?php foreach ($subject[$key] as $v) {?>
						<a href="Classes/getClassListByGradeAndSubject/<?php echo($key);?>/<?php echo($v['SubjectID']);?>"><?php echo($v['Title']);?></a>
						<?php } ?>
					</dd>
  		       	<?php }?>
		       </dl>
	        </div>
        </div>
        <div class="navleft-content">
        	<li>小学</li>	
		    <li class="grade">
		    	<?php foreach ($grade['primary'] as $key => $value) {?>
		        <a href=""><?php echo($value);?></a>
		    	<?php }?>
		    </li>
		    <div class="navleft-hide">
		       <dl>
		       	<?php foreach ($grade['primary'] as $key => $value) {?>
  					<dt><a href="#"><?php echo($value);?></a></dt>
					<dd>
						<?php foreach ($subject[$key] as $v) {?>
						<a href="Classes/getClassListByGradeAndSubject/<?php echo($key);?>/<?php echo($v['SubjectID']);?>"><?php echo($v['Title']);?></a>
						<?php } ?>
					</dd>
  		       	<?php }?>
		       </dl>
	        </div>	
        </div>
		
	  </ul>
    </div>
    <div class="classShow">
  	    <div class="classShowNew">
     		<div class="classShow-title">最新课程</div>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     	</div>
     	<div class="classShowHot">
     		<div class="classShow-title">热门课程</div>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     		<span><img src="" alt="" /><p>我的</p></span>
     	</div>
    </div>
</div>
   <script type="text/javascript">
	   $(document).ready(function(){
	   	   
	   	   $(".navleft-content").each(function(index){	   
	   	   	   	$(".navleft-content").attr({
	   	   	   		id:function(index,oldValue){
                        return 'navleft-content-'+index;
	   	   	   		}
	   	   	   	});
	   	   	   	$(".navleft-hide").attr({
	   	   	   		id:function(index,oldValue){
                        return 'navleft-hide-'+index;
	   	   	   		}
	   	   	   	});
	   	   	   $('#navleft-content-'+index).hover(
	   	   	      function(){
	   	   		  $("#navleft-hide-"+index).show();
	   	        },  	   	  
                  function(){
                  $("#navleft-hide-"+index).hide();
                });
	   	   });
	   	  
	   	   

	   });
   </script>
</body>
</html>