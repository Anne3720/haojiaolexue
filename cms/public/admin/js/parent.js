function parent_327()
{
	/* 取未处理 */
	$.get('/zpadmin/api/fqa/json_get_fqa_is_dis_count?is_dis=0',function(data){
		$("#s_menu_344").append('<span style="color:red">'+data.msg+'</span>');
	},'json')

	$.get('/zpadmin/api/fqa/json_get_fqa_is_dis_count?is_dis=1',function(data){
		$("#s_menu_345").append('<span style="color:red">'+data.msg+'</span>');
	},'json')

	$.get('/zpadmin/api/fqa/json_get_fqa_is_dis_count?is_good=1',function(data){
		$("#s_menu_343").append('<span style="color:red">'+data.msg+'</span>');
	},'json')

	$.get('/zpadmin/api/fqa/json_get_fqa_is_dis_count',function(data){
		$("#s_menu_334").append('<span style="color:red">'+data.msg+'</span>');
	},'json')
	
}