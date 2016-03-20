       $(document).ready(function(){
           
            $(".course-nav-item").each(function(index){ 
                   var index=index+1; 
                $('#course-nav-item-'+index).click(
                  function(event){

                  
                  for (i=1;i<=$('.course-nav-item').length;i++){
                     if (i==index) {
                        $('.course-nav-item0-'+i).show();
                        $('#course-nav-item-'+i).css('background','red');
                    }else{
                        $('.course-nav-item0-'+i).hide();
                        $('#course-nav-item-'+i).css('background','');
                    }
                 }
                  event.stopPropagation();
                });
            });
            $(".courseClass").each(function(index){
              var index=index+1; 
                $(".course-nav-item").each(function(j){ 
                  var j=j+1;  
                $('.course-nav-item0-'+j+' #course-'+index).click(
                  function(event){
                
                  for (i=1;i<=$('.courseClass').length+1;i++){
                     if (i==index) {
                        
                        $('#course-'+i).css('background','red');
                    }else{
                        
                        $('#course-'+i).css('background','');
                    }
                 }
                  event.stopPropagation();
                });
              });
            });
       });


