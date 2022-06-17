<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

echo _module();

	echo _div__('ttz','','',\Prjconfig::project_config['project_name'].\_skel_\Skelmodule::databridge_databridge('page_title'));
	echo _div('bdz');
		echo \_skel_\Skelmodule::databridge_databridge('page_inhtml');
	echo _div_();

echo _module_();

