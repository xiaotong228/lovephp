<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


function m_plusnum($plusnum)
{

	if(0==$plusnum)
	{
		return _b__('__color_grey__','','','+'.$plusnum);
	}
	else if($plusnum>0)
	{
		return _b__('__color_green__','','','+'.$plusnum);
	}
	else if($plusnum<0)
	{
		return _b__('__color_red__','','',$plusnum);
	}
	else
	{
		R_alert('[error-0148]');
	}

}
function m_currentdata()
{

	$__data_current=\db\Sitedata::sitedata_census(time());

	$__preday_datestr=date_str_num(time()-3600*24);

	$__preday_data=\db\Sitedata::find($__preday_datestr);

	$__data_plus=[];

	foreach($__data_current as $k=>$v)
	{
		$__data_plus[$k]=floatval($__data_current[$k]-$__preday_data[$k]);
	}

	$table_thlist=
	[
		'ID'=>'100px',
		'项目'=>'200px',
		'总量'=>'200px',
		'今日增量'=>0,
	];

	$table_trlist=[];

	$__index=1;
	foreach(\db\Sitedata::census_fieldnamemap as $k=>$v)
	{

		$__templine=[];

		$__templine[]=$__index++;
		$__templine[]=$v;
		$__templine[]=$__data_current[$k];
		$__templine[]=m_plusnum($__data_plus[$k]);
		$table_trlist[]=$__templine;

	}

	$H.=\_widget_\Tablelist::tablelist_html($table_thlist,$table_trlist);

	return $H;

}
function m_historydata()
{

	$__p=intval($_GET['_p']);
	$__npp=10;


	$where=[];

	$__db=\db\Sitedata::db_instance();

	$__itemlist=$__db->where($where)->orderby('id desc')->select_splitpage($__p,$__npp,$__totalpagenum,$__totalitemnum);

	$__splitpage_html=\_lp_\Splitpage::splitpage_gethtml($__p,$__totalpagenum,$__totalitemnum);

	$table_thlist=
	[
		'ID'=>'100px',
	];

	foreach(\db\Sitedata::census_fieldnamemap as $k=>$v)
	{
		$table_thlist[$v]='100px';
	}

	$table_thlist['创建时间']=0;

	$table_trlist=[];

	if(1)
	{//设置偏移参考量
		foreach($__itemlist as $k=>&$item)
		{

			$item_pre=$__itemlist[$k+1];
			if(!$item_pre)
			{
				$where1=[];
				$where1['id']=[db_lt,$item['id']];
				$item_pre=$__db->where($where1)->orderBy('id desc')->find();
			}

			$item['@pre']=$item_pre;

		}
		unset($item);
	}

	foreach($__itemlist as $item)
	{

		$__templine=[];

		if(1)
		{
			$__templine[]=$item['id'];
		}

		if(1)
		{
			foreach(\db\Sitedata::census_fieldnamemap as $kk=>$vv)
			{

				$plusnum=floatval($item[$kk]-$item['@pre'][$kk]);

				$__templine[]=m_plusnum($plusnum).'&emsp;/'.$item[$kk];

			}

			$__templine[]=time_str($item['sitedata_createtime']);

		}


		$table_trlist[]=$__templine;
	}

	$H.=\_widget_\Tablelist::tablelist_html($table_thlist,$table_trlist);

	$H.=$__splitpage_html;

	return $H;

}

$__tabmap=
[
	'current'=>'当前数据',
	'history'=>'历史数据',
];

$__tab=$_GET['_tab'];

if(!$__tab)
{
	$__tab=array_key_first($__tabmap);
}

echo _module('c_admin_panel_template_scroll');

	echo _div('g_module_header');
		foreach($__tabmap as $k=>$v)
		{
			echo _a__(url_build('',['_tab'=>$k]),$k==$__tab?'_csel_':'','','',$v);
		}
	echo _div_();

	if('current'==$__tab)
	{
		echo m_currentdata();
	}
	else if('history'==$__tab)
	{
		echo m_historydata();
	}
	else
	{

	}

echo _module_();


