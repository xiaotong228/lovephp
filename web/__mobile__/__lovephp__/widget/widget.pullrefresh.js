
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

__lpwidget__.pullrefresh=new function()
{

	this.pr_closeindbox_delaytime=1000;

	this.pr_dragoffsety_triggerefresh_mpx=180;
	this.pr_dragoffsety_triggerefresh_px=false;
	this.pr_dragoffsety_max_px=false;


	this.pr_refresh_delaytime=500;
	this.pr_refresh_silent=function(_widget)
	{
		var _config=_widget.data_getconfig('pullrefresh');

		var _dragbox=_widget.find('[pullrefresh_role=dragbox]');

		_widget.attr('pullrefresh_status','refreshing_silent');

		ajax_async(_config.pullrefresh_refreshurl,'',function(data)
			{
				if(_dragbox.length)
				{
					_dragbox.replaceWith(data.pullrefresh_html);
				}
				else
				{
					_widget.html(data.pullrefresh_html);
				}
			},
			false,
			{
				ajax_on_complete:function()
				{
					_widget.removeAttr('pullrefresh_status');
				}
			});

	};

};

_document.on('touchstart','[__pullrefresh__=pullrefresh] [pullrefresh_role=dragbox]',function(event)
{

	var _dragbox=$(this);

	var _dragbox_scrollpos=_dragbox.scrollpos_get();

	if(_dragbox_scrollpos.y>0)
	{
		console_log_wreckage('41','lovephp/0307/4841');
		return;
	}

	var _widget=_dragbox.closest('[__pullrefresh__=pullrefresh]');
	var _widget_config=_widget.data_getconfig('pullrefresh');

	var currentstatus=_widget.attr('pullrefresh_status');

	if(currentstatus)
	{
		console_log_wreckage('25','lovephp/0311/3325');
		return;
	}

	_widget.removeAttr('pullrefresh_status');

	var _indbox=false;
	var _indbox_loadingring=false;
	var _indbox_successtips=false;

	var _indbox_close=function()
	{

		_widget.ani_attr({'pullrefresh_status':'close'},function()
		{

			if('refreshing'==_widget.attr('pullrefresh_status'))
			{//正在刷新时不关闭,避免卡屏,虽然概率很低,实测chrome内核下2%左右
				console_log_wreckage('17','lovephp/0809/3917/不关闭');
			}
			else
			{
				console_log_wreckage('14','lovephp/0809/3914/关闭');
				_widget.removeAttr('pullrefresh_status');
			}

			_dragbox.css('transform','');

			if(_indbox)
			{
				_indbox.remove();
			}
		});
	};

	var touchend_callback=false;

	touchevent_regist(_dragbox[0],event.originalEvent,function(__event,__posinfo,__movecount)
	{

		if(!_indbox)
		{
			if(1)
			{//按理说是和其他的pullrefresh不冲突的,但是实测svg可能出现破图,可能和svg clipPath的id有关系吧,直接全部移除吧
				$('[pullrefresh_role=indbox]').remove();
			}
			else
			{
				_widget.find('[pullrefresh_role=indbox]').remove();
			}
			var temphtml='';

			temphtml+='<div pullrefresh_role=indbox>';

				temphtml+='<div pullrefresh_role=indbox_loadingring>';
				temphtml+='<?php
					$temp=string_remove_nl(fs_file_read_xml('./assets/img/ring/ring.pullrefreshloading.svg'));
					$temp=str_replace('\'','"',$temp);
					echo $temp;
					?>';
			//'

				temphtml+='</div>';

				temphtml+='<div pullrefresh_role=indbox_successtips style="display:none;" >';
				temphtml+='</div>';

			temphtml+='</div>';

			_indbox=$(temphtml);
			_indbox.insertBefore(_dragbox).find('svg').hide();

			_indbox_loadingring=_indbox.find('[pullrefresh_role=indbox_loadingring]');
			_indbox_successtips=_indbox.find('[pullrefresh_role=indbox_successtips]');

		}

		var offset_y=__posinfo.pos_offset.y;

		if(1)
		{//添加阻尼,手感好一些
			offset_y=offset_y/2;
		}

		offset_y=Math.max(offset_y,0);
		offset_y=Math.min(offset_y,__lpwidget__.pullrefresh.pr_dragoffsety_max_px);

		var offset_ratio=offset_y/__lpwidget__.pullrefresh.pr_dragoffsety_triggerefresh_px;
		offset_ratio=Math.max(offset_ratio,0.1);
		offset_ratio=Math.min(offset_ratio,1);

		_widget.attr('pullrefresh_status','dragging');

		_indbox_loadingring.css('transform','scale('+offset_ratio+')');

		_indbox.css('transform','translateY('+offset_y+'px)');
		_dragbox.css('transform','translateY('+offset_y+'px)');

		console_log_wreckage('08','lovephp/0424/2708',offset_y,__lpwidget__.pullrefresh.pr_dragoffsety_max_px,__lpwidget__.pullrefresh.pr_dragoffsety_triggerefresh_px);

		if(offset_y<=__lpwidget__.pullrefresh.pr_dragoffsety_triggerefresh_px)
		{
			touchend_callback=function()
			{
				_indbox_close();
			};
		}
		else if(offset_y>__lpwidget__.pullrefresh.pr_dragoffsety_triggerefresh_px)
		{

			touchend_callback=function()
			{

				_widget.attr('pullrefresh_status','refreshing');

				_indbox_loadingring.find('svg').show();

				if(0)
				{//test
					return;
				}

				setTimeout(function()
					{

						ajax_async(_widget_config.pullrefresh_refreshurl,'',function(data)
							{

								console_log_wreckage('32','lovephp/0424/2732');
								_dragbox.replaceWith(data.pullrefresh_html);
								_widget.attr('pullrefresh_status','success');
								_indbox_loadingring.hide();
								_indbox_successtips.html(data.pullrefresh_successtips).show();
								setTimeout(function()
								{
									_indbox_close();
								},__lpwidget__.pullrefresh.pr_closeindbox_delaytime);
							},
							false,
							{
								ajax_on_error:function()
								{
									console_log_wreckage('16','lovephp/0307/2616');
									_indbox_close();
								}

							});

					},__lpwidget__.pullrefresh.pr_refresh_delaytime+test____pullrefresh_delay);

			};
		}
		else
		{
			console_log_wreckage('13','lovephp/0424/xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx/不应该出现');
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
		{//保底

			_widget.removeAttr('pullrefresh_status');
			_dragbox.css('transform','');
			if(_indbox)
			{
				_indbox.remove();
			}

		}

	},'y+');

});

__lpwidget__.pullrefresh.pr_dragoffsety_triggerefresh_px=mpx_to_vw_js(__lpwidget__.pullrefresh.pr_dragoffsety_triggerefresh_mpx);
__lpwidget__.pullrefresh.pr_dragoffsety_max_px=__lpwidget__.pullrefresh.pr_dragoffsety_triggerefresh_px*2.5;

