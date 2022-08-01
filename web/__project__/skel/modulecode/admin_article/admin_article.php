<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


$__where=db_buildwhere('id|article_title');

$__p=intval($_GET['_p']);

$__npp=10;

$__db=\db\Article::db_instance();

$__itemlist=$__db->jointable_join(\db\Adminuser::db_instance(),'aid=id')->field(null,['id','adminuser_name'])->where($__where)->orderby($_GET['_order']?$_GET['_order']:'id desc')->select_splitpage($__p,$__npp,$__totalpagenum,$__totalitemnum);

$__splitpage_html=\_lp_\Splitpage::splitpage_gethtml($__p,$__totalpagenum,$__totalitemnum);

$table_thlist=
[
	'ID'=>'100px',

	'作者'=>'100px',

	'标题'=>'200px',

	'分类'=>'100px',

	'缩略图'=>'100px',

	'创建时间'=>'200px',

	'状态'=>'100px',

	'操作'=>0,
];

$table_trlist=[];

foreach($__itemlist as $item)
{

	$__templine=[];

	$__templine[]=$item['id'];

	if($item['@adminuser'])
	{
		$__templine[]=$item['@adminuser']['adminuser_name'].'#'.$item['@adminuser']['id'];
	}
	else
	{
		$__templine[]='/';
	}

	$__templine[]=_an__(article_articleurl($item['id']),'','','',$item['article_title']);

	$__templine[]=\db\Article::category_namemap[$item['article_category']];

	$__templine[]=_an__($item['article_thumb'],'','','',_img($item['article_thumb'],'img_w30'));

	$__templine[]=time_str($item['article_createtime']);

	if(1)
	{
		$__templine[]=_status(!$item['article_isdelete'],'正常','已删');
	}

	if(1)
	{

		$temptd=[];

		$temptd[]=_a__(url_build('edit?id='.$item['id']),'','','','编辑');

		if($item['article_isdelete'])
		{
			$temptd[]=_a0__('','','onclick="table_oper_confirm(this,\'delete_no\')"','还原');
		}
		else
		{
			$temptd[]=_a0__('','','onclick="table_oper_confirm(this,\'delete_yes\')"','删除');
		}

		$__templine[]=impd($temptd,'/');

	}

	$table_trlist[]=$__templine;

}

echo _module('c_admin_panel_template_fixed');

	echo _div('c_admin_panel_oper');

		echo _form(url_build());

			echo _input('_keyword',$_GET['_keyword'],'ID/标题');

			if(1)
			{

				echo _span__('','','','分类:');

				echo _select('article_category',$_GET['article_category']);
					echo _option('','全部');
					foreach(\db\Article::category_namemap as $k=>$v)
					{
						echo _option($k,$v);
					}
				echo _select_();
			}

			if(1)
			{

				$options=[['','全部']];

				$options[]=[0,'正常'];

				$options[]=[1,'已删'];

				echo _span__('','','','状态:');
				echo _select('article_isdelete',$_GET['article_isdelete']);
					foreach($options as $v)
					{
						echo _option($v[0],$v[1]);
					}
				echo _select_();
			}

			echo _span__('','','','创建时间:');
			echo _input_date('_datebegin/article_createtime',$_GET['_datebegin/article_createtime'],'起始时间');
			echo _span__('','','','-');
			echo _input_date('_dateend/article_createtime',$_GET['_dateend/article_createtime'],'结束时间');

			if(1)
			{
				$options=[];
				$options[]=['id desc','ID↘'];
				$options[]=['id asc','ID↗'];

				echo _span__('','','','排序:');
				echo _select('_order',$_GET['_order']);
					foreach($options as $v)
					{
						echo _option($v[0],$v[1]);
					}
				echo _select_();
			}

			echo _button('submit','搜索','gap1','','__button__="small black" ');

			echo _a__(url_build('edit'),'','','__button__="small green solid" ','添加文章');

		echo _form_();

	echo _div_();

	if($__itemlist)
	{

		echo _div('c_admin_panel_itemlist');
			echo \_widget_\Tablelist::tablelist_html($table_thlist,$table_trlist,1);
		echo _div_();

		echo $__splitpage_html;
	}
	else
	{
		echo _div('g_emptydatabox');
			echo _b__('','','','没有相关数据');
		echo _div_();
	}

echo _module_();

