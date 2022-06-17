<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\cloud;
class Index extends super\Supercloud
{
	function index()
	{
		R_http_404(404,'[error-3820]云空间预留,还没做','/admin');
	}
}
