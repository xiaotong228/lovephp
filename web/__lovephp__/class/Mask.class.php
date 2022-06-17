<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _lp_;
class Mask
{
	static function bankcard_num($str,$slim=false)
	{
		if($slim)
		{
			return '****'.substr($str,-4);
		}
		else
		{
			return '****&nbsp;&nbsp;****&nbsp;&nbsp;****&nbsp;&nbsp;'.substr($str,-4);
		}
	}

	static function mobile_num($str)
	{
		if($str)
		{
			return substr($str,0,3).'******'.substr($str,-2);
		}
		else
		{
			return '';
		}
	}

	static function shenfenzheng_num($str)
	{
		if(1)
		{
			$head=string_substr_cn($str,0,1);
			$tail=string_substr_cn($str,-1);
			$body=str_pad('',string_strlen_cn($str)-2,'*');
			return $head.$body.$tail;
		}
		else
		{
			$head=string_substr_cn($str,0,3);
			$tail=string_substr_cn($str,-4);
			$body=str_pad('',string_strlen_cn($str)-7,'*');
			return $head.$body.$tail;
		}
	}

	static function user_name($str)
	{
		$name_len=string_strlen_cn($str);

		$head=string_substr_cn($str,0,1);

		$body=str_pad('',$name_len-1,'*');

		return $head.$body;
	}

	static function company_name($str)
	{

		$str_len=string_strlen_cn($str);
		$begin=string_substr_cn($str,0,1);
		$end=string_substr_cn($str,-1);

		$center=str_pad('',$str_len-2,'*');

		return $begin.$center.$end;

	}

	static function company_serialnumber($str)
	{
		return self::company_name($str);
	}

}
