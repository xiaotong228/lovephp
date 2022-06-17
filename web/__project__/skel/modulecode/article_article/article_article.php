<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



$__article=\db\Article::assertfind($_GET['id']);

if($__article['article_isdelete'])
{
	R_alert('[error-4716]文章不存在或已删除');
}

echo _module();
	if(1)
	{
		echo _div('g_page_cookie');
			echo _a__('/','','','','首页');
			echo _i__('sep');
			echo _span__('','','',$__article['article_title']);
		echo _div_();
	}
	echo _div('mainz');

		echo _div__('article_titlez','','',$__article['article_title']);

		if(1)
		{

			echo _div('article_authorz');
				echo _span__('','','',date_str($__article['article_createtime']));
				echo _span__('_right_','','','浏览量:'.$__article['article_viewnum']);
			echo _div_();

		}

		if(1)
		{

			echo _div('article_bodyhtmlz_wrap');

				echo _div('article_bodyhtmlz');
					echo htmlentity_decode($__article['article_bodyhtml']);
				echo _div_();
			echo _div_();

		}

		echo _sep(40);

		echo _div('article_fromz');

			if(1)
			{

				$__db=\db\Article::db_instance();

				$where=[];
				$where['id']=[db_gt,$_GET['id']];
				$where['article_isdelete']=0;
				$article_next=$__db->where($where)->orderBy('id asc')->find();

				$where=[];
				$where['id']=[db_lt,$_GET['id']];
				$where['article_isdelete']=0;
				$article_prev=$__db->where($where)->orderBy('id desc')->find();

				if($article_next||$article_prev)
				{

					$temp=[];
						$temp[]=_a__(article_articleurl($article_prev['id']),'','','','上一篇:&nbsp;&nbsp;'.$article_prev['article_title']);
						$temp[]=_a__(article_articleurl($article_next['id']),'','','','下一篇:&nbsp;&nbsp;'.$article_next['article_title']);

						echo  impd($temp,'<br>');
				}
			}

		echo _div_();

	echo _div_();

echo _module_();

htmlecho_page_title($__article['article_title']);

htmlecho_page_keywords($__article['article_desctxt']);

if(\controller\foreground\Article::article_countviewnum_hascount($__article['id']))
{
	htmlecho_js_addvar('articlearticle_articleid',0);
}
else
{
	htmlecho_js_addvar('articlearticle_articleid',$__article['id']);
}


