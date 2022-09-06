<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

namespace controller\debug;

class Log extends \controller\admin\super\Superadmin
{

	function index()
	{
		_skel();
	}
//1 delete
	function delete()
	{

		$_POST['dnas']=htmlentity_decode($_POST['dnas']);

		$dnas=expd($_POST['dnas']);

		$__rootdir=debug_log(cmd_get);

		$path=null;

		if($dnas)
		{
			foreach($dnas as $v)
			{
				if(is_dir($path=$__rootdir.'/'.$v))
				{
					fs_dir_delete($path);
				}
				else if(is_file($path=$__rootdir.'/'.$v.'.log'))
				{
					fs_file_delete($path);
				}
				else
				{

				}
			}

			R_jump();

		}
		else
		{
			R_alert('[error-5538]');
		}

	}

	function delete_all($dna)
	{

		$__rootdir=debug_log(cmd_get);

		if($dna)
		{
			$__rootdir.='/'.$dna;
		}

		if(!is_dir($__rootdir))
		{
			R_alert('[error-2923]');
		}

		fs_dir_delete($__rootdir);
		fs_dir_create($__rootdir);

		R_jump();

	}

//1 rename
	function rename($dna)
	{

		if(!check_isavailable($dna))
		{
			R_alert('[error-4256]');
		}

		$temp=expd($dna,'/');

		R_window_xml(xml_getxmlfilepath(),url_build('rename_1?dna='.$dna),['name'=>end($temp)]);

	}
	function rename_1($dna)
	{

		$_POST['name']=htmlentity_decode($_POST['name']);

		if(!check_isavailable($dna))
		{
			R_alert('[error-2449]');
		}

		if(!check_isavailable($_POST['name']))
		{
			R_alert('[error-4412]请输入名称');
		}

		if(check_hasdangerchar($_POST['name']))
		{
			R_alert('[error-0821]名称含有禁用字符:<br>'.check_hasdangerchar_plaintext());
		}

		$__rootdir=debug_log(cmd_get);

		$temp=expd($dna,'/');

		if($_POST['name']==end($temp))
		{//没改名,啥也不干

		}
		else
		{

			$__oldpath=null;

			if(is_dir($__oldpath=$__rootdir.'/'.$dna))
			{

				if(is_dir($__rootdir.'/'.$_POST['name']))
				{
					R_alert('[error-0626]同名冲突');
				}

				fs_dir_move($__oldpath,$_POST['name']);

			}
			else if(is_file($__oldpath=$__rootdir.'/'.$dna.'.log'))
			{

				$pathinfo=path_info($__oldpath);

				if(is_file($pathinfo[0].'/'.$_POST['name'].'.log'))
				{
					R_alert('[error-3235]同名冲突');
				}

				fs_file_move($__oldpath,$_POST['name'].'.log');

			}
			else
			{
				R_alert('[error-4127]路径不存在');
			}

		}

		R_jump();

	}
//1 file
	function logfile_echofile($dna)
	{

		$filepath=debug_log(cmd_get).'/'.$dna.'.log';

		$file_size=filesize($filepath);

		if(false===$file_size)
		{
			R_alert('[error-5053]输出文件不存在或不能读取');
		}

		if($file_size>\Prjconfig::file_echofile_maxsize)
		{
			R_alert('[error-5051]输出文件不能超过'.datasize_oralstring(\Prjconfig::file_echofile_maxsize));
		}

		header('Content-Type:text/plain;charset=utf-8');

		echo fs_file_read($filepath);

		exit;

	}

}
