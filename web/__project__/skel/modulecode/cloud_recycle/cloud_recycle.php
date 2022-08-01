<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

$__order=session_get('cloudrecycle_currentorder');
if(!$__order)
{
	$__order=\db\Cloud::order_default_recycle;
}

$__where=[];
$__where['cloud_adminid']=clu_admin_id();
$__where['cloud_isdelete']=1;
$__where['cloud_folder_dad']=0;

$__db=\db\Cloud::db_instance();

$__itemlist=$__db->where($__where)->orderby($__order)->select();

$table_thlist=
[
	'ID'=>'100px',

	'名称'=>'300px',

	'类型'=>'100px',

	'大小'=>'100px',

	'尺寸'=>'100px',

	'创建时间'=>'100px',

	'删除时间'=>'100px',

	'操作'=>0,

];

$table_trlist=[];

foreach($__itemlist as $item)
{

	$__templine=[];

	$__templine[]=$item['id'];

	if(1)
	{

		$temp_name='';
		$temp_type='';
		$temp_size='';

		if(\db\Cloud::cloudtype_file==$item['cloud_type'])
		{

			$file_type=\db\Cloud::file_type_get($item['cloud_file_ext']);
			$file_url='/cloud/recycle/file_echofile?id='.$item['id'];

			if(
				in_array($item['cloud_file_ext'],\db\Cloud::file_type_extmap[\db\Cloud::file_type_pic])
			)
			{
				$temp_name.=_img($file_url,'itempicthumb');
			}
			else
			{
				$temp_name.=_img('/assets/img/fileicon/'.$file_type.'.svg','itemicon');
			}
			$temp_name.=_an__($file_url,'itemname','','',$item['cloud_name']);

			$temp_type='文件/'.\db\Cloud::file_type_namemap[$file_type].'/'.$item['cloud_file_ext'];

			$temp_size=datasize_oralstring($item['cloud_file_size']);

		}
		else if(\db\Cloud::cloudtype_folder==$item['cloud_type'])
		{

			$temp_name.=_img('/assets/img/fileicon/folder.svg','itemicon');
			$temp_name.=_span__('itemname','','',$item['cloud_name']);

			$temp_type='文件夹';

		}
		else
		{
			R_alert('[error-3039]');
		}

		$__templine[]=$temp_name;
		$__templine[]=$temp_type;
		$__templine[]=$temp_size;

	}

	if($item['cloud_file_pic_width']&&$item['cloud_file_pic_height'])
	{
		$__templine[]=$item['cloud_file_pic_width'].'*'.$item['cloud_file_pic_height'];
	}
	else
	{
		$__templine[]='';
	}

	$__templine[]=str_replace(' ','<br>',time_str($item['cloud_createtime']));

	$__templine[]=str_replace(' ','<br>',time_str($item['cloud_deletetime']));

	if(1)
	{

		$temptd=[];
		$temptd[]=_a0__('','','onclick="cloudrecycle_realdelete('.$item['id'].',\''.$item['cloud_name'].'\')"','彻底删除');
		$temptd[]=_a0__('','','onclick="table_oper_confirm(this,\'rescue\',\'即将还原到ROOT文件夹下,继续?\')"','还原');

		$__templine[]=impd($temptd,'&emsp;/&emsp;').$acsts_html;

	}

	$table_trlist[]=$__templine;

}

echo _module('c_admin_panel_template_fixed');

	if(1)
	{
		echo _div('c_admin_panel_oper');

			echo _span__('','','','排序:');
			echo _select('',$__order,'gap1','','onchange="cloudrecycle_order(this);" ');
				foreach(\db\Cloud::order_ordermap_recycle as $k=>$v)
				{
					echo _option($k,$v);
				}
			echo _select_();

			if(1)
			{
				echo _a0__('gap1','','__button__="small red solid" onclick="cloudrecycle_realdelete_all();" ','清空回收站');
				echo _a0__('','','__button__="small purple" onclick="cloudrecycle_realdelete_bat(this);" ','批量/彻底删除');
				echo _a0__('gap1','','__button__="small purple" onclick="cloudrecycle_rescue_bat(this);" ','批量/还原');
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

