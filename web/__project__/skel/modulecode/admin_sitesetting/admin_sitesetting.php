<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


function m_base()
{
	$__xml_namemap=\_lp_\Xmlparser::xmlfile_namemap_get(xml_getxmlfilepath('edit_base'));

	$__settingdata=\controller\admin\Sitesetting::sitesetting_get();

	$table_thlist=
	[
		'name'=>'300px',
		'label'=>'300px',
		'value'=>0,

	];

	$table_trlist_list=[];

	foreach($__settingdata as $k=>$v)
	{

		$__templine=[];

		if(1)
		{
			$__templine[]=$k;
			$__templine[]=impd($__xml_namemap[$k],'/');
			$__templine[]=_pre__('','','',$v);
		}

		$table_trlist_list[$__xml_namemap[$k][0]][]=$__templine;

	}

	$H.=_div('c_admin_panel_search');
		$H.=_b__('','margin-left:0;','','基础设置(只是演示并不生效)');
		$H.=_a0__('leftoperbtn','margin-left:20px;','onclick="table_oper(this,\'edit_base\')" ','设置');
	$H.=_div_();

	foreach($table_trlist_list as $v)
	{
		$H.=\_widget_\Tablelist::tablelist_html($table_thlist,$v);
	}

	return $H;

}
function m_business()
{

	$H.=_div('c_admin_panel_group');
		$H.='[error-5640]预留';
	$H.=_div_();

	return $H;

}
$__tabmap=
[
	'base'=>'基础设置',
	'business'=>'其他设置预留',
];

$__tab=$_GET['_tab'];

if(!$__tab)
{
	$__tab=array_key_first($__tabmap);
}

echo _module();

	echo _div('c_admin_panel_nav');
		foreach($__tabmap as $k=>$v)
		{
			echo _a__(url_build('',['_tab'=>$k]),$k==$__tab?'_csel_':'','','',$v);
		}
	echo _div_();

	if(0)
	{
		echo _div('c_admin_panel_search');
			echo _a0__('leftoperbtn','margin-left:0;','onclick="table_oper(this,\'edit\')" ','设置');
		echo _div_();
	}

	if('base'==$__tab)
	{
		echo m_base();
	}
	else if('business'==$__tab)
	{
		echo m_business();
	}
	else
	{

	}

echo _module_();


