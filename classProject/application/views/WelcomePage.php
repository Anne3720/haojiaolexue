<?php include('header.php');?>    
    <div class="navcenter">
	    <ul>
		    <li></li>
		    <li></li>
		    <li></li>
		    <li></li>
		    <li></li>
	    </ul>
	</div>
	<div class="navleft">
	   <ul>
		<div class="navleft-tittle"><a href="/Classes/classList">全部课程分类</a></div>
		<div class="navleft-content">
		    <li>高中</li>
		    <li class="grade">
		    	<?php foreach ($grade['high'] as $key => $value) {?>
		        <a href=""><?php echo($value);?></a>
		    	<?php }?>
		    </li>
		    <div class="navleft-hide">
		       <dl>
		       	<?php foreach ($grade['high'] as $key => $value) {?>
  					<dt><a href="#"><?php echo($value);?></a></dt>
					<dd>
						<?php foreach ($subject[$key] as $v) {?>
						<a href="Classes/classList?grade=<?php echo($key);?>"><?php echo($v['Title']);?></a>
						<?php } ?>
					</dd>
  		       	<?php }?>
		       </dl>
	        </div>
        </div>
        <div class="navleft-content">
            <li>初中</li>
		    <li class="grade">
		    	<?php foreach ($grade['middle'] as $key => $value) {?>
		        <a href=""><?php echo($value);?></a>
		    	<?php }?>
		    </li>
		    <div class="navleft-hide">
		       <dl>
		       	<?php foreach ($grade['middle'] as $key => $value) {?>
  					<dt><a href="#"><?php echo($value);?></a></dt>
					<dd>
						<?php foreach ($subject[$key] as $v) {?>
						<a href="Classes/classList?grade=<?php echo($key);?>"><?php echo($v['Title']);?></a>
						<?php } ?>
					</dd>
  		       	<?php }?>
		       </dl>
	        </div>
        </div>
        <div class="navleft-content">
        	<li>小学</li>	
		    <li class="grade">
		    	<?php foreach ($grade['primary'] as $key => $value) {?>
		        <a href=""><?php echo($value);?></a>
		    	<?php }?>
		    </li>
		    <div class="navleft-hide">
		       <dl>
		       	<?php foreach ($grade['primary'] as $key => $value) {?>
  					<dt><a href="#"><?php echo($value);?></a></dt>
					<dd>
						<?php foreach ($subject[$key] as $v) {?>
						<a href="Classes/classList?grade=<?php echo($key);?>"><?php echo($v['Title']);?></a>
						<?php } ?>
					</dd>
  		       	<?php }?>
		       </dl>
	        </div>	
        </div>
		
	  </ul>
    </div>
<script type="text/javascript" src="/public/js/navLeft.js"></script>
<?php include('footer.php');?>