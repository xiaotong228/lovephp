<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/




$__where=db_buildwhere('id|smssendlog_mobile|smssendlog_useragent|smssendlog_route|smssendlog_channel_args');

$__p=intval($_GET['_p']);

$__npp=10;

$__db=\db\Smssendlog::db_instance();

$__itemlist=$__db->where($__where)->orderby($_GET['_order']?$_GET['_order']:'id desc')->select_splitpage($__p,$__npp,$__totalpagenum,$__totalitemnum);

$__splitpage_html=\_lp_\Splitpage::splitpage_gethtml($__p,$__totalpagenum,$__totalitemnum);

$table_thlist=
[
	'ID'=>'100px',

	'用户'=>'200px',

	'手机号'=>'100px',

	'分类'=>'100px',

	'参数'=>'200px',

	'创建时间'=>'200px',

	'详情'=>0,

];

$table_trlist=[];

foreach($__itemlist as $item)
{

	$__templine=[];

	$__templine[]=$item['id'];

	$__templine[]=\db\User::userbox_admin($item['uid']);
	$__templine[]=$item['smssendlog_mobile'];
	$__templine[]=\db\Smssendlog::type_namemap[$item['smssendlog_type']];
	$__templine[]=$item['smssendlog_channel_args'];
	if(1)
	{
		$temptd=[];
		$temptd[]=time_str($item['smssendlog_createtime']);
		$temptd[]=ip_ipbox($item['smssendlog_ip']);
		$__templine[]=impd($temptd,'<br>');
	}

	if(1)
	{

		$temptd=[];
		$temptd[]=$item['smssendlog_route'];
		$temptd[]=$item['smssendlog_useragent'];

		$__templine[]=impd($temptd,'<br>');

	}

	$table_trlist[]=$__templine;

}

echo _module('c_admin_panel_template_fixed');

	echo _div('c_admin_panel_oper');

		echo _form(url_build());

			echo _input('_keyword',$_GET['_keyword'],'ID/手机号/参数/详情');

			echo _input('uid',$_GET['uid'],'UID');

			if(1)
			{

				echo _span__('','','','分类:');

				echo _select('smssendlog_type',$_GET['smssendlog_type']);
					echo _option('','全部');
					foreach(\db\Smssendlog::type_namemap as $k=>$v)
					{
						echo _option($k,$v);
					}
				echo _select_();
			}


			echo _span__('','','','创建时间:');
			echo _input_date('_datebegin/smssendlog_createtime',$_GET['_datebegin/smssendlog_createtime'],'起始时间');
			echo _span__('','','','-');
			echo _input_date('_dateend/smssendlog_createtime',$_GET['_dateend/smssendlog_createtime'],'结束时间');

			if(1)
			{
				$options=[];
				$options[]=['id desc','ID↘'];
				$options[]=['id asc','ID↗'];

				echo _span__('','','','排序:');
				echo _select('_order',$_GET['_order'],'gap1');
					foreach($options as $v)
					{
						echo _option($v[0],$v[1]);
					}
				echo _select_();
			}

			echo _button('submit','搜索','','','__button__="small black" ');

		echo _form_();

	echo _div_();

	if($__itemlist)
	{

		echo _div('c_admin_panel_itemlist');
			echo htmlcache_replace(\_widget_\Tablelist::tablelist_html($table_thlist,$table_trlist,1));
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

