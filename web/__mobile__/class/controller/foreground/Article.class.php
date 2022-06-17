<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _mobile_\controller\foreground;

class Article extends \controller\foreground\Article
{

//1 search
	function search()
	{

		$keyword_default='';

		$center.=_div('search_keywordz');
			$center.=_form('','','onsubmit="return articlesearch_keyword_onsubmit(this);"');

				$center.=_i__('','','','&#xf0a3;');

				$center.=_input('_keyword',$keyword_default,'请输入搜索关键字','','','__inputdefaultfocus__=inputdefaultfocus oninput="articlesearch_keyword_oninput(this)";');

				$center.=_s__('',$keyword_default?'':'visibility:hidden;','onclick="articlesearch_keyword_clear(this);"','&#xf066;');

				$center.=_button('submit','搜索','','','__button__="medium color0 solid" ');

			$center.=_form_();
		$center.=_div_();

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,$center);

		$H.=_div('','','mobilepage_role=body');

			if(1)
			{
				$H.=_div('search_searchhistoryz');

					$H.=_div('groupz');

						$H.=_div('p0');

							$H.=_span__('','','','搜索历史');

							$H.=_a0__('','','onclick="articlesearch_history_clear(this);"','&#xf07b;');

						$H.=_div_();

						$H.=_div('p1','display:none;','id=articlesearch_searchhistory_items_4758');

							if(0)
							{//test
								for($i=0;$i<10;$i++)
								{
									$H.=_div('historyitem');
										$H.=_span__('','','',math_salt());
										$H.=_a0__();
									$H.=_div_();
								}
							}

						$H.=_div_();

					$H.=_div_();



				$H.=_div_();
			}

			if(1)
			{
				$scrollappend_config=[];
				$scrollappend_config['scrollappend_loadurl']=url_build('search_result_scrollappend');
				$scrollappend_config['scrollappend_getpostdata']='articlesearch_result_getpostdata';
				$H.=_div__('search_searchresultz','display:none;',\_widget_\Widget::domtail('scrollappend',$scrollappend_config));
			}

		$H.=_div_();

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}
	function search_result_scrollappend()
	{

		$nomoredata=false;

		$in_html=$this->search_result_inhtml($nomoredata);

		$data=[];
		$data['scrollappend_html']=$in_html;
		$data['scrollappend_nomoredata']=$nomoredata;

		R_true($data);

	}
	function search_result_inhtml(&$nomoredata)
	{

		$__page_npp=20;

		if($_POST['_itemnum'])
		{
			$__page_p=intval($_POST['_itemnum']/$__page_npp);
		}
		else
		{
			$__page_p=0;
		}

		$__db=\db\Article::db_instance();

		$where=db_buildwhere('id|article_title',$_POST);
		$where['article_isdelete']=0;

		$__itemlist=$__db->where($where)->orderBy('id desc')->select_splitpage($__page_p,$__page_npp,$__totalpagenum,$__totalitemnum);
		$__itemlist_count=count($__itemlist);

		if($__itemlist_count<$__page_npp)
		{
			$nomoredata=true;
		}
		foreach($__itemlist as $v)
		{

			if($_POST['_keyword'])
			{
				$v['article_title']=str_ireplace($_POST['_keyword'],_b__('','','',$_POST['_keyword']),$v['article_title']);
			}

			$H.=\_mobile_\Mobile::articlebox_articlebox_list($v);
		}

		return $H;

	}


//1 article
	function article($id)
	{

		$__article=\db\Article::assertfind($id);

		if($__article['article_isdelete'])
		{
			R_alert('[error-4716]文章不存在或已删除');
		}

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,'',_i__('','','onclick="articlearticle_oper('.$id.')"','&#xf069;'));

		$H.=_div('','','mobilepage_role=body');

			$H.=_div__('article_titlez','','',$__article['article_title']);

			$H.=_div('article_authorz');
				$H.=date_str($__article['article_createtime']);
				$H.=_s__('','','','浏览量:'.$__article['article_viewnum']);
			$H.=_div_();
			$H.=_div('article_bodyhtmlz');

				$H.=htmlentity_decode($__article['article_bodyhtml']);

			$H.=_div_();

		$H.=_div_();

		if(\controller\foreground\Article::article_countviewnum_hascount($__article['id']))
		{
			$countid=0;
		}
		else
		{
			$countid=$__article['id'];
		}

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal articlecount_articleid='.$countid]);

	}
	function article_oper($id)
	{

		$H.=_div('operz');
			$H.=_a0__('oper','','onclick="copy_copytext(\''.server_host_http().article_articleurl($id).'\')" ',_i__('','','','&#xf0aa;')._span__('','','','复制链接'));
			$H.=_a0__('oper','','onclick="alert(\'[error-1302]\');" ',_i__('','','','&#xf07f;')._span__('','','','举报'));
			$H.=_a0__('oper','','onclick="alert(\'[error-1302]\');" ',_i__('__color_sns_weixin__','','','&#xf08d;')._span__('','','','微信'));
			$H.=_a0__('oper','','onclick="alert(\'[error-1302]\');" ',_i__('__color_sns_qq__','','','&#xf08e;')._span__('','','','QQ'));
			$H.=_a0__('oper','','onclick="alert(\'[error-1302]\');" ',_i__('__color_sns_weibo__','','','&#xf08c;')._span__('','','','微博'));
		$H.=_div_();

		$H.=_a0__('','','__button__="big black " mobilemodal_role=close ','取消');

		\_mobile_\Mobile::return_modal_open($H,['cls'=>'articlearticle_oper_modal'],'bottom_to_top',1);

	}

}
