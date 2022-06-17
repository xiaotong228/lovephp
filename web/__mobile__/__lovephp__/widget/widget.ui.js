
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

//1 window
function ui_window_open(inhtml,cls,sty,tail)
{

 	cls=cls?cls:'';
	sty=sty?sty:'';
	tail=tail?tail:'';

	var dna=math_salt_js();

	var html='';

	html+='<div __uiwindow__=uiwindow __uimask__=uimask>';
		html+='<div uiwindow_role=viewzone class="'+cls+'" style="'+sty+'" '+tail+' >';
			html+=inhtml;
		html+='</div>';
	html+='</div>';

	if(0)
	{
		ui_window_close_all();
	}

	_body.append(html);

}

function ui_window_close(_this)
{
	_this.remove();
}
function ui_window_close_all()
{
	$('[__uiwindow__=uiwindow]').remove();
}

_document.on('click','[__uiwindow__=uiwindow] [uiwindow_role=close]',function()
{

	var _this=$(this).closest('[__uiwindow__=uiwindow]');
	ui_window_close(_this);

});

//1 toast
var ui_toast_back=ui_toast;
function ui_toast(txt)
{

	if(client_is_app_js()&&client_is_plus_js())
	{
		if(array_isarray(txt))
		{
			txt=txt.toString();
		}
		txt=br2nl_js(txt);
		plus.nativeUI.toast(txt);
	}
	else
	{//和pc那边一样

		var max_num=5;

		var currentmap=[];
		for(let i=0;i<max_num;i++)
		{
			currentmap[i]=false;
		}

		var _list=$('[__uitoast__=uitoast][uitoast_status=fadein]');
		_list.each(function(index)
			{
				currentmap[int_intval($(this).attr('uitoast_index'))]=true;
			});

		var dest_index=0;
		for(let i in currentmap)
		{
			if(!currentmap[i])
			{
				dest_index=i;
				break;
			}
		}

		var inhtml='';
		inhtml+='<div __uitoast__=uitoast uitoast_index='+dest_index+'>';
			inhtml+='<span>';
				inhtml+=txt;
			inhtml+='</span>';
		inhtml+='</div>';

		var _toast=$(inhtml);

		_body.append(_toast);

		_toast.show();

		_toast.attr('uitoast_status','fadein');

		setTimeout(function()
		{
			_toast.ani_attr({'uitoast_status':'fadeout'},function()
			{
				_toast.remove();
			});

		},2000);

	}

}
//1 alert
function ui_alert(txt,yes_cb=false,btn_yes_txt=false,confirm_isconfirm=false,btn_no_txt=false)
{
	console_log_wreckage('07','lovephp/0128/5207');

	if(array_isarray(txt))
	{
		txt=txt.toString();

	}
	txt=br2nl_js(txt);

	alert(txt);

	if(yes_cb)
	{
		function_call(yes_cb);
	}

	return;

}
//1 confirm
function ui_confirm(txt,yes_cb,btn_yes_txt,btn_no_txt)
{
	console_log_wreckage(29,'lovephp/0128/5229');
	if(array_isarray(txt))
	{
		txt=txt.toString();
	}
	txt=br2nl_js(txt);

	if(confirm(txt))
	{
		function_call(yes_cb);
	}

}
