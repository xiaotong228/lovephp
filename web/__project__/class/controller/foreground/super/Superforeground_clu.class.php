<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\foreground\super;
class Superforeground_clu extends Superforeground
{

	function __construct()
	{

		parent::__construct();

		$__clu_id=clu_id();

		if($__clu_id)
		{//涉及到需要登录才可进行的操作的时候验证数据库中的用户数据

			$__cludata_session=clu_data();

			$__cludata_db=clu_data_db();//先获取session的,db会冲掉session

			if(

				!$__cludata_db||

				$__cludata_db['user_isban']||

				$__cludata_db['user_isdelete']||

				$__cludata_db['user_version']!=$__cludata_session['user_version']

			)
			{//有异常踢出去

				clu_logout();

				R_jump('/');
			}
			else
			{

			}

		}

		if(0)
		{//如果涉及到限制登录设备数量啥的预留,
		//登录时可以记录到user_currentlogin_sessionids里面,同时记录设备种类,如pc,移动端,安卓苹果啥的,然后判断,也可以用触发器在登录时写到xxx_login_index字段,不匹配或者差值大于一定数量(最大允许设备数)踢出去

		}

		$__clu_id=clu_id();
		if($__clu_id)
		{

		}
		else
		{
			R_needlogin();
		}

	}

}
