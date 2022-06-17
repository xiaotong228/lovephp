
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.smsvcode=new function()
{

	this.sv_frozentime_tick_timerid=0;

	this.sv_frozentime_tick_start=function()
	{
		clearTimeout(this.sv_frozentime_tick_timerid);
		this.sv_frozentime_tick_timerid=setTimeout(function()
		{

			var _list=$('[__smsvcode__=smsvcode]');

			var _startagain=false;

			_list.each(function()
			{

				var _this=$(this);
				var status=_this.attr('smsvcode_status');

				if('frozen'==status)
				{
					var num=int_intval(_this.find('[smsvcode_role=frozentime]').html());

					num--;

					_this.find('[smsvcode_role=frozentime]').html(num);

					if(num>0)
					{
						_startagain=true;
					}
					else
					{
						_this.removeAttr('smsvcode_status');
					}

				}
			});

			if(_startagain)
			{
				__lpwidget__.smsvcode.sv_frozentime_tick_start();
			}

		},1000);

	};

};

_document.on('click','[__smsvcode__=smsvcode] [smsvcode_role=sendbtn]',function()
{

	var _this=$(this);

	var _dad=_this.closest('[__smsvcode__=smsvcode]');

	var _ajaxform=_this.closest('[__ajaxform__=ajaxform]');

	var action=_dad.attr('smsvcode_action');

	var _config=_dad.data_getconfig('smsvcode');

	var postdata=false;

	if(_ajaxform.length)
	{
		_ajaxform.find('[ajaxform_role=fieldz]').removeAttr('ajaxform_status');
		postdata=_ajaxform.serialize_object();
		postdata['@ajaxform_submit']=1;
	}

	ajax_async(__lpconfig__.vcode_smsvcode_url+'?action='+action,postdata,
		function(data)
		{

			_dad.attr('smsvcode_status','frozen');
			_dad.find('[smsvcode_role=frozentime]').html(data.smsvcode_frozentime);

			if(data.smsvcode_message)
			{
				ui_toast(data.smsvcode_message);
			}

			__lpwidget__.smsvcode.sv_frozentime_tick_start();

		},
		function(data)
		{
			if(_ajaxform.length)
			{
				__lpwidget__.ajaxform.af_errorhandle(_ajaxform,data);
			}
		});
});

