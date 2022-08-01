<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

echo _module('c_admin_panel_template_fixed');

	$__table_header=
	[
		'ID'=>'100px',
		'名称'=>'200px',
		'布局类型'=>'300px',
		'引用状况'=>'400px',
		'操作'=>0
	];

	$__table_body=[];

	$__itemlist=$____controller->listdata_dataclass::list_select();

	$__gridtype_namemap=\_skel_\Skelcore::gridtype_namemap_get();

	if(1)
	{

		$__itemlist_ids=[];

		$__itemlist_quotemap=[];

		foreach($__itemlist as $v)
		{
			$__itemlist_ids[]=$v['id'];
			$__itemlist_quotemap[$v['id']]=[];
		}

		\_skel_\Skelcore::griddata_allgriddata_walk(function(&$grid,$tracecookie) use (&$__itemlist_quotemap,$__itemlist_ids)
		{
			if($grid['@crossgrid_gridid']&&in_array_1($grid['@crossgrid_gridid'],$__itemlist_ids))
			{
				$__itemlist_quotemap[$grid['@crossgrid_gridid']][]=$tracecookie;
			}
		});

		foreach($__itemlist as &$v)
		{
			$v['@quoteList']=$__itemlist_quotemap[$v['id']];
		}
		unset($v);
	}

	$__splitpage_html=false;

	foreach($__itemlist as $item)
	{
		$__templine=[];

		$__templine[]=$item['id'];

		$__templine[]=$item['name'];

		$__templine[]=$__gridtype_namemap[$item['layout_grids']['grid_gridtype']];

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

		if(1)
		{
			$temptd=[];
			$temptd[]=_a0__('','','onclick="table_oper(this,\'listdata_edit\')"','编辑');
			$temptd[]=_a0__('','','onclick="table_oper_confirm(this,\'listdata_delete\')"','删除');

			$temptd[]=_a0__('','','onclick="table_oper(this,\'listdata_moveup\')"','上移');
			$temptd[]=_a0__('','','onclick="table_oper(this,\'listdata_movedown\')"','下移');

			$__templine[]=impd($temptd,'/');
		}

		$__table_body[]=$__templine;

	}

	echo _div('c_admin_panel_oper','margin-top:0;');
		echo _a0__('','','__button__="small green solid" onclick="table_oper(this,\'listdata_add\')" ','添加跨页面布局');
	echo _div_();
	echo _div('c_admin_panel_itemlist');
		echo \_widget_\Tablelist::tablelist_html($__table_header,$__table_body);
	echo _div_();
echo _module_();

