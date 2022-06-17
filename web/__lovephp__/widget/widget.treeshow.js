
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.treeshow=new function()
{

	this.ts_updatehtml=function(_this,mustopendna=false)
	{

		var _config=_this.data_getconfig('treeshow');

		var node_open_status={};

		_this.find('[treeshow_role=node]').each(function()
			{
				var dna=$(this).attr('treeshow_nodedna');
				var open=$(this).attr('treeshow_nodeopenstatus');
				node_open_status[dna]=open;
			});

			if(false!==mustopendna)
			{
				node_open_status[mustopendna]='yes';
			}

		if(_config.treeshow_updatehtmlurl)
		{
			ajax_sync(_config.treeshow_updatehtmlurl,'',function(data)
				{

					var temp=$(data);
					_this.html(temp.html());

					if(1)
					{
						for(var key in node_open_status)
						{
							_this.find('[treeshow_role=node][treeshow_nodedna='+key+']').attr('treeshow_nodeopenstatus',node_open_status[key]);
						}
					}

				});

		}

	};

};

_document.on('click','[__treeshow__=treeshow] [treeshow_role=node_self_toggle]',function()
{
	var _this=$(this).closest('[treeshow_role=node]');

	if('yes'==_this.attr('treeshow_nodeopenstatus'))
	{
		_this.attr('treeshow_nodeopenstatus','no');
	}
	else
	{
		_this.attr('treeshow_nodeopenstatus','yes');
	}
});

_document.on('click','[__treeshow__=treeshow] [treeshow_role=openall]',function()
{
	var _this=$(this).closest('[__treeshow__=treeshow]');

	_this.find('[treeshow_role=node][treeshow_nodeend!=yes]').each(function()
		{
			$(this).attr('treeshow_nodeopenstatus','yes');
		});

});

_document.on('click','[__treeshow__=treeshow] [treeshow_role=closeall]',function()
{
	var _this=$(this).closest('[__treeshow__=treeshow]');

	_this.find('[treeshow_role=node][treeshow_nodeend!=yes]').each(function()
		{
			$(this).attr('treeshow_nodeopenstatus','no');
		});

});

_document.on('contextmenu','[__treeshow__=treeshow] [treeshow_role=node_self_self_header]',function()
{

	var _node=$(this).closest('[treeshow_role=node]');
	var _widget=_node.closest('[__treeshow__=treeshow]');
	var _node_dna=_node.attr('treeshow_nodedna');
	var _config=_widget.data_getconfig('treeshow');

	if(_config.treeshow_nodepopupmenuurl)
	{
		__lpwidget__.popupmenu.pm_open(event,_config.treeshow_nodepopupmenuurl+'?dna='+_node_dna)
		return false;
	}

});


