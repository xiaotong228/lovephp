<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



class Prjconfig
{

//1 project
	const project_config=
	[

		'project_name'=>'lovephp',

		'project_owner'=>'lovephp有限公司',

		'project_slogan'=>'Web全栈开源框架',

		'project_officialsite'=>'www.lovephp.com',

		'project_html_meta_keywords'=>'[error-3943]项目默认keywords',

		'project_html_meta_description'=>'[error-4011]项目默认description',

	];
//1 admin
	const admin_accesstoken='lovephp_changeme';//线上模式访问后台需要提供访问码才可访问	/admin?accesscode

//1 file
	const file_pic_exts=['jpg','jpeg','png','gif'];
	const file_echofile_maxsize=10*datasize_1mb;

	const file_avatar_final_maxwidth=400;
	const file_avatar_preselect_maxpixels=1600*1200;//如果预选择的原始图片超过这个尺寸,会被缩放再处理,避免卡顿

//1 html
	const html_iconfont_key='font_3271681_jonk1mvtvk8';

	const html_jqueryurl=(__online_isonline__||__alp_access__)?'/__vendor__/jquery/jquery-3.6.0.min.js':'/__vendor__/jquery/jquery-3.6.0.js';//jquery-1.11.2.js

	const html_common_ani_time=300;//ms

	const html_fakestatic_ext='.html';//false,.html

	static function html_randomcolors_get()
	{

		static $map=null;

		if(is_null($map))
		{
			$map=[];

			$seeds=['0','4','8','c'];

			foreach($seeds as $v)
			{
				foreach($seeds as $vv)
				{
					foreach($seeds as $vvv)
					{
						if($v==$vv&&$vv==$vvv)
						{
							continue;
						}
						$map[]=$v.$vv.$vvv;
					}

				}

			}

		}

		return $map;

	}

//1 ajax
	const ajax_requesttimeout=10;//秒,ajax超时时间

//1 clu
	const clu_config=
	[

		'clu_sessionkey'=>'clu',

		'clu_autologin_enable'=>true,
		'clu_autologin_cookiekey'=>'cluautologintoken',
		'clu_autologin_token_maxnum'=>10,
		'clu_autologin_token_lifetime'=>3600*24*30,

		'clu_defaultavatar'=>'/assets/img/avatar/avatar.default.svg',
		'clu_editusername_firewall_day'=>0,

//2 clu_admin
		'clu_admin_sessionkey'=>'clu_admin',

	];

//1 route
	const route_config=
	[
		'route_module_list'=>
		[
			'foreground',
			'admin',
			'skel',
			'cloud'
		],
		'route_defaultmodule'=>'foreground',
	];

	static function route_pathconvert($path)
	{

		$matchs=[];

		if(preg_match('/^\/article\/(\d+)$/',$path,$matchs))
		{
			$path='/article/article/id/'.$matchs[1];
		}

		return $path;

	}

//1 widget
	const widget_config=
	[//因为怕麻烦并且用css处理动画比js快,一些切屏效果是在css里面定义的,缺点是会导致css代码量增多,注意控制

		'sliderbox_maxframenum'=>10,
		'pagetabshow_maxframenum'=>10,
		'picgallery_maxframenum'=>100,

	];
//1 pc
	const pc_config=
	[

		'pc_widget_list'=>
		[//pc端用到的widget

			'core',

			'svg',

			'ui',

			'button',

			'xml',

			'tablelist',

			'movebox',

			'sliderbox',

			'tabshow',

			'ajaxform',
			'treeshow',
			'selectitem',
			'limittextarea',
			'numberrange',
			'timecount',
			'stickybox',
			'smsvcode',

			'popupbox',
			'popupmenu',

			'uploadfile',
			'uploadpic',
			'uploadavatar',

		]

	];

//1 mobile
	const mobile_config=
	[

//2 widget
		'mobile_widget_list'=>
		[//移动端用到的widget
			'core',

			'svg',

			'ui',

			'button',

			'pullrefresh',

			'scrollappend',

			'sliderbox',

			'ajaxform',

			'inputdefaultfocus',

			'smsvcode',

			'picgallery',

			'pagetabshow',

			'tabshow',

			'uploadfile',
			'uploadpic',
			'uploadavatar',
		],

//2 route
		'route_wap_hardjump_urls'=>
		[//路由硬跳转,匹配到就用url跳转方式,仅限wap环境下
			'/^\/article\/\d+(\?.*)?$/',
		],

//2 page
		'mobile_page_design_px'=>1080,//约定了移动端特有单位mpx的基准值
		'mobile_page_ani_time'=>300,//ms,移动端通用的动画切换时长,多个地方用到

//2 app
		'mobile_app_useragent'=>'__lovephpmobileapp__',//app打包时需要把这个加入到app本地的useragent中
		//同时后面要跟上版本号,比如1.0,这样服务器才能感知是否为app访问和app版本号,参见:hbuilder工程中的manifest.json

		'mobile_app_newestversion'=>
		[

			'android'=>
				[

					'versionnum'=>'1.0',//最大9999.9999.9999.9999

					'releasenote'=>'安卓版更新提示<br>修复bug,优化用户体验[error-2828]<br>修复bug,优化用户体验[error-2828]<br>修复bug,优化用户体验[error-2828]',

					'downloadurl'=>'/release/lovephp.v1.0.apk',//直接给apk下载地址

				],
			'iphone'=>
				[

					'versionnum'=>'1.0',

					'releasenote'=>'苹果版更新提示<br>修复bug,优化用户体验[error-2828]<br>修复bug,优化用户体验[error-2828]<br>修复bug,优化用户体验[error-2828]',

					'downloadurl'=>'itms-apps://itunes.apple.com/cn',//跳到appstore首页
					'downloadurl_1'=>'itms-apps://itunes.apple.com/cn/app/id414478124',//跳到自己的appstrore页面,这个id是微信的,需要替换成自己的

				],

		],

//2 alp=app land page/app落地页
		'alp_build_to_dirpath'=>'../hbuilder/lovephp_alp/lovephp_www',

		'alp_serverhost'=>'http://m.lovephp.onlinehost.lovephp.com',
		'alp_serverhost_1'=>false,//会使用当前alp打包时的host
		'alp_serverhost_2'=>'http://m.lovephp.onlinehost.lovephp.com',//直接指定host,发布时用

		'alp_preloadurls'=>
		[
			'/help/aboutus',
			'/help/terms_service',
			'/help/terms_privacy',
			'/api/alp_firststartagree',
		],

	];

}

class Dbconfig
{

	const db_connect_main=1;
	const db_connect_other=99;

	const db_connect_configmap=
	[
		self::db_connect_main=>
		[

			'db_driver_config'=>
			[

				'db_driver_type'               	=>'mysql',

				'db_driver_host'        	       	=>'127.0.0.1',

				'db_driver_port'               		=>'3306',

				'db_driver_charset'            	=>'utf8',

				'db_driver_databasename'               	=>'lovephp.lovephp',

				'db_driver_user'	               	=>'lovephp.lovephp',

				'db_driver_password'                =>'lovephp.lovephp',

			],
			'db_table_defaultconfig'=>
			[

				'db_table_prikey'=>'id',

				'db_table_signedfileds'=>false,//指定有正负数的栏位,默认数字类型的栏位会自动调整为unsigned

				'db_table_serializedfileds'=>false,//对于指定的fields用序列化存储,查询出来是可能是php标量,通常为数组

				'db_table_adjuststruct_enable'=>__online_isonline__?false:true,//是否自动调整表结构,对于数字类型的会调整成unsigned(db_table_signedfileds约定的除外)且默认值为0,varchar会调整成not null且默认值是空字符串

				'db_table_adjuststruct_maxrownum'=>1000000,//数据量太多的表不能自动调整表结构

				'db_table_triggers'=>false,//false会把数据库中原来的触发器删掉,cmd_ignore则不会同步触发器,同步触发器失败的话可能是mysql配置中的:log_bin_trust_function_creators未开启

			],

		],

		self::db_connect_other=>
		[//如果需要第二数据库的话,演示的配置是和第一数据库相同的

			'db_driver_config'=>
			[

				'db_driver_type'               	=>'mysql',

				'db_driver_host'        	       	=>'127.0.0.1',

				'db_driver_port'               		=>'3306',

				'db_driver_charset'            	=>'utf8',

				'db_driver_databasename'               	=>'lovephp.lovephp',

				'db_driver_user'	               	=>'lovephp.lovephp',

				'db_driver_password'                =>'lovephp.lovephp',

			],
			'db_table_defaultconfig'=>
			[

				'db_table_prikey'=>'id',

				'db_table_signedfileds'=>false,

				'db_table_serializedfileds'=>false,

				'db_table_adjuststruct_enable'=>__online_isonline__?false:true,

				'db_table_adjuststruct_maxrownum'=>1000000,

				'db_table_triggers'=>false,

			],

		]

	];

}

