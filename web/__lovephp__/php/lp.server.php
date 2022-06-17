<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



function server_host_domain()
{

	$temp=$_SERVER['HTTP_HOST'];

	$temp=expd($temp,':');

	return strtolower($temp[0]);

}
function server_host_http()
{//return http:://aaa.com,不含端口号

	return strtolower($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']);

}

function server_url_current($full=false)
{

	return ($full?server_host_http():'').$_SERVER['REQUEST_URI'];

}
function server_url_referer()
{

	return $_SERVER['HTTP_REFERER'];

}


