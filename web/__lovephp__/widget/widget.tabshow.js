
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.tabshow=new function()
{

	this.ts_switchframe_switch=function(_item)
	{
		var index=_item.index();

		var _this=_item.closest('[__tabshow__=tabshow]');

		var _config=_this.data_getconfig('tabshow');

		_item.attr('tabshow_navstatus','active').siblings().removeAttr('tabshow_navstatus');

		var _frame=_this.find('[tabshow_role=viewzone]').children().eq(index);

		_frame.show().siblings().hide();

		if(_config.tabshow_frame_activecallback)
		{
			function_call(_config.tabshow_frame_activecallback,_frame,index);
		}
	}

};

(function()
	{

		const temp0=function(_this)
		{
			var _this=$(_this);

			if('active'==_this.attr('tabshow_navstatus'))
			{
				console_log_wreckage(42,'lovephp/0126/4242/active');
				return;
			}

			__lpwidget__.tabshow.ts_switchframe_switch(_this);
		};

		_document.on('click','[__tabshow__=tabshow][tabshow_triggertype!=mouse] [tabshow_role=nav] >*',function()
		{

			temp0(this);
		});

		_document.on('mouseenter','[__tabshow__=tabshow][tabshow_triggertype=mouse] [tabshow_role=nav] >*',function()
		{
			temp0(this);
		});

	})();

