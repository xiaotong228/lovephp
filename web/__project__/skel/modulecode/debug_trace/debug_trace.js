
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


function debugtrace_delete(dnas,name)
{

	var msg='确定删除?'

	if(name)
	{
		msg+='<br>'+name;
	}

	ui_confirm(msg,function()
	{

		ajax_async(__lpvar__.route_routeinfo.controller_rooturl+'/delete',
			{
				dnas:dnas
			});

	});

}

function debugtrace_delete_bat(_this)
{

	_this=$(_this);

	var dnas=__lpwidget__.tablelist.tl_getvalue(_this.closest('[__skelmodule__=skelmodule]').find('[__tablelist__=tablelist]'));

	if(dnas.length)
	{

		var msg='确定删除?'
		msg+='<br>共'+dnas.length+'项';

		ui_confirm(msg,function()
		{
			ajax_async(__lpvar__.route_routeinfo.controller_rooturl+'/delete',
				{
					dnas:dnas.toString()
				});
		});


	}
	else
	{
		ui_toast('请选择需要操作的项目');
	}

}

