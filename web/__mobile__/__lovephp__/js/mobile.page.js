
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



//1 page

var mobile_page_switch_lock=false;

function mobile_page_open(url,postdata=false)
{

	if(mobile_page_switch_lock)
	{
		console_log_wreckage('44','lovephp/0312/4244/mobile_page_switch_lock/return');
		return;
	}

	mobile_page_switch_lock=true;

	ajax_async(url,postdata,false,false,
		{
			ajax_on_complete_before:function(data)
			{
				if(
					data['@'+__lpconfig__.returncode.mobile_returncode_openpage]||
					data['@'+__lpconfig__.returncode.mobile_returncode_openmodal]
				)
				{//是正常的新页面数据

				}
				else
				{
					mobile_page_switch_lock=false;
				}
			},
			ajax_on_error:function()
			{
				mobile_page_switch_lock=false;
			}

		});

};
function mobile_page_open_data(_ajaxdata)
{

	var __oldpage=mobile_history_get_currentpage();

	var __oldpage_attr={};

	var __newpage=$(_ajaxdata.mobilepage_newpage_set.newpage_html);

	var __newpage_attr={};

	var __newpage_url=__newpage.attr('mobilepage_url');

	if(mobile_history_has_url(__newpage_url))
	{
		if(-1==__newpage_url.indexOf('?'))
		{
			__newpage_url=__newpage_url+'?'+math_salt_js();
		}
		else
		{
			__newpage_url=__newpage_url+'&'+math_salt_js();
		}

		__newpage.attr('mobilepage_url',__newpage_url);
	}

	if(1)
	{

		if(_ajaxdata.mobilepage_oldpage_set.oldpage_position_to)
		{
			__oldpage_attr.mobilepage_position=_ajaxdata.mobilepage_oldpage_set.oldpage_position_to;
		}
		else
		{

		}

		if(_ajaxdata.mobilepage_oldpage_set.oldpage_mask)
		{
			__oldpage.attr('mobilepage_showmask','showmask_step_0').show();
			__oldpage_attr.mobilepage_showmask='showmask_step_1';
		}

		__oldpage.attr(__oldpage_attr);

	}

	if(1)
	{//newpage

		mobile_app_statusbar_setstyle(__newpage.attr('mobilepage_statusbarstyle'));

		__newpage.attr('mobilepage_position',_ajaxdata.mobilepage_newpage_set.newpage_position_from);

		__newpage_attr=
			{
				mobilepage_position:'position_fullfill',
				mobilepage_position_from:_ajaxdata.mobilepage_newpage_set.newpage_position_from,
			};

		_mobileroot.append(__newpage);

		__newpage.show().ani_attr
			(

				__newpage_attr,

				function()
				{

					mobile_page_switch_lock=false;

					__oldpage.trigger(mpe_historypush);

					__newpage.trigger(mpe_create);

					if(_ajaxdata.mobilepage_oldpage_set.oldpage_removehistory)
					{
						hash_replace(__newpage_url);
						__oldpage.remove();
					}
					else
					{
						hash_set(__newpage_url);
					}

		        }

			);

	}

}

function mobile_page_close()
{//纯页面处理,_sethash没有用到

	if(mobile_page_switch_lock)
	{
		console_log_wreckage('44','lovephp/0312/4244/mobile_page_switch_lock/return');
		return;
	}

	mobile_page_switch_lock=true;

	var history_pages=mobile_history_get_allpages();

	if(history_pages.length<=1)
	{
		console_log_wreckage('40','lovephp/0322/3940/mobile_page_close/不应该出现');
		return;
	}

	var __oldpage=history_pages.eq(history_pages.length-2);
	var __oldpage_attr={};

	var __newpage=mobile_history_get_currentpage();
	var __newpage_position_from=__newpage.attr('mobilepage_position_from');
	var __newpage_attr={};

	if(1)
	{//oldpage

		if('position_fullfill'!=__oldpage.attr('mobilepage_position'))
		{
			__oldpage_attr.mobilepage_position='position_fullfill';
		}
		if('showmask_step_1'==__oldpage.attr('mobilepage_showmask'))
		{//如果有蒙层
			__oldpage_attr.mobilepage_showmask='showmask_step_0';
		}

		__oldpage.ani_attr(__oldpage_attr);

	}

	if(1)
	{//newpage

		mobile_app_statusbar_setstyle(__oldpage.attr('mobilepage_statusbarstyle'));

		__newpage_attr.mobilepage_position=__newpage_position_from;
		__newpage.ani_attr(__newpage_attr,function()
		{

			mobile_page_switch_lock=false;

			if(mobile_route_back_callback)
			{
				function_call(mobile_route_back_callback);
				mobile_route_back_callback=false;
			}
			__newpage.trigger(mpe_destory);

			__newpage.remove();

			__oldpage.trigger(mpe_historypop);

			__oldpage.removeAttr('mobilepage_showmask');

			if(alp_isalp())
			{//alp模式下hash不能用

			}
			else
			{
				if(hash_get()!=__oldpage.attr('mobilepage_url'))
				{//如果没有回退到位继续回退

					setTimeout(function()
					{
						mobile_page_close();
					},300);

				}
			}

		});

	}

}
function mobile_page_refresh(_page,postdata=false)
{

	if(!postdata)
	{
		postdata={};
	}

	postdata=object_merge(postdata,
		{
			'@mobilepage_cmd':'refresh'
		});

	var url=_page.attr('mobilepage_url');

	ajax_sync(url,postdata,function(data)
	{
		var _temp=$(data.mobilepage_newpage_set.newpage_html);

		_page.html(_temp.html());

		_page.trigger(mpe_refresh);

	});

};

//1 history
function mobile_history_get_allpages()
{

	var list=$('[__mobilepage__=mobilepage]');

	return list;

}

function mobile_history_get_length()
{

	return mobile_history_get_allpages().length;

}

function mobile_history_get_currentpage()
{

	var list=mobile_history_get_allpages();
	return list.eq(list.length-1)

}
function mobile_history_get_allurls()
{
	var urls=[];

	var list=mobile_history_get_allpages();

	list.each(function()
	{
		urls.push($(this).attr('mobilepage_url'));
	});

	return urls;

}

function mobile_history_get_currenturl()
{

	var page=mobile_history_get_currentpage();

	var hash=page.attr('mobilepage_url');

	if(hash)
	{
		return hash;
	}
	else
	{
		return '';
	}

}

function mobile_history_has_url(url)
{

	var urls=mobile_history_get_allurls();
	return -1==urls.indexOf(url)?false:true;

}

//1 modal
function mobile_modal_open_data(_ajaxdata)
{

	$('[__mobilemodal__=mobilemodal]').remove();

	var _modal=$(_ajaxdata.modal_html);

	mobile_history_get_currentpage().append(_modal);
	var ani=_modal.attr('mobilemodal_ani');

	if('none'==ani)
	{
		_modal.show().attr({'mobilemodal_status':'fadein'});
		mobile_page_switch_lock=false;
	}
	else
	{
		_modal.show().ani_attr({'mobilemodal_status':'fadein'},function()
			{
				mobile_page_switch_lock=false;
			});
	}

}

function mobile_modal_close(_this)
{
	var ani=_this.attr('mobilemodal_ani');
	if('none'==ani)
	{
		_this.remove();
	}
	else
	{
		_this.ani_attr_remove('mobilemodal_status',function()
		{
			_this.remove();
		});
	}
}
_document.on('click','[mobilemodal_role=close]',function()
{

	var _this=$(this).closest('[__mobilemodal__=mobilemodal]');
	mobile_modal_close(_this);

});


//1 右滑关闭
if(client_is_app_js())
{//对于从右往左打开的页面,可以右滑关闭,只在app有效

	_document.on('touchstart','[__mobilepage__=mobilepage][mobilepage_position=position_fullfill][mobilepage_position_from=position_right100]',function(event)
	{

		var _dragbox=$(this);

		var touchend_callback=false;

		var gesture_limittime=500;//ms,右滑退出的操作需要在特定时间内完成
		var gesture_starttime=time_ms_js();

		var gesture_cancel=function()
		{
			_dragbox.removeAttr('mobilepage_lockscroll');
			touchend_callback=false;
		};

		setTimeout(function()
			{
				gesture_cancel();
			},gesture_limittime);

		touchevent_regist(_dragbox[0],event.originalEvent,function(__event,__posinfo,__movecount)
		{

			var offset_x=__posinfo.pos_offset.x;
			var offset_x_abs=Math.abs(offset_x);

			if(client_is_iphone_js())
			{//实测苹果手机的event.preventDefault();阻止不了内部元素的滚动,这里锁定下滚动

				_dragbox.attr('mobilepage_lockscroll','lockscroll');

			}

			if(time_ms_js()-gesture_starttime>gesture_limittime)
			{
				gesture_cancel();
				return cmd_touchevent_stoppropagation|cmd_touchevent_stoppropagation|cmd_touchevent_unregist;
			}
			else
			{

				if(offset_x_abs>_window.window_width_cache*__lpconfig__.widget_swiper_triggerswitchratio)
				{
					touchend_callback=function()
						{
							_dragbox.removeAttr('mobilepage_lockscroll');
							mobile_route_back();
						};
				}
				else
				{
					touchend_callback=false;
				}

				return cmd_touchevent_stoppropagation|cmd_touchevent_stoppropagation;

			}

		},
		function()
		{
			if(touchend_callback)
			{
				touchend_callback();
				return cmd_touchevent_stoppropagation;
			}
		},'x+');

	});
}

