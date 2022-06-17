
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


_document.on(mpe_create,'[pageroute_controller=help][pageroute_action=aboutus]',function(event)
{
	if(client_is_app_js())
	{
		helpappcache_update();
	}
});

function helpappcache_clear()
{
	ui_confirm('确定清除缓存?',function()
		{
			plus.cache.clear();
			helpappcache_update();
		});
}
function helpappcache_update()
{
	plus.cache.calculate(function(size)
		{
			$('#appcache_size').html(datasize_oralstring_js(size)).show();
		});

}

