<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _lp_;
class Token
{
	static function token_gen($data=null,$salt=null)
	{
		$__arystrval=function($mix) use (&$__arystrval)
		{

			if(is_array($mix))
			{
				foreach($mix as &$v)
				{
					$v=$__arystrval($v);
				}
			}
			else
			{
				$mix=strval($mix);
			}

			return $mix;

		};
		$temp=[];

		$data=$__arystrval($data);

		ksort($data);

		$temp[]=$data;

		$temp[]=$salt;

		return md5(serialize($temp));

	}
	static function token_check($data=null,$salt=null,$unsuretoken=null)
	{
		return self::token_gen($data,$salt)===$unsuretoken;
	}
}

