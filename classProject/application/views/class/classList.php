<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
	<title>好教乐学</title>
	<link rel="stylesheet" href="/public/css/classList.css" type="text/css" />
    <link rel="stylesheet" href="/public/css/main.css" type="text/css" />
    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body>
<div class="box">
	
    <div class="navtop">
        <span class="navtop-logo">好教乐学</span>
        <?php if(!$_SESSION['userInfo']){ ?>
        <ul>
            <li><a href="../User/login" >登录</a></li>
            <li><a href="../User/reg" >注册</a></li>
        </ul>
        <?php }else{ ?>
        <ul>
            <li><a href="../User/doLogout" >退出</a></li>
        </ul>
        <?php } ?>
    </div>
    <div class="course-nav">
        <div class="course-nav-hd">
            <span>全部课程</span>
        </div>
        <div class="course-nav-row clearfix">
            <span class="hd 1">年级:</span>
            <div class="bd">
                <ul class="">
                    <li class="course-nav-item on">
                        <a href="classList">全部</a>
                    </li>
                    <?php foreach($grade as $u=>$v){ ?>
                    <?php foreach($v as $uu=>$vv){ ?>
                    <li class="course-nav-item on">                       
                        <a href="classList?grade=<?php echo($uu)?>" id="course-nav-item-<?php echo($uu)?>"  ><?php echo($vv);?></a>
                    </li>
                    <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="course-nav-row clearfix">
            <span class="hd 1">科目:</span>
            <div class="bd">
                <ul class="">
                    <li class="course-nav-item on">
                        <a href="classList">全部</a>
                    </li>
                    
                    <?php foreach ($subject as $u => $v) {?>
                    <?php foreach ($v as $uu => $vv) {?>
                    <li class="course-nav-item on course-nav-item0-<?php echo($vv['Grade'])?>">
                        <a href="classList?grade=<?php echo($vv['Grade']);?>&classid=<?php echo($vv['SubjectID']);?>" > <?php echo($vv['Title']);?></a> 
                    </li>
                    <?php }?>
                    <?php }?>    
                </ul>
            </div>
        </div>
    </div>  

    <script type="text/javascript">
       $(document).ready(function(){
           
            $(".course-nav-item").each(function(index){ 
                    
                $('#course-nav-item-'+index).click(
                  function(event){

                    $.ajax({
                        type:"POST",
                        url:"classList?grade="+index,
                        dataType:"JSON",
                        success:function(data){
                        },
                        error:function(jqXHR){
                        }
                    }); 
                  for (i=1;i<$('.course-nav-item').length;i++){
                     if (i==index) {
                        $('.course-nav-item0-'+i).show();
                        $('#course-nav-item-'+i).css('background','red');
                    }else{
                        $('.course-nav-item0-'+i).hide();
                        $('#course-nav-item-'+i).css('background','');
                    }
                 }


                  event.stopPropagation();
                  event.preventDefault();
                });
           });
       });            
   </script>  
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
     	</div>
    </div>
</div>

</body>
</html>