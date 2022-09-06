<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

$__userdata=clu_data();

echo _module('c_admin_panel_template_scroll');

	echo _div('c_admin_panel_oper');

		echo _a0__('','','__button__="small green solid" onclick="table_oper(this,\'userhacklogin_login\')" ','前台登录用户');

		echo _b__('','','','前台当前登录用户:');

		if($__userdata)
		{
			echo _span__('','','',$__userdata['user_name'].'#'.$__userdata['id']);
		}
		else
		{
			echo _span__('__color_grey__','','','_无_');
		}

	echo _div_();

echo _module_();

