<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

namespace controller\debug;

class Cookie extends \controller\debug\Session
{

	function add_1($keypath)
	{

		if(
			''===$_POST['data_key']||
			''===$_POST['data_value']
		)
		{
			R_alert('[error-2907]key,value均必填');
		}

		cookie_set($_POST['data_key'],$_POST['data_value'],intval($_POST['data_time']));

		R_jump();

	}

	function edit_value_1($keypath)
	{

		if(!check_isavailable($keypath))
		{
			R_alert('[error-1213]');
		}

		if(
			''===$_POST['data_value']
		)
		{
			R_alert('[error-4209]value均必填');
		}

		$keypath=substr($keypath,strlen(__cookie_prefix__.'_'));

		cookie_set($keypath,$_POST['data_value'],intval($_POST['data_time']));

		R_jump();

	}

	function delete($keypath)
	{

		$keypath=substr($keypath,strlen(__cookie_prefix__.'_'));

		cookie_delete($keypath);

		R_jump();

	}

}

