<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

$__where=db_buildwhere();

$__p=intval($_GET['_p']);

$__npp=10;

if($_GET['_keyword'])
{
	if($_GET['_keywordexact'])
	{

		if('id'==$_GET['_keywordfield'])
		{
			$_GET['_keyword']=floatval($_GET['_keyword']);
		}

		$__where[$_GET['_keywordfield']]=$_GET['_keyword'];

	}
	else
	{
		$__where[$_GET['_keywordfield']]=[db_like,'%'.$_GET['_keyword'].'%'];
	}
}


$__db=\db\User::db_instance();

$__itemlist=$__db->where($__where)->orderby($_GET['_order']?$_GET['_order']:'id desc')->select_splitpage($__p,$__npp,$__totalpagenum,$__totalitemnum);

$__splitpage_html=\_lp_\Splitpage::splitpage_gethtml($__p,$__totalpagenum,$__totalitemnum);

$table_thlist=
[

	'ID'=>'100px',

	'用户名'=>'200px',

	'手机号'=>'100px',

	'邮箱'=>'100px',

	'创建'=>'200px',

	'最后登录'=>'200px',

	'备注'=>'200px',

	'封号'=>'100px',

	'操作'=>0,

];

$table_trlist=[];

foreach($__itemlist as $item)
{

	$__templine=[];

	$__templine[]=$item['id'];

	$__templine[]=\controller\admin\super\Superadmin::userbox_cache($item['id']);

	$__templine[]=$item['user_mobile'];

	$__templine[]=$item['user_email'];

	if(1)
	{
		$temptd=[];
		$temptd[]=time_str($item['user_create_time']);
		$temptd[]=ip_ipbox($item['user_create_ip']);
		$__templine[]=impd($temptd,'<br>');
	}

	if(1)
	{
		$temptd=[];
		if($item['user_lastlogin_time'])
		{
			$temptd[]=time_str($item['user_lastlogin_time']);
		}
		if($item['user_lastlogin_ip'])
		{
			$temptd[]=ip_ipbox($item['user_lastlogin_ip']);
		}
		$__templine[]=impd($temptd,'<br>');
	}

	$__templine[]=$item['user_mark'];

	if(1)
	{
		$__templine[]=_status(!$item['user_isban'],'正常','已封号');
	}

	if(1)
	{

		$temptd=[];

		$temptd[]=_a0__('','','onclick="table_oper(this,\'edit\')"','编辑');

		if($item['user_isban'])
		{
			$temptd[]=_a0__('','','onclick="table_oper(this,\'ban_no\')"','解封');
		}
		else
		{
			$temptd[]=_a0__('','','onclick="table_oper(this,\'ban_yes\')"','封号');
		}

		$__templine[]=impd($temptd,'/');

	}

	$table_trlist[]=$__templine;

}

$__date=date_str();

echo _module('c_admin_panel_template_fixed');

	echo _div('c_admin_panel_oper');

		echo _form(url_build());

			echo _input('_keyword',$_GET['_keyword'],'关键字');

			if(1)
			{

				$options=[];
				$options[]=['id','ID'];
				$options[]=['user_name','用户名'];
				$options[]=['user_mobile','手机号'];
				$options[]=['user_mark','备注'];

				echo _select('_keywordfield',$_GET['_keywordfield']);
					foreach($options as $v)
					{
						echo _option($v[0],$v[1]);
					}
				echo _select_();
			}

			if(1)
			{

				$options=[];

				$options[]=['1','确切'];
				$options[]=['0','模糊'];

				echo _select('_keywordexact',$_GET['_keywordexact'],'gap0');
					foreach($options as $v)
					{
						echo _option($v[0],$v[1]);
					}
				echo _select_();
			}

			if(1)
			{

				$options=[['','全部']];

				$options[]=[0,'正常'];

				$options[]=[1,'已封号'];

				echo _span__('','','','封号:');
				echo _select('user_isban',$_GET['user_isban']);
					foreach($options as $v)
					{
						echo _option($v[0],$v[1]);
					}
				echo _select_();
			}

			echo _span__('','','','创建时间:');
			echo _input_date('_datebegin/user_create_time',$_GET['_datebegin/user_create_time'],'起始时间');
			echo _span__('','','','-');
			echo _input_date('_dateend/user_create_time',$_GET['_dateend/user_create_time'],'结束时间');

			echo _span__('','','','最后登录:');
			echo _input_date('_datebegin/user_lastlogin_time',$_GET['_datebegin/user_lastlogin_time'],'起始时间');
			echo _span__('','','','-');
			echo _input_date('_dateend/user_lastlogin_time',$_GET['_dateend/user_lastlogin_time'],'结束时间');

			if(1)
			{
				$options=[];
				$options[]=['id desc','ID↘'];
				$options[]=['id asc','ID↗'];

				$options[]=['user_lastlogin_time desc','最后登录时间↘'];
				$options[]=['user_lastlogin_time asc','最后登录时间↗'];

				echo _span__('','','','排序:');

				echo _select('_order',$_GET['_order']);
					foreach($options as $v)
					{
						echo _option($v[0],$v[1]);
					}
				echo _select_();
			}

			echo _button('submit','搜索','gap1','','__button__="small black" ');

			echo _a0__('','','__button__="small green solid" onclick="table_oper(this,\'add\')" ','添加用户');

			echo _a__(url_build('',
					[
						'_datebegin/user_create_time'=>$__date,
						'_dateend/user_create_time'=>$__date,
					]),'','','__button__="small aqua solid" ','今日创建');

			echo _a__(url_build('',
					[
						'_datebegin/user_lastlogin_time'=>$__date,
						'_dateend/user_lastlogin_time'=>$__date,
					]),'','','__button__="small purple solid" ','今日登录');

		echo _form_();

	echo _div_();

	if($__itemlist)
	{

		echo _div('c_admin_panel_itemlist');
			echo htmlcache_replace(\_widget_\Tablelist::tablelist_html($table_thlist,$table_trlist,1));
		echo _div_();

		echo $__splitpage_html;
	}
	else
	{
		echo _div('g_emptydatabox');
			echo _b__('','','','没有相关数据');
		echo _div_();
	}

echo _module_();
