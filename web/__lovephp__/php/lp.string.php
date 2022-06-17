<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

function string_substr_cn($str,$begin,$length=null)
{
	return mb_substr($str,$begin,$length,'utf-8');
}
function string_strlen_cn($str)
{
	return mb_strlen($str,'utf-8');
}
function string_utf8_to_gbk($str)
{
	return iconv("UTF-8","GBK//IGNORE",$str);
}
function string_gbk_to_utf8($str)
{
	return iconv("GBK","UTF-8//IGNORE",$str);
}
function string_split_cn($str,$splitlength=1)
{
	if(function_exists('mb_str_split'))
	{//(PHP 7 >= 7.4.0, PHP 8)没环境,没测试这个
		return mb_str_split($str,$splitlength,'utf-8');
	}
	else
	{
		$result=[];

		$length=string_strlen_cn($str);

		for($i=0;$i<$length;$i+=$splitlength)
		{
			$result[]=string_substr_cn($str,$i,$splitlength);
		}

		return $result;
	}

}
function string_remove_nl($str)
{

	$str=str_replace(["\r\n", "\r", "\n"],'',$str);

	return $str;

}
