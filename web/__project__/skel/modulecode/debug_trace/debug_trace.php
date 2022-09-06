<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

$__rootdir=debug_trace(cmd_get);

$__itemlist=fs_dir_searchfile($__rootdir,'data');

usort($__itemlist,function($item0,$item1)
{

	$item0=path_filename_core($item0);
	$item0=expd($item0,'_');

	$item1=path_filename_core($item1);
	$item1=expd($item1,'_');

	if($item0[0]==$item1[0])
	{
		return $item0[1]>$item1[1];
	}
	else
	{
		return $item0[0]>$item1[0];
	}

});

$table_thlist=
[

	'时间'=>'200px',

	'key'=>'200px',

	'value'=>0,

	'操作'=>'100px',
];

$table_trlist=[];

foreach($__itemlist as $item)
{


	$__data=fs_file_read_data($item);

	$__dna=path_filename_core($item);

	$__dna_temp=expd($__dna,'_');

	$__templine=[];

	$__templine[]=[$__data['time'].' ('.$__dna_temp[1].')',$__dna];

	if(1)
	{

		$temptd=[];
		if($__data['key'])
		{
			$temptd[]=_b__('','','',$__data['key']);
		}

		$temptd[]=$__data['route'];

		$__templine[]=impd($temptd,'<br><br>');

	}

	$__templine[]=debug_dump($__data['data'],-1,0);

	$__templine[]=_a0__('','','onclick="debugtrace_delete(\''.$__dna.'\',\''.$__dna.'\')"','删除');

	$table_trlist[]=$__templine;

}

echo _module('c_admin_panel_template_fixed');

	echo _div__('g_warnbox','','','存储路径:&nbsp;'.$__rootdir);

	echo _div('c_admin_panel_oper');

		echo _a0__('','','__button__="small red solid" onclick="table_oper_confirm(this,\'delete_all\')" ','清空全部');

		echo _a0__('','','__button__="small purple" onclick="debugtrace_delete_bat(this);" ','批量/删除');

	echo _div_();

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

