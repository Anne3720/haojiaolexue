$(document).ready(function(){
	   	   
	   	$(".navleft-content").each(function(index){	   
	   	   	$(".navleft-content").attr({
	   	   	    id:function(index,oldValue){
                    return 'navleft-content-'+index;
	   	   	    }
	   	   	});
	   	    $(".navleft-hide").attr({
	   	        id:function(index,oldValue){
                    return 'navleft-hide-'+index;
	   	        }
	   	    });
	   	$('#navleft-content-'+index).hover(
	   	    function(){
	   	 	   $("#navleft-hide-"+index).show();
	   	    },  	   	  
            function(){
               $("#navleft-hide-"+index).hide();
        });
	});  
});