
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.inputdefaultfocus=new function()
{
	this.delay_time=500;


	this.idf_init=function(_dad)
	{

		var _list;

		if(_dad)
		{
			_list=_dad.find_includeself('[__inputdefaultfocus__=inputdefaultfocus][inputdefaultfocus_inited!=yes]');
		}
		else
		{
			_list=$('[__inputdefaultfocus__=inputdefaultfocus][inputdefaultfocus_inited!=yes]');
		}

		if(_list.length)
		{

			setTimeout(function()
				{
					_list.each(function()
					{

						var _this=$(this);

						_this.input_focustailcursor();

					});

				},__lpwidget__.inputdefaultfocus.delay_time);

			_list.attr('inputdefaultfocus_inited','yes');

		}

	}

};

_document.ready(function()
{

	__lpwidget__.inputdefaultfocus.idf_init();
	mo_watch_add(function(_dad)
	{
		__lpwidget__.inputdefaultfocus.idf_init(_dad);
	});

});



