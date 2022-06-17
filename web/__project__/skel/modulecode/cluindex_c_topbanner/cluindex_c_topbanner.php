<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



$__cludata=clu_data();

echo _module();

	echo _a__('/cluindex/useravatar','avatar','','',_img($__cludata['user_avatar']));

	echo _div('p0');

		echo _div('p00');
			echo _span__('','','',$__cludata['user_name']);
		echo _div_();

		echo _div('p01');
			echo _span__('','','','UID:'.$__cludata['id']);
		echo _div_();

	echo _div_();

echo _module_();

