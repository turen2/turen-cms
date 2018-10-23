var ColorHex   = new Array('00','33','66','99','CC','FF');
var SpColorHex = new Array('FF0000','00FF00','0000FF','FFFF00','00FFFF','FF00FF');
var current    = null;
var colorTable = '';

//颜色选择器
function colorpicker(showid,fun,id2)
{
	for(i=0; i<2; i++){
		for(j=0; j<6; j++){
			colorTable = colorTable+'<tr height="11" class="nb">'
			colorTable = colorTable+'<td width="11" onmouseover="onmouseover_color(\''+showid+'\',\'000\')" onclick="select_color(\''+showid+'\',\'000\',\''+fun+'\',\''+id2+'\')" style="background-color:#000">'
			if(i == 0){
				colorTable=colorTable+'<td width="11" onmouseover="onmouseover_color(\''+showid+'\',\''+ColorHex[j]+ColorHex[j]+ColorHex[j]+'\')" onclick="select_color(\''+showid+'\',\''+ColorHex[j]+ColorHex[j]+ColorHex[j]+'\',\''+fun+'\',\''+id2+'\')" style="background-color:#'+ColorHex[j]+ColorHex[j]+ColorHex[j]+'">'
			}
			else{
				colorTable=colorTable+'<td width="11" onmouseover="onmouseover_color(\''+showid+'\',\''+SpColorHex[j]+'\')" onclick="select_color(\''+showid+'\',\''+SpColorHex[j]+'\',\''+fun+'\',\''+id2+'\')" style="background-color:#'+SpColorHex[j]+'">'}
			colorTable=colorTable+'<td width="12" onmouseover="onmouseover_color(\''+showid+'\',\'000\')" onclick="select_color(\''+showid+'\',\'000\',\''+fun+'\',\''+id2+'\')" style="background-color:#000">'
			for(k=0; k<3; k++){
				for(l=0; l<6; l++){
					colorTable=colorTable+'<td width="11" onmouseover="onmouseover_color(\''+showid+'\',\''+ColorHex[k+i*3]+ColorHex[l]+ColorHex[j]+'\')" onclick="select_color(\''+showid+'\',\''+ColorHex[k+i*3]+ColorHex[l]+ColorHex[j]+'\',\''+fun+'\',\''+id2+'\')"  style="background-color:#'+ColorHex[k+i*3]+ColorHex[l]+ColorHex[j]+'">'
				}
			}
		}
	}
	colorTable='<div style="position:relative;width:253px;height:176px;"><a href="javascript:;" onclick="closeBox(\''+showid+'\');" class="close-own">X</a><table width="253" border="0" cellspacing="0" cellpadding="0" style="border:1px #000 solid #000;border-bottom:none;border-collapse:collapse">'
			   +'<tr height=30><td colspan="21" bgcolor="#eeeeee">'
			   +'<table cellpadding="0" cellspacing="1" border="0" style="border-collapse:collapse">'
			   +'<tr><td width="3"><td><input type="text" name="DisColor" size="6" class="background_colorId" disabled style="border:solid 1px #000;background:#ffff00"></td>'
			   +'<td width="3"><td><input type="text" name="HexColor" size="7" class="input_colorId" style="border:inset 1px;font-family:Arial;" value="#000000"></td><td>&nbsp;&nbsp;<a href="javascript:;" onclick="enter_title(\''+showid+'\',\''+fun+'\',\''+id2+'\');" title="确认自定义颜色">[确定]</a>&nbsp;<a href="javascript:;" onclick="clear_title(\''+fun+'\', \''+id2+'\');" title="清除设定的标题颜色">[清除]</a></td></tr></table></td></table>'
			   +'<table border="1" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="000000">'
			   +colorTable+'</table></div>';
	
	$('#'+showid).css({'position':'absolute','z-index':'999','top':'25px'});
	$('#'+showid).html(colorTable);
	colorTable = '';
}

//鼠标经过颜色
function onmouseover_color(showid, color)
{
	var color = '#'+color;
	$('#'+showid+' .background_colorId').css('background-color',color);
	$('#'+showid+' .input_colorId').val(color);
}

//选取颜色
function select_color(showid,color,fun,id2)
{
	var color = '#'+color;
	onmouseover_color(showid, color);
	if(fun) {
		$('#'+fun).val(color);
		$('#'+id2).css('color',color);
	}
	$('#'+showid).html('');
}

//关闭选色板
function closeBox(showid)
{
	$('#'+showid).html('');
}

//加粗选择器
function blodpicker(id,id2)
{
	if($('#'+id).val() == 'bold') {
		$('#'+id).val('normal');
		$('#'+id2).css('font-weight','');
	} else {
		$('#'+id).val('bold');
		$('#'+id2).css('font-weight','bold');
	}
}

//清除颜色
function clear_title(colorval, title)
{
	$('#'+colorval).val('');
	$('#'+title).css("color","");
}

//输入自定义颜色
function enter_title(showid, colorval, title)
{
	var color = $('#'+showid+' .input_colorId').val();
	$('#'+colorval).val(color);
	$('#'+title).css("color",color);
}

//清除属性ok
function clearpicker(colorval, boldval, title)
{
	$('#'+colorval).val('');
	$('#'+boldval).val('');
	$('#'+title).css({'font-weight':'normal','color':''})
}