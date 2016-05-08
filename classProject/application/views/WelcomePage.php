<?php include('header.php');?>    
<link rel="stylesheet" href="/public/css/foucs.css" type="text/css" />
<div class="clear"></div>
   
<div class="focus">
        <div class="focus-wrap" id="focus-wrap">
            <ul id="pic">
              <li> <img src="/public/img/01.jpg" >
                  
              </li>
              <li> <img  src="/public/img/02.jpg" >
                  
              </li>
              <li> <img  src="/public/img/03.jpg" >
                  
              </li>
              
            </ul>
            <ol id="list">
              <li class="on"></li>
              <li></li>
              <li></li>
              
            </ol>
        </div>
</div>	
<script type="text/javascript">
		window.onload=function(){
			var wrap=document.getElementById('focus-wrap');
			    pic=document.getElementById('pic');
                lists=document.getElementById('list').getElementsByTagName('li');
                index=0;
                timer=null;
                function auto(){
                	timer=setInterval(function auto(){
                	index++;
                	if(index>=lists.length){
                		index=0;
                	}
                	change(index);
                },4000);
               }
                
                auto();
                function change(curIndex){
                    pic.style.marginTop=-600*curIndex+'px';
                    for(var n=0;n<lists.length;n++){
                    	lists[n].className='';
                    }
                    lists[curIndex].className="on";
                    index=curIndex;
                }
                /*wrap.onmouseover=function(){
                    	clearInterval(timer);
                    }
                wrap.onmouseout=auto;*/
                for (var i = 0; i < lists.length; i++) {
                    	lists[i].id=i;
                    	lists[i].onmouseover=function(){
                            change(this.id);          
                        }
                    }
                
		}
	</script>
<?php include('navleft.php');?>
<div class="mainfoot"></div>
<?php include('footer.php');?>