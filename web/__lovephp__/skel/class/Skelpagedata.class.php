<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _skel_;
class Skelpagedata
{

	public $page_data_filepath=false;

	public $page_data_pagedata=false;

	public $route_dna=false;

	public $html_usedmodulenames=[];

	function __construct($route_dna,$data_ext,$richdata=true)
	{

		$this->route_dna=$route_dna;

		$this->page_data_filepath=__skel_layoutdata_dir__.'/pagedata/'.$route_dna.'.'.$data_ext;

		$layoutdata=fs_file_read_data($this->page_data_filepath,fs_loose);

		if($richdata)
		{

			$crossGrid_list=\ld\Skelcrossgridlist::list_select($data_ext);

			foreach($layoutdata['pagedata_layout']['layout_grids'] as $k=>$v)
			{
				if($v['@crossgrid_gridid'])
				{
					$crossgridDna=$v['@crossgrid_gridid'];

					$v['@crossgrid_gridname']=$crossGrid_list[$crossgridDna]['name'];

					$v=array_merge_1($v,$crossGrid_list[$crossgridDna]['layout_grids']);
				}

				$v['grid_gridinfo']=\_skel_\Skelcore::gridtype_infomap[$v['grid_gridtype']];

				unset($v['grid_gridinfo']['grid_csscode']);

				$layoutdata['pagedata_layout']['layout_grids'][$k]=$v;
			}
		}

		$this->page_data_pagedata=$layoutdata;

	}

	function html_gethtml()
	{

		if(!htmlecho_page_title(cmd_get)&&$this->page_data_pagedata['pagedata_pageset']['title'])
		{
			htmlecho_page_title($this->page_data_pagedata['pagedata_pageset']['title']);
		}
		if(!htmlecho_page_keywords(cmd_get)&&$this->page_data_pagedata['pagedata_pageset']['keywords'])
		{
			htmlecho_page_keywords($this->page_data_pagedata['pagedata_pageset']['keywords']);
		}
		if(!htmlecho_page_description(cmd_get)&&$this->page_data_pagedata['pagedata_pageset']['description'])
		{
			htmlecho_page_description($this->page_data_pagedata['pagedata_pageset']['description']);
		}

		foreach($this->page_data_pagedata['pagedata_layout']['layout_grids'] as $v)
		{

			$tail='skelgrid_type='.$v['grid_gridtype'];

			if(\_skel_\Skelcore::skel_accessmode_edit==__skel_accessmode__)
			{
				$griddata=[];
				$griddata['grid_gridtype']=$v['grid_gridtype'];
				$griddata['gridinfo']=$v['grid_gridinfo'];

				$tail.=' skelgrid_data=\''.json_encode_1($griddata).'\'';

			}

			$H.=_div('','','__skelgrid__=skelgrid '.$tail);

				if($v['grid_modules'])
				{
					foreach($v['grid_modules'] as $vv)
					{
						$H.=$this->html_module_single($vv);
					}
				}
				else if($v['grid_zones'])
				{
					foreach($v['grid_zones'] as $kk=>$vv)
					{
						$H.=_div('','','__skelzone__=skelzone skelzone_index='.$kk);
						foreach($vv as $vvv)
						{
							$H.=$this->html_module_single($vvv);
						}
						$H.=_div_();
					}
				}
				else{}
			$H.=_div_();
		}
		return $H;
	}
	function html_module_single(array $module)
	{

		global $____skel_module;

		global $____controller;

		$____skel_module=$module;


		$this->html_usedmodulenames[]=$____skel_module['module_name'];

		unset($module);

		ob_start();

		if(false===include(__skel_modulecode_dir__.'/'.$____skel_module['module_name'].'/'.$____skel_module['module_name'].'.php'))
		{
			R_exception('[error-0815]'.__skel_modulecode_dir__.'/'.$____skel_module['module_name'].'/'.$____skel_module['module_name'].'.php');
		}

		$module_html=ob_get_clean();

		$____skel_module=null;

		return $module_html;
	}

	function page_data_save($__updatekey=false,$__updatedata=false,$__crossgrid_save_enable)
	{

		$__crossgrid_save_datamap=[];

		$__griddata_purge=function(&$griddata)
		{

			if($griddata['@crossgrid_gridid'])
			{
				$griddata['@crossgrid_gridid']=intval($griddata['@crossgrid_gridid']);
			}
			else
			{
				if($griddata['grid_modules'])
				{
					foreach($griddata['grid_modules'] as &$vvv)
					{
						$vvv['module_configid']=intval($vvv['module_configid']);
					}
					unset($vvv);
				}
				else if($griddata['grid_zones'])
				{
					foreach($griddata['grid_zones'] as &$vv)
					{
						foreach($vv as &$vvv)
						{
							$vvv['module_configid']=intval($vvv['module_configid']);
						}
						unset($vvv);
					}
					unset($vv);
				}
				$griddata['grid_gridtype']=intval($griddata['grid_gridtype']);
			}


			if(1)
			{//重置索引,比如删了模块什么的,索引数字会跳空
				if($griddata['grid_modules'])
				{
					$griddata['grid_modules']=array_values($griddata['grid_modules']);
				}
				else if($griddata['grid_zones'])
				{
					if(1)
					{//有可能出现左边的zone是空,但是右边的zone不是空的情况,滤一下
						$max=max(array_keys($griddata['grid_zones']));

						$temp=[];

						for($i=0;$i<=$max;$i++)
						{
							if($griddata['grid_zones'][$i])
							{
								$temp[]=$griddata['grid_zones'][$i];
							}
							else
							{
								$temp[]=[];
							}
						}
						$griddata['grid_zones']=$temp;
					}

					foreach($griddata['grid_zones'] as &$v)
					{
						$v=array_values($v);
					}
					unset($v);
				}
				else{}
			}

		};

		if($__updatekey)
		{

			if('pagedata_layout/layout_grids'==$__updatekey)
			{
				$this->page_data_pagedata['pagedata_layout']['layout_grids']=$__updatedata;
			}
			else
			{
				$this->page_data_pagedata[$__updatekey]=$__updatedata;
			}

		}

		if(1)
		{//purge

			$__griddata=$this->page_data_pagedata['pagedata_layout']['layout_grids'];

			$__griddata_new=[];

			foreach($__griddata as $k=>$v)
			{

				$new_v=[];

				if($v['@crossgrid_gridid'])
				{

					$new_v['@crossgrid_gridid']=$v['@crossgrid_gridid'];

					if(1)
					{

						$temp=[];

						if($v['grid_zones'])
						{
							$temp['grid_zones']=$v['grid_zones'];
						}
						else if($v['grid_modules'])
						{
							$temp['grid_modules']=$v['grid_modules'];
						}
						else{}

						$temp['grid_gridtype']=$v['grid_gridtype'];

						$__crossgrid_save_datamap[$v['@crossgrid_gridid']]=$temp;
					}

				}
				else
				{

					$new_v['grid_gridtype']=$v['grid_gridtype'];

					if($v['grid_modules'])
					{
						$new_v['grid_modules']=$v['grid_modules'];
					}
					else if($v['grid_zones'])
					{
						$new_v['grid_zones']=$v['grid_zones'];
					}
					else
					{
						//空布局zone和module都没有
					}

				}

				$__griddata_purge($new_v);

				$__griddata_new[]=$new_v;

			}

			$this->page_data_pagedata['pagedata_layout']['layout_grids']=$__griddata_new;
		}

		fs_file_save_data($this->page_data_filepath,$this->page_data_pagedata);

		if($__crossgrid_save_enable&&$__crossgrid_save_datamap)
		{//如果需要保存crossgrid
			foreach($__crossgrid_save_datamap as $k=>$v)
			{
				$__griddata_purge($v);

				$crossgrid_item=\ld\Skelcrossgridlist::item_finditem($k);
				$crossgrid_item['layout_grids']=$v;

				\ld\Skelcrossgridlist::item_edititem($k,$crossgrid_item);
			}
		}

	}
}
