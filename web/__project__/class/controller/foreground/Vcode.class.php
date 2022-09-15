<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\foreground;

class Vcode extends super\Superforeground
{

	function imgvcode_imgvcode()
	{
		\_lp_\Vcode::imgvcode_echoimg();
	}

	function smsvcode_send($action)
	{

		if('smsvcode_clu_changepassword'==$action)
		{
			$_POST['user_mobile']=clu_data()['user_mobile'];
		}

		postdata_assert
		([
			'user_mobile'=>'手机号',
			'vcode_imgvcode'=>'图片验证码',
		]);


		$__mobile=$_POST['user_mobile'];

		$__user=false;
		$__doing=false;

		if(
			'smsvcode_connect_login'==$action||
			'smsvcode_connect_regist'==$action||
			'smsvcode_connect_retrieve'==$action||
			'smsvcode_clu_changemobile'==$action
		)
		{

			if(!\_lp_\Validate::is_mobile($__mobile))
			{
				R_error('user_mobile','手机号'.\_lp_\Validate::lasterror_msg());
			}

			if(1)
			{
				$where=[];
				$where['user_mobile']=$__mobile;
				$__user=\db\User::find($where);
			}

		}
		else if
		(
			'smsvcode_clu_changepassword'==$action
		)
		{

		}
		else
		{


		}

		if('smsvcode_connect_login'==$action)
		{
			if(!$__user)
			{
				R_error('user_mobile','手机号未注册');
			}
			$__doing='登录';
		}
		else if('smsvcode_connect_regist'==$action)
		{
			if($__user)
			{
				R_error('user_mobile','手机号已占用');
			}
			$__doing='注册';
		}
		else if('smsvcode_connect_retrieve'==$action)
		{
			if(!$__user)
			{
				R_error('user_mobile','手机号未注册');
			}
			$__doing='找回密码';
		}
		else if('smsvcode_clu_changemobile'==$action)
		{
			if($__user)
			{
				R_error('user_mobile','手机号已占用');
			}
			$__doing='更改手机号';
		}
		else if('smsvcode_clu_changepassword'==$action)
		{
			$__doing='更改密码';
		}
		else
		{

		}

		if(!$__mobile)
		{
			R_alert('[error-5128]无效手机号');
		}

		if(1)
		{//发送限制检测

			$where=[];

			if(1)
			{
				$uid=clu_id();

				$temp=[];
				$temp['smssendlog_mobile']=$__mobile;
				$temp['smssendlog_sessionid']=session_id();

				if($uid)
				{
					$temp['uid']=$uid;
				}

				$temp[db_logic]='or';

				$where[]=$temp;
			}

			$where['smssendlog_createtime']=array(db_gt,time()-\_lp_\Vcode::smsvcode_frozentime);
			$where['smssendlog_type']=\db\Smssendlog::type_vcode;

			$item=\db\Smssendlog::find($where);
			if($item)
			{
				R_alert('短信发送限制('.($item['smssendlog_createtime']+\_lp_\Vcode::smsvcode_frozentime-time()).'秒)');
			}

		}

		if(1)
		{//生成并且发送
			$vcode=math_salt_num(\_lp_\Vcode::smsvcode_digitnum);

			if(1)
			{//到这里应该连接阿里云,腾讯云啥的去真的把短信发出去了

			}

			if(1)
			{

				$args=[];
				$args[]=$vcode;
				if($__doing)
				{
					$args[]=$__doing;
				}

				$data=[];

				$data['uid']=clu_id();
				$data['smssendlog_type']=\db\Smssendlog::type_vcode;
				$data['smssendlog_mobile']=$__mobile;

				$data['smssendlog_url']=server_url_current(1);
				$data['smssendlog_ip']=client_ip();
				$data['smssendlog_sessionid']=session_id();
				$data['smssendlog_useragent']=client_useragent();
				$data['smssendlog_createtime']=time();

				$data['smssendlog_channel_args']=impd($args,'/');

				\db\Smssendlog::add($data);

			}

			\_lp_\Vcode::vcodeverify_settoken(\_lp_\Vcode::vcodetype_sms,$vcode,$__mobile);
		}

		$data=[];
		$data['smsvcode_frozentime']=\_lp_\Vcode::smsvcode_frozentime;
		$data['smsvcode_message']='已发送[error-4335],注意查收<br>('.$__doing.',验证码:'.$vcode.')';

		R_true($data);

	}

}
