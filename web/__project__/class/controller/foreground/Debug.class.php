<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace controller\foreground;

class Debug extends super\Superforeground
{
	function __construct()
	{

		if(__online_isonline__)
		{
			if(clu_admin_issuperadmin())
			{//ok,可以用

			}
			else
			{
				R_alert('[error-4147]封闭');
			}
		}

		parent::__construct();

	}

	function trace()
	{

		$__dirpath=__temp_dir__.'/trace';

		if($_GET['clear'])
		{
			fs_dir_delete($__dirpath);
			fs_dir_create($__dirpath);
			R_jump(url_build('trace'));
		}

		echo _a__(url_build('',array('clear'=>1)),'','','','清除');

		echo "<hr>";

		$list=fs_dir_list($__dirpath);

		foreach($list['file'] as $v)
		{
			echo "<font color=red>{$v}:</font><br>";
			dd(fs_file_read_data($__dirpath.'/'.$v));
		}

	}
	function session()
	{
		$sessiondir=session_save_path();
		echo '<font color=red>lovephp-4941</font><br>';
		echo $sessiondir;
		dd($_SESSION);
		dd($_COOKIE);
	}
	function session_all()
	{//返回全部session,不仅仅是自己的,没有指定save_path的话,或者对于save_path无权限,读取不出来

		$sessiondir=session_save_path();

		$dirlist=fs_dir_list($sessiondir);

		foreach($dirlist['file'] as $v)
		{

			$filepath=$sessiondir.'/'.$v;
			echo "<font color=red>".$v."</font><br>";

			ob_start();
			readfile($filepath);
			$txt=ob_get_clean();

			$txt=str_replace(__session_root__.'|','',$txt);
			$txt=unserialize($txt);

			dd($txt);

		}
	}
	function login($id)
	{//直接登录特定用户

		clu_login($id);
		dd($_SESSION);

	}
	function phpinfo()
	{
		phpinfo();
	}
	function test()
	{
		R_alert('[error-3123]');
	}

}
