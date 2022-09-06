<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



$adminuserdata=clu_admin_data();

echo _module();

	echo _a__('/'.$v[0],'logoz');

	if(
		$adminuserdata||
		(route_judge('debug')&&!__online_isonline__)
	)
	{
		$temp=
		[
			['admin','业务后台'],
			['skel','页面编辑'],
			['cloud','云空间'],
			['debug','调试']
		];

		foreach($temp as $v)
		{
			echo _a__('/'.$v[0],'navitem'.(__route_module__==$v[0]?' csel':''),'','',$v[1].'('.$v[0].')');
		}

		if(route_judge('debug')&&!__online_isonline__)
		{
			echo _span__('__color_red__','margin-left:20px;','','开发模式下调试页面不检测管理员权限');
		}
		else if($adminuserdata)
		{
			echo _a0__('rightoper','','onclick="table_oper_confirm(this,\'/admin/connect/logout\')"','退出');
			echo _a0__('rightoper','','onclick="table_oper(this,\'/admin/index/password_changepassword\')"','更改密码');
			echo _span__('rightoper','','','当前登录:'.$adminuserdata['adminuser_name'].'#'.$adminuserdata['id'].(clu_admin_issuperadmin()?'[超管]':''));
		}

		else
		{
			R_alert('[error-1612]');
		}

	}
	else
	{
		echo _a__('/admin/connect/login','rightoper','','','登录');
	}

echo _module_();

