<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

$__rootdir=debug_log(cmd_get);

$__currentdna=$_GET['dna'];

if($__currentdna)
{
	$__itemlist=fs_dir_searchfile($__rootdir.'/'.$__currentdna,'log');
}
else
{
	$__itemlist=fs_dir_list($__rootdir);
	$__itemlist=$__itemlist['dir'];
}

$table_thlist=
[

	'名称'=>'300px',
	'大小'=>'100px',
	'修改时间'=>'120px',
	'操作'=>0,

];

$table_trlist=[];

foreach($__itemlist as $item)
{

	$__templine=[];

	if($__currentdna)
	{

		$__item_dna=$__currentdna.'/'.path_filename_core($item);

		$__item_path=$item;

		$__templine[]=
		[

			_an__(url_build('logfile_echofile',
			[

				'dna'=>$__item_dna

			]),'','margin-left:20px;','',$__item_path),

			$__item_dna

		];

		$__templine[]=datasize_oralstring(filesize($__item_path));

		$__templine[]=time_str(filemtime($__item_path));

	}
	else
	{

		$__item_dna=$item;

		$__item_path=$__rootdir.'/'.$item;

		$__templine[]=
		[
			_a__(url_build('',['dna'=>$__item_dna]),'','margin-left:20px;','',$__item_path),
			$__item_dna
		];

		$__templine[]=datasize_oralstring(fs_dir_size($__item_path));

		$__templine[]=time_str(filemtime($__item_path));

	}


	if(1)
	{

		$temptd=[];

		if($__currentdna)
		{

			$temptd[]=_an__(url_build('logfile_echofile',
			[

				'dna'=>$__item_dna

			]),'','','download="'.path_filename($item).'" ','下载');

		}

		$temptd[]=_a0__('','','onclick="debuglog_rename(\''.$__item_dna.'\')"','重命名');

		$temptd[]=_a0__('','','onclick="debuglog_delete(\''.$__item_dna.'\',\''.$__item_path.'\')"','删除');

		$__templine[]=impd($temptd,'&emsp;/&emsp;');

	}

	$table_trlist[]=$__templine;

}

echo _module('c_admin_panel_template_fixed');

	echo _div('c_admin_panel_oper');

		echo _a0__('','','__button__="small red solid" onclick="debuglog_delete_all(\''.$__currentdna.'\')" ','清空全部');

		echo _a0__('','','__button__="small purple" onclick="debuglog_delete_bat(this);" ','批量/删除');

	echo _div_();

	if(1)
	{

		echo _div('folderpathz');

			echo _span__('','','','当前路径:&emsp;&emsp;');

			echo _a__(url_build(),'','','',$__rootdir);

			if($__currentdna)
			{
				echo _i__();
				echo _a__(url_build('',['dna'=>$__currentdna]),'','','',$__currentdna);
			}

		echo _div_();

	}

	if($__itemlist)
	{
		echo _div('c_admin_panel_itemlist');
			echo \_widget_\Tablelist::tablelist_html($table_thlist,$table_trlist,1);
		echo _div_();
	}
	else
	{
		echo _div('g_emptydatabox');
			echo _b__('','','','没有相关数据');
		echo _div_();
	}

echo _module_();

