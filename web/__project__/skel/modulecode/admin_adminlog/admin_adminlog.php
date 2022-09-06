<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

$__db=\db\Adminlog::db_instance();
$__db_adminuser=\db\Adminuser::db_instance();

$__names=[];
$__adminusers=[];

if(1)
{

	$temp=$__db->groupby('adminlog_name')->field(['adminlog_name'])->select();
	foreach($temp as $v)
	{
		$__names[]=$v['adminlog_name'];
	}
	sort($__names);

}
if(1)
{

	$__adminusers[0]='未登录#0';

	$temp=$__db_adminuser->field(['id','adminuser_name','adminuser_isban'])->orderby('adminuser_isban asc,id asc')->select();
	foreach($temp as $v)
	{
		$__adminusers[$v['id']]=$v['adminuser_name'].'#'.$v['id'].($v['adminuser_isban']?'(禁用)':'');
	}

}

$__where=db_buildwhere('id|adminlog_route|adminlog_itemids');

if(0&&$_GET['_keyword'])
{//不用精确了,就上面的模糊搜索吧
	$__where['adminlog_itemids']=[db_findinset,$_GET['_keyword']];
	$__where[db_logic]='or';
}

$__p=intval($_GET['_p']);

$__npp=10;

$__itemlist=$__db->jointable_join(\db\Adminuser::db_instance(),'aid=id')->field(null,['id','adminuser_name'])->where($__where)->orderby($_GET['_order']?$_GET['_order']:'id desc')->select_splitpage($__p,$__npp,$__totalpagenum,$__totalitemnum);


$__splitpage_html=\_lp_\Splitpage::splitpage_gethtml($__p,$__totalpagenum,$__totalitemnum);

$table_thlist=
[
	'ID'=>'100px',

	'管理员'=>'100px',

	'操作'=>'200px',

	'路由'=>'200px',

	'操作ID/DATA'=>0,

	'创建时间'=>'200px',

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

	$__templine[]=$item['adminlog_name'];

	$__templine[]=$item['adminlog_route'];

	if(1)
	{

		$temp='';

		if($item['adminlog_itemids'])
		{
			$temp=$item['adminlog_itemids'];
		}

		if(''!==$item['adminlog_tracedata'])
		{
			if(is_array($item['adminlog_tracedata']))
			{
				$temp.=debug_dump($item['adminlog_tracedata'],0,0);
			}
			else
			{
				$temp.=($item['adminlog_itemids']?'/':'').$item['adminlog_tracedata'];
			}
		}

		$__templine[]=$temp;

	}

	if(1)
	{
		$temptd=[];
		$temptd[]=time_str($item['adminlog_createtime']);
		$temptd[]=ip_ipbox($item['adminlog_ip']);
		$__templine[]=impd($temptd,'<br>');
	}

	$table_trlist[]=$__templine;

}

echo _module('c_admin_panel_template_fixed');

	echo _div('c_admin_panel_oper');

		echo _form(url_build());

			if(1)
			{

				echo _span__('','','','管理员:');
				echo _select('aid',$_GET['aid']);
						echo _option('','全部');
					foreach($__adminusers as $k=>$v)
					{
						echo _option($k,$v);
					}
				echo _select_();
			}

			if(1)
			{

				echo _span__('','','','操作:');
				echo _select('adminlog_name',$_GET['adminlog_name']);
						echo _option('','全部');
					foreach($__names as $v)
					{
						echo _option($v,$v);
					}
				echo _select_();
			}

			echo _input('_keyword',$_GET['_keyword'],'ID/路由/操作ID');

			echo _span__('','','','创建时间:');
			echo _input_date('_datebegin/adminlog_createtime',$_GET['_datebegin/adminlog_createtime'],'起始时间');
			echo _span__('','','','-');
			echo _input_date('_dateend/adminlog_createtime',$_GET['_dateend/adminlog_createtime'],'结束时间');

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

