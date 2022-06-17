<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _skel_;
class Skelcore
{

	const skel_accessmode_edit=1;
	const skel_accessmode_preview=2;

	const skel_dataext_edit='data';
	const skel_dataext_publish='publishdata';

	const skel_dataext_namemap=
	[
		self::skel_dataext_edit=>'编辑状态',
		self::skel_dataext_publish=>'发布状态',
	];

//1 grid

	const griddir_vertical=1;//竖
	const griddir_horizontal=2;//横

	const griddir_strmap=
	[
		'griddir_vertical'=>self::griddir_vertical,
		'griddir_horizontal'=>self::griddir_horizontal
	];

	const griddir_namemap=
	[
		self::griddir_vertical=>'竖',
		self::griddir_horizontal=>'横'
	];

//1 gridtype
	const gridtype_infomap=
	[

		1=>
			[
				'dir'=>self::griddir_vertical,
				'label'=>'[1200px]',

				'grid_csscode'=>
				'
width:@pc_page_layout_heartwidth;
margin:0px auto;

				',
			],
		2=>
			[
				'dir'=>self::griddir_vertical,
				'label'=>'[100%]',

				'grid_csscode'=>
				'
width:100%;
.dd_bg(@dd_randomcolor_42);

				',

			],

		100=>
			[
				'dir'=>self::griddir_horizontal,
				'label'=>'后台内页(上左右)',
				'zonenum'=>3,

				'grid_csscode'=>
				'
position:absolute;
left:0;
right:0;
top:0;
bottom:0;
display:grid;
.dd_bg(@dd_randomcolor_07);

grid-template-areas:\'z00 z00\' \'z10 z11\';

grid-template-rows:auto 1fr;

grid-template-columns:200px 1fr;

[__skelzone__=skelzone]
{
	&[skelzone_index=\'0\']
	{
		grid-area:z00;
		.dd_bg(@dd_randomcolor_14);
	}
	&[skelzone_index=\'1\']
	{
		grid-area:z10;
		.dd_bg(@dd_randomcolor_14);
		.dd_bg(@dd_randomcolor_26);
	}
	&[skelzone_index=\'2\']
	{
		grid-area:z11;
		.dd_bg(@dd_randomcolor_43);
		overflow-x:hidden;
		overflow-y:auto;
		margin:10px 0 10px 10px;
	}
}

				',

			],

		101=>
			[
				'dir'=>self::griddir_horizontal,
				'label'=>'用户内页(上左右)',
				'zonenum'=>3,

				'grid_csscode'=>
				'
display:grid;
.dd_bg(@dd_randomcolor_07);

grid-template-areas:\'z00 z00\' \'z10 z11\';

grid-template-columns:200px 1fr;

grid-row-gap:10px;

width:@pc_page_layout_heartwidth;

margin:0px auto;

[__skelzone__=skelzone]
{
	&[skelzone_index=\'0\']
	{
		grid-area:z00;
		.dd_bg(@dd_randomcolor_14);
	}
	&[skelzone_index=\'1\']
	{

		grid-area:z10;
		.dd_bg(@dd_randomcolor_14);
		.dd_bg(@dd_randomcolor_26);
		background:#fff;
		border:1px solid @bd_color;
	}
	&[skelzone_index=\'2\']
	{
		grid-area:z11;
		.dd_bg(@dd_randomcolor_43);
		background:#fff;
		border-width:1px 1px 1px 0;
		border-style:solid;
		border-color:@bd_color;
		padding:20px;
	}
}

				',


			],

		102=>
			[
				'dir'=>self::griddir_horizontal,
				'label'=>'文章内页(左右)',
				'zonenum'=>2,

				'grid_csscode'=>
				'
display:grid;
.dd_bg(@dd_randomcolor_07);

grid-template-columns:830px 1fr;

grid-column-gap:30px;

width:@pc_page_layout_heartwidth;

margin:0px auto;

[__skelzone__=skelzone]
{
	&[skelzone_index=\'0\']
	{
		.dd_bg(@dd_randomcolor_14);
	}
	&[skelzone_index=\'1\']
	{
		.dd_bg(@dd_randomcolor_16);
	}
}

				',

			],

	];

	static function echohtml_echo()
	{//skel主输出函数

		global $____skel;

		$H='';

		if(
			self::skel_accessmode_edit==__skel_accessmode__||
			self::skel_accessmode_preview==__skel_accessmode__
		)
		{
			$ext=self::skel_dataext_edit;
		}
		else
		{
			$ext=self::skel_dataext_publish;
		}


		$routedna=__route_module__.'/'.__route_controller__.'/'.__route_action__;

		$____skel=new \_skel_\Skelpagedata($routedna,$ext);

		if(!$____skel->page_data_pagedata)
		{
			R_exception('[error-2329]/skel缺失:'.$routedna,404);
		}

		$H.=$____skel->html_gethtml();

		if(self::skel_accessmode_edit==__skel_accessmode__)
		{

			if(1)
			{
				$url_preview=url_build(
					'',
					[
						'@skel_accessmode'=>self::skel_accessmode_preview,
					]);

				$H.=_div('','','skelvisualedit_role=menutrigger __movebox__=movebox');

					$H.=_div__('p0','','movebox_role=dragbox','&#xf097;');
					$H.=_div('p1');

						$H.=_a__('/skel/layoutedit?routedna='.$____skel->route_dna,'','margin-top:30px;','','布局编辑模式');

						$H.=_a0__('','margin-top:30px;','onclick="__lp_skel_layoutedit__.pagedata_pageset_edit();"','更改页面meta信息');

						$H.=_a0__('','','onclick="__lp_skel_layoutedit__.pagedata_rescue()"','还原数据');

						$H.=_an__(url_build(),'','margin-top:30px;','','查看页面');
						$H.=_an__($url_preview,'','','','预览页面');
						$H.=_a0__('','','onclick="__lp_skel_layoutedit__.pagedata_publish()"','发布页面');

					$H.=_div_();

				$H.=_div_();
			}

			htmlecho_js_addvar('skelvisualedit_enable',1);

			if(1)
			{

				$skeldata=[];
				$skeldata['route_dna']=$____skel->route_dna;
				$skeldata['tree_dna']=0;//用不到了,2021年10月26日15:13:43

				htmlecho_js_addvar('skeledit_currenteditpageinfo',$skeldata);
			}

			htmlecho_js_addurl('/assets/_skel/skel.layoutedit.jsraw');

		}


		if($____skel)
		{

			$filepath_css=false;
			$filepath_js=false;

			list($filepath_css,$filepath_js)=\_lp_\Codepack::skelmodules_packcode($____skel->html_usedmodulenames);

			htmlecho_css_addurl(ltrim($filepath_css,'.'));
			htmlecho_js_addurl(ltrim($filepath_js,'.'));

		}

		htmlecho_fire($H);

	}

	static function gridtype_namemap_get()
	{
		static $cache=[];

		if(!$cache)
		{
			foreach(self::gridtype_infomap as $k=>$v)
			{
				if($v['zonenum'])
				{
					$zonenum='(*'.$v['zonenum'].')';
				}
				else
				{
					$zonenum='';
				}
				$cache[$k]='[type='.$k.']['.self::griddir_namemap[$v['dir']].$zonenum.']/'.$v['label'].'';
			}
		}

		return $cache;
	}

//1 griddata
	static function griddata_allgriddata_walk($__walkfunc,$__savetofs=false)
	{//对所有的页面pagedata中的grid进行遍历处理

		if(1)
		{//各个页面的布局文件
			$list=fs_dir_searchfile(__skel_layoutdata_dir__.'/pagedata',
				[
					self::skel_dataext_edit,
					self::skel_dataext_publish
				]);

			foreach($list as $filepath)
			{
				$pagedata=fs_file_read_data($filepath);

				foreach($pagedata['pagedata_layout']['layout_grids'] as $k=>&$v)
				{
					$ext=path_ext($filepath);

					$tracecookie='页面布局('.self::skel_dataext_namemap[$ext].'):'.str_replace(__skel_layoutdata_dir__.'/pagedata/','',$filepath);

					$tracecookie=str_replace([
					'.'.self::skel_dataext_edit,
					'.'.self::skel_dataext_publish
					],'',$tracecookie);

					$__walkfunc($v,$tracecookie);

					if(is_null($v))
					{
						unset($pagedata['pagedata_layout']['layout_grids'][$k]);
					}

				}

				if($__savetofs)
				{
					fs_file_save_data($filepath,$pagedata);
				}
			}
		}

		if(1)
		{//跨页面布局

			foreach(self::skel_dataext_namemap as $_ext=>$_extname)
			{
				$crossgrid_list=\ld\Skelcrossgridlist::list_select($_ext);

				foreach($crossgrid_list as $k=>&$v)
				{
					$result=$__walkfunc($v['layout_grids'],'跨页面布局('.$_extname.'):'.$k);

					if(cmd_recu_deleteme===$result)
					{
						unset($v['layout_grids']);
					}
				}

				unset($v);

				if($__savetofs)
				{
					\ld\Skelcrossgridlist::list_save($crossgrid_list,$_ext);
				}

			}

		}

	}

	static function griddata_adjustgriddata_changegridtype(&$grid_data,$new_gridtype)
	{//更改布局之后涉及到左右结构的布局有多个zone,上下结构的布局只有一个zone的问题,这里做一下调整

		if($grid_data['grid_gridtype']==$new_gridtype)
		{
			return;
		}

		$grid_old=self::gridtype_infomap[$grid_data['grid_gridtype']];

		$grid_new=self::gridtype_infomap[$new_gridtype];

		if((self::griddir_vertical==$grid_old['dir'])&&(self::griddir_vertical==$grid_new['dir']))
		{
		}
		else if((self::griddir_vertical==$grid_old['dir'])&&(self::griddir_horizontal==$grid_new['dir']))
		{

			$grid_data['grid_zones']=[$grid_data['grid_modules']];

			unset($grid_data['grid_modules']);

		}
		else if((self::griddir_horizontal==$grid_old['dir'])&&(self::griddir_vertical==$grid_new['dir']))
		{
			$new_module=[];

			foreach($grid_data['grid_zones'] as $v)
			{
				foreach($v as $vv)
				{
					$new_module[]=$vv;
				}
			}

			$grid_data['grid_modules']=$new_module;

			unset($grid_data['grid_zones']);
		}
		else if((self::griddir_horizontal==$grid_old['dir'])&&(self::griddir_horizontal==$grid_new['dir']))
		{

			if($grid_old['zonenum']>$grid_new['zonenum'])
			{//都是水平布局的时候,如果新布局的zone数目小于旧布局的zone数目,会产生一个放不下的问题

				$new_zone=[];

				foreach($grid_data['grid_zones'] as $k=>$v)
				{
					foreach($v as $kk=>$vv)
					{
						if($k<$grid_new['zonenum'])
						{
							$new_zone[$k][$kk]=$vv;
						}
						else
						{
							$new_zone[0][]=$vv;
						}
					}
				}

				$grid_data['grid_zones']=$new_zone;

			}
			else
			{//都是水平布局时,且旧的布局的zone数目<=新的布局的zone数目时不处理
			}

		}
		else
		{
			R_alert('[error-2303]');
		}
		unset($grid_data['grid_gridtype']);
		$grid_data['grid_gridtype']=$new_gridtype;
	}
//1 moduleconfigdata
	static function moduleconfigdata_deleteallnotused()
	{

		$used_configids=[];

		self::griddata_allgriddata_walk(function($grid) use (&$used_configids)
			{
				if($grid['grid_modules'])
				{
					foreach($grid['grid_modules'] as $v)
					{
						$used_configids[]=$v['module_configid'];
					}
				}
				else if($grid['grid_zones'])
				{
					foreach($grid['grid_zones'] as $v)
					{
						foreach($v as $vv)
						{
							$used_configids[]=$vv['module_configid'];
						}
					}
				}else{}

			});

		$used_configids=array_unique($used_configids);

		foreach($used_configids as $v)
		{
			if(!$v)
			{
				R_alert('[error-4210]moduleconfigid错误');
			}
		}

		$dir_list=fs_dir_list(__skel_layoutdata_dir__.'/moduleconfigdata');

		foreach($dir_list['file'] as $v)
		{
			$temp=path_filename_core($v);

			if(!in_array($temp,$used_configids))
			{
				fs_file_delete(__skel_layoutdata_dir__.'/moduleconfigdata/'.$v);
			}

		}

	}

}
