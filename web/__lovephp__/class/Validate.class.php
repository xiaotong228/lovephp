<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _lp_;
class Validate
{

	static function lasterror_msg($msg=null)
	{

		static $cache=null;

		if(is_null($msg))
		{
			return $cache;
		}
		else
		{
			$cache=$msg;
		}

	}

	static function is_email($__value)
	{
		if(filter_var($__value,FILTER_VALIDATE_EMAIL))
		{
			return true;
		}
		else
		{
			self::lasterror_msg('格式不正确');
			return false;
		}
	}

	static function is_mobile($__value)
	{//只要是1开头的11位数字都算合法

		if(preg_match('/^[1][0-9]{10}$/',$__value))
		{
			return true;
		}
		else
		{
			self::lasterror_msg('格式不正确');
			return false;
		}

	}
	static function is_password($__value)
	{

		$__checkstrong=false;

		$__value=htmlentity_decode($__value);

		$length=string_strlen_cn($__value);

		if($length<6)
		{
			self::lasterror_msg('不能小于6位');
			return false;
		}
		if($length>50)
		{
			self::lasterror_msg('不能大于50位');
			return false;
		}

		if($__checkstrong)
		{//如果需要判断密码强度的话,请写在这里
		//默认只要是包含英文和数字的密码就算是strong
			if(
				!(
					preg_match('/[0-9]/',$__value)&&
					preg_match('/[a-zA-Z]/',$__value)
				)
			)
			{
				self::lasterror_msg('需同时包含数字和英文字母');
				return false;
			}
		}

		return true;

	}

	static function is_username($__value)
	{

		$__value=htmlentity_decode($__value);

		$blacklist_char=str_split('!"#$%&\'()*+,-./:;<=>?@[\\]^`{|} '."\n"."\t");

		$blacklist_string=
		[
			'管理员',
			'admin',
			'超管'
		];

		$length=string_strlen_cn($__value);

		if(!($length>=2&&$length<=16))
		{
			self::lasterror_msg('字需数在2~16之间');
			return false;
		}

		if(preg_match('/^[0-9_]/',$__value))
		{
			self::lasterror_msg('不能以数字或下划线开头');
			return false;
		}

		if(1)
		{
			foreach($blacklist_char as $v)
			{
				if(false!==strpos($__value,$v))
				{
					self::lasterror_msg('不能含有特殊符号和空格');
					return false;
				}
			}
		}

		foreach($blacklist_string as $v)
		{
			if(false!==stripos($__value,$v))
			{
				self::lasterror_msg('不能使用(系统保留)');
				return false;
			}
		}

		return true;

	}

	static function is_shenfenzhengnum($__value)
	{

		if(preg_match('/^[\d]{17}[\dxX]{1}$/', $__value))
		{
			return true;
		}
		else
		{
			self::lasterror_msg('格式不正确');
			return false;
		}

	}
	static function is_functionname($__value)
	{

		if(preg_match('/^[a-zA-Z_][a-zA-Z_\d]*$/',$__value))
		{
			return true;
		}
		else
		{
			self::lasterror_msg('不是合法的函数/类名称');
			return false;
		}

	}

}
