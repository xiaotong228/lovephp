<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



$userdata=clu_admin_data();

echo _module();

	echo _a__('/'.$v[0],'logoz');

	if($userdata)
	{
		$temp=
		[
			['admin','业务后台'],
			['skel','页面编辑'],
			['cloud','云空间']
		];

		foreach($temp as $v)
		{
			echo _a__('/'.$v[0],'navitem'.(__route_module__==$v[0]?' csel':''),'','',$v[1].'('.$v[0].')');
		}

		echo _a0__('rightoper','','onclick="table_oper_confirm(this,\'/admin/connect/logout\')"','退出');

		echo _a0__('rightoper','','onclick="table_oper(this,\'/admin/index/password_changepassword\')"','更改密码');

		echo _span__('rightoper','','','当前登录:'.$userdata['adminuser_name'].'#'.$userdata['id'].(clu_admin_issuperadmin()?'[超管]':''));
	}
	else
	{
		echo _a__('/admin/connect/login','rightoper','','','登录');
	}

echo _module_();

