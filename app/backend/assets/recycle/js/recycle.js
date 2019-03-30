//显示回收站
function RecycleShow(url)
{
	$.ajax({
		url : url,
		type:'get',
		dataType:'html',
		beforeSend:function(){
			$(".masklayer").css("height", $(document).height()).show();
			$(".loading4").show();
			$("#recycle").show();
			$("#recycle .list").html('<div class="loading">列表加载中...</div>');
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			$.notify(XMLHttpRequest.responseText, 'error');
		},
		success:RecycleDone
	});
}

//隐藏回收站
function RecycleHide()
{
	$("#recycle").hide();
	$(".masklayer").css("height",$(document).height()).show();
	$(".loading4").show();
	
	//刷新列表
	location.reload();
}

//回收站选择所有
function RecycleCheckAll(value)
{
	$("#recycle input[type='checkbox'][name^='checkid'][disabled!='true']").attr("checked",value);
}

//单选操作
function Recycle(url, _this)
{
	var id = $(_this).data('id');
	$.ajax({
		url : url,
		type: "post",
		data: {id: id},
		dataType:"html",
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			$.notify(XMLHttpRequest.responseText, 'error');
		},
		success:RecycleDone
	});
}

//多选操作
function RecycleCheck(url)
{
	var ids = '';

	$("#recycle input[type='checkbox'][id^='checkid']:checked").each(function(){
		ids += $(this).val() + ',';
	});

	ids = ids.slice(0,-1);
	if(ids=='')
	{
		$.notify('没有任何选中信息！', 'warn');
		return false;
	}
	
	$.ajax({
		url : url,
		type: "post",
		data: {ids: ids},
		dataType:"html",
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			$.notify(XMLHttpRequest.responseText, 'error');
		},
		success:RecycleDone
	});
}

//清空操作
function RecycleEmpty(url)
{
	$.ajax({
		url : url,
		type: "post",
		dataType:"html",
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			$.notify(XMLHttpRequest.responseText, 'error');
		},
		success:RecycleDone
	});
}

//完成操作
function RecycleDone(data)
{
	$("#recycle .list").html(data);
}

//操作所有
function RecycleResetAll(url)
{
	var ids = '';

	$("#recycle input[type='checkbox'][id^='checkid']:checked").each(function(){
		ids += $(this).val() + ',';
	});

	ids = ids.slice(0,-1);
	if(ids=='' && action!='empty')
	{
		$.notify('没有任何选中信息！', 'warn');
		return false;
	}

	$.ajax({
		url : url,
		type: "get",
		dataType:"html",
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			$.notify(XMLHttpRequest.responseText, 'error');
		},
		success:RecycleDone
	});
}