
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
function ui_toast(txt)
{

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
//1 alert
function ui_alert(txt,yes_cb=false,btn_yes_txt=false,confirm_isconfirm=false,btn_no_txt=false)
{

	if(!btn_yes_txt)
	{
		btn_yes_txt='确定'
	}

	if(!btn_no_txt)
	{
		btn_no_txt='取消'
	}

	if(array_isarray(txt))
	{
		if(client_is_mobile_js())
		{
			txt=txt.join("\n");
		}
		else
		{
			txt=txt.join("<br>");
		}
	}

	if(client_is_mobile_js())
	{
		alert(txt);
		if(yes_cb)
		{
			function_call(yes_cb,this);
		}
	}
	else
	{

		var dna_yes=math_salt_js();
		var dna_no=math_salt_js();

		var inhtml='';

		inhtml+='<div __uialert__=uialert __uimask__=uimask>';

			inhtml+='<div uialert_role=viewzone>';
				inhtml+='<div uialert_role=content>';
					inhtml+=txt;
				inhtml+='</div>';

				inhtml+='<div uialert_role=operz>';

					inhtml+='<div uialert_role=btn_yes id='+dna_yes+' >';
						inhtml+=btn_yes_txt;
					inhtml+='</div>';
					if(confirm_isconfirm)
					{
						inhtml+='<div uialert_role=btn_no id='+dna_no+' >';
							inhtml+=btn_no_txt;
						inhtml+='</div>';

					}

				inhtml+='</div>';

			inhtml+='</div>';

		inhtml+='</div>';

		$('[__uialert__=uialert]').remove();

		_body.append(inhtml);

		$('#'+dna_yes).on('click',function(event)
			{

				if(yes_cb)
				{
					function_call(yes_cb,this);
				}

				$(this).closest('[__uimask__=uimask]').remove();

			});
		if(confirm_isconfirm)
		{
			$('#'+dna_no).on('click',function(event)
				{
					$(this).closest('[__uimask__=uimask]').remove();
				});
		}

	}

}
//1 confirm
function ui_confirm(txt,yes_cb,btn_yes_txt,btn_no_txt)
{
	ui_alert(txt,yes_cb,btn_yes_txt,1,btn_no_txt);
}
