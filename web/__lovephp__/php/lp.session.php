<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

//1 get
function session_get(string $keypath=null)
{

	if(check_isavailable($keypath))
	{
		return array_cascade_get($_SESSION[__session_root__],$keypath);
	}
	else
	{//返回全部
		return $_SESSION[__session_root__];
	}

}

//1 set
function session_set(string $keypath,$value)
{

	if(check_isavailable($keypath))
	{
		array_cascade_set($_SESSION[__session_root__],$keypath,$value);
	}
	else
	{
		$_SESSION[__session_root__]=$value;
	}

}

//1 delete
function session_delete(string $keypath=null)
{

	if(check_isavailable($keypath))
	{
		array_cascade_delete($_SESSION[__session_root__],$keypath);
	}
	else
	{
		R_exception('[error-5317]session错误');
	}

}

function session_delete_all($root=0)
{

	if($root)
	{
		session_unset();
	}
	else
	{
		unset($_SESSION[__session_root__]);
	}

}

function session_delete_all_sessionid($sessionid)
{//根据sessionid删除,需要有文件夹删除权限,只对文件系统存储的session有效

	return fs_file_delete(session_save_path().'/sess_'.$sessionid);

}

