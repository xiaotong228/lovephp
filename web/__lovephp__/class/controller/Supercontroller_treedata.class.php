<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace _lp_\controller;

trait Supercontroller_treedata
{

	public $treedata_filepath;
	public $treedata_treeobj;

	public $treedata_xmlfilepath=false;
//1 add
	function treedata_add($dna)
	{

		if(!$this->treedata_xmlfilepath)
		{
			$this->treedata_xmlfilepath=xml_getxmlfilepath();
		}

		R_window_xml($this->treedata_xmlfilepath,url_build('treedata_add_1?dna='.$dna));

	}
	function treedata_add_1($dna)
	{

		$this->treedata_assertpostdata();

		if(!$this->treedata_treeobj->node_addnode_uniquename($_GET['dna'],$_POST['name']))
		{
			R_alert('[error-3752]节点重名冲突');
		}

		$nodelv=$this->treedata_treeobj->node_nodelv($dna);

		if(1)
		{//特殊处理,不想再封装一层了

			if('routemap'==__route_controller__)
			{

				if(!\_lp_\Validate::is_functionname($_POST['name']))
				{
					R_alert('名称'.\_lp_\Validate::lasterror_msg());
				}

				if(2==$nodelv)
				{
					if(!$_POST['title'])
					{
						R_alert('页面标题必填');
					}

					$acsts=$this->treedata_treeobj->node_nodeacsts($dna);

					$routepath=$acsts[1]['self']['name'].'/'.$acsts[2]['self']['name'].'/'.$_POST['name'];

					$pageSet=[];
					$pageSet['title']=$_POST['title'];
					$pageSet['keywords']=$_POST['keywords'];
					$pageSet['description']=$_POST['description'];

					$layout=[];
					$layout['pagedata_pageset']=$pageSet;
					$layout['pagedata_layout']=[];

					fs_file_save_data(strtolower(__skel_layoutdata_dir__.'/pagedata/'.$routepath.'.'.\_skel_\Skelcore::skel_dataext_edit),$layout);
					fs_file_save_data(strtolower(__skel_layoutdata_dir__.'/pagedata/'.$routepath.'.'.\_skel_\Skelcore::skel_dataext_publish),$layout);

					unset($_POST['title']);
					unset($_POST['keywords']);
					unset($_POST['description']);

				}

			}
			else{}

		}

		$nodelv=$this->treedata_treeobj->node_addnode($dna,fs_file_idautoinc(path_ext_change($this->treedata_filepath,'lastid.data')),$_POST);

		$this->treedata_operreturn($dna);

	}

//1 edit
	function treedata_edit($dna)
	{

		$node=$this->treedata_treeobj->node_findnode($dna);

		if(!$this->treedata_xmlfilepath)
		{
			$this->treedata_xmlfilepath=xml_getxmlfilepath();
		}

		$nodelv=$this->treedata_treeobj->node_nodelv($dna);

		R_window_xml($this->treedata_xmlfilepath,url_build('treedata_edit_1?dna='.$dna),$node['self'],'ID:'.$dna);

	}
	function treedata_edit_1($dna)
	{

		$this->treedata_assertpostdata();

		if(!$this->treedata_treeobj->node_editnode_uniquename($_GET['dna'],$_POST['name']))
		{
			R_alert('[error-3759]节点重名冲突');
		}

		$nodelv=$this->treedata_treeobj->node_nodelv($dna);

		if(1)
		{
			if('routemap'==__route_controller__)
			{
				if(!\_lp_\Validate::is_functionname($_POST['name']))
				{
					R_alert('名称'.\_lp_\Validate::lasterror_msg());
				}

				$routepath=$this->treedata_treeobj->node_routepath($dna);

				if(3==$nodelv)
				{
					fs_file_move(__skel_layoutdata_dir__.'/pagedata/'.$routepath.'.data',$_POST['name'].'.data');
					fs_file_move(__skel_layoutdata_dir__.'/pagedata/'.$routepath.'.publishdata',$_POST['name'].'.publishdata');
				}
				else
				{
					fs_dir_move(__skel_layoutdata_dir__.'/pagedata/'.$routepath,$_POST['name']);

				}
			}
			else{}
		}

		$this->treedata_treeobj->node_editnode($dna,$_POST);

		$this->treedata_operreturn();

	}

//1 move
	function treedata_moveup($dna)
	{
		$this->treedata_treeobj->node_movenode($dna,-1);
		$this->treedata_operreturn();
	}
	function treedata_movedown($dna)
	{
		$this->treedata_treeobj->node_movenode($dna,1);
		$this->treedata_operreturn();
	}

//1 delete
	function treedata_delete($dna)
	{

		$nodelv=$this->treedata_treeobj->node_nodelv($dna);

		if(1)
		{
			if('routemap'==__route_controller__)
			{
				$routepath=$this->treedata_treeobj->node_routepath($dna);

				if(3==$nodelv)
				{
					fs_file_delete(__skel_layoutdata_dir__.'/pagedata/'.$routepath.'.data');
					fs_file_delete(__skel_layoutdata_dir__.'/pagedata/'.$routepath.'.publishdata');
				}
				else
				{
					fs_dir_delete(__skel_layoutdata_dir__.'/pagedata/'.$routepath);
				}

				\_skel_\Skelcore::moduleconfigdata_deleteallnotused();

			}
			else{}
		}

		$this->treedata_treeobj->node_deletenode($dna);

		$this->treedata_operreturn();

	}

//1 tree
	function treedata_html($defaultopenlv=0)
	{

		$config=[];

		$config['treeshow_nodepopupmenuurl']=url_build('treedata_nodemenu');
		$config['treeshow_updatehtmlurl']=url_build('treedata_html_update');

		if(1)
		{
			$this->treedata_treeobj->tree_walknodes(function(&$node,$lv)
				{

					if('routemap'==__route_controller__)
					{

						$H='';
						if(3==$lv)
						{

							$routepath=$this->treedata_treeobj->node_routepath($node['dna']);

							$temp=new \_skel_\Skelpagedata($routepath,\_skel_\Skelcore::skel_dataext_edit,0);

							if($temp->page_data_pagedata)
							{
								$H.=_span__('','','',$temp->page_data_pagedata['pagedata_pageset']['title']);
							}
							else
							{
								$H.=_span__('','color:red;','','没有找到布局文件');

							}

							$node['self']['@node_self_icon']='&#xf075;@#0abf5b';

						}

						$node['self']['@node_self_body']=$H;

					}
					else{}
				});
		}

		return \_widget_\Treeshow::treeshow_html($this->treedata_treeobj->data_treedata,$config,$defaultopenlv);


	}
	function treedata_html_update()
	{
		R_true($this->treedata_html());
	}

//1 nodemenu
	function treedata_nodemenu($dna)
	{
		R_true(false);
	}

	function treedata_operreturn($mustopendna=false)
	{

		$this->treedata_treeobj->file_savetofile();

		//只用了__treeshow__=treeshow这个做选择器,如果是一个页面有多个treeshow,可以给个id再做区分

		$code='

			ui_window_close_all();
			__lpwidget__.treeshow.ts_updatehtml($("[__treeshow__=treeshow]"),'.$mustopendna.');


			';
		R_jscode($code);
	}

//1 postdata
	function treedata_assertpostdata()
	{

		$_POST['name']=strtolower($_POST['name']);

		if(!$_POST['name'])
		{
			R_alert('[error-3746]名称必填');
		}

	}

}
