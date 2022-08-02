<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\foreground;
class Upload extends super\Superforeground
{

	const uploadfile_timeout=3600;//s

	const uploadconfig_maxnum=100;//应该用不了这么多吧

	function uploadfile($token,$scene=false)
	{

		if(0)
		{//test
			dd_trace('0050',$_FILES);
			R_false('[error-4849]');
		}

		set_time_limit(self::uploadfile_timeout);

		$__config=self::uploadtoken_get($token);

		if(!$__config)
		{
			R_false('[error-1937]没有找到上传配置,请刷新页面后重试');
		}

		$__result_filelist=[];

		foreach($_FILES as $v)
		{

			if(1)
			{//基本检测
				if(UPLOAD_ERR_OK==$v['error'])
				{//UPLOAD_ERR_OK,UPLOAD_ERR_INI_SIZE,UPLOAD_ERR_FORM_SIZE,UPLOAD_ERR_PARTIAL,UPLOAD_ERR_NO_FILE,UPLOAD_ERR_NO_TMP_DIR,UPLOAD_ERR_CANT_WRITE,UPLOAD_ERR_EXTENSION

				}
				else if(UPLOAD_ERR_INI_SIZE==$v['error'])
				{
					R_false('[error-3726]文件大小超出服务器限制');
				}
				else
				{
					R_false('[error-1408]上传文件出错,code:'.$v['error']);
				}

				if(!$v||0==$v['size'])
				{
					R_false('[error-3521]没有上传文件或文件为0字节');
				}
				if($v['size']>$__config['file_maxsize'])
				{
					R_false('[error-0349]文件不能超过'.datasize_oralstring($__config['file_maxsize']));
				}

				$__file_ext=path_ext($v['name']);

				if(!$__file_ext)
				{
					R_false('[error-0456]扩展名缺失');
				}

				if('jpeg'==$__file_ext)
				{
					$__file_ext='jpg';
				}
				if(!in_array_1($__file_ext,$__config['file_exts']))
				{
					R_false('[error-3705]错误文件类型');
				}
			}

			if(1)
			{

				$filepath=self::savefile_genfilepath($__config['file_savedir'],$__file_ext);


				if(in_array($__file_ext,\Prjconfig::file_pic_exts))
				{

					$imagesize=getimagesize($v['tmp_name']);
					if(!$imagesize)
					{
						R_false('[error-2843]解析图片尺寸错误');
					}

				}

				if('xxx'==$scene)
				{//如果需要转储到云空间,ftp,cdn,数据库啥的

				}
				else
				{
					$moveresult=fs_move_uploaded_file($v['tmp_name'],$filepath);
				}

				if($moveresult)
				{

					$__result_filelist[]=$filepath;

					if($__config['upload_savefileinfo'])
					{//如果想保留文件名和文件大小的信息的话
						self::uploaded_fileinfo_set(ltrim($filepath,'.'),
							[
								'file_name'=>htmlentity_encode($v['name']),//防注入
								'file_size'=>$v['size']
							]);
					}

				}
				else
				{
					R_false('[error-2439]存储文件出错');
				}

			}

		}

		if('wangeditor'==$scene)
		{//可能多文件

			if(is_array($__result_filelist))
			{
				$data=[];
				foreach($__result_filelist as $v)
				{
					$data[]=
					[
						'url'=>ltrim($v,'.'),
						'alt'=>'',
						'href'=>''
					];
				}
				R_true($data);
			}
			else
			{
				R_alert($__result_filelist);
			}

		}
		else
		{//单文件

			if(is_array($__result_filelist))
			{
				R_true(ltrim($__result_filelist[0],'.'));
			}
			else
			{
				R_false($__result_filelist);
			}

		}

	}

//1 uploadtoken
	static function uploadtoken_set
	(

		array $file_exts,

		int $file_maxsize,

		$upload_savetodir=false,

		$upload_keepfileinfo=false/*上传文件到服务器时,服务器是否保留文件信息(文件名,文件大小)备用*/

	)
	{

		if(!$file_exts||!$file_maxsize)
		{//限制必须传入上传文件的扩展名,php,js,exe之类的慎用,可能被注入攻击
			R_alert('[error-5410]必须指定上传文件扩展名和文件大小上限');
		}

		$upload_config=session_get('upload_config');

		if(1)
		{//扩展名
			$temp['file_exts']=$file_exts;
			foreach($file_exts as &$v)
			{
				$v='.'.$v;
			}
			unset($v);
			$temp['file_exts_acceptstr']=impd($file_exts);//特殊情况应该在外部覆盖这个值
		}

		$temp['file_maxsize']=intval($file_maxsize);

		if($upload_savetodir)
		{

			if(0===strpos($upload_savetodir,'./'))
			{

			}
			else
			{
				$upload_savetodir=__upload_dir__.'/'.$upload_savetodir;
			}
		}
		else
		{
			$upload_savetodir=__upload_dir__;
		}

		if('foreground'==__route_module__)
		{
			$upload_savetodir.='/'.date_str_num().'/u'.clu_id();
		}
		else if
		(
			'admin'==__route_module__||
			'skel'==__route_module__||
			'cloud'==__route_module__
		)
		{
			$upload_savetodir.='/'.date_str_num().'/a'.clu_admin_id();
		}
		else
		{
			R_alert('[error-3023]');
		}

		$temp['file_savedir']=$upload_savetodir;

		$temp['upload_savefileinfo']=$upload_keepfileinfo?true:false;

		if(1)
		{
			$token=md5_md5($temp);

			if($upload_config[$token])
			{//如果已经生成直接返回
				return $upload_config[$token];
			}
		}

		$temp['upload_url']='/upload/uploadfile?token='.$token;

		$temp['@createtime']=time_str();

		$upload_config=array_pipe_push($upload_config,[$token=>$temp],self::uploadconfig_maxnum);

		session_set('upload_config',$upload_config);

		return $temp;

	}

	static function uploadtoken_get($token)
	{
		$upload_config=session_get('upload_config');
		return $upload_config[$token];
	}

//1 uploadedfile
	static function uploaded_fileinfo_set($fileurl,$fileinfo)
	{

		fs_file_save_data(__temp_dir__.'/uploaded_fileinfo'.$fileurl.'.data',$fileinfo);

	}
	static function uploaded_fileinfo_get($fileurl)
	{//如果想获取上传文件的原始文件名,大小什么的到这里取值

		return fs_file_read_data(__temp_dir__.'/uploaded_fileinfo'.$fileurl.'.data');

	}

//1 savefile
	static function savefile_genfilepath($dirpath,$ext)
	{

		while(1)
		{//生成存储文件路径
			$filepath=$dirpath.'/'.math_salt().'.'.$ext;
			if(!is_file($filepath))
			{
				break;
			}
		}

		return $filepath;

	}
	static function savefile_movetodir($from_filepath,$to_dirpath)
	{

		$to_filepath=self::savefile_genfilepath($to_dirpath,path_ext($from_filepath));

		$result=fs_file_move($from_filepath,$to_filepath);

		if($result)
		{
			return $to_filepath;
		}
		else
		{
			R_alert('[error-5042]移动文件失败');
		}

	}


}
