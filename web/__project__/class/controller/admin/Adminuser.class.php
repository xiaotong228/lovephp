<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\admin;
class Adminuser extends super\Superadmin
{

	function index()
	{
		_skel();
	}
	function add()
	{

		$xmlfilepath=xml_getxmlfilepath();
		R_window_xml($xmlfilepath,url_build('add_1'));

	}
	function add_1()
	{

		postdata_assert
		([
			'adminuser_name'=>'名称',
			'adminuser_password'=>'密码',
		]);

		$password=\_lp_\Password::create($_POST['adminuser_password']);

		$data=[];
		$data['adminuser_name']=$_POST['adminuser_name'];
		$data['adminuser_password_hash']=$password['hash'];
		$data['adminuser_password_salt']=$password['salt'];

		$data['adminuser_authority']=$_POST['adminuser_authority'];

		$data['adminuser_createtime']=time();

		\db\Adminuser::add($data);

		R_jump();

	}

	function edit($id)
	{


		$xmlfilepath=xml_getxmlfilepath('add');
		$data=\db\Adminuser::find($id);

		R_window_xml($xmlfilepath,url_build('edit_1?id='.$id),$data,'ID:'.$id);

	}
	function edit_1($id)
	{

		postdata_assert
		([
			'adminuser_name'=>'名称',
		]);

		$save=[];
		$save['adminuser_name']=$_POST['adminuser_name'];

		if($_POST['adminuser_password'])
		{
			$password=\_lp_\Password::create($_POST['adminuser_password']);
			$save['adminuser_password_hash']=$password['hash'];
			$save['adminuser_password_salt']=$password['salt'];
		}

		$save['adminuser_authority']=$_POST['adminuser_authority'];

		\db\Adminuser::save($id,$save);

		R_jump();

	}

	function ban_yes($id)
	{

		$save=[];
		$save['adminuser_isban']=1;

		\db\Adminuser::save($id,$save);

		R_jump();

	}
	function ban_no($id)
	{
		$save=[];
		$save['adminuser_isban']=0;

		\db\Adminuser::save($id,$save);

		R_jump();

	}
	function loginhistory_loginhistory($id)
	{

		$user=\db\Adminuser::find($id,['adminuser_loginhistory']);

		$__table_header=
		[
			'时间'=>'200px',
			'useragent'=>'200px',
			'ip'=>0,
		];

		$__table_body=[];

		foreach($user['adminuser_loginhistory'] as $v)
		{
		$__table_body[]=
			[
				time_str($v['login_time']),
				$v['login_useragent'],
				ip_ipbox($v['login_ip']),

			];
		}

		$H='';

		$H.=_div('','','xmlwindow=head');
			$H.=_b__('','border-right:0;','','登录历史');
			$H.=_a0__('','','uiwindow_role=close');
		$H.=_div_();

		$H.=_div('','','xmlwindow_role=body');
			$H.=\_widget_\Tablelist::tablelist_html($__table_header,$__table_body);
		$H.=_div_();

		$domset=[];
		$domset['tail']='__xmlwindow__=xmlwindow';

		R_window($H,$domset);
	}

}
