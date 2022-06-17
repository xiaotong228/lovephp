
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


_document.on('click','[__pagetabshow__=pagetabshow] [pagetabshow_role=navitem]',function(event)
{

	var _item=$(this);

	var _widget=_item.closest('[__pagetabshow__=pagetabshow]');

	var _widget_config=_widget.data_getconfig('pagetabshow');

	var index=_item.index();

	var currentindex=int_intval(_widget.attr('pagetabshow_frame_index'));

	if(currentindex==index)
	{
		return;
	}

	_widget.attr('pagetabshow_frame_index',index);

	if(_widget_config.pagetabshow_switchframe_done_callback)
	{
		function_call(_widget_config.pagetabshow_switchframe_done_callback,_widget.find('[pagetabshow_role=framewrap] [pagetabshow_role=frame]').eq(index),index);
	}

});

_document.on('touchstart','[__pagetabshow__=pagetabshow] [pagetabshow_role=framewrap]',function(event)
{

	var _dragbox=$(this);

	var _widget=_dragbox.closest('[__pagetabshow__=pagetabshow]');

	var _widget_config=_widget.data_getconfig('pagetabshow');

	if(_dragbox.hasClass('__ani_common__'))
	{
		return;
	}

	var frame_index=int_intval(_widget.attr('pagetabshow_frame_index'));
	var frame_count=int_intval(_widget.attr('pagetabshow_frame_count'));

	if(frame_count<=1)
	{
		console_log_wreckage(56,'lovephp/0119/2156');
		return;
	}

	var _eclipse_left=_widget.find('[pagetabshow_role=eclipse_left]');
	var _eclipse_right=_widget.find('[pagetabshow_role=eclipse_right]');

	_eclipse_left.removeClass('__ani_common__').hide();
	_eclipse_right.removeClass('__ani_common__').hide();

	var touchend_callback=false;

	touchevent_regist(_dragbox[0],event.originalEvent,function(__event,__posinfo,__movecount)
	{

		var offset_x=__posinfo.pos_offset.x;

		var offset_x_abs=Math.abs(offset_x);

		var _eclipse_ratio=offset_x_abs/_window.window_width_cache;

		_eclipse_ratio=Math.min(_eclipse_ratio,0.2);

		if(offset_x>0&&0==frame_index)
		{
			_eclipse_left.show().removeClass('__ani_common__').css('transform','scale('+_eclipse_ratio+',1)');
			_eclipse_right.hide();

			touchend_callback=function()
			{
				_eclipse_left.ani_css_commonani({'transform':'scale(0,1)'},function()
					{
						_eclipse_left.hide();
					});
			};

		}
		else if(offset_x<0&&(frame_count-1)==frame_index)
		{

			_eclipse_left.hide();
			_eclipse_right.show().removeClass('__ani_common__').css('transform','scale('+_eclipse_ratio+',1)');

			touchend_callback=function()
			{
				_eclipse_right.ani_css_commonani({'transform':'scale(0,1)'},function()
					{
						_eclipse_left.hide();
					});
			};

		}
		else
		{

			_eclipse_left.hide();
			_eclipse_right.hide();

			_dragbox.css('transform','translateX('+offset_x+'px)');

			if(offset_x_abs<__lpconfig__.widget_swiper_triggerswitchratio*_window.window_width_cache)
			{
				touchend_callback=function()
				{

					_dragbox.ani_css_commonani({'transform':'translateX(0)'},function()
					{
						_dragbox.css('transform','');
					});

				};
			}
			else
			{

				var translate_x;
				var dest_index;

				if(offset_x<0)
				{
					translate_x='-100vw';
					dest_index=frame_index+1;
				}
				else
				{
					translate_x='100vw';
					dest_index=frame_index-1;
				}

				touchend_callback=function()
				{

					_dragbox.ani_css_commonani({'transform':'translateX('+translate_x+')'},function()
					{
						_dragbox.css('transform','');

						_widget.attr('pagetabshow_frame_index',dest_index);

						if(1)
						{//调整navitem居中显示

							var _nav=_widget.find('[pagetabshow_role=nav]');

							var _nav_pos=_nav.dompos_get();

							var _items=_nav.find('>*').children();

							var width_list=[];

							var width_total=0;

							var width_before_currentitem=0;

							var currentitem_width=0;



							_items.each(function(index)
							{

								let pos=$(this).dompos_get();
								let width=pos.outer_width;

								if(index==dest_index)
								{
									currentitem_width=width;
								}
								if(index<dest_index)
								{
									width_before_currentitem+=width;
								}

								width_list.push(width);
								width_total+=width;

							});

							var scrollto_x=width_before_currentitem+currentitem_width/2-_nav_pos.width/2;

							_nav.scrollpos_set_x(scrollto_x);

						}

						if(_widget_config.pagetabshow_switchframe_done_callback)
						{
							function_call(_widget_config.pagetabshow_switchframe_done_callback,_dragbox.children().eq(dest_index),dest_index);
						}

					});

				};

			}

		}

		return cmd_touchevent_preventdefault|cmd_touchevent_stoppropagation;

	},
	function()
	{

		if(touchend_callback)
		{
			touchend_callback();
		}
		else
		{//保底,app实测有很小几率获取不到touchend_callback

			_eclipse_left.removeClass('__ani_common__').hide();
			_eclipse_right.removeClass('__ani_common__').hide();
			_dragbox.removeClass('__ani_common__').css('transform','');

		}

	},'x');

});
