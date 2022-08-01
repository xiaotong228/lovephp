<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



echo _module('c_admin_panel_template_scroll');

	echo _div__('g_warnbox','','','和路由的module,controller,action对应,右键点击节点操作');

	echo $____controller->treedata_html(1);

echo _module_();

