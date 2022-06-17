<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\admin\super;

class Superadmin extends \_lp_\controller\Supercontroller
{

	const superadmin_adminid=1;

	const authority_map=
	[

		'admin/sitedata'=>'业务后台/站点数据',
		'admin/user'=>'业务后台/用户列表',
		'admin/article'=>'业务后台/文章列表',

		'skel'=>'页面编辑/全部',

		'cloud'=>'云空间/全部',

	];

	const leftmenu_admin=
	[

		'sitedata'=>'站点数据',
		'user'=>'用户列表',
		'article'=>'文章列表',
		'adminuser'=>'超管功能/[超管]管理员列表',
		'sitesetting'=>'超管功能/[超管]站点设置',
		'smssendlog'=>'超管功能/[超管]短信记录',
	];

	const leftmenu_skel=
	[
		'routemap'=>'页面路由',
		'modulelist'=>'模块列表',
		'gridlist'=>'页面布局',
		'crossgridlist'=>'跨页面布局',
	];

	const leftmenu_cloud=
	[

	];

	public $leftmenu_menumap=false;

	function __construct()
	{

		parent::__construct();

		if(__online_isonline__&&\Prjconfig::admin_accesstoken)
		{//线上模式下,检测下admin_accesstoken

			$sessionvalue_old=session_get('admin_accesstoken');

			$sessionvalue_new=md5_md5(\Prjconfig::admin_accesstoken,session_id());

			if($sessionvalue_old)
			{
				if($sessionvalue_old==$sessionvalue_new)
				{
				}
				else
				{
					R_alert('[error-3628]');
				}
			}
			else
			{
				if(array_key_exists(\Prjconfig::admin_accesstoken,$_GET))
				{

					session_set('admin_accesstoken',$sessionvalue_new);
					R_jump('/admin');

				}
				else
				{

					R_alert('[error-2908]');

				}

			}

		}

		$clu_admin_id=clu_admin_id();

		if(route_judge('admin','connect'))
		{

		}
		else
		{

			if($clu_admin_id)
			{

				$__cla_data_session=clu_admin_data();

				$__cla_data_db=\db\Adminuser::find($clu_admin_id,
				[
					'id',
					'adminuser_name',
					'adminuser_authority',
					'adminuser_isban',
					'adminuser_isdelete',
					'adminuser_version',
				]);

				if(
					!$__cla_data_db||
					$__cla_data_db['adminuser_isban']||
					$__cla_data_db['adminuser_isdelete']||
					$__cla_data_db['adminuser_version']!=$__cla_data_session['adminuser_version']
				)
				{
					clu_admin_logout();

					R_jump('/admin');
				}

				if(1)
				{//更新从数据库里拿到的实际权限,后续再判断权限都已session为准
					session_set(\Prjconfig::clu_config['clu_admin_sessionkey'].'/adminuser_authority',$__cla_data_db['adminuser_authority']);
				}

				if(1)
				{
					$__authority=clu_admin_authority();
					if(clu_admin_issuperadmin())
					{
						goto authority_check_ok;
					}
					else if(route_judge('admin','index'))
					{
						goto authority_check_ok;
					}
					else
					{
						foreach($__authority as $k=>$v)
						{

							$v=expd($v,'/');
							if(route_judge(
								$v[0]?$v[0]:cmd_ignore,
								$v[1]?$v[1]:cmd_ignore,
								$v[2]?$v[2]:cmd_ignore
							))
							{
								goto authority_check_ok;
							}
						}
					}
				}

				authority_check_fail:

				R_jump('/admin','[error-5110]无权限');

				authority_check_ok:

				if('admin'==__route_module__)
				{

					$__menus=self::leftmenu_admin;

					if(clu_admin_issuperadmin())
					{

					}
					else
					{
						$temp=[];

						foreach($__authority as $k=>$v)
						{
							$v=expd($v,'/');

							if('admin'==$v[0])
							{
								$temp[]=$v[1];
							}
						}

						$__menus=array_keep_keys($__menus,$temp);
					}
				}
				else if('skel'==__route_module__)
				{
					$__menus=self::leftmenu_skel;
				}
				else if('cloud'==__route_module__)
				{
					$__menus=self::leftmenu_cloud;
				}
				else
				{

				}

				$this->leftmenu_menumap=$__menus;

			}
			else
			{

				R_jump('/admin/connect/login');

			}

		}


	}

}
