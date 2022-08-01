<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

$__id=intval($_GET['id']);

$__keyword=$_GET['_keyword'];

$__moveids=session_get('cloudindex_moveids');
$__moveids=$__moveids?$__moveids:[];

$__currentfolder=false;
$__currentfolder_acsts=false;

$__order=session_get('cloudindex_currentorder');
if(!$__order)
{
	$__order=\db\Cloud::order_default;
}

if($__id&&!$__keyword)
{

	$__currentfolder=\controller\cloud\Index::db_assertfind($__id);

	$__currentfolder_acsts=\db\Cloud::folder_acsts($__currentfolder);

	$__currentfolder_acsts=array_merge($__currentfolder_acsts,[$__currentfolder]);

}

$__where=[];
$__where['cloud_adminid']=clu_admin_id();
$__where['cloud_isdelete']=0;

if($__keyword)
{
	$__where['cloud_name|cloud_file_url']=[db_like,'%'.$__keyword.'%'];
}
else
{
	$__where['cloud_folder_dad']=$__id;
}

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

	'修改时间'=>'100px',

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

			if(
				in_array($item['cloud_file_ext'],\db\Cloud::file_type_extmap[\db\Cloud::file_type_pic])
			)
			{
				$temp_name.=_img($item['cloud_file_url'].'?'.$item['cloud_updatetime'],'itempicthumb');
			}
			else
			{
				$temp_name.=_img('/assets/img/fileicon/'.$file_type.'.svg','itemicon');
			}

			$temp_name.=_an__($item['cloud_file_url'],'itemname','','',$item['cloud_name']);

			$temp_type='文件/'.\db\Cloud::file_type_namemap[$file_type].'/'.$item['cloud_file_ext'];

			$temp_size=datasize_oralstring($item['cloud_file_size']);

		}
		else if(\db\Cloud::cloudtype_folder==$item['cloud_type'])
		{

			$temp_name.=_img('/assets/img/fileicon/folder.svg','itemicon');

			if(in_array($item['id'],$__moveids))
			{
				$temp_name.=_span__('itemname','','',$item['cloud_name']);
			}
			else
			{
				$temp_name.=_a__(url_build('',['id'=>$item['id']]),'itemname','','',$item['cloud_name']);
			}

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

	$__templine[]=_span__($item['cloud_createtime']==$item['cloud_updatetime']?'__color_grey__':'','','',str_replace(' ','<br>',time_str($item['cloud_updatetime'])));//$item['cloud_updatetime']?'':str_replace(' ','<br>',time_str($item['cloud_updatetime']));

	if(1)
	{

		$temptd=[];

		if(in_array($item['id'],$__moveids))
		{
			$temptd[]=_span__('__color_grey__','','','待移动');
		}
		else
		{
			$temptd[]=_a0__('','','onclick="cloudindex_delete('.$item['id'].',\''.$item['cloud_name'].'\')"','删除');

			if($__keyword)
			{

			}
			else
			{
				$temptd[]=_a0__('','','onclick="table_oper(this,\'move\')"','移动');
			}

			$temptd[]=_a0__('','','onclick="table_oper(this,\'rename\')"','重命名');

			if(\db\Cloud::cloudtype_file==$item['cloud_type'])
			{
				$temptd[]=_a0__('','','onclick="table_oper(this,\'file_replace\')"','替换文件');
				$temptd[]=_a0__('','','onclick="copy_copytext(\''.server_host_http().$item['cloud_file_url'].'\',1)"','复制URL(绝对)');
				$temptd[]=_a0__('','','onclick="copy_copytext(\''.$item['cloud_file_url'].'\',1)"','复制URL(相对)');
				if(in_array($item['cloud_file_ext'],\Prjconfig::file_pic_exts))
				{
					$temptd[]=_a0__('','','onclick="table_oper(this,\'buildimage_setarg\')"','图片参数访问');
				}
			}

			$acsts_html='';

			if($__keyword)
			{
				$acsts_temp=\db\Cloud::folder_acsts($item);
				$acsts_temp=array_merge(
				[
					[
						'id'=>0,
						'cloud_name'=>'ROOT'
					]
				],$acsts_temp);

				$sep_temp='<hr>所属路径:&nbsp;';

				foreach($acsts_temp as $v)
				{
					$acsts_html.=$sep_temp._a__(url_build('',['id'=>$v['id']]),'','','',$v['cloud_name']);
					$sep_temp='&nbsp;>&nbsp;';
				}

			}
		}

		$__templine[]=impd($temptd,'&emsp;/&emsp;').$acsts_html;

	}

	$table_trlist[]=$__templine;

}

echo _module('c_admin_panel_template_fixed');

	if(1)
	{
		echo _div('c_admin_panel_oper');

			echo _form(url_build());
				echo _input('_keyword',$_GET['_keyword'],'名称/url','','');
				echo _button('submit','搜索','gap1','','__button__="small black" ');
			echo _form_();

			echo _span__('','','','排序:');
			echo _select('',$__order,'gap1','','onchange="cloudindex_order(this);" ');
				foreach(\db\Cloud::order_ordermap as $k=>$v)
				{
					echo _option($k,$v);
				}
			echo _select_();

			if($__keyword)
			{

			}
			else
			{
				echo _a0__('','','__button__="small green solid" onclick="cloudindex_add_folder();" ','新建文件夹');
				echo _a0__('gap1','','__button__="small aqua solid" onclick="cloudindex_add_file();" ','上传文件');

				if($__moveids)
				{
					echo _a0__('','','__button__="small fuchsia" onclick="cloudindex_move_1(this);" ','移动/移动至此');
					echo _a0__('gap1','','__button__="small fuchsia" onclick="table_oper(this,\'move_cancel\');" ','移动/取消移动');
				}
				else
				{
					echo _a0__('','','__button__="small purple" onclick="cloudindex_delete_bat(this);" ','批量/删除');
					echo _a0__('gap1','','__button__="small purple" onclick="cloudindex_move_bat(this);" ','批量/移动');
				}
			}

		echo _div_();

	}

	if(1)
	{

		echo _div('folderpathz');

			echo _span__('','','','当前路径:&emsp;&emsp;');

			echo _a__(url_build(),'','','','ROOT');

			if($__keyword)
			{
				echo _i__();
				echo _span__('','','','搜索结果:'.$__keyword);
			}
			else
			{
				foreach($__currentfolder_acsts as $v)
				{
					echo _i__();
					echo _a__(url_build('',['id'=>$v['id']]),'','','',$v['cloud_name']);
				}
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

htmlecho_js_addvar('cloudindex_foldid',$__id);

