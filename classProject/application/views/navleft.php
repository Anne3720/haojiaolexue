<div class="navleft">
	   <ul>
		<div class="navleft-tittle"><a href="/classes/classlist">全部课程分类</a></div>
		<div class="navleft-content">
		    <li>高中</li>
		    <li class="grade">
		    	<?php foreach ($grade['high'] as $key => $value) {?>
		        <a href="classes/classlist?grade=<?php echo($key);?>"><?php echo($value);?></a>
		    	<?php }?>
		    </li>
		    <div class="navleft-hide">
		       <dl>
		       	<?php foreach ($grade['high'] as $key => $value) {?>
  					<dt><a href="classes/classlist?grade=<?php echo($key);?>"><?php echo($value);?></a></dt>
					<dd>
						<?php foreach ($subject[$key] as $v) {?>
						<a href="classes/classlist?grade=<?php echo($key);?>&subject=<?php echo($v['SubjectID']); ?>"><?php echo($v['Title']);?></a>
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
		        <a href="classes/classlist?grade=<?php echo($key);?>"><?php echo($value);?></a>
		    	<?php }?>
		    </li>
		    <div class="navleft-hide">
		       <dl>
		       	<?php foreach ($grade['middle'] as $key => $value) {?>
  					<dt><a href="classes/classlist?grade=<?php echo($key);?>"><?php echo($value);?></a></dt>
					<dd>
						<?php foreach ($subject[$key] as $v) {?>
						<a href="classes/classlist?grade=<?php echo($key);?>&subject=<?php echo($v['SubjectID']); ?>"><?php echo($v['Title']);?></a>
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
		        <a href="classes/classlist?grade=<?php echo($key);?>"><?php echo($value);?></a>
		    	<?php }?>
		    </li>
		    <div class="navleft-hide">
		       <dl>
		       	<?php foreach ($grade['primary'] as $key => $value) {?>
  					<dt><a href="classes/classlist?grade=<?php echo($key);?>"><?php echo($value);?></a></dt>
					<dd>
						<?php foreach ($subject[$key] as $v) {?>
						<a href="classes/classlist?grade=<?php echo($key);?>&subject=<?php echo($v['SubjectID']); ?>"><?php echo($v['Title']);?></a>
						<?php } ?>
					</dd>
  		       	<?php }?>
		       </dl>
	        </div>	
        </div>
		
	  </ul>
    </div>