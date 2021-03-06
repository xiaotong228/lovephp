<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\admin;
class User extends super\Superadmin
{

	function index()
	{
		_skel();
	}

	function add()
	{
		R_window_xml(xml_getxmlfilepath(),url_build('add_1'));
	}

	function add_1()
	{

		postdata_assert([
			'user_name'=>'用户名',
			'user_password_0'=>'密码',
			'user_password_1'=>'重复密码',
		]);

		$__adddata=$_POST;

		unset($__adddata['user_password_0']);
		unset($__adddata['user_password_1']);

		if(1)
		{
			if($_POST['user_password_0']===$_POST['user_password_1'])
			{
				$__adddata['user_password']=$_POST['user_password_0'];
			}
			else
			{
				R_alert('[error-3725]重复密码不一致');
			}
		}

		\db\User::createuser_createuser($__adddata);

		R_jump();

	}
	function edit($id=0)
	{

		if($id)
		{
			$data=\db\User::assertfind($id);
		}

		R_window_xml(xml_getxmlfilepath('add'),url_build('edit_1?id='.$id),$data);

	}
	function edit_1($id=0)
	{

		postdata_assert([
			'user_name'=>'用户名',
		]);


		$__savedata=$_POST;

		if(1)
		{
			unset($__savedata['user_password_0']);
			unset($__savedata['user_password_1']);

			foreach($__savedata as &$v)
			{
				if(!$v)
				{
					$v='';
				}
			}
			unset($v);
		}

		if(1)
		{
			if($_POST['user_password_0']||$_POST['user_password_1'])
			{
				if($_POST['user_password_0']===$_POST['user_password_1'])
				{

					if(\_lp_\Validate::is_password($_POST['user_password_0']))
					{
						$temp=\_lp_\Password::create($_POST['user_password_0']);
						$__savedata['user_password_hash']=$temp['hash'];
						$__savedata['user_password_salt']=$temp['salt'];
					}
					else
					{
						R_alert('密码'.\_lp_\Validate::lasterror_msg());
					}
				}
				else
				{
					R_alert('[error-3725]重复密码不一致');
				}
			}
		}

		if(1)
		{
			$check=\db\User::checkavailable_username($__savedata['user_name'],$id);
			if(true!==$check)
			{
				R_alert('[error-2614]'.$check);
			}
		}
		if($__savedata['user_mobile'])
		{
			$check=\db\User::checkavailable_mobile($__savedata['user_mobile'],$id);
			if(true!==$check)
			{
				R_alert('[error-1652]'.$check);
			}
		}
		if($__savedata['user_email'])
		{

			$check=\db\User::checkavailable_email($__savedata['user_email'],$id);
			if(true!==$check)
			{
				R_alert('[error-1657]'.$check);
			}
			$__savedata['user_email']=strtolower($__savedata['user_email']);

		}

		\db\User::save($id,$__savedata);

		R_jump();

	}
	function ban_yes($id)
	{

		\db\User::save_fieldset($id,'user_isban',1);
		R_jump();

	}
	function ban_no($id)
	{

		\db\User::save_fieldset($id,'user_isban',0);
		R_jump();

	}
}
