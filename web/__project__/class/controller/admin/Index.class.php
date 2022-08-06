<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\admin;
class Index extends super\Superadmin
{

	function index()
	{
		if($this->leftmenu_menumap)
		{
			R_jump_module('/'.array_key_first($this->leftmenu_menumap));
		}
		_skel();
	}
	function password_changepassword()
	{
		R_window_xml(xml_getxmlfilepath(),url_build('password_changepassword_1'));
	}
	function password_changepassword_1()
	{

		$currentuser=\db\Adminuser::assertfind(clu_admin_id());

		postdata_assert([
			'password'=>'原密码',
			'password_new_0'=>'新密码',
			'password_new_1'=>'确认新密码',
		]);

		if($_POST['password_new_0']!==$_POST['password_new_1'])
		{
			R_error('password_new_1','重复密码不一致');
		}

		if(!\_lp_\Validate::is_password($_POST['password_new_0']))
		{
			R_error('password_0','新密码'.\_lp_\Validate::lasterror_msg());
		}

		$check=\_lp_\Password::check($_POST['password'],$currentuser['adminuser_password_hash'],$currentuser['adminuser_password_salt']);
		if(!$check)
		{
			R_alert('[error-3710]原密码错误');
		}

		$password=\_lp_\Password::create($_POST['password_new_0']);

		$data=[];
		$data['adminuser_password_hash']=$password['hash'];
		$data['adminuser_password_salt']=$password['salt'];

		\db\Adminuser::save(clu_admin_id(),$data);

		clu_admin_login(clu_admin_id());//再登录下防止被踢出去

		R_jump('','修改登录密码完成');

	}
	function itemdetail_user($id)
	{

		$user=\db\User::find($id);

		$__table_header=
		[
			'项目'=>'200px',
			'值'=>0,
		];

		$__table_body=[];
		$__table_body[]=['id',$user['id']];
		$__table_body[]=['用户名',$user['user_name']];
		$__table_body[]=['头像',_an__($user['user_avatar'],'','','',_img($user['user_avatar'],'img_w30'))];
		$__table_body[]=['手机号',$user['user_mobile']];
		$__table_body[]=['邮箱',$user['user_email']];
		$__table_body[]=['状态',_status(!$item['adminuser_isban'],'正常','禁用')];

		$H='';

		$H.=_div('','','xmlwindow=head');
			$H.=_b__('','border-right:0;','','用户详情');
			$H.=_a0__('','','uiwindow_role=close');
		$H.=_div_();

		$H.=_div('','','xmlwindow_role=body');
			$H.=\_widget_\Tablelist::tablelist_html($__table_header,$__table_body);
		$H.=_div_();

		$domset=[];
		$domset['tail']='__xmlwindow__=xmlwindow';

		R_window($H,$domset);

	}

}
