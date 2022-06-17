
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



function examplewidget_getpostdata(_this)
{
	var data={};

	data.currentitemnum=_this.find('[__pagemenu__=menu]').length;

	return data;

}

function example_picgallery_openpic(_this)
{

	_this=$(_this);

	var _list=_this.parent().find('.pic');

	var urls=[];

	_list.each(function()
	{
		urls.push($(this).css_bgimage_get());
	});

	console_log_wreckage(43,'lovephp/0119/1843',urls);

	__lpwidget__.picgallery.pg_open(urls,_this.index());

}

_document.on
(

	[mpe_create,mpe_destory,mpe_historypush,mpe_historypop,mpe_refresh].join(' '),

	'[pageroute_controller=example][pageroute_action=openpage]',

	function(event)
	{
		console_log_wreckage(14,'lovephp/0128/1314',event.type);

	}
);

