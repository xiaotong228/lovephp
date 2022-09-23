<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\skel;

class Routemap extends \controller\admin\super\Superadmin
{

	use \_lp_\controller\Supercontroller_treedata
	{
		treedata_add as public treedata_add_trait;
		treedata_edit as public treedata_edit_trait;
	}

	function __construct()
	{

		parent::__construct();

		$this->treedata_filepath=__data_dir__.'/skel/skelroutemap/skelroutemap.data';
		$this->treedata_treeobj=new \_lp_\datamodel\Treedata($this->treedata_filepath);

	}
	function index()
	{
		_skel();
	}
	function treedata_add($dna)
	{

		$nodelv=$this->treedata_treeobj->node_nodelv($dna);

		$xmlfilepath=xml_getxmlfilepath();

		$xmlfilepath=str_replace('.xml','.lv'.($nodelv+1).'.xml',$xmlfilepath);

		$this->treedata_xmlfilepath=$xmlfilepath;

		$this->treedata_add_trait($dna);
	}

	function treedata_edit($dna)
	{

		$nodelv=$this->treedata_treeobj->node_nodelv($dna);

		$xmlfilepath=xml_getxmlfilepath('treedata_add');

		if(3==$nodelv)
		{
			$xmlfilepath=str_replace('.xml','.lv'.$nodelv.'_rename.xml',$xmlfilepath);
		}
		else
		{
			$xmlfilepath=str_replace('.xml','.lv'.$nodelv.'.xml',$xmlfilepath);
		}

		$this->treedata_xmlfilepath=$xmlfilepath;

		$this->treedata_edit_trait($dna);

	}

	function treedata_nodemenu($dna)
	{

		if(0==$dna)
		{
			$H.=_a0__('','','popupmenu_role=menu onclick="tree_oper(\'treedata_add\',\''.$dna.'\');"','添加/MOUDLE');
		}
		else
		{

			$lv=$this->treedata_treeobj->node_nodelv($dna);

			if(1==$lv)
			{
				$H.=_a0__('','','popupmenu_role=menu onclick="tree_oper(\'treedata_add\',\''.$dna.'\');"','添加/CONTROLLER');
			}
			else if(2==$lv)
			{
				$H.=_a0__('','','popupmenu_role=menu onclick="tree_oper(\'treedata_add\',\''.$dna.'\');"','添加/ACTION');
			}
			else if(3==$lv)
			{

				$routepath=$this->treedata_treeobj->node_routepath($dna);

				$H.=_an__('/'.$routepath,'','','popupmenu_role=menu','查看页面');

				$H.=_an__('/skel/layoutedit?routedna='.$routepath,'','','popupmenu_role=menu','设计页面');

				$H.=_div__('','','popupmenu_role=sepline');

			}
			else
			{
				R_alert('[error-3832]');
			}

			$H.=_a0__('','','popupmenu_role=menu onclick="tree_oper(\'treedata_edit\',\''.$dna.'\');"','编辑');
			$H.=_a0__('','','popupmenu_role=menu onclick="tree_oper(\'treedata_delete\',\''.$dna.'\',\'删除\');"','删除');

			$H.=_div__('','','popupmenu_role=sepline');

			$H.=_a0__('','','popupmenu_role=menu onclick="tree_oper(\'treedata_moveup\',\''.$dna.'\');"','上移一位↑');
			$H.=_a0__('','','popupmenu_role=menu onclick="tree_oper(\'treedata_movedown\',\''.$dna.'\');"','下移一位↓');

		}

		R_true($H);

	}
}
