<?php include('/../header.php');?> 
<link rel="stylesheet" href="/../../../public/css/vedioPlay.css" type="text/css" />
<style type="text/css">
.vedio {
    width: 1002px;
    position: relative;
    height: 610px;
    margin: 50px auto 50px;
    background:#D7E7F4; 
    overflow: hidden;
 
}
.reback {
    overflow: hidden;
    background: #000;
    width: 100%;
    height: 40px;
    color: red;
    line-height: 40px;
}
.reback a {
    font-size: 16px;
    color: #317EF3;
}

.reback:hover a {
    color:red; 
}
.vedioPlay {
    width: 600px;
    float: left;
    padding: 20px;
    position: relative;
    overflow: hidden;
    background: #000;
    margin:20px; 
    
}
.vedioPlayBox {
    width: 600px;
    height: 450px;
}
.vedioContent {
    width: 300px;
    height: 550px;
    float: left;
    overflow: hidden;
    position: relative;
    border-left: 2px solid #000;
}
.vedioContent span {
    width: 265px;
    display:inline-block;
    padding: 20px 20px;
    word-wrap: break-word;
    font-size: 18px;
}
.vedioContent span strong {
    font-size: 18px;
}

span.time {
    font-size: 14px;
    text-align: right;
    display: block;
    color: red;
}
.bottom {
    background:#000;
    width: 100%;
    height: 40px;
    position: absolute;
    bottom: 0px;
}
</style>
<div class="vedio">
    <div class="reback">
    	<span class="desc"><strong>课程名称: </strong><?php echo ($Name);?></span>
    </div>
	<div class="vedioPlay"> 
	    <video class="vedioPlayBox" src="http://www.cms.com/resource/Video/<?php echo ($Video);?>" controls autobuffer ></video>   
	    
	</div>
    <div class="vedioContent">
    	
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