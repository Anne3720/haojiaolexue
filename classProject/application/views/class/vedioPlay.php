<?php include('/../header.php');?> 
<link rel="stylesheet" href="/../../../public/css/vedioPlay.css" type="text/css" />
<div class="vedio">
    <div class="reback">
    	<a href="#" onClick="javascript :history.back(-1);"><img src="" alt=""> > 返回</a>
    </div>
	<div class="vedioPlay"> 
	    <video class="vedioPlayBox" src="http://www.cms.com/resource/Video/<?php echo ($Video);?>" controls autobuffer ></video>   
	    
	</div>
    <div class="vedioContent">
    	<span class="desc"><strong>课程名称: </strong><?php echo ($Name);?></span>
        <span><strong>课程内容: </br></strong></span>
    	<span class="desc"> <?php echo ($Desc);?></span>
    	<span><strong>主讲老师: </strong><?php echo ($Teacher);?></span>
    	<span class="desc" style="font-family: 'Microsoft YaHei';">课程优惠价：<?php echo "&yen; "; echo ($Price);?></span>
        <span class="time">更新时间:<?php echo ($UpdateTime);?></span>
    </div>
    <div class="bottom">
        
    </div>
</div>
<?php include('/../footer.php');?>