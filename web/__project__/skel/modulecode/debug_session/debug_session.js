
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

_document.on('contextmenu','[skelmodule_name=debug_session] [lpdd_role=header]',function(event)
{

	var _this=$(this);
	__lpwidget__.popupmenu.pm_open(event,__lpvar__.route_routeinfo.controller_rooturl+'/node_menu_get?keypath='+_this.attr('lpdd_keypath'));

	return false;

});

function debugsession_add(keypath)
{
	ajax_async(__lpvar__.route_routeinfo.controller_rooturl+'/add?keypath='+keypath);
}

function debugsession_edit_key(keypath)
{
	ajax_async(__lpvar__.route_routeinfo.controller_rooturl+'/edit_key?keypath='+keypath);
}

function debugsession_edit_value(keypath)
{
	ajax_async(__lpvar__.route_routeinfo.controller_rooturl+'/edit_value?keypath='+keypath);
}

function debugsession_delete(keypath)
{

	ui_confirm('确定删除['+keypath+']?',function()
		{
			ajax_async(__lpvar__.route_routeinfo.controller_rooturl+'/delete?keypath='+keypath);
		});

}

function debugsession_move(keypath,direction)
{
	ajax_async(__lpvar__.route_routeinfo.controller_rooturl+'/move?keypath='+keypath+'&direction='+direction);
}

function debugsession_update(mustexpand_keypath)
{

	var _list=$('[skelmodule_name=debug_session] [lpdd_role=subtree][lpdd_type=array][lpdd_expand=no] > [lpdd_role=header]');

	var closednode_list=[];

	_list.each(function()
		{
			var _this=$(this);
			closednode_list.push(_this.attr('lpdd_keypath'));
		});

	ajax_async(__lpvar__.route_routeinfo.controller_rooturl+'/update','',function(data)
		{

			var _tempdom=$(data);

			for(var i=0;i<closednode_list.length;i++)
			{
				if(mustexpand_keypath==closednode_list[i])
				{
					continue;
				}
				_tempdom.find('[lpdd_keypath="'+closednode_list[i]+'"]').closest('[lpdd_role=subtree][lpdd_type=array]').attr('lpdd_expand','no');
			}

			$('[skelmodule_name=debug_session] [__lpdd__=lpdd]').replaceWith(_tempdom);
			ui_window_close_all();

		});

}