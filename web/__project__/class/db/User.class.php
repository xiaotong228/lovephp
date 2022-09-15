<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

namespace db;

class User
{

	use \_lp_\datamodel\Superdb;

	static function db_table_config()
	{
		$triggers=[];

		$code='';

		$code.='

				BEGIN
					IF
						NEW.user_isban!=OLD.user_isban OR
						NEW.user_isdelete!=OLD.user_isdelete OR
						NEW.user_password_hash!=OLD.user_password_hash

					THEN

						SET NEW.user_version=NEW.user_version+1;

					END IF;

					IF
						NEW.user_name!=OLD.user_name
					THEN

						SET NEW.user_usernamelastedittime=unix_timestamp();

					END IF;

				END

			';

		$triggers['update/before']=$code;

		return
		[

			'db_table_serializedfileds'=>
			[
				'user_autologin_tokens',
				'user_access_tokens',
				'user_currentlogin_sessionids',
			],

			'db_table_triggers'=>$triggers,

		];
	}
	static function checkavailable_username($username,int $except_id=0)
	{

		if(!$username)
		{
			return '用户名不能为空';
		}

		if(!\_lp_\Validate::is_username($username))
		{
			return '用户名'.\_lp_\Validate::lasterror_msg();
		}

		if(1)
		{
			$where=[];
			$where['user_name']=$username;
			if($except_id)
			{
				$where['id']=[db_neq,$except_id];
			}

			$temp=self::find($where);

			if($temp)
			{
				return '用户名已被占用';
			}
		}

		return true;

	}

	static function checkavailable_mobile($mobile,int $except_id=0)
	{

		if(!$mobile)
		{
			return '手机号不能为空';
		}

		if(!\_lp_\Validate::is_mobile($mobile))
		{
			return '手机号'.\_lp_\Validate::lasterror_msg();
		}

		$where=[];

		$where['user_mobile']=$mobile;

		if($except_id)
		{
			$where['id']=[db_neq,$except_id];
		}

		$temp=self::find($where);

		if($temp)
		{
			return '手机号已被占用,请换一个';
		}

		return true;

	}
	static function checkavailable_email($email,int $except_id=0)
	{

		if(!\_lp_\Validate::is_email($email))
		{
			return '邮箱'.\_lp_\Validate::lasterror_msg();
		}

		$where=[];
		$where['user_email']=$email;

		if($except_id)
		{
			$where['id']=[db_neq,$except_id];
		}

		$temp=self::find($where);

		if($temp)
		{
			return '邮箱已被占用,请换一个';
		}

		return true;

	}
	static function createuser_createuser(array $__user,string $__password=null)
	{

		$__adjustusername=false;

		foreach($__user as $k=>$v)
		{
			if(!$v)
			{
				unset($__user[$k]);
			}
		}

		if(1)
		{
			if($__user['user_name'])
			{
				$check=self::checkavailable_username($__user['user_name']);

				if(true!==$check)
				{
					R_alert('[error-4057]'.$check);
				}

			}
			else
			{
				$__user['user_name']=math_salt().math_salt();
				$__adjustusername=true;
			}
		}

		if(!$__user['user_avatar'])
		{
			$__user['user_avatar']=\Prjconfig::clu_config['clu_defaultavatar'];
		}

		if($__user['user_password'])
		{

			if(!\_lp_\Validate::is_password($__user['user_password']))
			{
				R_alert('[error-5231]密码'.\_lp_\Validate::lasterror_msg());
			}

			$temp=\_lp_\Password::create($__user['user_password']);
			$__user['user_password_hash']=$temp['hash'];
			$__user['user_password_salt']=$temp['salt'];
			unset($__user['user_password']);
		}

		if($__user['user_mobile'])
		{
			$verify=self::checkavailable_mobile($__user['user_mobile']);
			if(true!==$verify)
			{
				R_alert($verify);
			}
		}

		if($__user['user_email'])
		{

			$verify=self::checkavailable_email($__user['user_email']);
			if(true!==$verify)
			{
				R_alert($verify);
			}
			$__user['user_email']=strtolower($__user['user_email']);

		}

		$__user['user_create_time']=time();
		$__user['user_create_ip']=client_ip();

		$userid=self::add($__user);
		if($__adjustusername)
		{
			self::save_fieldset($userid,'user_name','用户'.$userid);
		}

		if($userid)
		{
			return $userid;
		}
		else
		{
			R_alert('[error-4659]错误,请重试');
			return false;
		}

	}

}
