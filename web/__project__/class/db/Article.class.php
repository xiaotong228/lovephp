<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace db;
class Article
{

	use \_lp_\datamodel\Superdb;

	const category_namemap=
	[

		1=>'分类1',

		2=>'分类2',


		3=>'分类3',

		4=>'分类4',

		5=>'分类5',

		6=>'分类6',

		7=>'分类7',

		7=>'分类8',
	];
	const order_ordermap=
	[
		'id desc'=>'默认排序',
		'article_viewnum desc,id desc'=>'浏览量',
	];
//1 articlebox
	static function articlebox_list($__item,$cls='')
	{

		if(0)
		{//test
			$bb=mt_rand(0,2);
			if(0==$bb)
			{
				$__item['article_thumb']='';
			}
		}

		$H.=_div('g_article_articlebox '.$cls,'','article_showmode=list');

			if(1)
			{
				$temp=self::articlebox_creattime($__item['article_createtime']);
				$H.=_div('createtimez');
					$H.=_div__('createtimez_p0','','',$temp[0]);
					$H.=_div__('createtimez_p1','','',$temp[1]);
				$H.=_div_();
			}

			if($__item['article_thumb'])
			{
				$H.=_an(article_articleurl($__item['id']),'thumbz','background-image:url('.$__item['article_thumb'].');');

				$H.=_a_();
			}

			if(1)
			{
				$H.=_div('p1_rightz'.($__item['article_thumb']?' hasthumb':''));
					$H.=_div('titlez');
						$H.=_an__(article_articleurl($__item['id']),'','','',$__item['article_title']);
					$H.=_div_();
					$H.=_div('viewnumz');
						$H.=self::articlebox_viewnum($__item);
					$H.=_div_();
				$H.=_div_();
			}

		$H.=_div_();

		return $H;

	}

	static function articlebox_recommend($__item,$cls='')
	{

		if(0)
		{//test
			$bb=mt_rand(0,2);
			if(0==$bb)
			{
				$__item['article_thumb']='';
			}
		}

		$H.=_an(article_articleurl($__item['id']),'g_article_articlebox '.$cls,'','article_showmode=recommend');

			$H.=_div('titlez');
				$H.=$__item['article_title'];
			$H.=_div_();
			$H.=_div('viewnumz');
				$H.=_span__('','','',self::articlebox_viewnum($__item));
				$H.=_span__('_right_','','',date_str($__item['article_createtime']));
			$H.=_div_();
		$H.=_a_();

		return $H;

	}
	static function articlebox_creattime($time)
	{

		$temp=date_str($time);
		$temp=expd($temp,'-');

		return [$temp[2],$temp[0].'-'.$temp[1]];

	}
	static function articlebox_viewnum($__item)
	{

		$temp=[];

		$temp[]='浏览'.$__item['article_viewnum'].'次';

		return impd($temp,'&nbsp;|&nbsp;');

	}
}