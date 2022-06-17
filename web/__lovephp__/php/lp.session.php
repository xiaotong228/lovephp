<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



function session_set($key,$value)
{

	if(false===strpos($key,'/'))
	{

		$_SESSION[__session_root__][$key]=$value;

	}
	else
	{

		$key=array_key_convertto_subscript($key);

		$code='return $_SESSION[\''.__session_root__.'\']'.$key.'=$value;';

		eval($code);

	}

}

function session_get($key=false)
{

	if($key)
	{
		if(false===strpos($key,'/'))
		{
			return $_SESSION[__session_root__][$key];
		}
		else
		{
			$key=array_key_convertto_subscript($key);
			$code='return $_SESSION[\''.__session_root__.'\']'.$key.';';
			return eval($code);
		}
	}
	else
	{//此时返回全部
		return $_SESSION[__session_root__];
	}

}

function session_delete($key)
{

	if(false===strpos($key,'/'))
	{
		unset($_SESSION[__session_root__][$key]);
	}
	else
	{
		$key=array_key_convertto_subscript($key);
		$code='unset($_SESSION[\''.__session_root__.'\']'.$key.');';
		return eval($code);
	}

}

function session_clear($allcurrentsession=0)
{

	if($allcurrentsession)
	{
		session_unset();
	}
	else
	{
		unset($_SESSION[__session_root__]);
	}

}

function session_super_clear($sessionid)
{//根据sessionid删除,需要有文件夹删除权限

	return fs_file_delete(session_save_path().'/sess_'.$sessionid);

}

