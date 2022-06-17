<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\skel;
class Index extends \controller\admin\super\Superadmin
{
	function index()
	{
		R_jump_module('/'.array_key_first(\controller\admin\super\Superadmin::leftmenu_skel));
	}
}
