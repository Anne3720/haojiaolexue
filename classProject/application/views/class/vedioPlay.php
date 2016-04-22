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
<!-- svg icons -->
<svg aria-hidden="true" style="display: none;" >
    <symbol id="icon-play" width="24" height="24" viewBox="0 0 24 24" x="320" y="0">
        <path fill="#00f" d="M4 21v-18l15 9zM15.109 12l-9.109-5.469v10.938z"></path>
    </symbol>
    <symbol id="icon-pause" width="24" height="24" viewBox="0 0 24 24" x="360" y="0">
        <path fill="#00f" d="M16 3q1.242 0 2.121 0.879t0.879 2.121v12q0 1.242-0.879 2.121t-2.121 0.879-2.121-0.879-0.879-2.121v-12q0-1.242 0.879-2.121t2.121-0.879zM8 3q1.242 0 2.121 0.879t0.879 2.121v12q0 1.242-0.879 2.121t-2.121 0.879-2.121-0.879-0.879-2.121v-12q0-1.242 0.879-2.121t2.121-0.879zM8 5q-0.414 0-0.707 0.293t-0.293 0.707v12q0 0.414 0.293 0.707t0.707 0.293 0.707-0.293 0.293-0.707v-12q0-0.414-0.293-0.707t-0.707-0.293zM16 5q-0.414 0-0.707 0.293t-0.293 0.707v12q0 0.414 0.293 0.707t0.707 0.293 0.707-0.293 0.293-0.707v-12q0-0.414-0.293-0.707t-0.707-0.293z"></path>
    </symbol>
    <symbol id="icon-expand2" width="16" height="16" viewBox="0 0 16 16" x="0" y="80">
        <path fill="#00f" d="M5.574 8.994l-3.29 3.29-1.284-1.284c-0.553 0-1 0.447-1 1v3c0 0.553 0.447 1 1 1h3c0.553 0 1-0.447 1-1l-1.284-1.283 3.29-3.291-1.432-1.432zM15 0h-3c-0.553 0-1 0.448-1 1l1.284 1.284-3.29 3.29 1.432 1.432 3.29-3.29 1.284 1.284c0.553 0 1-0.447 1-1v-3c0-0.552-0.447-1-1-1zM15 11l-1.284 1.284-3.29-3.29-1.432 1.432 3.29 3.291-1.284 1.283c0 0.553 0.447 1 1 1h3c0.553 0 1-0.447 1-1v-3c0-0.553-0.447-1-1-1zM5 1c0-0.552-0.447-1-1-1h-3c-0.553 0-1 0.448-1 1v3c0 0.553 0.447 1 1 1l1.284-1.284 3.29 3.29 1.432-1.432-3.29-3.29 1.284-1.284z"></path>
    </symbol>
    <symbol id="icon-contract" width="24" height="24" viewBox="0 0 24 24" x="200" y="40">
        <path fill="#00f" d="M17 1q0.414 0 0.707 0.293t0.293 0.707v3q0 0.414 0.293 0.707t0.707 0.293h3q0.414 0 0.707 0.293t0.293 0.707-0.293 0.707-0.707 0.293h-3q-1.242 0-2.121-0.879t-0.879-2.121v-3q0-0.414 0.293-0.707t0.707-0.293zM2 16h3q1.242 0 2.121 0.879t0.879 2.121v3q0 0.414-0.293 0.707t-0.707 0.293-0.707-0.293-0.293-0.707v-3q0-0.414-0.293-0.707t-0.707-0.293h-3q-0.414 0-0.707-0.293t-0.293-0.707 0.293-0.707 0.707-0.293zM7 1q0.414 0 0.707 0.293t0.293 0.707v3q0 1.242-0.879 2.121t-2.121 0.879h-3q-0.414 0-0.707-0.293t-0.293-0.707 0.293-0.707 0.707-0.293h3q0.414 0 0.707-0.293t0.293-0.707v-3q0-0.414 0.293-0.707t0.707-0.293zM19 16h3q0.414 0 0.707 0.293t0.293 0.707-0.293 0.707-0.707 0.293h-3q-0.414 0-0.707 0.293t-0.293 0.707v3q0 0.414-0.293 0.707t-0.707 0.293-0.707-0.293-0.293-0.707v-3q0-1.242 0.879-2.121t2.121-0.879z"></path>
</symbol>
</svg>
<div class="video">
    <div class="container">
    <div class="videoPlay">    
        <video width="600" height="450" poster="" controls="controls" preload="none">
            <!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
            <source type="video/mp4" src="<?php echo($resourceUrl);?>/resource/Video/<?php echo ($Video);?>" />
            <!-- WebM/VP8 for Firefox4, Opera, and Chrome -->
            <source type="video/webm" src="<?php echo($resourceUrl);?>/resource/Video/<?php echo ($Video);?>" />
            <!-- Ogg/Vorbis for older Firefox and Opera versions -->
            <source type="video/ogg" src="<?php echo($resourceUrl);?>/resource/Video/<?php echo ($Video);?>" />
            <!-- Optional: Add subtitles for each language -->
            <track kind="subtitles" src="subtitles.srt" srclang="en" />
            <!-- Optional: Add chapters -->
            <track kind="chapters" src="chapters.srt" srclang="en" />
            <!-- Flash fallback for non-<span class="wp_keywordlink_affiliate"><a href="http://www.dglives.com/        tag/html5" title="查看HTML5中的全部文章" target="_blank">HTML5</a></span> browsers without         JavaScript -->
            <object width="600" height="450" type="application/x-shockwave-flash" data="flashmediaelement.swf">
                <param name="movie" value="flashmediaelement.swf" />
                <param name="flashvars" value="controls=true&file=<?php echo($resourceUrl);?>/resource/Video/<?php echo ($Video);?>" />
            <!-- Image as a last resort -->
                <img src="myvideo.jpg" width="600" height="450" title="No video playback capabilities" />
            </object>
        </video>      
    </div> 
    </div>
   
    <div class="videoContent">
        <span class="desc"><strong>课程名称: </strong><?php echo ($Name);?></span>
        <span><strong>课程内容: </br></strong></span>
        <span class="desc"> <?php echo ($Desc);?></span>
        <span><strong>主讲老师: </strong><?php echo ($Teacher);?></span>
        <span class="desc" style="font-family: 'Microsoft YaHei';">课程优惠价：<?php echo "&yen; "; echo ($Price);?></span>
        <span class="time">更新时间:<?php echo ($UpdateTime);?></span>
    </div>   
</div>



<?php include('/../footer.php');?>