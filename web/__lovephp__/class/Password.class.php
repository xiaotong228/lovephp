<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _lp_;
class Password
{

	static function create($password)
	{

		$password=htmlentity_decode($password);

		$salt=math_salt();

		$hash=md5(md5($password).$salt);

		return ['hash'=>$hash,'salt'=>$salt];

	}
	static function check($unsure_password,$hash,$salt)
	{

		if(0&&!__online_isonline__)
		{
			return true;
		}

		$unsure_password=htmlentity_decode($unsure_password);

		if($hash==md5(md5($unsure_password).$salt))
		{
			return true;
		}
		else
		{
			return false;
		}

	}

}
