
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


//1 picgallery
__lpwidget__.picgallery=new function()
{

//1 public
	this.pg_open=function(pics,index=0)
	{

		if(!array_isarray(pics))
		{
			pics=[pics];
		}

		mobile_page_open('/api/widgetpage_picgallery',
			{
				pics:pics,
				index:index
			});
	};

//1 private
	this.pg_realimgs_sizemap={};

	this.pg_toucheventregist_frame=function(event,_dragbox,_realimgsize)
	{
		var _dragbox_pos=_dragbox.dompos_get();

		var _img=_dragbox.find('img');
		var _img_pos_total=_img.dompos_get();

		var _realimgsize_ratio=_realimgsize.width/_realimgsize.height;

		var _img_ratio_max=(Math.max(_realimgsize.width*2,_dragbox_pos.width*2))/_img_pos_total.width;

		var _img_transformorigin_x=false;
		var _img_transformorigin_y=false;

		var _dragbox_scrollpos=_dragbox.scrollpos_get();

		var multitouch_moved=false;
		var touchend_callback=false;

		var touchend_img_adjust=function(_img11,_this_size,multitouch_end=false)
		{

			var _img_pos_temp=_img.dompos_physic();

			var _img_css_temp=css_object_append_px(_img_pos_temp);

			_img_css_temp['transform']='';
			_img.css(_img_css_temp).show();

			var scroll_x=0;
			var scroll_y=0;

			var height_back=_img_pos_temp.height;

			if(_img_pos_temp.width<_dragbox_pos.width)
			{
				_img_pos_temp.width=_dragbox_pos.width;
				_img_pos_temp.height=_img_pos_temp.width/_realimgsize_ratio;
				_img_pos_temp.x=(_dragbox_pos.width-_img_pos_temp.width)/2;
			}
			else
			{
				if(_img_pos_temp.x>0)
				{
					_img_pos_temp.x=0;
				}
			}

			if(_img_pos_temp.height>height_back&&_img_transformorigin_y)
			{//等比例返还一部分y
				_img_pos_temp.y-=(_img_pos_temp.height-height_back)*(_img_transformorigin_y/_img_pos_total.height);
			}

			if(_img_pos_temp.height<_dragbox_pos.height)
			{
				_img_pos_temp.y=(_dragbox_pos.height-_img_pos_temp.height)/2;
			}
			else
			{
				if(_img_pos_temp.y>0)
				{
					_img_pos_temp.y=0;
				}
			}

			scroll_x=-_img_pos_temp.x;
			scroll_y=-_img_pos_temp.y;

			_img_css_temp=css_object_append_px(_img_pos_temp);

			_img.ani_css_commonani(_img_css_temp,function()
			{
				_dragbox.removeAttr('picgallery_frame_multitouchdragging');
				_dragbox.scrollpos_set_x(scroll_x);
				_dragbox.scrollpos_set_y(scroll_y);

				_img.css(
				{
					left:'',
					top:'',
					'transform-origin':'',
				});

			});

		};

		touchevent_regist(_dragbox[0],event.originalEvent,function(__event,__posinfo,__movecount)
		{

			var _img_css_temp={};

			if(__posinfo.multitouch_info)
			{//双指

				if(!multitouch_moved)
				{

					multitouch_moved=true;

					_dragbox.attr('picgallery_frame_multitouchdragging','multitouchdragging');
					_dragbox.scrollpos_set_x(0);
					_dragbox.scrollpos_set_y(0);

					var orig_x,orig_y;

					if(_img_pos_total.width<=_dragbox_pos.width)
					{
						orig_x='center';
					}
					else
					{
						_img_transformorigin_x=(__posinfo.multitouch_info.te_centerpos.x-_img_pos_total.x);
					}

					if(_img_pos_total.height<=_dragbox_pos.height)
					{
						orig_y='center';
					}
					else
					{
						_img_transformorigin_y=(__posinfo.multitouch_info.te_centerpos.y-_img_pos_total.y);
					}

					_img_css_temp=css_object_append_px(_img_pos_total);
					_img_css_temp['transform-origin']=(_img_transformorigin_x?(_img_transformorigin_x+'px'):'center')+' '+(_img_transformorigin_y?(_img_transformorigin_y+'px'):'center');

				}

				_dragbox.closest('[picgallery_role=framewrap]').css('transform','');

				var ratio=__posinfo.multitouch_info.te_scaleratio;
				ratio=Math.min(ratio,_img_ratio_max);

				_img_css_temp['transform']='scale('+ratio+')';
				_img.css(_img_css_temp);

				touchend_callback=function(event)
				{
					touchend_img_adjust(_img,_dragbox_pos,true);
				};

				return cmd_touchevent_preventdefault|cmd_touchevent_stoppropagation;

			}
			else
			{

				if(multitouch_moved)
				{
					return cmd_touchevent_stoppropagation|cmd_touchevent_preventdefault;
				}

				if(0==__movecount)
				{//初次移动判断
					if('x+'==__posinfo.move_direction&&_img_pos_total.x>-1)
					{
						return cmd_touchevent_unregist;
					}
					else if('x-'==__posinfo.move_direction&&(_img_pos_total.x+_img_pos_total.width)<_dragbox_pos.width+1)
					{
						return cmd_touchevent_unregist;
					}
					else
					{

					}
				}
				if(_dragbox_scrollpos.y<1&&'y+'==__posinfo.move_direction)
				{

					return cmd_touchevent_stoppropagation|cmd_touchevent_preventdefault;

				}
				else
				{

					return cmd_touchevent_stoppropagation;

				}

			}

		},
		function()
		{

			if(touchend_callback)
			{
				touchend_callback();
			}
			else
			{//保底

			}
		});

	};

	this.pg_toucheventregist_framewrap=function(event,_dragbox)
	{//几乎和pagetabshow里面一样

		var _widget=_dragbox.closest('[__picgallery__=picgallery]');

		if(_dragbox.hasClass('__ani_common__'))
		{
			return;
		}

		var frame_index=int_intval(_widget.attr('picgallery_frame_index'));
		var frame_count=int_intval(_widget.attr('picgallery_frame_count'));

		if(frame_count<=1)
		{
			return;
		}

		var _eclipse_left=_widget.find('[picgallery_role=eclipse_left]');
		var _eclipse_right=_widget.find('[picgallery_role=eclipse_right]');

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

							var _img_src=_dragbox.find('[picgallery_role=frame]').eq(dest_index).find('img').attr('src');//.css(

							if(!__lpwidget__.picgallery.pg_realimgs_sizemap[_img_src])
							{//预加载图片尺寸

								img_load_from_url(_img_src).then(function(result)
									{
										__lpwidget__.picgallery.pg_realimgs_sizemap[_img_src]=
										{
											width:result.width,
											height:result.height
										};
									});
							}

						_dragbox.ani_css_commonani({'transform':'translateX('+translate_x+')'},function()
						{

							_dragbox.css('transform','');

							_widget.attr('picgallery_frame_index',dest_index);

							_dragbox.find('[picgallery_role=frame]').eq(frame_index).scrollpos_set_x(0).scrollpos_set_y(0).find('img').css(
								{
									width:'',
									height:'',
								});

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
			{//保底预留

				_eclipse_left.removeClass('__ani_common__').hide();
				_eclipse_right.removeClass('__ani_common__').hide();
				_dragbox.removeClass('__ani_common__').css('transform','');

			}

		},'x');

	};

};

//1 mpe
_document.on(mpe_create,'[pageroute_controller=api][pageroute_action=widgetpage_picgallery]',async function(event)
{

	var _this=$(this);

	var frame_count=int_intval(_this.attr('picgallery_frame_count'));
	var frame_index=int_intval(_this.attr('picgallery_frame_index'));

	if(!frame_count)
	{
		setTimeout(function()
		{
			ui_alert('没有图片',function()
			{
				mobile_route_back();
			});
		},__lpconfig__.mobile_page_ani_time+500);

		return;
	}

	__lpwidget__.picgallery.pg_realimgs_sizemap={};

	var _img=_this.find('[picgallery_role=frame] >img').eq(frame_index);
	var _img_src=_img.attr('src');

	var _realimg=await img_load_from_url(_img_src);
	__lpwidget__.picgallery.pg_realimgs_sizemap[_img_src]=
		{
			width:_realimg.width,
			height:_realimg.height
		};
});
_document.on(mpe_destory,'[pageroute_controller=api][pageroute_action=widgetpage_picgallery]',function(event)
{
	__lpwidget__.picgallery.pg_realimgs_sizemap={};
});
//1 eventregist
_document.on('click','[__picgallery__=picgallery] [picgallery_role=save]',function(event)
{

	var _this=$(this).closest('[__picgallery__=picgallery]');

	var index=int_intval(_this.attr('picgallery_frame_index'));

	var _img_url=_this.find('[picgallery_role=frame]').eq(index).find('img').attr('src');

	if(client_is_app_js())
	{
		mobile_app_download_pic(_img_url);
	}
	else
	{
		file_download_file(_img_url);
	}

});

_document.on('touchstart','[__picgallery__=picgallery] [picgallery_role=frame]',function(event)
{

	var _dragbox=$(this);

	var _img=_dragbox.find('img');
	var _img_src=_img.attr('src');

	var _realimg_size=__lpwidget__.picgallery.pg_realimgs_sizemap[_img_src];

	var _sink=function()
	{
		__lpwidget__.picgallery.pg_toucheventregist_frame(event,_dragbox,_realimg_size);
		__lpwidget__.picgallery.pg_toucheventregist_framewrap(event,_dragbox.closest('[picgallery_role=framewrap]'));
	};

	if(_realimg_size)
	{
		_sink();
	}
	else
	{
		img_load_from_url(_img_src).then(function(result)
			{
				_realimg_size=__lpwidget__.picgallery.pg_realimgs_sizemap[_img_src]=
					{
						width:result.width,
						height:result.height,
					};
					_sink();
			});
	}

});


