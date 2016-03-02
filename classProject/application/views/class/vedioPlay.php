<?php include('/../header.php');?> 
<link rel="stylesheet" href="/../../../public/css/vedioPlay.css" type="text/css" />
<div class="vedio">
    <div class="reback">
    	<a href="#" onClick="javascript :history.back(-1);">返回</a>
    </div>
	<div class="vedioPlay"> 
	    <video class="vedioPlayBox" src="http://www.cms.com/resource/Video/<?php echo ($Video);?>" controls autobuffer></video>   
	    <!--
	    <script src="http://html5media.googlecode.com/svn/trunk/src/html5media.min.js"></script> 
	    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="624" height="351" style="margin-top: -10px;margin-left: -8px;" id="FLVPlayer1"> 
            <param name="movie" value="FLVPlayer_Progressive.swf" /> 
            <param name="quality" value="high" /> 
            <param name="wmode" value="opaque" /> 
            <param name="scale" value="noscale" /> 
            <param name="salign" value="lt" /> 
            <param name="FlashVars" value="&amp;MM_ComponentVersion=1&amp;skinName=public/swf/Clear_Skin_3&amp;streamName=public/video/test&amp;autoPlay=false&amp;autoRewind=false" /> 
            <param name="swfversion" value="8,0,0,0" /> 
           <!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 --> 
         <!-- <param name="expressinstall" value="expressInstall.swf" /> 
            </object> -->
	</div>
    <div class="vedioContent">
    	<span>课程名称</span>
    	<span>课程内容</span>
    	<span>主讲老师</span>
    	<span></span>
    </div>
</div>
