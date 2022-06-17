
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


_document.on(mpe_create,'[pageroute_controller=article][pageroute_action=search]',function(event)
{
	articlesearch_history_render();

	if(0)
	{//test
		setTimeout(function()
		{
			articlesearch_search($('input[name=_keyword]'),'销售');
		},500);
	}

});

_document.on('click','[pageroute_controller=article][pageroute_action=search] .search_searchhistoryz .historyitem span',function(event)
{
	var _this=$(this);
	var _page=_this.closest('[__mobilepage__=mobilepage]');
	_page.find('.search_keywordz input').val(_this.html()).trigger('input');
	_page.find('.search_keywordz form').submit();
});

_document.on('click','[pageroute_controller=article][pageroute_action=search] .search_searchhistoryz .historyitem a',function(event)
{
	var _this=$(this).closest('.historyitem');
	ui_confirm('确定删除?',function()
	{
		articlesearch_history_delete(_this.index());
	})
});
//1 articlesearch

var articlesearch_keyword_currentkeyword=false;

function articlesearch_keyword_clear(_this)
{

	_this=$(_this);

	_this.siblings('input').val('').trigger('input');

	var _page=_this.closest('[__mobilepage__=mobilepage]');

	_page.find('.search_searchhistoryz').show();
	_page.find('.search_searchresultz').html('').hide();

}
function articlesearch_keyword_onsubmit(_this)
{

	_this=$(_this);

	var keyword=_this.find('input').val();

	keyword=$.trim(keyword);

	if(keyword)
	{
		articlesearch_search(_this,keyword);
	}
	else
	{
		ui_toast('请输入搜索关键字');

	}

	return false;

}
function articlesearch_keyword_oninput(_this)
{

	_this=$(_this);

	var keyword=_this.val();

	if(keyword)
	{
		_this.siblings('s').css('visibility','visible');
	}
	else
	{
		_this.siblings('s').css('visibility','hidden');

	}

}
function articlesearch_search(_this,keyword)
{

	articlesearch_keyword_currentkeyword=keyword;

	_this=_this.closest('[__mobilepage__=mobilepage]');

	var _searchhistory=_this.find('.search_searchhistoryz');
	var _searchresult=_this.find('.search_searchresultz');

	ajax_async('/article/search_result_scrollappend',{_keyword:keyword},function(data)
	{

		articlesearch_history_add(keyword);

		_searchresult.html(data.scrollappend_html);

		_searchhistory.hide();
		_searchresult.show();
		_searchresult.scrollpos_set_y(0);

		if(data.scrollappend_nomoredata)
		{
			_searchresult.attr('scrollappend_status','nomoredata');
		}
		else
		{
			_searchresult.removeAttr('scrollappend_status');
		}

	});

}

function articlesearch_result_getpostdata(_this)
{

	var data={};

	data._itemnum=_this.find('.g_article_articlebox').length;

	data._keyword=articlesearch_keyword_currentkeyword;

	return data;

}
//1 history
function articlesearch_history_get()
{

	var data=localstorage_get('articlesearch_history_localstorage');

	if(!data)
	{
		data=[];
	}

	return data;

}
function articlesearch_history_render()
{
	var data=articlesearch_history_get();
	var inhtml='';
	for(var i in data)
	{
		inhtml+='<div class="historyitem"><span>'+data[i]+'</span><a></a></div>';
	}

	$('#articlesearch_searchhistory_items_4758').html(inhtml).show();

	console_log_wreckage(53,'lovephp/0122/2953/articlesearch_history_render');

}
function articlesearch_history_clear()
{

	ui_confirm('确定清除搜索历史?',function()
	{
		localstorage_delete('articlesearch_history_localstorage');
		ui_toast('已清除');
		articlesearch_history_render();
	});
}
function articlesearch_history_add(keyword)
{
	var data=articlesearch_history_get();

	data=array_reverse_js(data);

	data.push(keyword);

	data=array_reverse_js(data);

	data=array_unique_js(data);

	localstorage_set('articlesearch_history_localstorage',data);

	articlesearch_history_render();
}

function articlesearch_history_delete(index)
{

	var data=localstorage_get('articlesearch_history_localstorage');

	delete(data[index]);

	data=array_unique_js(data);

	localstorage_set('articlesearch_history_localstorage',data);

	ui_toast('已删除');
	articlesearch_history_render();

}
//1 articlearticle
_document.on(mpe_create,'[pageroute_controller=article][pageroute_action=article]',function(event)
{

	var _this=$(this);

	var articleid=int_intval(_this.attr('articlecount_articleid'));
	if(articleid)
	{
		setTimeout(function()
		{
			ajax_async('/article/article_countviewnum?id='+articleid);
	    },2000);
	}


});

_document.on('click','.article_bodyhtmlz img',function(event)
{
	var _this=$(this);

	var _imgs=_this.closest('.article_bodyhtmlz').find('img');

	var urls=[];

	var img_index=0;

	_imgs.each(function(index)
	{
		if($(this).is(_this))
		{
			img_index=index;
		}
		urls.push(this.src);
	});

	__lpwidget__.picgallery.pg_open(urls,img_index);

});



function articlearticle_oper(id)
{

	ajax_async('/article/article_oper?id='+id);

}


