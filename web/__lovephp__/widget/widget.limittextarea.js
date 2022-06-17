
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.limittextarea=new function()
{

	this.lt_init=function(_dad)
	{

		var _list;

		if(_dad)
		{
			_list=_dad.find_includeself('[__limittextarea__=limittextarea][limittextarea_inited!=yes]');
		}
		else
		{
			_list=$('[__limittextarea__=limittextarea][limittextarea_inited!=yes]');
		}

		if(_list.length)
		{

			if(__lpwidget__.limittextarea.lt_regist)
			{
				__lpwidget__.limittextarea.lt_regist();
				__lpwidget__.limittextarea.lt_regist=false;
			}

			_list.each(function()
				{
					var _this=$(this);
					__lpwidget__.limittextarea.lt_oninput(_this.find('textarea'));
				});
			_list.attr('limittextarea_inited','yes');

		}

	};

	this.lt_regist=function()
	{
		console_log('41','lovephp/0509/2341/lt_regist');
		_document.on('input','[__limittextarea__=limittextarea] textarea',function(event)
		{

			var _this=$(this);

			__lpwidget__.limittextarea.lt_oninput(_this);

		});
	};
	this.lt_oninput=function(_this)
	{

		var _dad=_this.closest('[__limittextarea__=limittextarea]');

		var _config=_dad.data_getconfig('limittextarea');

		if(!_config.limittextarea_maxlength)
		{
			console_log_wreckage('12','lovephp/limittextarea/1712/不对劲');
		}

		var left=_config.limittextarea_maxlength-_this.val().length;

		if(left>=0)
		{

			_dad.removeAttr('limittextarea_status');
			_dad.find('[limittextarea_role=ind]').html(left);

		}
		else
		{

			_dad.attr('limittextarea_status','haserror');
			_dad.find('[limittextarea_role=ind]').html(-left);

		}

	};

};

_document.ready(function()
{

	__lpwidget__.limittextarea.lt_init();

	mo_watch_add(function(_dad)
	{
		__lpwidget__.limittextarea.lt_init(_dad);
	});

});

