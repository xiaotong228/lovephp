
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

function indexarticle_frame_activecallback(_frame,index)
{

	_frame.attr('indexarticle_framerefresh_index',__lpvar__.indexarticle_framerefresh_currentindex);

	var list=$('[indexarticle_framerefresh_index]');

	list.each(function()
	{
		let _this=$(this);
		let currentindex=int_intval(_this.attr('indexarticle_framerefresh_index'));

		if(currentindex<=__lpvar__.indexarticle_framerefresh_currentindex-__lpvar__.indexarticle_framerefresh_cachenum)
		{//清掉之前的frame内容只缓存特定的页面数量
			if(_this.html())
			{
				_this.html('');
			}

		}
	});

	__lpvar__.indexarticle_framerefresh_currentindex++;

	if(!_frame.html())
	{
		__lpwidget__.pullrefresh.pr_refresh_silent(_frame);
	}

}
function indexarticle_frame_scrollappend_getpostdata(_this)
{

	var data={};

	data._itemnum=_this.find('.g_article_articlebox').length;

	return data;

}
