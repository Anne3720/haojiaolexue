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
	
    <div class="navtop"></div>
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
                    <li class="course-nav-item on">
                        高中
                    </li>
                    <?php foreach($grade['high'] as $key=>$value){ ?>
                    <li class="course-nav-item on">                       
                        <a href="classList?grade=<?php echo($key)?>"><?php echo($value);?></a>
                    </li>
                    <?php } ?>
                    
                    <li class="course-nav-item on">
                        初中
                    </li>
                    <?php foreach($grade['middle'] as $key=>$value){ ?>
                    <li class="course-nav-item on">                       
                        <a href="classList?grade=<?php echo($key)?>"><?php echo($value);?></a>
                    </li>
                    <?php } ?>
                    <li class="course-nav-item on">
                        小学
                    </li>
                    <?php foreach($grade['primary'] as $key=>$value){ ?>
                    <li class="course-nav-item on">                       
                        <a href="classList?grade=<?php echo($key)?>"><?php echo($value);?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="course-nav-row clearfix">
            <span class="hd 1">科目:</span>
            <div class="bd">
                <ul class="">
                    <?php foreach($subject[$key] as $value){ ?>
                    <li class="course-nav-item on">                       
                        <a href="classList?subject=<?php echo($value['SubjectID'])?>&grade=<?php echo($key);?>&page="><?php echo($value['Title']);?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
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