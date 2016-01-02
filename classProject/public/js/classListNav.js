       $(document).ready(function(){
           
            $(".course-nav-item").each(function(index){ 
                    
                $('#course-nav-item-'+index).click(
                  function(event){

                    $.ajax({
                        type:"POST",
                        url:"classList?grade="+index,
                        dataType:"JSON",
                        success:function(data){
                        },
                        error:function(jqXHR){
                        }
                    }); 
                  for (i=1;i<$('.course-nav-item').length;i++){
                     if (i==index) {
                        $('.course-nav-item0-'+i).show();
                        $('#course-nav-item-'+i).css('background','red');
                    }else{
                        $('.course-nav-item0-'+i).hide();
                        $('#course-nav-item-'+i).css('background','');
                    }
                 }
                  event.stopPropagation();
                  event.preventDefault();
                });
            });
            $(".courseClass").each(function(index){
                $(".course-nav-item").each(function(j){
                $('.course-nav-item0-'+j+' #course-'+index).click(
                  function(event){
                   
                    $.ajax({
                        type:"POST",
                        url:"classList?grade="+j+"&classid="+index,
                        dataType:"JSON",
                        success:function(data){
                        },
                        error:function(jqXHR){
                        }
                    }); 
                  for (i=1;i<$('.courseClass').length;i++){
                     if (i==index) {
                        
                        $('#course-'+i).css('background','red');
                    }else{
                        
                        $('#course-'+i).css('background','');
                    }
                 }
                  event.stopPropagation();
                  event.preventDefault();
                });
              });
            });
       });