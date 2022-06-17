<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



echo _module();

	foreach($____controller->__leftmenu_menus as $k=>$v)
	{
		$cls='menu';
		if(route_judge(cmd_ignore,$k))
		{
			$cls.=' _csel_';
		}
		echo _a('/'.$k,$cls);
			echo $v;
		echo _a_();
	}

echo _module_();
