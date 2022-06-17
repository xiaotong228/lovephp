<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace controller\foreground\super;

class Superforeground extends \_lp_\controller\Supercontroller
{

	public $__leftmenu_menus=
	[

		'cluindex'=>'账户信息',
		'clubusiness'=>'业务菜单',

	];

	function __construct()
	{

		parent::__construct();

		$__clu_id=clu_id();

		if($__clu_id)
		{

		}
		else
		{

			if(\Prjconfig::clu_config['clu_autologin_enable'])
			{//尝试自动登录

				$autologin_token=cookie_get(\Prjconfig::clu_config['clu_autologin_cookiekey']);

				if($autologin_token)
				{

					$userid=clu_autologin_checktoken($autologin_token);
					if($userid)
					{
						clu_login($userid);
						$__clu_id=clu_id();
					}
					else
					{
						clu_logout();
					}
				}

			}

		}

	}

}
