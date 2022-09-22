<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace _lp_\controller;

trait Supercontroller_listdata
{

	public $listdata_dataclass;

	function listdata_add()
	{

		$xmlfilepath=xml_getxmlfilepath();

		R_window_xml($xmlfilepath,url_build('listdata_add_1'));

	}
	function listdata_add_1()
	{

		$this->listdata_postdataassert();

		$this->listdata_dataclass::item_additem($_POST);

		R_jump();

	}
	function listdata_edit($id)
	{

		$xmlfilepath=xml_getxmlfilepath();

		$data=$this->listdata_dataclass::item_finditem($id);

		R_window_xml($xmlfilepath,url_build('listdata_edit_1?id='.$id),$data,'ID:'.$id);

	}
	function listdata_edit_1($id)
	{

		$this->listdata_postdataassert();

		$this->listdata_dataclass::item_edititem($id,$_POST);

		R_jump();

	}
	function listdata_delete($id)
	{

		$this->listdata_dataclass::item_deleteitem($id);

		R_jump();
	}

	function listdata_moveup($id)
	{
		$this->listdata_dataclass::item_moveitem($id,-1);
		R_jump();
	}
	function listdata_movedown($id)
	{
		$this->listdata_dataclass::item_moveitem($id,1);
		R_jump();
	}
//1 postdata
	function listdata_postdataassert($exceptid=0)
	{

		if(1)
		{//如果允许大写,关闭,或者做区分
			$_POST['name']=strtolower($_POST['name']);
		}

		if(!$_POST['name'])
		{
			R_alert('[error-4442]名称必须');
		}
		if(!$this->listdata_dataclass::item_uniquename($_POST['name'],$exceptid))
		{
			R_alert('[error-1034]重名冲突');
		}

	}

}
