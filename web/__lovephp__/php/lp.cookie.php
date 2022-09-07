<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



function cookie_set($key,$value,$lifetime=0)
{

	$key=__cookie_prefix__.$key;

	if(is_array($value))
	{
		$value=json_encode_1($value);
	}

	if($lifetime)
	{
		$expiretime=time()+$lifetime;
	}
	else
	{//关闭浏览器就清除了
		$expiretime=0;
	}

	setcookie($key,$value,$expiretime,'/',__cookie_domain__);

}

function cookie_get($key)
{

	$key=__cookie_prefix__.$key;

	$value=$_COOKIE[$key];

	$tryresult=json_decode_1($value);

	if(is_array($tryresult))
	{
		$value=$tryresult;
	}

	return $value;

}
function cookie_delete($key)
{

	$key=__cookie_prefix__.$key;
	setcookie($key,'',time()-3600,'/',__cookie_domain__);
	unset($_COOKIE[$key]);

}

