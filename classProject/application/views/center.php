
<link rel="stylesheet" href="/public/css/foucs.css" type="text/css" />
    <div class="foucs">
        <div class="col-xs-12 col-sm-12 col-md-12 ">
            
              <div id="div2">    
                <div id="div1">    
                  <ul id="ul1">    
                    <li><img src="/public/img/01.jpg">  
                    </li>    
                    <!-- <li><img src="/public/img/02.jpg">    
                      </li>    
                      <li><img src="/public/img/03.jpg">    
                      </li>    -->  
                  </ul>    
                </div>    
              </div>    
            
        </div>
    </div>
<script type="text/javascript">        
  window.onload = function ()    
   {                 
     var t,o;        
     var funny = function ()    
     {    
        o = 1;
        t && clearInterval(t);    
        t = setInterval (function ()    
        {   
            if(o > 3) {
                o = 1;
            }           
            $("#ul1").children("li").children("img").attr('src','/public/img/0' + o + '.jpg'); 
            o = o + 1;
       }, 2000);    
     }    
    funny();    
   }    
</script> 

