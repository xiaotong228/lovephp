<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\admin;

class Connect extends super\Superadmin
{
	function login()
	{
		_skel();
	}

	function login_1()
	{

		\db\Adminlog::adminlog_addlog('登录/尝试');

		postdata_assert(
		[
			'user_name'=>'用户名',
			'user_password'=>'密码',
			'vcode_imgvcode'=>'图片验证码',
		]);

		$user=\db\Adminuser::find(['adminuser_name'=>$_POST['user_name']]);

		if(!$user||$user['adminuser_isban']||$user['adminuser_isdelete'])
		{

			\db\Adminlog::adminlog_addlog('登录/失败',0,$_POST);

			R_error('user_name','账号被封或不存在');

		}

		if(\_lp_\Password::check($_POST['user_password'],$user['adminuser_password_hash'],$user['adminuser_password_salt']))
		{

			clu_admin_login($user['id']);

			R_jump('/admin');

		}
		else
		{

			\db\Adminlog::adminlog_addlog('登录/失败',0,$_POST);

			R_error('user_password','密码错误');

		}

	}
	function logout()
	{

		clu_admin_logout();

		R_jump('/admin');

	}

}
