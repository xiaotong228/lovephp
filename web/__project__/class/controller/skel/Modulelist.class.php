<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\skel;

class Modulelist extends \controller\admin\super\Superadmin
{

	use \_lp_\controller\Supercontroller_listdata;

	function __construct()
	{
		parent::__construct();
		$this->listdata_dataclass='\ld\Skelmodulelist';
	}

	function index()
	{
		_skel();
	}
	function listdata_add_1()
	{

		$this->listdata_postdataassert();

		if(!$_POST['title'])
		{
			R_alert('标题必须');
		}

		if(!\_lp_\Validate::is_functionname($_POST['name']))
		{
			R_alert('模块名称'.\_lp_\Validate::lasterror_msg());
		}

		$new_module_dir=__skel_modulecode_dir__.'/'.$_POST['name'];

		if(path_isdir_ignorecase($new_module_dir))
		{
			R_alert('[error-3938]和现有模块重名冲突(不区分大小写)');
		}

		if(1)
		{//创建module代码

			$exts=$this->listdata_dataclass::modulecode_get_file_exts();

			fs_dir_copy(__lp_dir__.'/skel/module_mother_template',$new_module_dir);

			$module_name=$_POST['name'];

			foreach($exts as $v)
			{

				$cont=fs_file_read($new_module_dir.'/module_mother.'.$v);
				$cont=str_replace('{__MODULE_NAME__}',$module_name,$cont);
				$cont=str_replace('{__MODULE_TITLE__}',$_POST['title'],$cont);
				$cont=str_replace('{__MODULE_THUMB__}',$_POST['thumb'],$cont);
				$cont=str_replace('{__MODULE_DESCRIPTION__}',$_POST['description'],$cont);

				fs_file_save($new_module_dir.'/module_mother.'.$v,$cont);

				fs_file_move($new_module_dir.'/module_mother.'.$v,$module_name.'.'.$v);

			}

			session_set('skelmodulelist_lastadd',$module_name);

		}

		R_jump();


		$this->listdata_dataclass::item_additem($_POST);

		R_jump();

	}
	function listdata_edit_1($id)
	{

		$this->listdata_postdataassert($id);

		if(!\_lp_\Validate::is_functionname($_POST['name']))
		{
			R_alert('模块名称'.\_lp_\Validate::lasterror_msg());
		}

		$old_item=$this->listdata_dataclass::item_finditem($id);

		$old_name=$old_item['name'];
		$new_name=$_POST['name'];

		if(0===strcasecmp($old_name,$new_name))
		{
			R_alert('新旧名不能一样(不区分大小写)');
		}

		if(path_isdir_ignorecase(__skel_modulecode_dir__.'/'.$new_name))
		{
			R_alert('[error-4230]不能和现有的模块重名');
		}

		if(1)
		{
			$modulecode_fileexts=\ld\Skelmodulelist::modulecode_get_file_exts();

			foreach($modulecode_fileexts as $v)
			{
				fs_file_move(__skel_modulecode_dir__.'/'.$old_name.'/'.$old_name.'.'.$v,$new_name.'.'.$v);
			}

			fs_dir_move(__skel_modulecode_dir__.'/'.$old_name,$new_name);

			foreach($modulecode_fileexts as $v)
			{
				$filepath=__skel_modulecode_dir__.'/'.$new_name.'/'.$new_name.'.'.$v;

				$cont=fs_file_read($filepath);

				$cont=str_replace('[skelmodule_name='.$old_name.']','[skelmodule_name='.$new_name.']',$cont);

				$cont=str_replace('<name>'.$old_name.'</name>','<name>'.$new_name.'</name>',$cont);

				fs_file_save($filepath,$cont);
			}

			\_skel_\Skelcore::griddata_allgriddata_walk(function(&$grid) use ($old_name,$new_name)
				{

					if($grid['grid_modules'])
					{
						foreach($grid['grid_modules'] as &$v)
						{
							if($old_name==$v['module_name'])
							{
								$v['module_name']=$new_name;
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
								if($old_name==$vv['module_name'])
								{
									$vv['module_name']=$new_name;
								}
							}
							unset($vv);
						}
						unset($v);
					}else{}
				},true);

		}

		session_set('skelmodulelist_lastedit',$new_name);

		R_jump();

	}
	function listdata_delete($id)
	{

		$item=$this->listdata_dataclass::item_finditem($id);

		$moduleName=$item['name'];

		fs_dir_delete(__skel_modulecode_dir__.'/'.$moduleName);

		$configIds=[];

		\_skel_\Skelcore::griddata_allgriddata_walk(function(&$grid) use ($moduleName,&$configIds)
			{

				if($grid['grid_modules'])
				{
					foreach($grid['grid_modules'] as $k=>$v)
					{
						if($v['module_name']==$moduleName)
						{
							unset($grid['grid_modules'][$k]);
							$configIds[]=$v['module_configid'];
						}
					}
				}
				else if($grid['grid_zones'])
				{
					foreach($grid['grid_zones'] as $k=>$v)
					{
						foreach($v as $kk=>$vv)
						{
							if($vv['module_name']==$moduleName)
							{
								unset($grid['grid_zones'][$k][$kk]);
								$configIds[]=$vv['module_configid'];
							}
						}
					}
				}else{}
			},true);

		if(1)
		{//删掉module_configid相关数据

			foreach($configIds as $v)
			{
				$path=\_skel_\Skelmodule::config_filepath($v,\_skel_\Skelcore::skel_dataext_edit);
				fs_file_delete($path);

				$path=\_skel_\Skelmodule::config_filepath($v,\_skel_\Skelcore::skel_dataext_publish);
				fs_file_delete($path);
			}

		}

		R_jump();

	}
}
