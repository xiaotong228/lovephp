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
		'名称(name)'=>'200px',
		'标题(title)'=>'200px',
		'缩略图(thumb)'=>'100px',
		'描述(description)'=>'150px',
		'引用状况'=>'400px',
		'操作'=>0
	];

	$__table_body=[];

	$__itemlist=$____controller->listdata_dataclass::list_select();

	if(1)
	{//新增的和新改名的显示下
		$__lastadd=session_get('skelmodulelist_lastadd');
		session_delete('skelmodulelist_lastadd');

		$__lastedit=session_get('skelmodulelist_lastedit');
		session_delete('skelmodulelist_lastedit');
	}

	if(1)
	{
		$__module_names=[];
		$__module_quotemap=[];
		foreach($__itemlist as $v)
		{
			$__module_names[]=$v['name'];
			$__module_quotemap[$v['name']]=[];
		}
		\_skel_\Skelcore::griddata_allgriddata_walk(function(&$grid,$tracecookie) use (&$__module_quotemap,$__module_names)
		{

			if($grid['grid_modules'])
			{
				foreach($grid['grid_modules'] as &$v)
				{
					if(in_array_1($v['module_name'],$__module_names))
					{
						$__module_quotemap[$v['module_name']][]=$tracecookie;
					}
				}
				unset($v);
			}
			else if($grid['grid_zones'])
			{
				foreach($grid['grid_zones'] as &$v)
				{
					foreach($v as &$vv)
					{
						if(in_array_1($vv['module_name'],$__module_names))
						{
							$__module_quotemap[$vv['module_name']][]=$tracecookie;
						}
					}
					unset($vv);
				}
				unset($v);
			}else{}
		});
		if(1)
		{
				foreach($__module_quotemap as &$v)
				{//去重
					$v=array_unique($v);
				}
				unset($v);
				foreach($__itemlist as &$v)
				{
					$v['@quoteList']=$__module_quotemap[$v['name']];
				}
				unset($v);
		}

	}

	$__splitpage_html=false;

	foreach($__itemlist as $item)
	{
		$__templine=[];

		$__templine[]=$item['id'];

		if($__lastadd==$item['name'])
		{
			$item['name']=_span__('','color:red;','','[新增加]').$item['name'];
		}
		else if($__lastedit==$item['name'])
		{
			$item['name']=_span__('','color:red;','','[新编辑]').$item['name'];
		}
		else{}

		$__templine[]=$item['name'];

		$__templine[]=$item['title'];

		$__templine[]=_an__($item['thumb'],'','','',_img($item['thumb'],'img_w30'));

		$__templine[]=$item['description'];

		if(1)
		{
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
			$__templine[]=impd($temptd,'/');
		}

		$__table_body[]=$__templine;

	}

	echo _div__('g_warnbox','','','删除后果:&emsp;&emsp;页面布局(包括跨页面布局)中的对应模块都会被删除');

	echo _div('c_admin_panel_oper');
		echo _a0__('','','__button__="small green solid" onclick="table_oper(this,\'listdata_add\')" ','添加模块');
	echo _div_();

	echo _div('c_admin_panel_itemlist');
		echo \_widget_\Tablelist::tablelist_html($__table_header,$__table_body);
	echo _div_();

echo _module_();

