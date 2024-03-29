<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



if(check_isavailable($_GET['_keyword']))
{
	$_GET['_keyword']=htmlentity_decode($_GET['_keyword']);
}

$__where=db_buildwhere('id|smssendlog_mobile|smssendlog_useragent|smssendlog_url|smssendlog_channel_args');

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

	'详情'=>0,

];

$table_trlist=[];

foreach($__itemlist as $item)
{

	$__templine=[];

	$__templine[]=$item['id'];

	$__templine[]=\controller\admin\super\Superadmin::userbox_cache($item['uid']);
	$__templine[]=$item['smssendlog_mobile'];
	$__templine[]=\db\Smssendlog::type_namemap[$item['smssendlog_type']];
	$__templine[]=$item['smssendlog_channel_args'];

	if(1)
	{
		$temp1=[];

		if($item['smssendlog_url'])
		{
			$temp1[]='URL:'.$item['smssendlog_url'];
		}

		if($item['smssendlog_useragent'])
		{
			$temp1[]='USERAGENT:'.$item['smssendlog_useragent'];
		}

		$temp1[]=time_str($item['smssendlog_createtime']);
		$temp1[]=ip_ipbox($item['smssendlog_ip']);



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
				echo _span__('','','','关键字:');
				echo _input('_keyword',$_GET['_keyword'],'id/url/useragent/ip/参数/手机号','gap0','width:300px;');
			}

			if(1)
			{

				echo _span__('','','','分类:');

				echo _select('smssendlog_type',$_GET['smssendlog_type'],'gap0');
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
			echo _input_date('_dateend/smssendlog_createtime',$_GET['_dateend/smssendlog_createtime'],'结束时间','gap0');

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

