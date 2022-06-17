<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\foreground;
class Cluindex extends super\Superforeground_clu
{
//1 index
	function index()
	{
		_skel();
	}
//1 username
	function username()
	{
		_skel();
	}
	function username_1()
	{



		postdata_assert
		([
			'user_name'=>'新用户名',
		]);

		$user=\db\User::find(clu_id());

		$daynum=day_calcdiff(time(),$user['user_usernamelastedittime']);

		if($daynum<\Prjconfig::clu_config['clu_editusername_firewall_day'])
		{
			R_toast('请'.(\Prjconfig::clu_config['clu_editusername_firewall_day']-$daynum).'天后再来改名吧');
		}

		$check=\db\User::checkavailable_username($_POST['user_name']);

		if(true!==$check)
		{
			R_error('user_name',$check);
		}

		\db\User::save_fieldset(clu_id(),'user_name',$_POST['user_name']);
		if(__m_access__)
		{
			\_mobile_\Mobile::return_route_back(1,'操作完成');
		}
		else
		{
			R_jump('/cluindex','操作完成');
		}

	}

//1 avatar
	function useravatar()
	{
		_skel();
	}
	function useravatar_1()
	{

		if($_POST['@uploadavatar_resultimgurl'])
		{
			\db\User::save_fieldset(clu_id(),'user_avatar',$_POST['@uploadavatar_resultimgurl']);

			if(__m_access__)
			{
				\_mobile_\Mobile::return_route_back(1,'操作完成');
			}
			else
			{
				R_jump('/cluindex','操作完成');
			}
		}
		else
		{
			R_alert('[error-1105]');
		}
	}
//1 mobile
	function usermobile()
	{
		_skel();
	}
	function usermobile_1()
	{

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


		\db\User::save_fieldset(clu_id(),'user_mobile',$_POST['user_mobile']);
		if(__m_access__)
		{
			\_mobile_\Mobile::return_route_back(1,'操作完成');
		}
		else
		{
			R_jump('/cluindex','设置手机号成功');
		}


	}
//1 password
	function userpassword()
	{
		_skel();
	}
	function userpassword_1()
	{

		postdata_assert
		([
			'vcode_smsvcode'=>'短信验证码',
		]);

		if(1)
		{//test
			$check=\_lp_\Vcode::vcodeverify_verify(\_lp_\Vcode::vcodetype_sms,$_POST['vcode_smsvcode'],clu_data()['user_mobile']);
			if(true!==$check)
			{
				R_error('vcode_smsvcode',$check);
			}
		}

		session_set('cluindexpassword_verifiedmobile',1);

		$jscode='
		$("#cluindexpassword_step_0").hide();
		$("#cluindexpassword_step_1").show();
		';
		R_jscode($jscode);

	}
	function userpassword_2()
	{

		if(!session_get('cluindexpassword_verifiedmobile'))
		{
			R_alert('[error-1321]');
		}

		postdata_assert
		([
			'password_0'=>'新密码',
			'password_1'=>'重复新密码',
		]);

		if($_POST['password_0']!==$_POST['password_1'])
		{
			R_error('password_1','重复密码不一致');
		}


		if(!\_lp_\Validate::is_password($_POST['password_0']))
		{
			R_error('password_0','新密码'.\_lp_\Validate::lasterror_msg());
		}

		$save=[];

		$temp=\_lp_\Password::create($_POST['password_0']);

		$save['user_password_hash']=$temp['hash'];
		$save['user_password_salt']=$temp['salt'];

		\db\User::save(clu_id(),$save);

		clu_login(clu_id());//重新登录下防止被踢出去

		session_delete('cluindexpassword_verifiedmobile');
		if(__m_access__)
		{
			\_mobile_\Mobile::return_route_back(0,'操作完成');
		}
		else
		{
			R_jump('/cluindex','密码已设置');
		}

	}
	function userpassword_3()
	{

		postdata_assert
		([
			'password'=>'当前密码',
		]);

		$__user=\db\User::assertfind(clu_id());

		if(\_lp_\Password::check($_POST['password'],$__user['user_password_hash'],$__user['user_password_salt']))
		{
			session_set('cluindexpassword_verifiedmobile',1);
			$this->userpassword_2();
		}
		else
		{
			R_error('password','当前密码错误');
		}
	}

}
