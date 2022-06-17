<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\admin;
class Sitesetting extends super\Superadmin
{

	const sitesetting_data_filepath=__data_dir__.'/sitesetting/sitesetting.data';

	function index()
	{
		_skel();
	}
	function edit_base()
	{

		$data=$this->sitesetting_get();
		R_window_xml(xml_getxmlfilepath(),url_build('edit_base_1'),$data);

	}
	function edit_base_1()
	{

		$this->sitesetting_set($_POST);
		R_jump();

	}
	static function sitesetting_get($keyexpd=false)
	{

		static $cache_0=null;
		static $cache_1=null;

		if(cmd_clear===$keyexpd)
		{
			$cache_0=null;
			$cache_1=null;
			return;
		}

		if(is_null($cache_0))
		{
			$cache_0=fs_file_read_data(self::sitesetting_data_filepath,fs_loose);
		}

		if($keyexpd)
		{
			if(is_null($cache_1))
			{
				$cache_1=array_key_expd($cache_0);
			}
			return $cache_1;
		}
		else
		{
			return $cache_0;
		}

	}
	static function sitesetting_set($data)
	{

		sitesetting_get(cmd_clear);
		return fs_file_save_data(self::sitesetting_data_filepath,$data);

	}

}
