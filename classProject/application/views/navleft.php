<link rel="stylesheet" href="/public/css/navleft.css" type="text/css" />
 <div class="nav-wrap">  
    <div class="navleft-tittle"><a href="/classes/classlist">全部课程</a></div>
    <div class="nav">
    <div class="navleft">
	   <ul>	
		<div class="navleft-content">
		    <li>高中</li>
		    <li class="grade">
		    	<?php foreach ($grade['high'] as $key => $value) {?>
		        <a href="classes/classlist?grade=<?php echo($key);?>"><?php echo($value);?></a>
		    	<?php }?>
		    </li>
		     <div class="navleft-hide">
		       
		       	<?php foreach ($grade['high'] as $key => $value) {?>
  					<dl>
  					<dt><a href="classes/classlist?grade=<?php echo($key);?>"><?php echo($value);?></a></dt>
					<dd>
						<?php foreach ($subject[$key] as $v) {?>
						<a href="classes/classlist?grade=<?php echo($key);?>&subject=<?php echo($v['SubjectID']); ?>"><?php echo($v['Title']);?></a>
						<?php } ?>
					</dd>
					<div class="clear"></div>
					</dl>
  		       	<?php }?>
		       
	        </div> 	    
        </div>
        <div class="navleft-content">
            <li>初中</li>
		    <li class="grade">
		    	<?php foreach ($grade['middle'] as $key => $value) {?>
		        <a href="classes/classlist?grade=<?php echo($key);?>"><?php echo($value);?></a>
		    	<?php }?>
		    </li>
		    <div class="navleft-hide">
		       
		       	<?php foreach ($grade['middle'] as $key => $value) {?>
  				<dl>	
  				    <dt><a href="classes/classlist?grade=<?php echo($key);?>"><?php echo($value);?></a></dt>
					<dd>
						<?php foreach ($subject[$key] as $v) {?>
						<a href="classes/classlist?grade=<?php echo($key);?>&subject=<?php echo($v['SubjectID']); ?>"><?php echo($v['Title']);?></a>
						<?php } ?>
					</dd>
					<div class="clear"></div>
				</dl>
  		       	<?php }?>
		       
	        </div>
		</div>   
        <div class="navleft-content">
        	<li>小学</li>
		    <li class="grade">
		    	<?php foreach ($grade['primary'] as $key => $value) {?>
		        <a href="classes/classlist?grade=<?php echo($key);?>"><?php echo($value);?></a>
		    	<?php }?>
		    </li>
		    <div class="navleft-hide">
		       
		       	<?php foreach ($grade['primary'] as $key => $value) {?>
  				<dl>
  					<dt><a href="classes/classlist?grade=<?php echo($key);?>"><?php echo($value);?></a></dt>
					<dd>
						<?php foreach ($subject[$key] as $v) {?>
						<a href="classes/classlist?grade=<?php echo($key);?>&subject=<?php echo($v['SubjectID']); ?>"><?php echo($v['Title']);?></a>
						<?php } ?>
					</dd>
					<div class="clear"></div>
				</dl>
  		       	<?php }?>
		       
	        </div>
        </div>
		
	  </ul>
    </div>

           
	        
            
<div class="clear"></div>	
</div>
</div>     
<div class="clear"></div>
<!-- <script type="text/javascript" src="/public/js/navLeft.js"></script> -->
 