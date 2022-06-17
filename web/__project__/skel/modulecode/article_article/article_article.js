
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


_document.ready(function()
{
	if(__lpvar__.articlearticle_articleid)
	{
		setTimeout(function()
			{
				ajax_async('/article/article_countviewnum?id='+__lpvar__.articlearticle_articleid);
	        },2000);	
	}

});

