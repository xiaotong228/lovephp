
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.sliderbox=new function()
{

//1 init
	this.sb_init=function(_dad)
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

			if(__lpwidget__.sliderbox.sb_regist)
			{
				__lpwidget__.sliderbox.sb_regist();
				__lpwidget__.sliderbox.sb_regist=false;
			}

			_list.each(function()
				{
					var _this=$(this);
					__lpwidget__.sliderbox.sb_autoplay_start($(this),1);

					var _inditems=_this.find('[sliderbox_role=ind]').children();
					_inditems.eq(0).attr('sliderbox_ind_status','active').siblings().removeAttr('sliderbox_ind_status');

				});

			_list.attr('sliderbox_inited','yes');

		}

	};

	this.sb_regist=function()
	{
		const temp0=function(_this,dir)
			{
				var _widget=$(_this).closest('[__sliderbox__=sliderbox]');
				__lpwidget__.sliderbox.sb_switchframe_switch(_widget,dir);
				__lpwidget__.sliderbox.sb_autoplay_start(_widget);
			};

		_document.on('click','[__sliderbox__=sliderbox] [sliderbox_role=prev]',function()
		{
			temp0(this,cmd_slider_prev);
		});
		_document.on('click','[__sliderbox__=sliderbox] [sliderbox_role=next]',function()
		{
			temp0(this,cmd_slider_next);
		});

		const temp1=function()
			{

				var _this=$(this);
				var _widget=_this.closest('[__sliderbox__=sliderbox]');
				__lpwidget__.sliderbox.sb_switchframe_switch(_widget,_this.index());
				__lpwidget__.sliderbox.sb_autoplay_start(_this);
			};

		_document.on('click','[__sliderbox__=sliderbox][sliderbox_triggertype=click] [sliderbox_role=ind] >*',temp1);
		_document.on('mouseenter','[__sliderbox__=sliderbox][sliderbox_triggertype=mouse] [sliderbox_role=ind] >*',temp1);

	};
//1 autoplay
	this.sb_autoplay_stop=function(_widget)
	{

		var temp=int_intval(_widget.attr('sliderbox_autoplay_timerid'));
		clearInterval(temp);
		_widget.attr('sliderbox_autoplay_timerid',0);

	};
	this.sb_autoplay_start=function(_widget,regist_hoverstop)
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
					__lpwidget__.sliderbox.sb_switchframe_switch(_widget,cmd_slider_next);
				}
				else
				{
					console_log_wreckage('29','lovephp/0505/4029/autoplay/stop');
					clearInterval(autoplay_timerid);
				}

			},_config.sliderbox_autoplay_delaytime);

			_widget.attr('sliderbox_autoplay_timerid',autoplay_timerid);

			if(regist_hoverstop&&_config.sliderbox_autoplay_hoverstop)
			{

				_widget.on('mouseenter',function()
					{
						__lpwidget__.sliderbox.sb_autoplay_stop(_widget);
					});

				_widget.on('mouseleave',function()
					{
						__lpwidget__.sliderbox.sb_autoplay_start(_widget);
					});

			}

		}

	};
//1 switchframe
	this.sb_switchframe_switch=function(_this,dest_index)
	{

		var frame_num=int_intval(_this.attr('sliderbox_frame_num'));

		var current_index=int_intval(_this.attr('sliderbox_frame_index'));

		var _config=_this.data_getconfig('sliderbox');

		if(cmd_slider_prev==dest_index)
		{
			dest_index=current_index-1;
		}
		else if(cmd_slider_next==dest_index)
		{
			dest_index=current_index+1;
		}
		else
		{

		}

		dest_index=int_intval(dest_index);

		dest_index=Math.min(dest_index,frame_num);
		dest_index=Math.max(dest_index,-1);

		var dest_index_final=dest_index;

		if(dest_index<=-1)
		{
			dest_index_final=frame_num-1;
		}
		else if(dest_index>=frame_num)
		{
			dest_index_final=0;

		}
		else
		{

		}

		var _framewrap=_this.find('[sliderbox_role=framewrap]');
		_framewrap.css('transition-duration',_config.sliderbox_ani_switchtime+'ms');

		var _inditems=_this.find('[sliderbox_role=ind]').children();
		_inditems.eq(dest_index_final).attr('sliderbox_ind_status','active').siblings().removeAttr('sliderbox_ind_status');

		if(_config.sliderbox_ani_switchtime>0&&current_index!=dest_index)
		{

			_this.ani_attr({'sliderbox_frame_index':dest_index},function()
				{
					if(dest_index_final!=dest_index)
					{
						_framewrap.css('transition-duration','0ms');
						_this.attr('sliderbox_frame_index',dest_index_final);
					}
				});

		}
		else
		{
			_this.attr('sliderbox_frame_index',dest_index_final);

		}

	};

};

_document.ready(function()
{

	__lpwidget__.sliderbox.sb_init();

	mo_watch_add(function(_dad)
	{
		__lpwidget__.sliderbox.sb_init(_dad);
	});

});

