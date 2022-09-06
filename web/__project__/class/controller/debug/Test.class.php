<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

namespace controller\debug;

class Test extends \controller\admin\super\Superadmin
{

	function index()
	{

		$aaa=[];
		$aaa[math_salt()]=math_salt();
		$aaa[math_salt()]=math_salt();
		$aaa[math_salt()]=math_salt();

		echo debug_dump($aaa);

		R_alert('[error-0822]测试预留');

	}

}
