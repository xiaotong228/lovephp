<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

//1 clu=current login user
function clu_id()
{

	$data=session_get(\Prjconfig::clu_config['clu_sessionkey']);
	return intval($data['id']);

}
//1 clu_data
function clu_data()
{//从session拿数据

	$data=session_get(\Prjconfig::clu_config['clu_sessionkey']);

	return $data?$data:false;

}
function clu_data_db($cmd=false)
{//从db拿数据

	static $cache=null;

	if(cmd_clear===$cmd)
	{
		$cache=null;
		return;
	}

	if(is_null($cache))
	{
		$userid=clu_id();
		if($userid)
		{

			$__db=\db\User::db_instance();

			$temp=$__db->where($userid)->field(
				[
					'id',
					'user_name',
					'user_avatar',
					'user_mobile',
					'user_email',
					'user_isban',
					'user_isdelete',
					'user_version'
				])->find();

			if($temp)
			{
				$cache=$temp;
			}
			else
			{
				R_alert('[error-1825]');
			}

		}
		else
		{
			$cache=false;
		}

	}

	if($cache)
	{
		session_set(\Prjconfig::clu_config['clu_sessionkey'],$cache);
	}

	return $cache;

}
function clu_login(int $userid)
{

	$user=\db\User::assertfind($userid);

	if($user['user_isban']||$user['user_isdelete'])
	{
		R_alert('[error-5933]用户被封或不存在');
	}

	$save=[];
	$save['user_lastlogin_ip']=client_ip();
	$save['user_lastlogin_time']=time();

	\db\User::save($userid,$save);

	$data=[];

	$data['id']=intval($user['id']);
	$data['user_name']=$user['user_name'];
	$data['user_avatar']=$user['user_avatar'];
	$data['user_mobile']=$user['user_mobile'];
	$data['user_email']=$user['user_email'];
	$data['user_version']=intval($user['user_version']);

	session_set(\Prjconfig::clu_config['clu_sessionkey'],$data);

	if(\Prjconfig::clu_config['clu_autologin_enable'])
	{
		$newtoken=clu_autologin_gentoken($userid);
		cookie_set(\Prjconfig::clu_config['clu_autologin_cookiekey'],$newtoken,\Prjconfig::clu_config['clu_autologin_token_lifetime']);
	}
}

function clu_logout()
{
	session_delete(\Prjconfig::clu_config['clu_sessionkey']);
	cookie_delete(\Prjconfig::clu_config['clu_autologin_cookiekey']);
	clu_data_db(cmd_clear);
}
//1 autologin
function clu_autologin_gentoken($userid)
{

	$__user=\db\User::assertfind($userid);

	$__salt=md5(math_salt());

	$__hash=md5($userid.$__salt);

	$__currentdata=$__user['user_autologin_tokens'];

	if(!$__currentdata)
	{
		$__currentdata=[];
	}

	$__currentdata=array_pipe_push($__currentdata,[$__hash.'/'.(time()+\Prjconfig::clu_config['clu_autologin_token_lifetime'])],\Prjconfig::clu_config['clu_autologin_token_maxnum']);

	\db\User::save_fieldset($userid,'user_autologin_tokens',$__currentdata);

	return $userid.'_'.$__salt;

}

function clu_autologin_checktoken($token)
{

	$token=expd($token,'_');

	$userid=intval($token[0]);

	$token=$token[1];

	$__user=\db\User::assertfind($userid);

	if($__user['user_isban']||$__user['user_isdelete'])
	{
		return false;
	}
	$__currentdata=$__user['user_autologin_tokens'];

	$match=false;

	foreach($__currentdata as $k=>$v)
	{
		$v=expd($v,'/');
		if(md5($userid.$token)==$v[0]&&$v[1]>time())
		{

			$match=true;
			unset($__currentdata[$k]);
			$__currentdata=array_values($__currentdata);
			break;
		}
	}

	if($match)
	{
		\db\User::save_fieldset($userid,'user_autologin_tokens',$__currentdata);
		return $userid;
	}

	return false;

}

//1 clu_admin
function clu_admin_id()
{

	$data=clu_admin_data();

	return intval($data['id']);

}
function clu_admin_data()
{

	return session_get(\Prjconfig::clu_config['clu_admin_sessionkey']);

}
//1 login
function clu_admin_login(int $adminid)
{


	$__db=\db\Adminuser::db_instance();

	$sessiondata=$__db->where($adminid)->field(
	[
		'id',
		'adminuser_name',
		'adminuser_isban',
		'adminuser_isdelete',
		'adminuser_createtime',
		'adminuser_version',
		'adminuser_loginhistory',
	])->find();

	if(!$sessiondata||$sessiondata['adminuser_isban']||$sessiondata['adminuser_isdelete'])
	{
		R_alert('[error-3713]账号被封或不存在');
	}

	$sessiondata['adminuser_version']++;//更改version会导致之前的登录状态被踢出去,实现单一登录

	if(1)
	{
		$save=[];
		$save['adminuser_loginhistory']=array_pipe_prepend($sessiondata['adminuser_loginhistory'],
			[
				[
					'login_time'=>time(),
					'login_useragent'=>client_useragent(),
					'login_ip'=>client_ip()

				]
			],\db\Adminuser::loginhistory_recordnum);

		$save['adminuser_version']=$sessiondata['adminuser_version'];
	}

	$__db->where($adminid)->save($save);

	unset($sessiondata['adminuser_loginhistory']);

	session_set(\Prjconfig::clu_config['clu_admin_sessionkey'],$sessiondata);

}
function clu_admin_logout()
{
	return session_delete(\Prjconfig::clu_config['clu_admin_sessionkey']);
}
//1 authority
function clu_admin_issuperadmin()
{

	return \controller\admin\super\Superadmin::superadmin_adminid==clu_admin_id();

}
function clu_admin_authority()
{

	$data=clu_admin_data();

	return $data['adminuser_authority']?$data['adminuser_authority']:false;

}