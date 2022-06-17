<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



echo _module();

	echo _div('g_module_header');
		echo _b__('','','','设置头像');
	echo _div_();

	$config=[];
	$config['uploadavatar_saveurl']='/cluindex/useravatar_1';
	echo \_widget_\Uploadavatar::uploadavatar_html($config);

echo _module_();

