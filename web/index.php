<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

if(0&&PHP_VERSION_ID<70000)
{
	echo '需要php7+';
	exit;
}

error_reporting(E_ALL&~E_WARNING&~E_DEPRECATED);
/*
E_ALL
E_ERROR
E_RECOVERABLE_ERROR
E_WARNING
E_PARSE
E_NOTICE
E_STRICT
E_DEPRECATED
E_CORE_ERROR
E_CORE_WARNING
E_COMPILE_ERROR
E_COMPILE_WARNING
E_USER_ERROR
E_USER_WARNING
E_USER_NOTICE
E_USER_DEPRECATED
*/

date_default_timezone_set('PRC');

define('__online_isonline__',false);//确定是开发(debug)模式还是线上(release)模式

if(__online_isonline__)
{//线上模式

	define('__error_pageshow__',false);//在页面报出错误详情

	define('__error_recordlog__',true);//记录错误详情到log

	define('__db_recordsqllog__',true);//记录查询的sql语句

	define('__codepack_cachecorephp__',false);//缓存核心php缓存文件

	define('__codepack_compress__',true);//压缩js,css代码

	define('__codepack_salt__','2830');//随便写,不和以前重复就行,主要用来防浏览器缓存的

	define('__htmltag_check__',false);//检测html tag的匹配情况,是否正常关闭标签

}
else
{//开发模式

	define('__error_pageshow__',true);

	define('__error_recordlog__',true);

	define('__db_recordsqllog__',true);

	define('__codepack_cachecorephp__',false);

	define('__codepack_compress__',false);

	define('__codepack_salt__',time());

	define('__htmltag_check__',true);

}

if(1)
{

	define('__cli_iscli__','cli'==PHP_SAPI?true:false);

	if('xmlhttprequest'==strtolower($_SERVER['HTTP_X_REQUESTED_WITH']))
	{
		define('__ajax_isajax__',true);
	}
	else
	{
		define('__ajax_isajax__',false);
	}

	if($_GET['@skel_accessmode'])
	{
		define('__skel_accessmode__',intval($_GET['@skel_accessmode']));
	}
	else
	{
		define('__skel_accessmode__',false);
	}

}

if(1)
{//1 mobile

	if(!defined('__m_access__'))
	{
		define('__m_access__',false);
	}

	if(!defined('__alp_access__'))
	{
		define('__alp_access__',false);
	}

}

//1 const
const	__lp_dir__							='./__lovephp__';

const	__prj_dir__							='./__project__';

const	__data_dir__							='./__data__';

const	__vendor_dir__						='./__vendor__';

const	__temp_dir__							='./temp';

const	__upload_dir__						='./upload';

//2 skel
const	__skel_modulecode_dir__				=__prj_dir__.'/skel/modulecode';
const	__skel_layoutdata_dir__				=__data_dir__.'/skel/layoutdata';

//2 mobile
const	__m_dir__							='./__mobile__';


if(1)
{//1 corephp

	$file_list=
	[

		__prj_dir__.'/php/prj.config.php',

		__lp_dir__.'/php/lp.core.php',
		__lp_dir__.'/php/lp.return.php',

		__lp_dir__.'/php/lp.function.php',

		__lp_dir__.'/php/lp.class.php',
		__lp_dir__.'/php/lp.filesystem.php',
		__lp_dir__.'/php/lp.time.php',
		__lp_dir__.'/php/lp.array.php',
		__lp_dir__.'/php/lp.string.php',

		__lp_dir__.'/php/lp.session.php',
		__lp_dir__.'/php/lp.cookie.php',

		__lp_dir__.'/php/lp.server.php',
		__lp_dir__.'/php/lp.client.php',

		__lp_dir__.'/php/lp.htmltag.php',
		__lp_dir__.'/php/lp.htmlecho.php',

		__lp_dir__.'/php/lp.database.php',

		__lp_dir__.'/php/lp.debug.php',

		__prj_dir__.'/php/prj.function.php',
		__prj_dir__.'/php/prj.clu.php',

	];

	if(__codepack_cachecorephp__)
	{//似乎也没啥必要,毕竟现在php的即时编译已经很好了,引用文件多了可能影响更大,没有实测

 		$to_filepath=__temp_dir__.'/codepack/lp.corephp_'.md5(serialize($file_list)).'.php';

		if(is_file($to_filepath))
		{//如果存在就不生成,不检测原始内容
		}
		else
		{
			$__loadfile=function($filepath)
			{

				$content=php_strip_whitespace($filepath);
				$content=trim($content);
				$content=substr($content,5);

				if('?>'==substr($content,-2))
				{
					$content=substr($content,0,-2);
				}
				$content=trim($content);
				return $content;
			};

			$php_code='<?php
			if(!defined(\'__online_isonline__\'))
			{
				echo \'[error-5031]\';
				exit;
			}';

			foreach($file_list as $v)
			{
				$php_code.="\n".$__loadfile($v);
				file_put_contents($to_filepath,$php_code);
			}
		}

		require $to_filepath;

	}
	else
	{

		foreach($file_list as $v)
		{
			require $v;
		}

	}

}

if(__online_isonline__&&__alp_access__)
{
	R_alert('[error-5541]不能再线上模式下使用alp打包');
}

if(1)
{//1 cookie

	if(1)
	{//如果想跨子域名共享cookie

		$host_domain=server_host_domain();

		$temp=
		[

			'lovephp.localhost.lovephp.com',
			'lovephp.lanhost.lovephp.com',
			'lovephp.onlinehost.lovephp.com',

		];

		foreach($temp as $v)
		{

			if(str_ends_with($host_domain,$v))
			{
				define('__cookie_domain__',$v);
				break;
			}

		}

	}

	if(!defined('__cookie_domain__'))
	{
		define('__cookie_domain__',false);
	}

	define('__cookie_prefix__','lpcookie');

}

if(1)
{//1 session

	define('__session_root__','__lpsession__');

	if(__cli_iscli__)
	{//命令行启动就别管session了

	}
	else if(0)
	{//如果有其他不需要启动session的情况,比如爬虫啥的访问,没必要启动session增加服务器负担

	}
	else
	{//启动session

		$sessionstatus=session_status();

		if(PHP_SESSION_DISABLED==$sessionstatus)
		{
			R_alert('[error-2823]请启用session');
		}
		else if(PHP_SESSION_NONE==$sessionstatus)
		{

			ini_set('session.name','lpcookie_sessionid');
			ini_set('session.cookie_path','/');
			ini_set('session.cookie_lifetime',0);

			if(__cookie_domain__)
			{
				ini_set('session.cookie_domain',__cookie_domain__);
			}

			if(0)
			{
				session_save_path('D:/session');
			}
			if(0)
			{
				ini_set('session.gc_probability',1);
				ini_set('session.gc_divisor',1000);
				ini_set('session.gc_maxlifetime',3600*24);
			}
			if(0)
			{
				session_set_save_handler();
			}

			if($_SERVER['HTTP_LOVEPHPSESSIONID'])
			{//因为苹果端的alp,session不能保持一致,这个动作要放在session_start之前,也就是说如果php.ini中自启动session的话,无效

				session_id($_SERVER['HTTP_LOVEPHPSESSIONID']);

			}

			session_start();

		}
		else if(PHP_SESSION_ACTIVE==$sessionstatus)
		{//如果已经自启动了session

		}
		else
		{
			R_alert('[error-2827]');
		}

	}

}

\Lovephp::start();

