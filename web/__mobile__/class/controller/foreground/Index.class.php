<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _mobile_\controller\foreground;

class Index extends \controller\foreground\Index
{

	use index\Index_article;
	use index\Index_example;
	use index\Index_my;

	const indexarticle_framerefresh_preloadnum=1;
	const indexarticle_framerefresh_cachenum=2;

	function index()
	{

		if(__alp_access__)
		{
			if(clu_id())
			{
				R_alert('[error-0308]/__alp_access__仅在用户未登录情况下有效,且只能访问移动端首页用');
			}
		}

		$__tabmap=
		[
			'article'		=>[$this->_article_html()					,_i__()._span__('','','','文章首页')		,\_mobile_\Mobile::statusbarstyle_light],
			'example'	=>[$this->_example_html()				,_i__()._span__('','','','演示')			,\_mobile_\Mobile::statusbarstyle_dark],
			'my'			=>[$this->_my_html()					,_i__()._span__('','','','我的')			,\_mobile_\Mobile::statusbarstyle_dark],
		];

		$__alpconnect_config=session_get('alpconnect_config');

		$__tab_default=$__alpconnect_config['alpconnect_indextab'];

		if(!$__tab_default||!array_key_exists($__tab_default,$__tabmap))
		{
			$__tab_default='article';
		}

		$H.=_div('','','indexpageframe_role=viewzone');

			foreach($__tabmap as $k=>$v)
			{

				$tail=($__tab_default==$k?'indexpageframe_status=active':'');

				if('my'==$k)
				{
					$pullrefresh_config=[];
					$pullrefresh_config['pullrefresh_refreshurl']=url_build('_my_html?pullrefresh=1');
					$tail.=' '.\_widget_\Widget::domtail('pullrefresh',$pullrefresh_config);
				}
				else
				{
				}

				$H.=_div($cls,'','indexpageframe_tab='.$k.' '.$tail);
					$H.=$v[0];
				$H.=_div_();

			}


		$H.=_div_();

		$H.=_div('','','indexpageframe_role=nav');

			foreach($__tabmap as $k=>$v)
			{
				$tail=$k.' indexpageframe_statusbarstyle='.$v[2].($__tab_default==$k?' indexpageframe_status=active':'');

				$H.=_div('','',$tail);
					$H.=$v[1];
				$H.=_div_();

			}

		$H.=_div_();

		htmlecho_js_addvar('indexarticle_framerefresh_currentindex',self::indexarticle_framerefresh_preloadnum);
		htmlecho_js_addvar('indexarticle_framerefresh_cachenum',self::indexarticle_framerefresh_cachenum);

		if($__alpconnect_config['alpconnect_defaultopen'])
		{//比如在alp页面,联网成功后,点击任意页面会加载线上页面后默认打开

			htmlecho_js_addvar('indexindex_defaultopen',$__alpconnect_config['alpconnect_defaultopen']);

		}

		if(1)
		{//1 alp
			$ajax_preloaddata=[];
			if(__alp_access__)
			{
				$alp_info=[];

				$alp_info['alp_getonlineserver_url']=\_mobile_\controller\foreground\Api::alpbuild_getserverhost().'/api/alp_getonlineserver';

				$temp=fs_file_read_data(__temp_dir__.'/alp/pagedatamap.data');
				if($temp)
				{
					$ajax_preloaddata=array_merge_1($ajax_preloaddata,$temp);
				}

			}
			else
			{
				$alp_info=false;
			}

			htmlecho_js_addvar('ajax_preloaddata',$ajax_preloaddata);
			htmlecho_js_addvar('alp_info',$alp_info);
		}

		session_delete('alpconnect_config');

		\_mobile_\Mobile::return_mobilepage($H,['statusbarstyle'=>$__tabmap[$__tab_default][2]]);

	}

}
