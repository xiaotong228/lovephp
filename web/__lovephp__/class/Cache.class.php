<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _lp_;
class Cache
{

	const cache_dir=__temp_dir__.'/cachedata';

	static $cache_data=[];

	static function cache_set($route,$data)
	{

		if(is_null($data))
		{
			R_alert('[error-4704]');
		}

		self::$cache_data[$route]=$data;

		$__filepath=self::cache_dir.'/'.$route;
		return fs_file_save_data($__filepath.'.data',$data);

	}
	static function cache_get($route,$updatedata=null)
	{
		static $cache_data=[];

		if(!is_null(self::$cache_data[$route]))
		{
			return self::$cache_data[$route];
		}

		$__filepath=self::cache_dir.'/'.$route;

		self::$cache_data[$route]=fs_file_read_data($__filepath.'.data',fs_loose);
		return self::$cache_data[$route];

	}

}

