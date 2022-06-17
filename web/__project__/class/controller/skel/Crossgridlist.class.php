<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\skel;

class Crossgridlist extends \controller\admin\super\Superadmin
{

	use \_lp_\controller\Supercontroller_listdata;

	function __construct()
	{
		parent::__construct();
		$this->listdata_dataclass='\ld\Skelcrossgridlist';
	}

	function index()
	{
		_skel();
	}

	function listdata_add_1()
	{

		$this->listdata_postdataassert();

		$gridinfo=\_skel_\Skelcore::gridtype_infomap[$_POST['grid_type']];

		$data=[];

		$data['name']=$_POST['name'];


		$data['layout_grids']=[];
		$data['layout_grids']['grid_gridtype']=intval($_POST['grid_type']);

		if($gridinfo['zonenum'])
		{
			$data['layout_grids']['grid_zones']=[];
			for($i=0;$i<$gridinfo['zonenum'];$i++)
			{
				$data['layout_grids']['grid_zones'][]=[];
			}
		}

		$this->listdata_dataclass::item_additem($data);

		R_jump();

	}
	function listdata_edit($id)
	{

		$xmlfilepath=xml_getxmlfilepath();

		$item=$this->listdata_dataclass::item_finditem($id);

		$data=[];
		$data['name']=$item['name'];
		$data['grid_type']=$item['layout_grids']['grid_gridtype'];

		R_window_xml($xmlfilepath,url_build('listdata_edit_1?id='.$id),$data,'ID:'.$id);

	}
	function listdata_edit_1($id)
	{

		$this->listdata_postdataassert($id);

		$data=$this->listdata_dataclass::item_finditem($id);

		$grid_type=intval($_POST['grid_type']);

		$data['name']=$_POST['name'];

		\_skel_\Skelcore::griddata_adjustgriddata_changegridtype($data['layout_grids'],$grid_type);

		$this->listdata_dataclass::item_edititem($id,$data);

		R_jump();

	}

}

