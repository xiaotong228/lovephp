<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



$__table_header=
[
	'ID'=>'100px',
	'label'=>'200px',
	'zone'=>'100px',
	'css代码'=>'100px',
	'引用状况'=>0
];

$__table_body=[];

$__itemlist=\_skel_\Skelcore::gridtype_infomap;

if(1)
{

	$__itemlist_quotemap=[];
	foreach($__itemlist as $k=>$v)
	{
		$__itemlist_quotemap[$k]=[];
	}
	\_skel_\Skelcore::griddata_allgriddata_walk(function(&$grid,$tracecookie) use (&$__itemlist_quotemap)
	{
		if($grid['grid_gridtype'])
		{
			$__itemlist_quotemap[$grid['grid_gridtype']][]=$tracecookie;
		}
	});
	foreach($__itemlist as $k=>&$v)
	{
		$v['@quoteList']=array_unique($__itemlist_quotemap[$k]);
	}
	unset($v);
}

$__splitpage_html=false;

foreach($__itemlist as $k=>$item)
{

	$__templine=[];

	$__templine[]=$k;

	$__templine[]=$item['label'];

	$__templine[]=\_skel_\Skelcore::griddir_namemap[$item['dir']].($item['zonenum']?'/zonenum:'.$item['zonenum']:'');

	$__templine[]=_pre__('','','',trim($item['grid_csscode']));

	if(1)
	{
		$tempH='';
		if($item['@quoteList'])
		{
			$tempH=impd($item['@quoteList'],'<br>');
		}
		else
		{
			$tempH=_span__('','color:red;','','未被引用');
		}
		$__templine[]=$tempH;
	}

	$__table_body[]=$__templine;

}

echo _module();

	echo _div__('c_warnbox','','','配置路径:&emsp;&emsp;\_skel_\Skelcore::gridtype_infomap');

	echo \_widget_\Tablelist::tablelist_html($__table_header,$__table_body);

echo _module_();

