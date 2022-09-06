<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\cloud;
class Recycle extends \controller\admin\super\Superadmin
{

	function index()
	{
		_skel();
	}

//1 file
	function file_echofile($id)
	{//已经进入回收站的文件也可以读取,直接用php输出,需要管理员登录

		$item=\controller\cloud\Index::db_assertfind($id);

		if(\db\Cloud::cloudtype_file!=$item['cloud_type'])
		{
			R_alert('[error-3623]');
		}

		$filepath_recycle=\controller\cloud\Index::recycle_filepath_to_recycle('.'.$item['cloud_file_url']);

		if(in_array($item['cloud_file_ext'],array_merge(\Prjconfig::file_pic_exts,['svg'])))
		{

			header('Cache-Control:private,max-age=0,no-store,no-cache,must-revalidate');
			header('Cache-Control:post-check=0,pre-check=0',false);
			header('Pragma:no-cache');
			header('Content-Type:image/'.$item['cloud_file_ext'].('svg'==$item['cloud_file_ext']?'+xml':''));
			echo fs_file_read($filepath_recycle);

		}
		else
		{

			R_echofile($filepath_recycle,$item['cloud_name']);

		}

	}

//1 realdelete
	function realdelete()
	{

		$ids=$_POST['ids'];

		$ids=expd($ids);

		$ids=array_unique($ids);

		if(!$ids)
		{
			R_alert('[error-2602]参数错误');
		}

		\controller\cloud\Index::recycle_handle($ids,\controller\cloud\Index::recycle_cmd_realdelete);

		R_jump();

	}

	function realdelete_all()
	{

		$__db=\db\Cloud::db_instance();

		$where=[];
		$where['cloud_adminid']=clu_admin_id();
		$where['cloud_isdelete']=1;
		$where['cloud_type']=\db\Cloud::cloudtype_file;

		if(1)
		{//删除相关文件
			$list=$__db->where($where)->field(
				[
					'id',
					'cloud_type',
					'cloud_folder_dad',
					'cloud_file_url',
				])->select();

			if($list)
			{
				foreach($list as $v)
				{
					fs_file_delete(\controller\cloud\Index::recycle_filepath_to_recycle('.'.$v['cloud_file_url']));
				}
			}
		}
		if(1)
		{//删除数据库数据
			unset($where['cloud_type']);
			$__db->where($where)->delete();
		}

		R_jump();

	}
//1 rescue
	function rescue()
	{

		$ids=$_POST['ids'];

		$ids=expd($ids);

		$ids=array_unique($ids);

		if(!$ids)
		{
			R_alert('[error-2604]参数错误');
		}

		\controller\cloud\Index::recycle_handle($ids,\controller\cloud\Index::recycle_cmd_rescue);
		\controller\cloud\Index::db_nameconflict_check(0);

		R_jump();

	}
//1 order
	function order()
	{

		if(array_key_exists($_POST['order'],\db\Cloud::order_ordermap_recycle))
		{
			session_set('cloudrecycle_currentorder',$_POST['order']);
			R_jump();
		}
		else
		{
			R_alert('[error-5324]参数错误');
		}

	}
}
