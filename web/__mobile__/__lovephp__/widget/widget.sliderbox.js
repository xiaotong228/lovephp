
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.sliderbox=new function()
{

//1 init
	this.sb_init=function(_dad=false,only_stop=false)
	{

		var _list;

		if(_dad)
		{
			_list=_dad.find_includeself('[__sliderbox__=sliderbox][sliderbox_inited!=yes]');
		}
		else
		{
			_list=$('[__sliderbox__=sliderbox][sliderbox_inited!=yes]');
		}

		if(_list.length)
		{
			_list.each(function()
				{
					var _this=$(this);

					__lpwidget__.sliderbox.sb_autoplay_start(_this);
					if(client_is_iphone_js())
					{//苹果上面,不会显示ind小圆圈,但是触摸屏幕之后会显示,取消display:flex改成用原始的float:left也没有这个问题,可能是和他的渲染机制有关系
						var _ind=_this.find('[sliderbox_role=ind]');
						setTimeout(function()
						{
							_ind.css('transform','translateY(0.1px)').css('transform','translateY(0px)');
						},100);
					}
				});

			_list.attr('sliderbox_inited','yes');
		}

	};
//1 autoplay
	this.sb_autoplay_stop=function(_widget)
	{

		console_log_wreckage('36','lovephp/0505/3336/sb_autoplay_stop');

		var temp=int_intval(_widget.attr('sliderbox_autoplay_timerid'));
		clearInterval(temp);
		_widget.attr('sliderbox_autoplay_timerid',0);

	};
	this.sb_autoplay_start=function(_widget)
	{

		var _framewrap=_widget.find('[sliderbox_role=framewrap]');

		var _config=_widget.data_getconfig('sliderbox');

		if(_config.sliderbox_autoplay)
		{

			__lpwidget__.sliderbox.sb_autoplay_stop(_widget);

			_config.sliderbox_autoplay_delaytime=int_intval(_config.sliderbox_autoplay_delaytime);

			if(_config.sliderbox_autoplay_delaytime<1000)
			{
				console_log_wreckage('42','lovephp/0221/1742,不对,间隔时间太短了');
			}

			var autoplay_timerid=setInterval(function()
			{
				if(_widget.exist_isexist())
				{
					console_log_wreckage('03','lovephp/0505/3703/autoplay/continue');
					__lpwidget__.sliderbox.sb_switchframe_switch(_widget,1);
				}
				else
				{
					console_log_wreckage('29','lovephp/0505/4029/autoplay/stop');
					clearInterval(autoplay_timerid);
				}

			},_config.sliderbox_autoplay_delaytime);

			_widget.attr('sliderbox_autoplay_timerid',autoplay_timerid);

		}

	};
//1 switchframe
	this.sb_switchframe_switch=function(_widget,dir)
	{
		var dompos=_widget.dompos_get();

		var _dragbox=_widget.find('[sliderbox_role=framewrap]');

		var _config=_widget.data_getconfig('sliderbox');

		var dest_translateX=false;
		if(-1==dir)
		{
			dest_translateX=dompos.width;
		}
		else if(1==dir)
		{
			dest_translateX=-dompos.width;
		}
		else
		{
			console_log_wreckage('00','lovephp/1231/2308/不对,不该走这里'+JSON.stringify(0));
		}

		var to_index=int_intval(_widget.attr('sliderbox_frame_index'));

		var frame_count=int_intval(_widget.attr('sliderbox_frame_num'));

		to_index+=dir;

		if(-1==to_index)
		{
			to_index=frame_count-1;
		}
		else if(frame_count==to_index)
		{
			to_index=0;
		}
		else
		{

		}

		_dragbox.css('transition-duration',_config.sliderbox_ani_switchtime+'ms');

		_widget.attr('sliderbox_status','running');

		_dragbox.ani_css({'transform':'translateX('+dest_translateX+'px)'},function()
		{
			__lpwidget__.sliderbox.sb_switchframe_done(_widget,to_index);
		});

	};

	this.sb_switchframe_done=function(_widget,to_index=false)
	{

		_widget.removeAttr('sliderbox_status');

		_widget.find('[sliderbox_role=framewrap]').css(
			{
				'transition-duration':'',
				'transform':'',
			});

		if(false!==to_index)
		{

			_widget.find('[sliderbox_role=ind]').children().eq(to_index).attr('sliderbox_ind_status','active').siblings().removeAttr('sliderbox_ind_status');
			_widget.attr('sliderbox_frame_index',to_index);

		}

	};

};

_document.on('touchstart','[__sliderbox__=sliderbox] [sliderbox_role=framewrap]',function(event)
{
	var _dragbox=$(this);

	var _widget=_dragbox.closest('[__sliderbox__=sliderbox]');
	var _widget_config=_widget.data_getconfig('sliderbox');
	var _widget_pos=_widget.dompos_get();

	var current_status=_widget.attr('sliderbox_status');

	if(current_status)
	{//此时不做反应
		return;
	}

	var current_frame_count=int_intval(_widget.attr('sliderbox_frame_num'));
	var current_frame_index=int_intval(_widget.attr('sliderbox_frame_index'));

	var touchend_callback=false;

	__lpwidget__.sliderbox.sb_autoplay_stop(_widget);

	touchevent_regist(_dragbox[0],event.originalEvent,function(__event,__posinfo,__movecount)
	{

		var offset_x=__posinfo.pos_offset.x;

		offset_x=Math.max(offset_x,-_widget_pos.width);
		offset_x=Math.min(offset_x,_widget_pos.width);


		var offset_x_abs=Math.abs(offset_x);

		_dragbox.css('transform','translateX('+offset_x+'px)');

		if(offset_x_abs<_widget_pos.width*__lpconfig__.widget_swiper_triggerswitchratio)
		{
			touchend_callback=function()
			{
				_dragbox.css('transition-duration',_widget_config.sliderbox_ani_switchtime+'ms').ani_css
				(

					{
						'transform':'translateX(0)'
					},
					function()
					{
						__lpwidget__.sliderbox.sb_switchframe_done(_widget);
					}
				);
			};
		}
		else
		{

			var to_index=current_frame_index;

			var translateto_x=false;

			if(1)
			{
				if(offset_x<0)
				{
					to_index++;
					translateto_x=-_widget_pos.width;

				}
				else if(offset_x>0)
				{
					to_index--;
					translateto_x=_widget_pos.width;
				}
				else
				{
					console_log_wreckage('00','lovephp/1230/2315/不该走这里'+JSON.stringify(0));
				}

				if(-1==to_index)
				{
					to_index=current_frame_count-1;
				}
				else if(current_frame_count==to_index)
				{
					to_index=0;
				}
				else
				{

				}
			}

			touchend_callback=function()
			{
				_widget.attr('sliderbox_status','running');

				_dragbox.css('transition-duration',_widget_config.sliderbox_ani_switchtime+'ms').ani_css
				(
					{
						'transform':'translateX('+translateto_x+'px)'
					},
					function()
					{

						__lpwidget__.sliderbox.sb_switchframe_done(_widget,to_index);

					}
				);

			};

		}

		return cmd_touchevent_preventdefault|cmd_touchevent_stoppropagation;

	},
	function()
	{

		__lpwidget__.sliderbox.sb_autoplay_start(_widget);

		if(touchend_callback)
		{
			touchend_callback();
		}
		else
		{

			_widget.removeAttr('sliderbox_status');
			_dragbox.css(
				{
					'transition-duration':'0ms',
					'transform':'translateX(0)'
				});

		}

	},'x');

});

_document.ready(function()
{

	__lpwidget__.sliderbox.sb_init();

	mo_watch_add(function(_dad)
	{
		__lpwidget__.sliderbox.sb_init(_dad);
	});

});

