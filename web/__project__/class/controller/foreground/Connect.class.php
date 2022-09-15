<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\foreground;

class Connect extends super\Superforeground
{

//1 login
	function login()
	{
		_skel();
	}
	function login_1()
	{
		R_alert('[error-4811]废弃');
	}
	function login_1_password()
	{

		postdata_assert
		([
			'user_name'=>'用户名',
			'user_password'=>'密码',
			'vcode_imgvcode'=>'图片验证码',
		]);

		if(1)
		{
			$where=[];

			if(\_lp_\Validate::is_mobile($_POST['user_name']))
			{
				$where['user_mobile']=$_POST['user_name'];
			}
			else
			{
				$where['user_name']=$_POST['user_name'];
			}

			$__user=\db\User::find($where);

			if($__user)
			{
				if(\_lp_\Password::check($_POST['user_password'],$__user['user_password_hash'],$__user['user_password_salt']))
				{

					\db\Userlog::userlog_addllog($__user['id'],'登录/密码登录');

					$this->login_1_sink($__user['id']);

				}
				else
				{

					\db\Userlog::userlog_addllog(clu_id(),'登录/失败',0,$_POST);

					R_error('user_password','密码错误');

				}
			}
			else
			{

				\db\Userlog::userlog_addllog(clu_id(),'登录/失败',0,$_POST);

				R_error('user_name','未找到用户');

			}

		}

	}
	function login_1_smsvcode()
	{

		postdata_assert
		([
			'user_mobile'=>'手机号',
			'vcode_smsvcode'=>'短信验证码'
		]);


		if(!\_lp_\Validate::is_mobile($_POST['user_mobile']))
		{
			R_error('user_mobile','手机号'.\_lp_\Validate::lasterror_msg());
		}

		if(1)
		{
			$check=\_lp_\Vcode::vcodeverify_verify(\_lp_\Vcode::vcodetype_sms,$_POST['vcode_smsvcode'],$_POST['user_mobile']);
			if(true!==$check)
			{

				\db\Userlog::userlog_addllog(clu_id(),'登录/失败',0,$_POST);

				R_error('vcode_smsvcode',$check);

			}
		}

		if(1)
		{
			$where=[];
			$where['user_mobile']=$_POST['user_mobile'];
			$__user=\db\User::find($where);

			if(!$__user)
			{
				R_alert('[error-4307]');
			}
		}

		\db\Userlog::userlog_addllog($__user['id'],'登录/短信登录');

		$this->login_1_sink($__user['id']);

	}
	function login_1_sink($userid,$message=false)
	{

		clu_login($userid);

		if($_GET['_continue'])
		{
			$url=urldecode(htmlentity_decode($_GET['_continue']));
		}
		else
		{
			$url='/';
		}

		if(__m_access__)
		{
			\_mobile_\Mobile::return_route_back(1,$message);
		}
		else
		{
			R_jump($url,$message);
		}

	}
//1 logout
	function logout()
	{

		\db\Userlog::userlog_addllog(clu_id(),'退出');

		clu_logout();

		if(__m_access__)
		{
			\_mobile_\Mobile::return_route_back(1,'已退出登录');
		}
		else
		{
			R_jump('/');
		}

	}
//1 regist
	function regist()
	{
		_skel();
	}
	function regist_1()
	{

		if(!$_POST['agree'])
		{
			R_toast('请先阅读并同意本站服务条款');
		}

		postdata_assert
		([
			'user_mobile'=>'手机号',
			'vcode_smsvcode'=>'短信验证码',
		]);

		$check=\db\User::checkavailable_mobile($_POST['user_mobile']);
		if(true!==$check)
		{
			R_error('user_mobile',$check);
		}


		if(1)
		{//test
			$check=\_lp_\Vcode::vcodeverify_verify(\_lp_\Vcode::vcodetype_sms,$_POST['vcode_smsvcode'],$_POST['user_mobile']);
			if(true!==$check)
			{
				R_error('vcode_smsvcode',$check);
			}
		}

		if(1)
		{
			$where=[];
			$where['user_mobile']=$_POST['user_mobile'];

			$__user=\db\User::find($where);

			if($__user)
			{
				R_alert('[error-5734]手机号已被占用');
			}
		}

		session_set('connectregist_verifiedmobile',$_POST['user_mobile']);

		$jscode='
		$("#connectregist_step_0").hide();
		$("#connectregist_step_1").show();
		';
		R_jscode($jscode);

	}
	function regist_2()
	{

		postdata_assert
		([
			'user_name'=>'用户名',
			'password_0'=>'密码',
			'password_1'=>'重复密码',
		]);


		$__mobile=session_get('connectregist_verifiedmobile');

		if(!$__mobile)
		{
			R_alert('[error-2623]');
		}

		$check=\db\User::checkavailable_username($_POST['user_name']);
		if(true!==$check)
		{
			R_error('user_name',$check);
		}

		$check=\db\User::checkavailable_mobile($__mobile);
		if(true!==$check)
		{
			R_alert('[error-1929]'.$check);
		}

		if($_POST['password_0']!==$_POST['password_1'])
		{
			R_error('password_1','重复密码不一致');
		}

		if(!\_lp_\Validate::is_password($_POST['password_0']))
		{
			R_error('password_0','密码'.\_lp_\Validate::lasterror_msg());
		}

		if(1)
		{
			$__adddata=[];

			$__adddata['user_name']=$_POST['user_name'];
			$__adddata['user_mobile']=$__mobile;
			$__adddata['user_password']=$_POST['password_0'];

			$userid=\db\User::createuser_createuser($__adddata);

			session_delete('connectregist_verifiedmobile');

			\db\Userlog::userlog_addllog($userid,'注册');

			$this->login_1_sink($userid,'注册成功');

		}

		R_alert('[error-2231]');

	}
//1 retrieve
	function retrieve()
	{
		_skel();
	}
	function retrieve_1()
	{

		postdata_assert
		([
			'user_mobile'=>'手机号',
			'vcode_smsvcode'=>'短信验证码',
		]);


		if(!\_lp_\Validate::is_mobile($_POST['user_mobile']))
		{
			R_error('user_mobile','手机号'.\_lp_\Validate::lasterror_msg());
		}

		if(1)
		{//test
			$check=\_lp_\Vcode::vcodeverify_verify(\_lp_\Vcode::vcodetype_sms,$_POST['vcode_smsvcode'],$_POST['user_mobile']);
			if(true!==$check)
			{
				R_error('vcode_smsvcode',$check);
			}
		}

		$user=\db\User::find(
			[
				'user_mobile'=>$_POST['user_mobile']
			]);

		if(!$user)
		{
			R_error('user_mobile','手机号未在本站注册');
		}

		session_set('connectretrieve_verifieduid',intval($user['id']));

		$jscode='
		$("#connectretrieve_step_0").hide();
		$("#connectretrieve_step_1").show();
		';
		R_jscode($jscode);

	}

	function retrieve_2()
	{


		postdata_assert
		([
			'password_0'=>'密码',
			'password_1'=>'重复密码',
		]);


		$__uid=session_get('connectretrieve_verifieduid');

		if(!$__uid)
		{
			R_alert('[error-5403]');
		}

		if($_POST['password_0']!==$_POST['password_1'])
		{
			R_error('password_1','重复密码不一致');
		}

		if(!\_lp_\Validate::is_password($_POST['password_0']))
		{
			R_error('password_0','密码'.\_lp_\Validate::lasterror_msg());
		}

		$save=[];

		$temp=\_lp_\Password::create($_POST['password_0']);
		$save['user_password_hash']=$temp['hash'];
		$save['user_password_salt']=$temp['salt'];

		\db\User::save($__uid,$save);

		session_delete('connectretrieve_verifieduid');

		\db\Userlog::userlog_addllog($__uid,'找回密码');

		if(__m_access__)
		{
			$jscode='
				connectlogin_retrieve_done();
			';
			R_jscode($jscode);
		}
		else
		{
			R_jump('/connect/login','密码已重置');
		}

	}

}
