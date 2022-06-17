<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



$__result=[];

$__result[]='<b style="color:blue;">Lovephp运行环境检测</b>';
if(1)
{//1 版本检测
	$__result[]='<hr>';
	$__result[]='当前PHP版本:<b style="color:blue;">'.PHP_VERSION.'</b>(本程序没有在7.2以下版本跑过,不能确定会发生什么)';
}

if(1)
{//1 extension
	$extensions=
	[
		'gd',
		'gd2',
		'curl',
		'mbstring',
		'openssl',
		'pdo_mysql',
	];
	$__result[]='<hr>';
	$__result[]='<b style="color:blue;">扩展</b>';
	foreach($extensions as $v)
	{
		if(extension_loaded($v))
		{
			$__result[]='<span style="color:green;">'.$v.':正常</span>';
		}
		else
		{
			$__result[]='<span style="color:red;">'.$v.':未开启</span>';
		}
	}
}

if(1)
{//1 session
	$__result[]='<hr>';
	$__result[]='<b style="color:blue;">session</b>';
	$sessionstatus=session_status();
	if(PHP_SESSION_DISABLED==$sessionstatus)
	{
		$__result[]='<span style="color:red;">被禁用(请打开session)</span>';
	}
	else if(PHP_SESSION_NONE==$sessionstatus)
	{
		$__result[]='<span style="color:green;">未自动开启(正常)</span>';
	}
	else if(PHP_SESSION_ACTIVE==$sessionstatus)
	{
		$__result[]='<span style="color:red;">已自动开启(不推荐,最好关闭自动开启session)</span>';
	}
	else
	{
		$__result[]='<span style="color:red;">未知状态</span>';
	}
}

if(1)
{//1 java
	$__result[]='<hr>';
	$__result[]='<b style="color:blue;">java(如不能正常显示java版本信息请先安装java,并确保exec函数可用):</b>';
	$temp=[];
	exec('java -version 2>&1',$temp);
	$__result=array_merge($__result,$temp);
}

if(1)
{//1 filesystem

	$__result[]='<hr>';
	$__result[]='<b style="color:blue;">文件读写删测试</b>';
	$dirs=
	[
		'./__data__',
		'./temp',
		'./upload',
	];

	foreach($dirs as $v)
	{

		if(1)
		{//file
			$filename='temp_'.str_shuffle("abcdefghij").mt_rand(1,999999);
			$filevalue_0='temp_'.str_shuffle("abcdefghij").mt_rand(1,999999);
			$filevalue_1='temp_'.str_shuffle("abcdefghij").mt_rand(1,999999);

			$file_0=file_put_contents($v.'/'.$filename.'.data',$filevalue_0);
			$file_1=file_put_contents($v.'/'.$filename.'.data',$filevalue_1);

			if($filevalue_1===file_get_contents('./'.$v.'/'.$filename.'.data'))
			{
				$file_2=true;
			}
			else
			{
				$file_2=true;
			}

			$file_3=unlink('./'.$v.'/'.$filename.'.data');

		}
		if(1)
		{//dir
			$dirname='temp_'.str_shuffle("abcdefghij").mt_rand(1,999999);
			$dir_0=mkdir($v.'/'.$dirname,0777,true);
			$dir_1=rmdir($v.'/'.$dirname);
		}

		if($file_2&&$file_3&&$file_1&&$file_0&&$dir_0&&$dir_1)
		{
			$__result[]='<span style="color:green;">'.$v.':'.'成功</span>';
		}
		else
		{
			$__result[]='<span style="color:red;">'.$v.':'.'失败</span>';
		}

	}
}

echo implode('<div></div>',$__result);

