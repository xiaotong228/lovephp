<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



$__cludata=clu_data();

echo _module();

	echo _a__('/'.$v[0],'logoz');

	if(1)
	{
		echo _a('/example','','margin-left:20px;font-weight:bold;');
			echo '组件演示';
		echo _a_();
	}

	if(clu_id())
	{
		echo _a0__('','float:right;color:red;margin-left:20px;','onclick="clu_connect_logout()"','退出');

		echo _a__('/cluindex','','float:right;','','当前登录:'.$__cludata['user_name'].'#'.clu_id());

	}
	else
	{
		echo _a__('/connect/regist','','float:right;','','注册');
		echo _a__('/connect/login','','float:right;margin-right:20px;','','登录');

	}

echo _module_();

