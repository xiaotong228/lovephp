<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


echo _module('c_admin_panel_template_fixed');

	$__table_header=
	[
		'ID'=>'100px',
		'用户名'=>'100px',
		'权限'=>'400px',
		'创建时间'=>'200px',
		'状态'=>'100px',
		'操作'=>0
	];

	$__table_body=[];

	$__itemlist=\db\Adminuser::select(false,[],'id asc');

	foreach($__itemlist as $item)
	{
		$__templine=[];

		$__templine[]=$item['id'];
		$__templine[]=$item['adminuser_name'];

		if(\controller\admin\super\Superadmin::superadmin_adminid===$item['id'])
		{
			$__templine[]='[超管]';
			$__templine[]='/';
			$__templine[]='';
			$__templine[]=_a0__('','','onclick="table_oper(this,\'loginhistory_loginhistory\')"','登录历史');
		}
		else
		{
			if(1)
			{
				if(1)
				{
					$temp=[];

					if($item['adminuser_authority'])
					{
						foreach($item['adminuser_authority'] as $v)
						{
							$temp[]=\controller\admin\super\Superadmin::authority_map[$v].'('.$v.')';
						}
					}
					else
					{
						$temp[]='/';
					}


					$__templine[]=impd($temp,'<br>');

				}

				$__templine[]=$item['adminuser_createtime']?time_str($item['adminuser_createtime']):'/';

				$__templine[]=_status(!$item['adminuser_isban'],'正常','禁用');

				$temptd=[];
				$temptd[]=_a0__('','','onclick="table_oper(this,\'edit\')"','编辑');

				if($item['adminuser_isban'])
				{
					$temptd[]=_a0__('','','onclick="table_oper_confirm(this,\'ban_no\')"','解封');
				}
				else
				{
					$temptd[]=_a0__('','','onclick="table_oper_confirm(this,\'ban_yes\')"','封号');
				}

				$temptd[]=_a0__('','','onclick="table_oper(this,\'loginhistory_loginhistory\')"','登录历史');

				$__templine[]=impd($temptd,'/');

			}

		}

		$__table_body[]=$__templine;

	}

	if(0)
	{
		echo _div__('g_warnbox','','','预留提示信息');
	}

	echo _div('c_admin_panel_oper');
		echo _a0__('','','__button__="small green solid" onclick="table_oper(this,\'add\')" ','添加管理员');
	echo _div_();

	echo _div('c_admin_panel_itemlist');
		echo \_widget_\Tablelist::tablelist_html($__table_header,$__table_body,1);
	echo _div_();

echo _module_();

