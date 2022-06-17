
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.scrollappend=new function()
{

//1 init
	this.sa_init=function(_dad)
	{

		var _list;

		if(_dad)
		{
			_list=_dad.find_includeself('[__scrollappend__=scrollappend][scrollappend_inited!=yes]');
		}
		else
		{
			_list=$('[__scrollappend__=scrollappend][scrollappend_inited!=yes]');
		}

		if(_list.length)
		{
			_list.on('scroll',function(event)
			{

				var _this=$(this);

				var scroll_info=_this.scrollpos_get();

				var current_status=_this.attr('scrollappend_status');

				var _config=_this.data_getconfig('scrollappend');

				if(
					'loading'==current_status||
					'nomoredata'==current_status
				)
				{
					console_log_wreckage('26','lovephp/0307/4526');
					return;
				}

				if(scroll_info.remain_y<__lpwidget__.scrollappend.sa_trigger_remainy_px)
				{

					var postdata=false;

					if(_config.scrollappend_getpostdata)
					{
						postdata=function_call(_config.scrollappend_getpostdata,_this);
						console_log_wreckage('34','lovephp/0307/4534',postdata);
					}

					_this.attr('scrollappend_status','loading');

					ajax_async(_config.scrollappend_loadurl,postdata,function(data)
						{

							_this.append(data.scrollappend_html);

							if(data.scrollappend_nomoredata)
							{
								_this.attr('scrollappend_status','nomoredata');
							}
							else
							{
								_this.removeAttr('scrollappend_status');
							}

						},
						false,
						{
							ajax_on_error:function()
							{
								console_log_wreckage('57','lovephp/0221/3557');
								_this.removeAttr('scrollappend_status');
							}

						});
				}

			});

			_list.attr('scrollappend_inited','yes');

		}

	};

	this.sa_trigger_remainy_px=5;//不能为0,有的手机由于浮点计算的问题不能完全到底为0,偏移量表示距离滚动到底部还有多少距离是开始加载

};

_document.ready(function()
{

	__lpwidget__.scrollappend.sa_init();

	mo_watch_add(function(_dad)
	{
		__lpwidget__.scrollappend.sa_init(_dad);
	});

});

