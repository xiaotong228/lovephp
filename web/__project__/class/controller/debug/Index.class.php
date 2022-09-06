<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

namespace controller\debug;

class Index extends \controller\admin\super\Superadmin
{

	function index()
	{
		_skel();
	}

	function userhacklogin_login()
	{
		R_window_xml(xml_getxmlfilepath(),url_build('userhacklogin_login_1'));
	}

	function userhacklogin_login_1()
	{

		$id=intval($_POST['hacklogin_userid']);

		if(!$id)
		{
			R_alert('[error-0411]请填写用户uid');
		}

		clu_login(intval($_POST['hacklogin_userid']));

		R_jump();

	}
}
