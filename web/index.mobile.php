<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



define('__m_access__',true);

if(array_key_exists('@alp_access',$_GET))
{//上线的情况下注意关闭
	define('__alp_access__',true);
}

include('./index.php');

