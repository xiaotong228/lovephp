<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

/*模块自用函数
if(!function_exists('{__MODULE_NAME__}_dosomething'))
{
	function {__MODULE_NAME__}_dosomething()
	{
		//do something
	}
}
*/

if(0)
{//如果需要读取模块配置
	$__moduleconfig=\_skel_\Skelmodule::config_getconfig();
}

echo _module();
	var_dump(get_defined_vars());
echo _module_();

