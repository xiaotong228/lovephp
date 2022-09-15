<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

$__db=\db\Userlog::db_instance();


$__names=[];

if(1)
{

	$temp=$__db->groupby('userlog_name')->field(['userlog_name'])->select();
	foreach($temp as $v)
	{
		$__names[]=$v['userlog_name'];
	}
	sort($__names);

}

if(check_isavailable($_GET['_keyword']))
{
	$_GET['_keyword']=htmlentity_decode($_GET['_keyword']);
}

$__where=db_buildwhere('id|userlog_url|userlog_useragent|userlog_ip');

if(check_isavailable($_GET['_userlog_itemids']))
{
	$__where['userlog_itemids']=[db_findinset,$_GET['_userlog_itemids']];
}

$__p=intval($_GET['_p']);

$__npp=10;

$__itemlist=$__db->where($__where)->orderby($_GET['_order']?$_GET['_order']:'id desc')->select_splitpage($__p,$__npp,$__totalpagenum,$__totalitemnum);

$__splitpage_html=\_lp_\Splitpage::splitpage_gethtml($__p,$__totalpagenum,$__totalitemnum);

$table_thlist=
[
	'ID'=>'100px',

	'用户'=>'200px',

	'操作'=>'200px',

	'操作ID'=>'200px',

	'详情'=>0,

];

$table_trlist=[];

foreach($__itemlist as $item)
{

	$__templine=[];

	$__templine[]=$item['id'];

	$__templine[]=\controller\admin\super\Superadmin::userbox_cache($item['uid']);

	$__templine[]=$item['userlog_name'];

	$__templine[]=$item['userlog_itemids'];

	if(1)
	{

		$temp1=[];

		if($item['userlog_url'])
		{
			$temp1[]='URL:'.$item['userlog_url'];
		}

		if($item['userlog_useragent'])
		{
			$temp1[]='USERAGENT:'.$item['userlog_useragent'];
		}

		if(''!==$item['userlog_tracedata'])
		{
			$temp1[]=debug_dump($item['userlog_tracedata'],0,0);
		}

		$temp1[]=time_str($item['userlog_createtime']);
		$temp1[]=ip_ipbox($item['userlog_ip']);



		$temp='';
		foreach($temp1 as $v)
		{
			$temp.=_div__('itemdetaillinez','','',$v);
		}

		$__templine[]=$temp;

	}

	$table_trlist[]=$__templine;

}

echo _module('c_admin_panel_template_fixed');

	echo _div('c_admin_panel_oper');

		echo _form(url_build());


			if(1)
			{
				echo _span__('','','','用户:');
				echo _input('uid',$_GET['uid'],'用户UID','gap0');
			}

			if(1)
			{

				echo _span__('','','','操作:');
				echo _select('userlog_name',$_GET['userlog_name'],'gap0');
					echo _option('','全部');
					foreach($__names as $v)
					{
						echo _option($v,$v);
					}
				echo _select_();
			}

			if(1)
			{
				echo _span__('','','','操作ID:');
				echo _input('_userlog_itemids',$_GET['_userlog_itemids'],'操作ID','gap0','');
			}

			if(1)
			{
				echo _span__('','','','关键字:');
				echo _input('_keyword',$_GET['_keyword'],'id/url/useragent/ip','gap0');
			}

			echo _span__('','','','创建时间:');
			echo _input_date('_datebegin/userlog_createtime',$_GET['_datebegin/userlog_createtime'],'起始时间');
			echo _span__('','','','-');
			echo _input_date('_dateend/userlog_createtime',$_GET['_dateend/userlog_createtime'],'结束时间');

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

