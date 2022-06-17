
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



__lpwidget__.popupmenu=new function()
{
//1 open
	this.pm_open=function(event,url,postdata=false)
	{

		var pos=
		{
			x:event.clientX,
			y:event.clientY
		};

		ajax_async(url,postdata,function(data)
			{
				if(data)
				{
					__lpwidget__.popupmenu.pm_open_html(pos,data);
				}
			});

	};

	this.pm_open_html=function(pos,inhtml)
	{

		if(!inhtml)
		{
			inhtml='';
		}

		__lpwidget__.popupmenu.pm_close();

		var html='';
		html+='<div __popupmenu__=popupmenu>';
			html+=inhtml;
		html+='</div>';

		var _popupmenu=$(html);

		_body.append(_popupmenu);

		_popupmenu.css(
		{
			left:pos.x+'px',
			top:pos.y+'px',
		});//.show();//不用show,下面的dompos_get也可以获取到尺寸

		if(1)
		{//超出屏幕显示区域,调整下
			var ajust_x=false;
			var ajust_y=false;
			var css_obj={};
			var _this_pos=_popupmenu.dompos_get();

			if((pos.x+_this_pos.outer_width)>_window.width())
			{
				ajust_x=true;
			}

			if((pos.y+_this_pos.outer_height)>_window.height())
			{
				ajust_y=true;
			}

			if(ajust_x||ajust_y)
			{
				if(ajust_x)
				{
					css_obj.left='auto';
					css_obj.right='10px';
				}
				if(ajust_y)
				{
					css_obj.top='auto';
					css_obj.bottom='10px';
				}
				_popupmenu.css(css_obj);
			}
		}

		_body.append(_popupmenu);

		_popupmenu.show();//append之后再show否则无效

		_document.one('click scroll',__lpwidget__.popupmenu.pm_close);

	};
//1 close
	this.pm_close=function()
	{

		console_log_wreckage('46','lovephp/0428/popupmenu_close_newpopupmenu_close_newpopupmenu_close_new');
		$('[__popupmenu__=popupmenu]').remove();
		_document.off('click scroll',__lpwidget__.popupmenu.pm_close);
	};

};

_document.on('click','[__popupmenu__=popupmenu] [popupmenu_role=menu]',function(event)
{//点击menu会关闭,点击其他会停止冒泡

	__lpwidget__.popupmenu.pm_close();

});
_document.on('click','[__popupmenu__=popupmenu]',function(event)
{

	event.stopPropagation();

});

