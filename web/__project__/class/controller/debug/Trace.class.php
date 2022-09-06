<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

namespace controller\debug;

class Trace extends \controller\admin\super\Superadmin
{

	function index()
	{
		_skel();
	}

	function delete()
	{


		$dnas=$_POST['dnas'];

		if(!$dnas)
		{
			R_alert('[error-2252]参数无效');
		}

		$__rootdir=debug_trace(cmd_get);

		$dnas=expd($dnas);

		foreach($dnas as $v)
		{
			fs_file_delete($__rootdir.'/'.$v.'.data');
		}

		R_jump();

	}

	function delete_all()
	{


		$__rootdir=debug_trace(cmd_get);

		fs_dir_delete($__rootdir);

		fs_dir_create($__rootdir);

		R_jump();

	}

}
