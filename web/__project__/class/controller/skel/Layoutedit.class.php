<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\skel;
class Layoutedit extends \controller\admin\super\Superadmin
{

	public $__skel=false;

	function __construct()
	{

		parent::__construct();

		if($_GET['routedna'])
		{
			$this->__skel=new \_skel_\Skelpagedata($_GET['routedna'],\_skel_\Skelcore::skel_dataext_edit);
		}
		else
		{
		}
	}
	function index($routedna)
	{

		$__modulehtml=function($module)
		{

			$xml=\_lp_\Xmlparser::xmlfile_structdata_get(__skel_modulecode_dir__."/{$module['module_name']}/{$module['module_name']}.xml");

			$module_name=$module['module_name'].'('.$xml['title'].')#'.$module['module_configid'];

			$H.=_div('module','','skeldrag_dragclass="moduledrag" skelmodule_moduledata=\''.json_encode_1($module).'\' title="'.$module_name.'"');

				$H.=$module_name;

				$H.=_a0__('module_operbtn','right:60px;','title="编辑模块" onclick="__lp_skel_layoutedit__.module_editmodule(this);"','&#xf099;');
				$H.=_a0__('module_operbtn','right:30px;','title="在其上插入模块" onclick="__lp_skel_layoutedit__.module_addmodule(this);"','&#xf0a6;');
				$H.=_a0__('module_operbtn','right:0;','title="删除模块" onclick="__lp_skel_layoutedit__.module_deletemodule(this);"','&#xf06d;');

			$H.=_div_();

			return $H;
		};

		if(1)
		{
			$H.=$this->page_header_html($this->__skel->page_data_pagedata['pagedata_pageset']['title'],$routedna);
		}

		$__gridtype_namemap=\_skel_\Skelcore::gridtype_namemap_get();

		$H.=_sep(0);

		$H.=_div('layout skeldrag_container_lv0');

		foreach($this->__skel->page_data_pagedata['pagedata_layout']['layout_grids'] as $grid)
		{

			$griddata=$grid;

			unset($griddata['grid_modules']);
			unset($griddata['grid_zones']);


			$tails=[];
			$tails['skeldrag_dragclass']='griddrag';
			$tails['skelgrid_griddata']=$griddata;

			$H.=_div('grid','',_tails($tails));

				$H.=_div('gridd '.($grid['@crossgrid_gridid']?'__crossgrid__':''));

					if($grid['@crossgrid_gridid'])
					{
						$H.=_div('titlez');
							$H.='跨页面布局:[name='.$grid['@crossgrid_gridname'].'][id='.$grid['@crossgrid_gridid'].']';
							$H.=_div('bjyx');
								$H.=$__gridtype_namemap[$grid['grid_gridtype']];
							$H.=_div_();
						$H.=_div_();
					}
					else
					{
						$H.=_div('titlez');
							$H.='本页布局';
							$H.=_div('bjyx');
								$H.=$__gridtype_namemap[$grid['grid_gridtype']];
							$H.=_div_();
						$H.=_div_();
					}

					$H.=_div('griddd '.((\_skel_\Skelcore::griddir_vertical==$grid['grid_gridinfo']['dir'])?'skeldrag_container_lv1':''));
						if(\_skel_\Skelcore::griddir_vertical==$grid['grid_gridinfo']['dir'])
						{
							foreach($grid['grid_modules'] as $vv)
							{
								$H.=$__modulehtml($vv);
							}
						}
						else if(\_skel_\Skelcore::griddir_horizontal==$grid['grid_gridinfo']['dir'])
						{

							$divi=math_divi(1200,$grid['grid_gridinfo']['zonenum'],10,'width');

							for($zoneIndex=0;$zoneIndex<$grid['grid_gridinfo']['zonenum'];$zoneIndex++)
							{
								$H.=_div('zone',_sty('margin-left',$divi[$zoneIndex]['margin'].'px')._sty('width',$divi[$zoneIndex]['width'].'px'));
									$H.=_div('zonee skeldrag_container_lv1');
										foreach($grid['grid_zones'][$zoneIndex] as $vvv)
										{
											$H.=$__modulehtml($vvv);
										}
									$H.=_div_();
									$H.=_a0__('add_module','','onclick="__lp_skel_layoutedit__.module_addmodule(this)"','＋添加模块');
								$H.=_div_();

							}
						}
						else {}
					$H.=_div_();
					if(\_skel_\Skelcore::griddir_vertical==$grid['grid_gridinfo']['dir'])
					{
						$H.=_a0__('add_module','','onclick="__lp_skel_layoutedit__.module_addmodule(this)"','＋添加模块');
					}
				$H.=_div_();

				if(1)
				{//布局右下角的小的操作按钮
					if($grid['@crossgrid_gridid'])
					{
						$H.=_a0__('setting','','title="更改布局类型" onclick="ui_alert(\'这是一个跨页面布局<br>如需更改样式或者名称,请到[跨页面布局管理]\');"');
					}
					else
					{
						$H.=_a0__('setting','','title="更改布局类型" onclick="__lp_skel_layoutedit__.grid_changegridtype(this);"');
					}
					$H.=_a0__('delete','','title="删除布局" onclick="__lp_skel_layoutedit__.grid_deletegrid(this);"');
				}

			$H.=_div_();
		}

		$H.=_div_();

		$H.=_a0__('add_grid','','onclick="__lp_skel_layoutedit__.grid_addgrid();"','＋添加一个本页布局');

		$H.=_a0__('add_grid crossgrid','margin-bottom:20px;','onclick="__lp_skel_layoutedit__.crossgrid_add();"','＋添加一个跨页面布局');

		htmlecho_page_title('Skel/设计页面/布局编辑');

		if(1)
		{
			$info=[];
			$info['routeDna']=$routedna;
			$info['treeDna']=$treeDna;
			htmlecho_js_addvar('skelEdit_currentEditPageInfo',$info);
		}

		if(1)
		{
			$skeldata=[];
			$skeldata['route_dna']=$routedna;
			$skeldata['tree_dna']=$treeDna;
			htmlecho_js_addvar('skeledit_currenteditpageinfo',$skeldata);
		}

		htmlecho_fire($H);

	}
	function page_header_html($pagetitle,$routedna)
	{

		$baseurl='/'.$routedna;

		$url_visualedit=url_build(
			$baseurl,
			[
				'@skel_accessmode'=>\_skel_\Skelcore::skel_accessmode_edit
			]);


		$url_preview=url_build(
			$baseurl,
			[
					'@skel_accessmode'=>\_skel_\Skelcore::skel_accessmode_preview,
			]);

		$H.=_div('','','__pageheader__=pageheader');


			$H.=_b__('','','',$pagetitle);
			$H.=_b__('','margin-left:40px;','',$baseurl);

			$H.=_a__($url_visualedit,'','margin-left:40px;','','可视化编辑模式');


			$H.=_a0__('','margin-left:40px;','onclick="__lp_skel_layoutedit__.pagedata_pageset_edit();"','更改页面meta信息');



			$H.=_a0__('','','onclick="__lp_skel_layoutedit__.pagedata_rescue()"','还原数据');

			$H.=_an__($baseurl,'','margin-left:40px;','','查看页面');
			$H.=_an__($url_preview,'','','','预览页面');

			$H.=_a0__('','','onclick="__lp_skel_layoutedit__.pagedata_publish()"','发布页面');

		$H.=_div_();

		return $H;
	}
//1 pagedata
	function pagedata_publish($routedna,$act)
	{

		if(1)
		{
			$__filelist=[];

			$__filelist[]=$this->__skel->page_data_filepath;

			foreach($this->__skel->page_data_pagedata['pagedata_layout']['layout_grids'] as $grid)
			{
				if($grid['@crossgrid_gridid'])
				{
					$__filelist[]=\ld\Skelcrossgridlist::__getDataFilePath();
				}

				if(\_skel_\Skelcore::griddir_vertical==$grid['grid_gridinfo']['type'])
				{
					foreach($grid['grid_modules'] as $vv)
					{
						$__filelist[]=\_skel_\Skelmodule::config_filepath($vv['module_configid'],\_skel_\Skelcore::skel_dataext_edit);
					}
				}
				else if(\_skel_\Skelcore::griddir_horizontal==$grid['grid_gridinfo']['type'])
				{
					foreach($grid['grid_zones'] as $vv)
					{
						foreach($vv as $vvv)
						{
							$__filelist[]=\_skel_\Skelmodule::config_filepath($vvv['module_configid'],\_skel_\Skelcore::skel_dataext_edit);
						}
					}
				}else{}
			}
		}

		foreach($__filelist as $v)
		{
			if('publish'==$act)
			{
				fs_file_copy($v,path_ext_change($v,'publishdata'));
			}
			else if('rescue'==$act)
			{

				$publishfile=path_ext_change($v,'publishdata');

				if(is_file($publishfile))
				{
					fs_file_copy($publishfile,$v);
				}
				else
				{
					fs_file_delete($v);
				}
			}
			else
			{
				R_alert("err-[1857]");
			}
		}
		if('publish'==$act)
		{
			$pageUrl='/'.$routedna;

			$code='ui_alert("发布成功,你可以:<br><a target=_blank href=\''.$pageUrl.'\' >查看页面</a>");';

			R_jscode($code);
		}
		else
		{
			R_jump('','还原数据完成');
		}

	}
//1 pagedata_pageset
	function pagedata_pageset_edit($routedna)
	{
		$data=$this->__skel->page_data_pagedata['pagedata_pageset'];

		R_window_xml(xml_getxmlfilepath(),url_build('pagedata_pageset_edit_1?routedna='.$routedna),$data,'编辑');
	}
	function pagedata_pageset_edit_1($routedna)
	{

		if(!$_POST['title'])
		{
			R_alert('[error-3217]页面标题不能为空');
		}

		$this->__skel->page_data_save('pagedata_pageset',$_POST,0);

		R_jump();

	}
	function pagedata_layout_savegrids($routedna)
	{
		$this->__skel->page_data_save('pagedata_layout/layout_grids',$_POST,1);

		\_skel_\Skelcore::moduleconfigdata_deleteallnotused();

		R_true();
	}
//1 grid
	function grid_addgrid($routedna)
	{

		R_window_xml(xml_getxmlfilepath(),url_build('grid_addgrid_1?routedna='.$routedna),'','添加');

	}
	function grid_addgrid_1($routedna)
	{

		$grid_type=intval($_POST['grid_type']);

		if(!$grid_type)
		{
			R_alert('请选择一个布局');
		}

		$gridinfo=\_skel_\Skelcore::gridtype_infomap[$grid_type];

		$newgrid=[];
		$newgrid['grid_gridtype']=$grid_type;
		if($gridinfo['zonenum'])
		{
			$newgrid['grid_zones']=[];
			for($i=0;$i<$gridinfo['zonenum'];$i++)
			{

				$newgrid['grid_zones'][]=[];
			}
		}

		$__griddata=$this->__skel->page_data_pagedata['pagedata_layout']['layout_grids'];

		$__griddata[]=$newgrid;

		$this->__skel->page_data_save('pagedata_layout/layout_grids',$__griddata,0);

		R_jump();

	}


	function grid_changegridtype($routedna,$gridindex)
	{

		$data=[];

		foreach($this->__skel->page_data_pagedata['pagedata_layout']['layout_grids'] as $k=>$v)
		{
			if($k==$gridindex)
			{
				$data['grid_type']=$v['grid_gridtype'];
				break;
			}
		}

		if(!$data['grid_type'])
		{
			R_alert('[error-1300]');
		}

		R_window_xml(
			xml_getxmlfilepath('grid_addgrid'),
			url_build('grid_changegridtype_1?routedna='.$routedna.'&gridindex='.$gridindex),
			$data,
			'更改'

			);
	}
	function grid_changegridtype_1($routedna,$gridindex)
	{

		if(!$_POST['grid_type'])
		{
			R_alert('必须选一个布局样式');
		}

		$__griddata=$this->__skel->page_data_pagedata['pagedata_layout']['layout_grids'];

		\_skel_\Skelcore::griddata_adjustgriddata_changegridtype($__griddata[$gridindex],$_POST['grid_type']);

		$this->__skel->page_data_save('pagedata_layout/layout_grids',$__griddata,1);

		R_jump();

	}

//1 crossgrid
	function crossgrid_add($routedna)
	{
		R_window_xml(xml_getxmlfilepath(),url_build('crossgrid_add_1?routedna='.$routedna),'','添加');
	}
	function crossgrid_add_1($routedna)
	{

		if(!$_POST['crossgrid_gridid'])
		{
			R_alert('请选择一个跨页面布局');
		}

		foreach($this->__skel->page_data_pagedata['pagedata_layout']['layout_grids'] as $v)
		{
			if($v['@crossgrid_gridid']&&$v['@crossgrid_gridid']==$_POST['crossgrid_gridid'])
			{
				R_alert('不能添加重复的跨页面布局');
			}
		}


		$__griddata=$this->__skel->page_data_pagedata['pagedata_layout']['layout_grids'];

		$__griddata[]=['@crossgrid_gridid'=>$_POST['crossgrid_gridid']];

		$this->__skel->page_data_save('pagedata_layout/layout_grids',$__griddata,0);

		R_jump();

	}

//1 module
	function module_addmodule($routedna)
	{
		R_window_xml(xml_getxmlfilepath(),url_build('module_addmodule_1?routedna='.$routedna.'&data='.bin_encode($_POST)),'','添加');
	}
	function module_addmodule_1($routedna,$data)
	{

		$__data=bin_decode($data);

		$__module_postion=$__data['module_position'];

		$__gridIndex=$__module_postion['grid_index'];
		$__zoneIndex=$__module_postion['zone_index'];
		$__moduleIndex=$__module_postion['module_index'];

		$module_name=$_POST['module_name'];

		$__griddata=$this->__skel->page_data_pagedata['pagedata_layout']['layout_grids'];

		$module_configid=fs_file_idautoinc(__data_dir__.'/skel/module.lastid.data');

		if(1)
		{
			$default_config=\_lp_\Xmlparser::xmlfile_defaultconfigdata_get(__skel_modulecode_dir__.'/'.$module_name.'/'.$module_name.'.xml');
			fs_file_save_data(\_skel_\Skelmodule::config_filepath($module_configid,\_skel_\Skelcore::skel_dataext_edit),$default_config);
			fs_file_save_data(\_skel_\Skelmodule::config_filepath($module_configid,\_skel_\Skelcore::skel_dataext_publish),$default_config);
		}

		if(1)
		{
			$module=[];
			$module['module_name']=$module_name;
			$module['module_configid']=$module_configid;

			if(-1==$__zoneIndex)
			{
				if(-1==$__moduleIndex)
				{
					$__griddata[$__gridIndex]['grid_modules'][]=$module;
				}
				else
				{
					array_splice($__griddata[$__gridIndex]['grid_modules'],$__moduleIndex,0,array(0=>$module));
				}
			}
			else
			{
				if(-1==$__moduleIndex)
				{
					$__griddata[$__gridIndex]['grid_zones'][$__zoneIndex][]=$module;
				}
				else
				{
					array_splice($__griddata[$__gridIndex]['grid_zones'][$__zoneIndex],$__moduleIndex,0,array(0=>$module));
				}

			}
		}

		$this->__skel->page_data_save('pagedata_layout/layout_grids',$__griddata,1);

		R_jump();

	}
	function module_editmodule()
	{


		$module_name=$_POST['module_name'];

		$module_configid=$_POST['module_configid'];

		$data=\_skel_\Skelmodule::config_getconfig($module_configid,\_skel_\Skelcore::skel_dataext_edit);

		R_window_xml(__skel_modulecode_dir__.'/'.$module_name.'/'.$module_name.'.xml',url_build('module_editmodule_1?module_configid='.$module_configid),$data);

	}
	function module_editmodule_1($module_configid)
	{

		\_skel_\Skelmodule::config_setconfig($module_configid,\_skel_\Skelcore::skel_dataext_edit,$_POST);

		R_jump();
	}

//1 visualedit
	function visualedit_module_deletemodule()
	{

		$__griddata=$this->__skel->page_data_pagedata['pagedata_layout']['layout_grids'];

		foreach($__griddata as $k=>$v)
		{
			if($v['grid_modules'])
			{
				foreach($v['grid_modules'] as $kk=>$vv)
				{
					if($_POST['module_configid']==$vv['module_configid'])
					{
						unset($__griddata[$k]['grid_modules'][$kk]);
					}
				}
			}
			else if($v['grid_zones'])
			{
				foreach($v['grid_zones'] as $kk=>$vv)
				{
					foreach($vv as $kkk=>$vvv)
					{
						if($_POST['module_configid']==$vvv['module_configid'])
						{
							unset($__griddata[$k]['grid_zones'][$kk][$kkk]);
						}
					}
				}
			}
			else
			{

			}
		}

		$this->__skel->page_data_save('pagedata_layout/layout_grids',$__griddata,1);

		\_skel_\Skelcore::moduleconfigdata_deleteallnotused();

		R_jump();

	}
	function visualedit_module_moveindex($routedna,$dir)
	{

		$__griddata=$this->__skel->page_data_pagedata['pagedata_layout']['layout_grids'];

		foreach($__griddata as $k=>$v)
		{
			if($v['grid_modules'])
			{
				foreach($v['grid_modules'] as $kk=>$vv)
				{
					if($_POST['module_configid']==$vv['module_configid'])
					{
						$index=$kk;
						$handle_data=&$__griddata[$k]['grid_modules'];
						goto sink_swap;
					}
				}
			}
			else if($v['grid_zones'])
			{
				foreach($v['grid_zones'] as $kk=>$vv)
				{
					foreach($vv as $kkk=>$vvv)
					{
						if($_POST['module_configid']==$vvv['module_configid'])
						{
							$index=$kkk;
							$handle_data=&$__griddata[$k]['grid_zones'][$kk];
							goto sink_swap;
						}
					}
				}
			}
			else
			{

			}
		}

		R_alert('[error-5653]');

		sink_swap:


		if(-1==$dir&&$index==array_key_first($handle_data))
		{
			R_alert('首节点不能上移');
		}
		else if(1==$dir&&$index==array_key_last($handle_data))
		{
			R_alert('末节点不能下移');
		}
		else
		{

		}

		$handle_data=array_item_move($handle_data,$index,$dir);

		$this->__skel->page_data_save('pagedata_layout/layout_grids',$__griddata,1);

		R_jump();

	}
}
