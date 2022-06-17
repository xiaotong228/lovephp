<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _lp_\controller;
class Supercontroller
{

	function __construct()
	{
		\db\Sitedata::sitedata_dailycheck();
	}
	function __call_wreckage($actionname,$args=false)
	{//如果需要动态加载skel就打开,不需要就关闭,开启注意一定要有相应的skel数据,否则可能会死循环调用

		if(__m_access__)
		{
			R_exception('[error-3019]route/'.$actionname);
		}
		else
		{
			_skel();
		}

	}

}
