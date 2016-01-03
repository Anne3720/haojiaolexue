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
                    <li class="course-nav-item">
                        <a href="/Classes/classList">全部</a>
                    </li>
                    <?php foreach($grade as $u=>$v){ ?>
                    <?php foreach($v as $uu=>$vv){ ?>
                    <li class="course-nav-item <?php if(isset($_GET['grade'])&&$_GET['grade']==$uu) echo("on");?>" >
                    <a href="/Classes/classList?grade=<?php echo($uu)?>" ><?php echo($vv);?></a>
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
                    <li class="course-nav-item">
                        <a href="classList" >全部</a>
                    </li>
                    <?php if(isset($_GET['grade'])&&!empty($_GET['grade'])){
                        foreach ($subject as $u => $v) {
                            if($_GET['grade']==$u){
                                foreach ($v as $uu => $vv) { ?>
                            <li class="course-nav-item course-nav-item0-<?php echo($vv['Grade'])?> <?php if(isset($_GET['subject'])&&$_GET['subject']==$vv['SubjectID']) echo("on");?>">
                            <a href="/Classes/classList?grade=<?php echo($vv['Grade']);?>&subject=<?php echo($vv['SubjectID']);?>" > <?php echo($vv['Title']);?></a> 
                            </li>
                    <?php  }}}}?>    
                </ul>
            </div>
        </div>
    </div>  
    <div class="classShow">
  	    <div class="classShowNav">
        <?php foreach ($classList as $u => $v) {
              foreach ($v as $uu => $vv) {?>
            <a href="/Classes/classList/<?php echo($u);?>?grade=<?php echo($vv['Grade']);?>&class=<?php echo($vv['ClassID']);?>&subject=<?php echo($vv['SubjectID']);?>">
                <span>
                    <img src="" alt="" />
                    <p><?php echo($vv['SubjectID']); ?></p>
                </span>
            </a>     
        <?php }} ?>   		
     	</div>
    </div>

    <div class="classListPage">
        <ul>
            <li>
            <?php echo($page_links);?>
            </li>
        </ul>
    </div>
   
  
<!--script文件-->
<!--script type="text/javascript" src="/public/js/classListNav.js"></script-->
<?php include('/../footer.php');?>