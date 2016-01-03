<?php include('/../header.php');?>
<link rel="stylesheet" href="/../../../public/css/classList.css" type="text/css" />
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
                    <li class="course-nav-item on" id="course-nav-item-<?php echo($uu)?>">
                    <a href="#" ><?php echo($vv);?></a>
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
                        <a href="#" grade="<?php echo($vv['Grade']);?>" class="courseClass" id="course-<?php echo($vv['SubjectID']);?>" > <?php echo($vv['Title']);?></a> 
                    </li>
                    <?php }?>
                    <?php }?>    
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
<!--script文件-->
<script type="text/javascript" src="/public/js/classListNav.js"></script>
<?php include('/../footer.php');?>