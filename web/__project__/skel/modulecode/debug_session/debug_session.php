<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

echo _module('c_admin_panel_template_scroll');


	if(route_judge(cmd_ignore,'session'))
	{

		echo _div__('g_warnbox','','','session_path:&nbsp;'.session_save_path().'<br>session_id:&nbsp;'.session_id().'<br>右键点击节点操作'
	//		._span__('__color_orange__','','','调试功能在线上模式可能很危险,请注意控制权限')
		);
		echo debug_dump($_SESSION);

	}
	else if(route_judge(cmd_ignore,'cookie'))
	{

		echo _div__('g_warnbox','','','只提供了简单的cookie操作,复杂情况请用浏览器调试模式操作<br>右键点击节点操作,只能操作以'.__cookie_prefix__.'开头的cookie');
		echo debug_dump($_COOKIE);

	}
	else
	{
		echo '[error-0039]待完善';
	}

echo _module_();

