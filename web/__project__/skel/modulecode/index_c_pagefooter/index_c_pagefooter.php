<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



echo _module();

	echo _a__('/','','','','首页');

	echo _a__('/example','','','','组件演示');

	echo _an__('/help/terms_service','','','',\controller\foreground\Help::service_title);

	echo _an__('/help/terms_privacy','','','',\controller\foreground\Help::privacy_title);

	echo _an__('/help/aboutus','','','',\controller\foreground\Help::aboutus_title);

	echo _span__('','','',\Prjconfig::project_config['project_name']);

	echo _span__('','','',\Prjconfig::project_config['project_officialsite']);

echo _module_();


