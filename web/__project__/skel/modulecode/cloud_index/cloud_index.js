
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

//1 add
function cloudindex_add_folder()
{
	ajax_async('/cloud/index/add_folder?id='+__lpvar__.cloudindex_foldid);
}
function cloudindex_add_file()
{
	ajax_async('/cloud/index/add_file?id='+__lpvar__.cloudindex_foldid);
}
//1 delete
function cloudindex_delete(ids,name)
{

	var msg='确定删除?'

	if(name)
	{
		msg+='<br>'+name;
	}

	ui_confirm(msg,function()
	{
		ajax_async('/cloud/index/delete?ids='+ids);
	});

}
function cloudindex_delete_bat(_this)
{

	_this=$(_this);

	var ids=__lpwidget__.tablelist.tl_getvalue(_this.closest('[__skelmodule__=skelmodule]').find('[__tablelist__=tablelist]'));

	if(ids.length)
	{

		var msg='确定删除?'
		msg+='<br>共'+ids.length+'项';

		ui_confirm(msg,function()
		{
			ajax_async('/cloud/index/delete?ids='+ids.toString());
		});


	}
	else
	{
		ui_toast('请选择需要操作的项目');
	}

}

//1 move
function cloudindex_move_1(_this)
{
	ajax_async('/cloud/index/move_1?id='+__lpvar__.cloudindex_foldid);
}
function cloudindex_move_bat(_this)
{

	_this=$(_this);

	var ids=__lpwidget__.tablelist.tl_getvalue(_this.closest('[__skelmodule__=skelmodule]').find('[__tablelist__=tablelist]'));

	if(ids.length)
	{
		ajax_async('/cloud/index/move?ids='+ids.toString());
	}
	else
	{
		ui_toast('请选择需要操作的项目');
	}

}
//1 order
function cloudindex_order(_this)
{

	_this=$(_this);

	ajax_async('/cloud/index/order',
		{
			order:_this.val()
		});

}

