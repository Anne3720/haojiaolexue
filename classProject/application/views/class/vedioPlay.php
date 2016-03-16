<?php include('/../header.php');?> 
<link rel="stylesheet" href="/../../../public/css/videoPlay.css" type="text/css" />
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="/../public/js/mediaelement-and-player.min.js"></script>
<script type="text/javascript">
// <![CDATA[ 
$(document).ready(function() { 
    $('video').mediaelementplayer({ 
        alwaysShowControls: true, 
        videoVolume: 'horizontal', 
        features: ['playpause','progress','volume','fullscreen'],
    });
     
}); 
// ]]>
</script>
<div class="video">
<div class="container">
    <div class="reback">
        <span class="desc"><strong>课程名称: </strong><?php echo ($Name);?></span>
    </div>
    <div class="videoPlay">    
        <video width="600" height="450" poster="" controls="controls" preload="none">
            <!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
            <source type="video/mp4" src="http://www.cms.com/resource/Video/<?php echo ($Video);?>" />
            <!-- WebM/VP8 for Firefox4, Opera, and Chrome -->
            <source type="video/webm" src="http://www.cms.com/resource/Video/<?php echo ($Video);?>" />
            <!-- Ogg/Vorbis for older Firefox and Opera versions -->
            <source type="video/ogg" src="http://www.cms.com/resource/Video/<?php echo ($Video);?>" />
            <!-- Optional: Add subtitles for each language -->
            <track kind="subtitles" src="subtitles.srt" srclang="en" />
            <!-- Optional: Add chapters -->
            <track kind="chapters" src="chapters.srt" srclang="en" />
            <!-- Flash fallback for non-<span class="wp_keywordlink_affiliate"><a href="http://www.dglives.com/        tag/html5" title="查看HTML5中的全部文章" target="_blank">HTML5</a></span> browsers without         JavaScript -->
            <object width="600" height="450" type="application/x-shockwave-flash" data="flashmediaelement.swf">
                <param name="movie" value="flashmediaelement.swf" />
                <param name="flashvars" value="controls=true&file=http://www.cms.com/resource/Video/<?php echo ($Video);?>" />
            <!-- Image as a last resort -->
                <img src="myvideo.jpg" width="600" height="450" title="No video playback capabilities" />
            </object>
        </video>      
    </div> 
    </div>
   
    <div class="videoContent">
        
        <span><strong>课程内容: </br></strong></span>
        <span class="desc"> <?php echo ($Desc);?></span>
        <span><strong>主讲老师: </strong><?php echo ($Teacher);?></span>
        <span class="desc" style="font-family: 'Microsoft YaHei';">课程优惠价：<?php echo "&yen; "; echo ($Price);?></span>
        <span class="time">更新时间:<?php echo ($UpdateTime);?></span>
    </div>
    <div class="bottom">
        
    </div>
</div>   
</div>



<?php include('/../footer.php');?>