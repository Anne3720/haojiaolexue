<?php include('/../mainScript.php');?>
<?php include('/../header.php');?>
<title>好教乐学</title>
<link rel="stylesheet" href="/../../../public/css/classList.css" type="text/css" />
    <div class="course-nav">
        <div class="course-nav-hd">
            <span>全部课程</span>
        </div>
        <div class="course-nav-row ">
            <span>年级:</span>
            
                <ul class="">
                    <li class="course-nav-item <?php if(!isset($_GET['grade'])) echo("on");?>">
                        <a href="/classes/classlist">全部</a>  
                    </li>
                    <?php foreach($grade as $u=>$v){ ?>
                    <?php foreach($v as $uu=>$vv){ ?>
                    <li class="course-nav-item <?php if(isset($_GET['grade'])&&$_GET['grade']==$uu) echo("on");?>" >
                    <a href="/classes/classlist?grade=<?php echo($uu)?>&subject=0" ><?php echo($vv);?></a>
                    </li>
                    <?php }} ?>
                   
                </ul>
            
        </div>
        <div class="course-nav-row ">
            <span>科目:</span>
            
                <ul class="">
                    <li class="course-nav-item <?php if(!isset($_GET['grade']) || $_GET['subject']==0) echo("on");?>">
                    
                    <a href="/classes/classlist?grade=<?php echo ($_GET['grade']);?>&subject=0" >全部</a>
                    
                    </li>
                    <?php if(isset($_GET['grade'])&&!empty($_GET['grade'])){
                        foreach ($subject as $u => $v) {
                            if($_GET['grade']==$u){
                                foreach ($v as $uu => $vv) { ?>
                            <li class="course-nav-item  <?php if(isset($_GET['subject'])&&$_GET['subject']==$vv['SubjectID']) echo("on");?>">
                            <a href="/classes/classlist?grade=<?php echo($vv['Grade']);?>&subject=<?php echo($vv['SubjectID']);?>" > <?php echo($vv['Title']);?></a> 
                            </li>
                    <?php  }}}}?>    
                </ul>
            
        </div>
     
    <div class="course-nav-row ">
            <span>章节:</span>
            
                <ul class="courseChapter">
                    <li class="course-nav-item  <?php if(!isset($_GET['chapter']) || $_GET['chapter']==0) echo("on");?>">
                            <a href="/classes/classlist?grade=<?php echo($_GET['grade']);?>&subject=<?php echo($_GET['subject']);?>" >全部</a> 
                    </li>   
                </ul>
            
        </div>
    
    <div class="classShow">
  	    <div class="classShowNav">
        <?php if(isset($_GET['grade'])&&!empty($_GET['grade'])){
                foreach ($classList as $u => $v) {                  
                    if($_GET['grade']== $v['Grade']){ ;?>                
            <a href="/classes/video/<?php echo ($v['ClassID']);?>" target="_blank">
                <span class="className">
                    <img src="http://<?php echo($resourceUrl);?>/resource/image/<?php echo ($v['Image']);?>" alt="" />
                         
                    <p>
                    <i><?php if(!is_null($v['Price'])){
                        echo "&yen; ";echo ($v['Price']); 
                       } ?> 
                    </i>
                    <b>
                       <?php if($v['available']==1){
                           echo"已购买";
                        }elseif($v['available']==0){
                           echo"点击购买";
                        } ?> 
                    </b>
                    </p>                  
                    <ul>
                        <li><?php echo ($v['Name']); ?></li>
                        <li><?php echo ($v['Chapter']); ?></li>
                    </ul>
                </span>
            </a>     
        <?php }}} ?>         
        </div>
        <div class="classShowNav">
        <?php if(!isset($_GET['grade'])){
                foreach ($classList as $u => $v) {?>                
            <a href="/classes/video/<?php echo ($v['ClassID']);?>" >
                <span class="className">
                    <img src="http://<?php echo($resourceUrl);?>/resource/image/<?php echo ($v['Image']);?>" alt="" />
                    <p>
                    <i><?php if(!is_null($v['Price'])){
                        echo "&yen; ";echo ($v['Price']); 
                       } ?> 
                    </i>
                    <b>
                       <?php if($v['available']==1){
                           echo"已购买";
                        }elseif($v['available']==0){
                           echo"点击购买";
                        } ?> 
                    </b>
                    </p>                   
                    <ul>
                        <li><?php echo ($v['Name']); ?></li>
                        <li><?php echo ($v['Chapter']); ?></li>
                    </ul>
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
   
</div> 
<div class="clear"></div> 
<!--script文件-->
<script type="text/javascript" src="/public/js/classList.js"></script>

<?php include('/../footer.php');?>