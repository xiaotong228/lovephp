<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _skel_;
class Skelmodule
{

	static function config_filepath($config_id,$ext)
	{
		return __skel_layoutdata_dir__.'/moduleconfigdata/'.$config_id.'.'.$ext;
	}
	static function config_getconfig($config_id=false,$ext=false)
	{

		global $____skel_module;

		if(!$config_id)
		{
			$config_id=$____skel_module['module_configid'];
		}

		if(!$ext)
		{
			$ext=(\_skel_\Skelcore::skel_accessmode_edit==__skel_accessmode__||\_skel_\Skelcore::skel_accessmode_preview==__skel_accessmode__)?\_skel_\Skelcore::skel_dataext_edit:\_skel_\Skelcore::skel_dataext_publish;
		}
		return fs_file_read_data(self::config_filepath($config_id,$ext));

	}

	static function config_setconfig($config_id,$ext,$data)
	{
		return fs_file_save_data(self::config_filepath($config_id,$ext),$data);
	}

	static function databridge_databridge($key,$data=null)
	{

		static $cache=[];

		if(isset($data))
		{
			$cache[$key]=$data;
		}
		else
		{
			return $cache[$key];
		}

	}


}
