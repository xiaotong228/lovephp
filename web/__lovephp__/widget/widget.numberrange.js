
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.numberrange=new function()
{


//1 init
	this.nr_init=function(_dad)
	{

		var _list;

		if(_dad)
		{
			_list=_dad.find_includeself('[__numberrange__=numberrange][numberrange_inited!=yes]');
		}
		else
		{
			_list=$('[__numberrange__=numberrange][numberrange_inited!=yes]');
		}

		if(_list.length)
		{

			if(__lpwidget__.numberrange.nr_regist)
			{
				__lpwidget__.numberrange.nr_regist();
				__lpwidget__.numberrange.nr_regist=false;
			}

			_list.attr('numberrange_inited','yes');

		}

	};
	this.nr_regist=function()
	{

		console_log('01','lovephp/0509/0601/nr_regist');

		_document.on('click','[__numberrange__=numberrange] [numberrange_role=dec]',function()
		{

			var _this=$(this);

			var status=_this.attr('numberrange_status');

			if('disable'==status)
			{
				return;
			}

			var _widget=_this.closest('[__numberrange__=numberrange]');

			__lpwidget__.numberrange.nr_number_plus(_widget,-1);

		});

		_document.on('click','[__numberrange__=numberrange] [numberrange_role=inc]',function()
		{

			var _this=$(this);

			var status=_this.attr('numberrange_status');

			if('disable'==status)
			{
				return;
			}

			var _widget=_this.closest('[__numberrange__=numberrange]');

			__lpwidget__.numberrange.nr_number_plus(_widget,1);

		});

		_document.on('blur','[__numberrange__=numberrange] input',function()
		{

			clearTimeout(__lpwidget__.numberrange.nr_input_timeid);

			var _this=$(this);

			var _widget=_this.closest('[__numberrange__=numberrange]');

			__lpwidget__.numberrange.nr_number_plus(_widget,0);

		});

		_document.on('input','[__numberrange__=numberrange] input',function()
		{

			var _this=$(this);

			var _widget=_this.closest('[__numberrange__=numberrange]');

			clearTimeout(__lpwidget__.numberrange.nr_input_timeid);

			__lpwidget__.numberrange.nr_input_timeid=setTimeout(
				function()
				{

					_this.blur();

				},1000);

		});
	};

//1 input
	this.nr_input_timeid=0;

	this.nr_number_plus=function(_this,plusnum)
	{

		var _input=_this.find('input');

		var currentvalue=_input.val();

		var _config=_this.data_getconfig('numberrange');

		var temp=parseInt(currentvalue);

		if(isNaN(temp))
		{
			currentvalue=_config.numberrange_default;
		}

		currentvalue=int_intval(currentvalue);

		currentvalue=currentvalue+plusnum;

		currentvalue=Math.max(currentvalue,_config.numberrange_min);
		currentvalue=Math.min(currentvalue,_config.numberrange_max);

		_input.val(currentvalue);

		if(_config.numberrange_min==currentvalue)
		{
			_this.find('[numberrange_role=dec]').attr('numberrange_status','disable');
		}
		else
		{
			_this.find('[numberrange_role=dec]').removeAttr('numberrange_status');
		}
		if(_config.numberrange_max==currentvalue)
		{
			_this.find('[numberrange_role=inc]').attr('numberrange_status','disable');
		}
		else
		{
			_this.find('[numberrange_role=inc]').removeAttr('numberrange_status');
		}
		if(_config.numberrange_callback)
		{
			function_call(_config.numberrange_callback,_this,currentvalue);
		}

	};
};

_document.ready(function()
{

	__lpwidget__.numberrange.nr_init();

	mo_watch_add(function(_dad)
	{
		__lpwidget__.numberrange.nr_init(_dad);
	});

});

