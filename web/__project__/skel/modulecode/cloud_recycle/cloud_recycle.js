
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/
//1 delete
function cloudrecycle_realdelete(ids,name)
{

	var msg='确定彻底删除(不可恢复)?'

	if(name)
	{
		msg+='<br>'+name;
	}

	ui_confirm(msg,function()
	{
		ajax_async('/cloud/recycle/realdelete',{ids:ids});
	});

}
function cloudrecycle_realdelete_bat(_this)
{

	_this=$(_this);

	var ids=__lpwidget__.tablelist.tl_getvalue(_this.closest('[__skelmodule__=skelmodule]').find('[__tablelist__=tablelist]'));

	if(ids.length)
	{

		var msg='确定彻底删除(不可恢复)?'
		msg+='<br>共'+ids.length+'项';

		ui_confirm(msg,function()
		{
			ajax_async('/cloud/recycle/realdelete',{ids:ids.toString()});
		});
	}
	else
	{
		ui_toast('请选择需要操作的项目');
	}

}
function cloudrecycle_realdelete_all()
{
	ui_confirm('确定清空回收站(不可恢复)?',function()
	{
		ajax_async('/cloud/recycle/realdelete_all');
	});
}
//1 rescue
function cloudrecycle_rescue_bat(_this)
{

	_this=$(_this);

	var ids=__lpwidget__.tablelist.tl_getvalue(_this.closest('[__skelmodule__=skelmodule]').find('[__tablelist__=tablelist]'));

	if(ids.length)
	{

		var msg='即将还原到ROOT文件夹下,继续?'
		msg+='<br>共'+ids.length+'项';

		ui_confirm(msg,function()
		{
			ajax_async('/cloud/recycle/rescue',{ids:ids.toString()});
		});
	}
	else
	{
		ui_toast('请选择需要操作的项目');
	}

}

//1 order
function cloudrecycle_order(_this)
{

	_this=$(_this);

	ajax_async('/cloud/recycle/order',
		{
			order:_this.val()
		});

}

