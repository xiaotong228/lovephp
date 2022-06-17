<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\foreground;

class Index extends super\Superforeground
{
	function index()
	{

		htmlecho_page_title(\Prjconfig::project_config['project_name'],1);

		_skel();

	}

}
