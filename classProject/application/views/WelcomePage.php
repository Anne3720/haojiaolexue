<?php include('header.php');?>    

<div class="clear"></div>
<style type="text/css">
.clear {
	clear: both;
}
.focus{
	border:#efc8ff solid 1px;
	position:relative;
    margin-left:300px;
    height: 600px;
    top: 10px;
    width: 983px;
}

.focus-wrap{
	width: 100%;
	height: 600px;
	overflow: hidden;
	margin: 0 auto;
	position: relative;
}
.focus img {
	height: 600px;
}
.focus-warp ul{position: absolute;}
.focus-warp ul li{ position:relative;}
.pic-tit {
	color:blue;
	font-weight:bolder;
	font-family:"Times New Roman", Times, serif;
	font-size:18px;
	display:block;
	height:180px;
	text-align:center;
	vertical-align:auto;
	margin:2px auto;
    line-height: 21px;
	}
.focus-wrap ol{
	position: absolute;
	left: 480px;
	bottom: 50px;
}
.focus-wrap ol li{
	float: left;
	height: 12px;
	width: 12px;
	border-radius: 6px;
	background: #ccc;
	margin-left: 5px;
	text-align: center;
	line-height: center;
	cursor:pointer;
}
.focus-wrap ol .on {
	background:#ff0000;
}
</style>   
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
<?php include('footer.php');?>