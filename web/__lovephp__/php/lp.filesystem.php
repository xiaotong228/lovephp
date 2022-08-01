<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



function fs_move_uploaded_file($from_file,$to_file)
{

	fs_dir_create(dirname($to_file));
	return move_uploaded_file($from_file,$to_file);

}
//1 file
//2 fs_file_read
function fs_file_read($filepath,$flag=0)
{

	$result=false;

	if(!is_file($filepath))
	{
		if($flag&fs_loose)
		{
			return null;
		}
		else
		{
			R_exception('[error-5002]未找到文件'.$filepath);
		}
	}

	if($flag&fs_php)
	{
		ob_start();
		include $filepath;
		$result=ob_get_clean();
	}
	else
	{
		$result=file_get_contents($filepath);
	}

	if($flag&fs_trim)
	{
		$result=trim($result);
	}
	if($flag&fs_unserialize)
	{
		$result=unserialize($result);
	}
	if($flag&fs_jsondecode)
	{
		$result=json_decode_1($result);
	}
	return $result;

}

function fs_file_read_data($filepath,$flag=0)
{
	return fs_file_read($filepath,$flag|fs_unserialize|fs_trim);
}

function fs_file_read_php(string $filepath,$flag=0)
{
	return fs_file_read($filepath,$flag|fs_php|fs_trim);
}

function fs_file_read_xml($filepath,$flag=0)
{//先用php的就行,后面有别的需求再说

	return fs_file_read_php($filepath);

}

//2 save
function fs_file_save($filepath,$data)
{

	if(is_null($data))
	{
		R_alert('[error-1523]');
	}
	fs_dir_create(dirname($filepath));

	return file_put_contents($filepath,$data);

}
function fs_file_save_data($filepath,$data)
{

	if(is_null($data))
	{
		R_alert('[error-0735]');
	}

	return fs_file_save($filepath,serialize($data));

}
//2 other

function fs_file_delete($filepath)
{
	$result=unlink($filepath);
	clearstatcache();
	return $result;
}
function fs_file_move($old_path,$new_path/*filepath|filename*/)
{

	if(
		0===strpos($new_path,'./')||
		0===strpos($new_path,'/')
	)
	{
	}
	else
	{
		$old_dir=dirname($old_path);
		$new_path=$old_dir.'/'.$new_path;
	}

	fs_dir_create(dirname($new_path));

	if(1)
	{//如果目标文件存在会被删除
		fs_file_delete($new_path);
	}

	return rename($old_path,$new_path);

}
function fs_file_copy($from_filepath,$to_filepath)
{

	fs_dir_create(dirname($to_filepath));

	return copy($from_filepath,$to_filepath);

}
function fs_file_idautoinc($filepath)
{

	$current_id=fs_file_read_data($filepath,fs_loose);

	$current_id=intval($current_id);

	$current_id++;

	fs_file_save_data($filepath,$current_id);

	return $current_id;
}
function fs_file_prepend($filepath,$data)
{
	if(is_null($data))
	{
		R_alert('[error-4326]');
	}

	$data.=fs_file_read($filepath,fs_loose);

	return fs_file_save($filepath,$data);
}

function fs_file_append($filepath,$data)
{
	if(is_null($data))
	{
		R_alert('[error-1523]');
	}

	fs_dir_create(dirname($filepath));

	return file_put_contents($filepath,$data,FILE_APPEND);

}
//1 dir
function fs_dir_searchfile($dirpath,$__ext/*array|string*/)
{

	$__result=[];

	if(is_array($__ext))
	{

	}
	else
	{
		$__ext=[$__ext];
	}

	$__recufunc=function($dirpath) use (&$__recufunc,$__ext,&$__result)
	{
		$list=fs_dir_list($dirpath);

		foreach($list['file'] as $v)
		{
			$ext=path_ext($v);
			if(in_array_1($ext,$__ext))
			{
				$__result[]=$dirpath.'/'.$v;
			}
		}

		foreach($list['dir'] as $v)
		{
			$__recufunc(rtrim($dirpath,'/').'/'.$v);
		}

	};
	$__recufunc($dirpath);

	return $__result;

}
function fs_dir_move($old_path,$new_path)
{
	return fs_file_move($old_path,$new_path);
}
function fs_dir_list($dirpath)
{//list命令

	if(!is_dir($dirpath))
	{
		return false;
	}

	$result=
	[
		'dir'=>[],
		'file'=>[],
		'all'=>[],
	];

	$hd=opendir($dirpath);
	while(false!==($item=readdir($hd)))
	{
		if(("."==$item)||(".."==$item))
		{
			continue;
		}
		if(is_dir($dirpath.'/'.$item))
		{
			$result['dir'][]=$result['all'][]=$item;
		}
		else
		{
			$result['file'][]=$result['all'][]=$item;
		}
	}
	closedir($hd);
	return $result;

}

function fs_dir_create($dirpath)
{

	if(!is_dir($dirpath))
	{
		mkdir($dirpath,0777,true);//true表示递归创建
		chmod($dirpath,0777);//设置权限,因为第一条由于umask的原因一般是设置不上权限的
	}

}
function fs_dir_delete($dirpath)
{
	if(rmdir($dirpath))
	{
		return;
	}

	$dir_list=fs_dir_list($dirpath);

	foreach($dir_list['file'] as $v)
	{
		fs_file_delete($dirpath.'/'.$v);
	}
	foreach($dir_list['dir'] as $v)
	{
		fs_dir_delete($dirpath.'/'.$v);
	}

	rmdir($dirpath);

	clearstatcache();

}
function fs_dir_clear($dirpath)
{

	$dir_list=fs_dir_list($dirpath);

	foreach($dir_list['file'] as $v)
	{
		fs_file_delete($dirpath.'/'.$v);
	}
	foreach($dir_list['dir'] as $v)
	{
		fs_dir_delete($dirpath.'/'.$v);
	}

}
function fs_dir_copy($from_dirpath,$to_dirpath,$to_dirpath_deletefst=false)
{

	$result=true;

	if($to_dirpath_deletefst)
	{
		fs_dir_delete($to_dirpath);
	}

	fs_dir_create($to_dirpath);

	$dir_list=fs_dir_list($from_dirpath);

	foreach($dir_list['file'] as $v)
	{
		if(!copy($from_dirpath.'/'.$v,$to_dirpath.'/'.$v))
		{
			$result=false;
		}
	}
	foreach($dir_list['dir'] as $v)
	{
		if(fs_dir_copy($from_dirpath.'/'.$v,$to_dirpath.'/'.$v))
		{
			$result=false;
		}
	}

	return $result;

}

