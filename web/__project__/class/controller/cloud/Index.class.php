<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

namespace controller\cloud;

class Index extends \controller\admin\super\Superadmin
{

//1 upload

	const upload_file_maxsize=100*datasize_1mb;
	const upload_file_maxnum=9999;

//1 recycle

	const recycle_prefix='cloudrecycle_';//需要在nginx配置里面根据cloudrecycle_配置好禁止访问

	const recycle_cmd_delete=1;
	const recycle_cmd_rescue=2;

	const recycle_cmd_realdelete=10;
	const recycle_cmd_realdelete_all=11;

	static function recycle_filepath_to_recycle($filepath)
	{

		$path_info=path_info($filepath);
		return $path_info[0].'/'.self::recycle_prefix.$path_info[1];

	}
	static function recycle_handle(array $ids,$__cmd)
	{

		$__folder_ids=[];

		$__file_ids=[];

		$__total_ids=[];

		$__file_urls=[];

		$__db=\db\Cloud::db_instance();

		if(self::recycle_cmd_delete==$__cmd)
		{
			$__isdelete=0;
		}
		else if(self::recycle_cmd_rescue==$__cmd)
		{
			$__isdelete=1;
		}
		else if(self::recycle_cmd_realdelete==$__cmd)
		{
			$__isdelete=1;
		}
		else if(self::recycle_cmd_realdelete_all==$__cmd)
		{//不用了,放在Recycle.class.php里面去处理
			R_alert('[error-1753]');
		}
		else
		{
			R_alert('[error-1739]');
		}

		$__get_descendant_ids=function($ids) use
		(
			$__isdelete,
			&$__db,
			&$__get_descendant_ids,
			&$__folder_ids,
			&$__file_ids,
			&$__file_urls
		)
		{

			$where=[];
			$where['cloud_adminid']=clu_admin_id();
			$where['cloud_isdelete']=$__isdelete;
			$where['cloud_folder_dad']=[db_in,$ids];

			$folder_ids=[];

			$temp=$__db->where($where)->field(
			[
				'id',
				'cloud_type',
				'cloud_folder_dad',
				'cloud_file_url',
			])->select();

			foreach($temp as $v)
			{
				if(\db\Cloud::cloudtype_file==$v['cloud_type'])
				{
					$__file_ids[]=$v['id'];
					$__file_urls[]=$v['cloud_file_url'];
				}
				else if(\db\Cloud::cloudtype_folder==$v['cloud_type'])
				{
					$folder_ids[]=$v['id'];
				}
				else
				{
					R_alert('[error-2444]');
				}
			}

			if($folder_ids)
			{
				$__folder_ids=array_merge($__folder_ids,$folder_ids);
				$__get_descendant_ids($folder_ids);
			}
			else
			{

			}

		};

		$where=[];
		$where['cloud_adminid']=clu_admin_id();
		$where['cloud_isdelete']=$__isdelete;
		$where['id']=[db_in,$ids];

		$list=$__db->where($where)->field(
			[
				'id',
				'cloud_type',
				'cloud_folder_dad',
				'cloud_file_url',
			])->select();

		if(count($list)!=count($ids))
		{
			R_alert('[error-3032]含有不允许操作或不存在的id');
		}

		foreach($list as $v)
		{
			if(\db\Cloud::cloudtype_file==$v['cloud_type'])
			{
				$__file_ids[]=$v['id'];
				$__file_urls[]=$v['cloud_file_url'];
			}
			else if(\db\Cloud::cloudtype_folder==$v['cloud_type'])
			{
				$__folder_ids[]=$v['id'];
			}
			else
			{
				R_alert('[error-2852]');
			}
		}

		if($__folder_ids)
		{
			$__get_descendant_ids($__folder_ids);
		}

		$__total_ids=array_merge($__folder_ids,$__file_ids);

		if(self::recycle_cmd_delete==$__cmd)
		{
			$__db->where($ids)->save_fieldset('cloud_folder_dad',0);

			if($__total_ids)
			{
				$__db->where($__total_ids)->save_fieldset('cloud_isdelete',1);
			}

			if($__file_urls)
			{

				foreach($__file_urls as $v)
				{

					fs_file_move('.'.$v,self::recycle_filepath_to_recycle('.'.$v));

					self::recycle_deletebuildimage('.'.$v);

				}

			}

		}
		else if(self::recycle_cmd_rescue==$__cmd)
		{

			if($__total_ids)
			{
				$__db->where($__total_ids)->save_fieldset('cloud_isdelete',0);
			}

			if($__file_urls)
			{
				foreach($__file_urls as $v)
				{
					fs_file_move(self::recycle_filepath_to_recycle('.'.$v),'.'.$v);
				}
			}

		}
		else if(self::recycle_cmd_realdelete==$__cmd)
		{
			if($__total_ids)
			{
				$__db->where($__total_ids)->delete();
			}

			if($__file_urls)
			{
				foreach($__file_urls as $v)
				{
					fs_file_delete(self::recycle_filepath_to_recycle('.'.$v));
				}
			}
		}
		else if(self::recycle_cmd_realdelete_all==$__cmd)
		{
			R_alert('[error-1731]');
		}
		else
		{
			R_alert('[error-1733]');
		}

	}

	static function recycle_deletebuildimage($filepath)
	{

		$info=path_info($filepath);

		array_map('unlink',glob($info[0].'/'.$info[2].'[*.'.$info[3]));

	}
//1 db
	static function db_assertfind($id)
	{

		$where=[];

		$where['cloud_adminid']=clu_admin_id();
		$where['id']=$id;

		$item=\db\Cloud::find($where);

		if($item)
		{
			return $item;
		}
		else
		{
			if(__ajax_isajax__)
			{
				R_alert('[error-1147]未找到或无权限');
			}
			else
			{
				R_jump('/cloud','[error-1352]未找到或无权限');
			}
		}

	}
 	static function db_nameconflict($cloud_folder_dad_id,$cloud_name,$except_id=0)
	{

		$where=[];

		$where['cloud_folder_dad']=$cloud_folder_dad_id;
		$where['cloud_adminid']=clu_admin_id();
		$where['cloud_isdelete']=0;
		$where['cloud_name']=$cloud_name;

		if($except_id)
		{
			$where['id']=[db_neq,$except_id];
		}

		$item=\db\Cloud::find($where);

		return $item;

	}
	static function db_nameconflict_check($cloud_folder_dad_id)
	{

		$__db=\db\Cloud::db_instance();

		$where=[];

		$where['cloud_folder_dad']=$cloud_folder_dad_id;
		$where['cloud_adminid']=clu_admin_id();
		$where['cloud_isdelete']=0;

		$item_list=$__db->field(['id','cloud_name','cloud_type'])->where($where)->orderby('cloud_updatetime asc,id desc')->select();

		if(!$item_list)
		{
			return;
		}

		$name_list=[];

		$index_needchange=[];

		foreach($item_list as $k=>$v)
		{

			$name=strtolower($v['cloud_name']);

			if(in_array($name,$name_list))
			{
				$index_needchange[]=$k;
			}
			else
			{

			}

			$name_list[]=$name;

		}

		foreach($index_needchange as $v)
		{

			$item=$item_list[$v];

			$new_name='';

			$ext='';

			if(\db\Cloud::cloudtype_file==$item['cloud_type'])
			{

				$pathinfo=path_info($item['cloud_name']);

				$new_name=$pathinfo[2];

				$ext='.'.$pathinfo[3];
			}
			else if(\db\Cloud::cloudtype_folder==$item['cloud_type'])
			{
				$new_name=$item['cloud_name'];
			}
			else
			{
				R_alert('[error-0712]');
			}

			$new_name=preg_replace('/#(同名冲突[a-z0-9]*)?$/i','',$new_name);

			$new_name.='#同名冲突'.math_salt().$ext;

			\db\Cloud::save_fieldset($item['id'],'cloud_name',$new_name);

		}

	}



//1 index
	function index()
	{
		_skel();
	}

//1 add
	function add_folder($id)
	{
		R_window_xml(xml_getxmlfilepath(),url_build('add_folder_1?id='.$id));
	}
	function add_folder_1($id)
	{

		if(!var_isavailable($_POST['name']))
		{
			R_alert('[error-0714]请输入名称');
		}

		if(self::db_nameconflict($id,$_POST['name']))
		{
			R_alert('[error-1822]同名冲突');
		}

		$add=[];
		$add['cloud_adminid']=clu_admin_id();
		$add['cloud_type']=\db\Cloud::cloudtype_folder;
		$add['cloud_name']=$_POST['name'];
		$add['cloud_folder_dad']=$id;
		\db\Cloud::add($add);

		R_jump();

	}
	function add_file($id)
	{
		if(1)
		{
			$config=[];

			$config['@upload_config']=\controller\foreground\Upload::uploadtoken_set
				(
					\db\Cloud::file_type_allexts(),
					self::upload_file_maxsize,
					__temp_dir__.'/cloud',
					1
				);

			$config['@upload_config']['upload_url'].='&scene=cloud';

			$config['uploadfile_filemaxnum']=self::upload_file_maxnum;

			$config['uploadfile_inputname']='filelist';

			$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin(url_build('add_file_1?id='.$id));
				$H.=_div('uploadz');
					$H.=\_widget_\Uploadfile::uploadfile_html($config);
				$H.=_div_();

				$H.=_button('submit','确定上传','','margin-top:20px;','__button__="medium color0 block solid"');
			$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

		}

		$H.=_div__('','','uiwindow_role=close');

		$domset=[];

		$domset['cls']='cloudindex_file_upload';

		R_window($H,$domset);

	}
	function add_file_1($id)
	{

		if(!$_POST['filelist'])
		{
			R_alert('[error-0740]请上传文件');
		}

		$filelist=expd($_POST['filelist']);

		foreach($filelist as $v)
		{

			$file_info=\controller\foreground\Upload::uploaded_fileinfo_get($v);

			if(!$file_info)
			{
				R_alert('[error-5144]获取文件信息出错');
			}

			$filename_name=$file_info['file_name'];
			$filename_core=path_filename_core($file_info['file_name']);
			$filename_ext=path_ext($file_info['file_name']);

			$v=\controller\foreground\Upload::savefile_movetodir('.'.$v,__upload_dir__.'/cloud/'.date_str_num().'/a'.clu_admin_id());//转换成正式存储文件,temp下面的那些要定时清理,都是不用的

			$v=ltrim($v,'.');

			$add=[];
			$add['cloud_adminid']=clu_admin_id();
			$add['cloud_type']=\db\Cloud::cloudtype_file;
			$add['cloud_name']=$filename_name;
			$add['cloud_file_size']=$file_info['file_size'];
			$add['cloud_folder_dad']=$id;
			$add['cloud_file_url']=$v;
			$add['cloud_file_ext']=$filename_ext;

			if(in_array($filename_ext,\Prjconfig::file_pic_exts))
			{

				$imagesize=getimagesize('.'.$v);

				if(!$imagesize)
				{
					R_alert('[error-0708]解析图片尺寸错误');
				}

				$add['cloud_file_pic_width']=$imagesize[0];
				$add['cloud_file_pic_height']=$imagesize[1];
//				$add['cloud_file_pic_pixels']=$imagesize[0]*$imagesize[1];

			}

			\db\Cloud::add($add);

		}

		self::db_nameconflict_check($id);

		R_jump();

	}

//1 delete
	function delete($ids)
	{

		$ids=expd($ids);

		$ids=array_unique($ids);

		if(!$ids)
		{
			R_alert('[error-5452]参数错误');
		}

		self::recycle_handle($ids,self::recycle_cmd_delete);

		R_jump();

	}

//1 rename
	function rename($id)
	{

		$item=self::db_assertfind($id);

		$data=[];

		if(\db\Cloud::cloudtype_file==$item['cloud_type'])
		{
			$data['name']=path_filename_core($item['cloud_name']);
		}
		else if(\db\Cloud::cloudtype_folder==$item['cloud_type'])
		{
			$data['name']=$item['cloud_name'];
		}
		else
		{
			R_alert('[error-5344]');
		}

		R_window_xml(xml_getxmlfilepath(),url_build('rename_1?id='.$id),$data);

	}
	function rename_1($id)
	{

		if(!var_isavailable($_POST['name']))
		{
			R_alert('[error-5802]请输入有效的名称');
		}

		$item=self::db_assertfind($id);

		$cloud_name_new='';

		if(\db\Cloud::cloudtype_file==$item['cloud_type'])
		{
			$cloud_name_new=$_POST['name'].'.'.$item['cloud_file_ext'];
		}
		else if(\db\Cloud::cloudtype_folder==$item['cloud_type'])
		{
			$cloud_name_new=$_POST['name'];
		}
		else
		{
			R_alert('[error-5344]');
		}

		if(self::db_nameconflict($item['cloud_folder_dad'],$cloud_name_new,$id))
		{
			R_alert('[error-3217]同名冲突');

		}

		\db\Cloud::save_fieldset($id,'cloud_name',$cloud_name_new);

		R_jump();

	}

//1 file_replace
	function file_replace($id)
	{

		$item=self::db_assertfind($id);

		if(\db\Cloud::cloudtype_file!=$item['cloud_type'])
		{
			R_alert('[error-2243]');
		}

		if(1)
		{
			$config=[];

			$config['@upload_config']=\controller\foreground\Upload::uploadtoken_set
				(
					[$item['cloud_file_ext']],
					self::upload_file_maxsize,
					__temp_dir__.'/cloud',
					1
				);

			$config['@upload_config']['upload_url'].='&scene=cloud';

			$config['uploadfile_filemaxnum']=1;

			$config['uploadfile_inputname']='filelist';

			$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin(url_build('file_replace_1?id='.$id));
				$H.=_div('uploadz');
					$H.=\_widget_\Uploadfile::uploadfile_html($config);
				$H.=_div_();

				$H.=_button('submit','确定替换','','margin-top:20px;','__button__="medium color0 block solid"');
			$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

		}

		$H.=_div__('','','uiwindow_role=close');

		$domset=[];

		$domset['cls']='cloudindex_file_upload';

		R_window($H,$domset);

	}

	function file_replace_1($id,$force_replace=0)
	{

		if(!$_POST['filelist'])
		{
			R_alert('[error-0718]请上传文件');
		}

		$__item=self::db_assertfind($id);

		$oldfile_path='.'.$__item['cloud_file_url'];

		$newfile_url=$_POST['filelist'];
		$newfile_path='.'.$newfile_url;
		$newfile_info=\controller\foreground\Upload::uploaded_fileinfo_get($newfile_url);
		$newfile_ext=path_ext($newfile_url);

		if(!$newfile_info)
		{
			R_alert('[error-1454]获取文件信息出错');
		}
		if($newfile_ext!=$__item['cloud_file_ext'])
		{
			R_alert('[error-2140]扩展名不匹配');
		}

		$__savedata=[];
		$__savedata['cloud_file_size']=$newfile_info['file_size'];
		$__savedata['cloud_updatetime']=time();

		if(in_array($__item['cloud_file_ext'],\Prjconfig::file_pic_exts))
		{

			$newfile_imagesize=getimagesize($newfile_path);

			if($newfile_imagesize)
			{

				if(
					$newfile_imagesize[0]==$__item['cloud_file_pic_width']&&
					$newfile_imagesize[1]==$__item['cloud_file_pic_height']
				)
				{

				}
				else
				{
					if($force_replace)
					{

						$__savedata['cloud_file_pic_width']=$newfile_imagesize[0];
						$__savedata['cloud_file_pic_height']=$newfile_imagesize[1];
//						$__savedata['cloud_file_pic_pixels']=$newfile_imagesize[0]*$newfile_imagesize[1];

					}
					else
					{
						R_confirm('图片尺寸不匹配,是否强行替换?','
							ajax_sync(\''.url_build('file_replace_1',['id'=>$id,'force_replace'=>1]).'\',{filelist:\''.$newfile_url.'\'});
						');
					}

				}

			}
			else
			{
				R_alert('[error-0301]不能获取图片尺寸');

			}
		}
		else
		{

		}

		\db\Cloud::save($id,$__savedata);

		fs_file_move($newfile_path,$oldfile_path);

		self::recycle_deletebuildimage($oldfile_path);

		R_jump();

	}
//1 move
	function move($ids)
	{

		if(!$ids)
		{
			R_alert('[error-4303]参数错误');
		}

		$ids=expd($ids);

		$ids=array_unique($ids);

		session_set('cloudindex_moveids',$ids);

		R_jump();

	}
	function move_1($id)
	{

		if($id)
		{
			$item=self::db_assertfind($id);
		}

		$ids=session_get('cloudindex_moveids');

		if(!$ids)
		{
			R_alert('[error-5649]参数错误');
		}

		$__db=\db\Cloud::db_instance();

		$where=[];
		$where['cloud_adminid']=clu_admin_id();
		$where['id']=[db_in,$ids];

		$__db->where($where)->save_fieldset('cloud_folder_dad',$id);

		session_delete('cloudindex_moveids');

		self::db_nameconflict_check($id);

		R_jump();

	}
	function move_cancel()
	{

		session_delete('cloudindex_moveids');

		R_jump();

	}


//1 order
	function order()
	{

		if(array_key_exists($_POST['order'],\db\Cloud::order_ordermap))
		{
			session_set('cloudindex_currentorder',$_POST['order']);
			R_jump();
		}
		else
		{
			R_alert('[error-5324]参数错误');
		}

	}
//1 buildimage_setarg
	function buildimage_setarg($id)
	{

		$item=self::db_assertfind($id);

		R_window_xml(xml_getxmlfilepath(),url_build('buildimage_setarg_1?id='.$id),$item);

	}
	function buildimage_setarg_1($id)
	{

		if(
			!$_POST['width']&&
			!$_POST['height']&&
			!$_POST['rotate']
		)
		{
			R_alert('[error-1713]宽度,高度,旋转至少要指定一个');
		}

		$item=self::db_assertfind($id);

		$url=\controller\cloud\Buildimage::buildarg_setarg($item['cloud_file_url'],$_POST['width'],$_POST['height'],$_POST['rotate']);

		R_jscode
		('
				ui_alert(\'生成链接:'.$url.'\');
				jump_opennewwindow(\''.$url.'\');
		');

	}

}
