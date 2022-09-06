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

		$id=\db\Adminuser::add($data);

		\db\Adminlog::adminlog_addlog('业务后台/管理员/添加',$id);

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

		\db\Adminlog::adminlog_addlog('业务后台/管理员/编辑',$id);

		R_jump();

	}

	function ban_yes($id)
	{

		$save=[];
		$save['adminuser_isban']=1;

		\db\Adminuser::save($id,$save);

		\db\Adminlog::adminlog_addlog('业务后台/管理员/封号',$id);

		R_jump();

	}
	function ban_no($id)
	{
		$save=[];
		$save['adminuser_isban']=0;

		\db\Adminuser::save($id,$save);

		\db\Adminlog::adminlog_addlog('业务后台/管理员/解封',$id);

		R_jump();

	}

}
