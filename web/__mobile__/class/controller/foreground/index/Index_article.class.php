<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace _mobile_\controller\foreground\index;

trait Index_article
{

	function _article_html()
	{

		$__navs=[0=>'全部'];

		if(__alp_access__)
		{

		}
		else
		{
			$__navs=array_merge_1($__navs,\db\Article::category_namemap);
		}

		$__navs_count=count($__navs);

		if($__navs_count>\Prjconfig::widget_config['pagetabshow_maxframenum'])
		{
			R_alert('[error-1600]超过最大frame数限制');
		}

		$pagetabshow_config=[];
		$pagetabshow_config['pagetabshow_switchframe_done_callback']='indexarticle_frame_activecallback';

		$H.=_div('top_searchz');
			$H.=_div('left_logoz');
			$H.=_div_();

			$H.=_a('/article/search','right_searchz');
				$H.=_i__('','','','&#xf0a3;');
				$H.=_span__('','','','想找点什么呢?');
			$H.=_a_();

		$H.=_div_();

		$H.=_div('center_bodyz','',\_widget_\Widget::domtail('pagetabshow',$pagetabshow_config).' pagetabshow_frame_index=0 pagetabshow_frame_count='.$__navs_count);

			$H.=_div('','','pagetabshow_role=nav');

				$H.=_div('','','pagetabshow_role=navitemwrap');

					if(1)
					{
						$tail='';
					}
					else
					{
						$tail=' pagetabshow_navitem_status=active';
					}

					foreach($__navs as $v)
					{
						$H.=_div('','','pagetabshow_role=navitem'.$tail);
							$H.=_span__('','','',$v);
						$H.=_div_();
						$tail='';

					}
				$H.=_div_();

			$H.=_div_();

			$H.=_div('',__alp_access__?'display:flex;justify-content:center;align-items:center;':'','pagetabshow_role=viewzone');

				if(__alp_access__)
				{
					$H.=_div('g_emptydatabox nonetwork');
						$H.=_b__('','','','没有网络连接');
						$H.=_a0__('','margin-top:'.mpx_to_vw(20),'__button__="medium black" onclick="alp_tryconnectserver()" ','刷新网络');
					$H.=_div_();
				}
				else
				{
					$H.=_div('','width:'.$__navs_count.'00vw;','pagetabshow_role=framewrap');


						$index=0;

						foreach($__navs as $k=>$v)
						{

							$pullrefresh_config=[];
							$pullrefresh_config['pullrefresh_refreshurl']=url_build('_article_html_pullrefresh',['category'=>$k]);

							$scrollappend_config=[];
							$scrollappend_config['scrollappend_loadurl']=url_build('_article_html_scrollappend',['category'=>$k]);
							$scrollappend_config['scrollappend_getpostdata']='indexarticle_frame_scrollappend_getpostdata';

							if($index<self::indexarticle_framerefresh_preloadnum)
							{//只预显示特定页数
								$nomoredata=false;

								$articlelist_html=$this->_article_html_inhtml($k,$nomoredata);

								$H.=_div('','','pagetabshow_role=frame '.\_widget_\Widget::domtail('pullrefresh',$pullrefresh_config).' indexarticle_framerefresh_index='.$index);

									$H.=_div('','','pullrefresh_role=dragbox '.\_widget_\Widget::domtail('scrollappend',$scrollappend_config).($nomoredata?' scrollappend_status=nomoredata':''));

										$H.=$articlelist_html;

									$H.=_div_();

								$H.=_div_();
							}
							else
							{
								$H.=_div('','','pagetabshow_role=frame '.\_widget_\Widget::domtail('pullrefresh',$pullrefresh_config));
								$H.=_div_();
							}

							$index++;

						}

					$H.=_div_();

					if($__navs_count>1)
					{
						$H.=_div__('','','pagetabshow_role=eclipse_left');
						$H.=_div__('','','pagetabshow_role=eclipse_right');
					}
				}

			$H.=_div_();

		$H.=_div_();

		return $H;

	}

	function _article_html_pullrefresh($category=0)
	{
//		sleep(3);
		$scrollappend_config=[];
		$scrollappend_config['scrollappend_loadurl']=url_build('_article_html_scrollappend',['category'=>$category]);
		$scrollappend_config['scrollappend_getpostdata']='indexarticle_frame_scrollappend_getpostdata';

		$nomoredata=false;
		$articlelist_html=$this->_article_html_inhtml($category,$nomoredata);

		$H.=_div('','','pullrefresh_role=dragbox '.\_widget_\Widget::domtail('scrollappend',$scrollappend_config).($nomoredata?'scrollappend_status=nomoredata':''));
			$H.=$articlelist_html;
		$H.=_div_();

		$data=[];
		$data['pullrefresh_html']=$H;
		$data['pullrefresh_successtips']=$articlelist_html?'数据已更新':'没有数据';

		R_true($data);

	}
	function _article_html_scrollappend($category)
	{

		$nomoredata=false;

		$in_html=$this->_article_html_inhtml($category,$nomoredata);

		$data=[];
		$data['scrollappend_html']=$in_html;
		$data['scrollappend_nomoredata']=$nomoredata;

		R_true($data);

	}

	function _article_html_inhtml($category=0,&$nomoredata=0)
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

		$where=[];
		$where['article_isdelete']=0;

		if($category)
		{
			$where['article_category']=$category;
		}

		$__itemlist=$__db->where($where)->orderBy('id desc')->select_splitpage($__page_p,$__page_npp,$__totalpagenum,$__totalitemnum);
		$__itemlist_count=count($__itemlist);

		if($__itemlist_count<$__page_npp)
		{
			$nomoredata=true;
		}

		foreach($__itemlist as $v)
		{
			$H.=\_mobile_\Mobile::articlebox_articlebox_list($v);
		}

		return $H;

	}

}

