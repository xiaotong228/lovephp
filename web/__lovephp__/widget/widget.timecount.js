
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

__lpwidget__.timecount=new function()
{

//1 public
	this.tc_restart=function(_this,time)
	{//涉及到tc_timetick_timerid是否已经启动的问题,只有事先已经启动过计时器才能restart

		time=int_intval(time);

		if(time<=0)
		{
			console_log_wreckage('54','lovephp/0507/2154/不对');
			return;
		}

		var id=_this.attr('timecount_id');

		var _config=_this.data_getconfig('timecount');

		_config.timecount_timeend=time_server_js()+time;

		_this.data_setconfig('timecount',_config);

		_this.find('[timecount_role=day],[timecount_role=hour],[timecount_role=min],[timecount_role=sec]').html('');

		_this.removeAttr('timecount_status');

	};

//1 private
	this.tc_init=function(_dad)
	{

		var _list;

		if(_dad)
		{
			_list=_dad.find_includeself('[__timecount__=timecount][timecount_inited!=yes]');
		}
		else
		{
			_list=$('[__timecount__=timecount][timecount_inited!=yes]');
		}

		if(_list.length)
		{

			_list.each(function()
				{
					var _this=$(this);

					var _config=_this.data_getconfig('timecount');

					var id=_this.attr('timecount_id');

					if(!id)
					{
						id=math_salt_js();
						_this.attr('timecount_id',id);
					}
				});

			_list.attr('timecount_inited','yes');

			if(!this.tc_timetick_timerid)
			{
				this.tc_timetick_timerid=setInterval(this.tc_timetick,1000);
			}

		}

	};
//1 timetick
	this.tc_timetick_timerid=0;
	this.tc_timetick=function()
	{

		var _list=$('[__timecount__=timecount][timecount_inited=yes]');

		_list.each(function()
			{

				var _this=$(this);

				var _config=_this.data_getconfig('timecount');

				var second_num;

				if('inc'==_config.timecount_dir)
				{//正计时
					second_num=time_server_js()-_config.timecount_timebegin;
				}
				else if('dec'==_config.timecount_dir)
				{//倒计时
					second_num=_config.timecount_timeend-time_server_js();
				}
				else
				{
					console_log_wreckage('41','lovephp/0507/4041/不对');
				}

				var timecount_status=_this.attr('timecount_status');

				if('end'==timecount_status)
				{
					console_log_wreckage('57','lovephp/0507/1057/end');
					return;
				}

				second_num=Math.max(second_num,0);

				if(second_num<=0)
				{

					if('end'!=timecount_status)
					{
						if(_config.timecount_timeend_callback)
						{
							_this.attr('timecount_status','end');
							function_call(_config.timecount_timeend_callback,_this);
						}
					}

				}

				var _temp=false;

				if(1)
				{
					_temp=_this.find('[timecount_role=day]')
					if(_temp.length)
					{
						let num=int_intval(second_num/(60*60*24));
						_temp.html(num);
						second_num-=num*60*60*24;
					}
				}

				if(1)
				{
					_temp=_this.find('[timecount_role=hour]')
					if(_temp.length)
					{
						let num=int_intval(second_num/(60*60));
						_temp.html((num<10?'0'+num:num));
						second_num-=num*60*60;
					}
				}

				if(1)
				{
					_temp=_this.find('[timecount_role=min]')
					if(_temp.length)
					{
						let num=int_intval(second_num/(60));
						_temp.html((num<10?'0'+num:num));
						second_num-=num*60;
					}
				}

				if(1)
				{
					_temp=_this.find('[timecount_role=sec]')
					if(_temp.length)
					{
						let num=second_num;
						_temp.html((num<10?'0'+num:num));
					}

				}

			});

	};

};

_document.ready(function()
{
	__lpwidget__.timecount.tc_init();

	mo_watch_add(function(_dad)
	{
		__lpwidget__.timecount.tc_init(_dad);
	});

});

