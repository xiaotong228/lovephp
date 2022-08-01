<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

$____controller=false;

$____skel=false;
$____skel_module=false;//给模块内部php访问用

$____htmltag_stack=[];

$____return_assemble=0;

//1 cmd
const cmd_set					='<>cmd_set.1';
const cmd_get					='<>cmd_get.2';
const cmd_clear					='<>cmd_clear.3';
const cmd_default					='<>cmd_default.4';

const cmd_ignore					='<>cmd_ignore.5';
const cmd_sep					='<>cmd_sep.6';

//1 recursion
const cmd_recu_deleteme			='<>cmd_recu_deleteme.0';
const cmd_recu_breakrecu			='<>cmd_recu_breakrecu.1';
const cmd_recu_breakloop			='<>cmd_recu_breakloop.2';

//1 logic
const logic_and		='<>logic_and.1';
const logic_or		='<>logic_or.2';
const logic_not		='<>logic_not.3';
const logic_xor		='<>logic_xor.4';

//1 datasize
const datasize_1kb				=1024;
const datasize_1mb				=1024*1024;
const datasize_1gb				=1024*1024*1024;

//1 filesystem
const fs_loose					=0b00000001;
const fs_trim						=0b00000010;
const fs_php						=0b00000100;
const fs_unserialize				=0b00001000;
const fs_jsondecode				=0b00010000;

//1 database
const db_eq			='<>db_eq.1';		//等于
const db_neq			='<>db_neq.2';		//不等于

const db_gt			='<>db_gt.3';		//大于
const db_egt			='<>db_egt.4';		//大于等于

const db_lt			='<>db_lt.5';		//小于
const db_elt			='<>db_elt.6';		//小于等于

const db_like			='<>db_like.7';		//like
const db_notlike		='<>db_notlike.8';		//not like

const db_in			='<>db_in.9';		//in
const db_notin		='<>db_notin.10';		//not in

const db_isnull		='<>db_isnull.11';		//is null
const db_isnotnull		='<>db_isnotnull.12';		//is not null

const db_findinset		='<>db_findinset.13';		//find_in_set

const db_logic		='<>db_logic.100';		//where条件逻辑控制,and,or,xor等
const db_exp			='<>db_exp.101';		//表达式,特殊情况下使用
const db_null			='<>db_null.102';		//表示null,硬性约定

class Lovephp
{

//1 returncode
	//jscode
	const returncode_jscode=1;

	//jump
	const returncode_jump=10;

	//bool
	const returncode_bool_true=100;
	const returncode_bool_false=101;

	//ui
	const returncode_ui_alert=200;
	const returncode_ui_confirm=201;
	const returncode_ui_toast=202;
	const returncode_ui_window=203;

	//mobile
	const mobile_returncode_openpage=1000;
	const mobile_returncode_openmodal=1001;

	const returncode_keymap=
	[

		//jscode
		'returncode_jscode'=>self::returncode_jscode,

		//jump
		'returncode_jump'=>self::returncode_jump,

		//bool
		'returncode_bool_true'=>self::returncode_bool_true,
		'returncode_bool_false'=>self::returncode_bool_false,

		//ui
		'returncode_ui_alert'=>self::returncode_ui_alert,
		'returncode_ui_confirm'=>self::returncode_ui_confirm,
		'returncode_ui_toast'=>self::returncode_ui_toast,
		'returncode_ui_window'=>self::returncode_ui_window,

		//mobile
		'mobile_returncode_openpage'=>self::mobile_returncode_openpage,
		'mobile_returncode_openmodal'=>self::mobile_returncode_openmodal,

	];

	static function start()
	{

		global $____controller;

		if(1)
		{

			spl_autoload_register('\Lovephp::php_autoload');
			set_error_handler('\Lovephp::php_error_handler');
			set_exception_handler('\Lovephp::php_exception_handler');

			if(1)
			{
				register_shutdown_function('\Lovephp::php_shutdown_function');
			}

		}


		if(1)
		{//1 route

			$__route__modulename=\Prjconfig::route_config['route_defaultmodule'];
			$__route_controllername='index';
			$__route_actionname='index';

			if(1)
			{//分析path_info

				$__pathinfo=$_SERVER['PATH_INFO'];

				$__pathinfo=\Prjconfig::route_pathconvert($__pathinfo);

				$__pathinfo=explode('.',$__pathinfo);

				$__pathinfo=$__pathinfo[0];//滤掉.之后的内容

				$__pathinfo=trim($__pathinfo,'\\/');

				$__pathinfo=explode('/',$__pathinfo);

				foreach($__pathinfo as &$v)
				{
					$v=urldecode($v);
				}
				unset($v);
			}


			if(1)
			{

				if($__pathinfo[0])
				{
					if(in_array_1($__pathinfo[0],\Prjconfig::route_config['route_module_list']))
					{
						$__route__modulename=$__pathinfo[0];
						$__pathinfo=array_slice($__pathinfo,1);
					}
				}

				if($__pathinfo[0])
				{
					$__route_controllername=strtolower($__pathinfo[0]);
				}

				if($__pathinfo[1])
				{
					$__route_actionname=strtolower($__pathinfo[1]);
				}

				if(!\_lp_\Validate::is_functionname($__route_controllername)||!\_lp_\Validate::is_functionname($__route_actionname))
				{
					R_exception('[error-5319]/非法路由/'.$__route_controllername.'/'.$__route_actionname);
				}
			}

			if(1)
			{//把path_info里面的参数添加到$_GET里面
				$temp=array_slice($__pathinfo,2);
				if($temp)
				{
					$temp=array_chunk($temp,2);
					foreach($temp as $v)
					{
						if(var_isavailable($v[0])&&var_isavailable($v[1]))
						{
							$_GET[$v[0]]=$v[1];
						}
					}
				}
			}

		}

		if(1)
		{//处理从外部来的输入的get和post数据

			if($_GET)
			{
				array_walk($_GET,function(&$item)
				{
					$item=htmlentity_encode(trim($item));
				});

				if(isset($_GET['id']))
				{
					$_GET['id']=intval($_GET['id']);
				}

				if(var_isavailable($_GET['ids']))
				{
					if(!\_lp_\Validate::is_ints($_GET['ids']))
					{
						R_alert('[error-1405]'.\_lp_\Validate::lasterror_msg());
					}
				}

				if(isset($_GET['_p']))
				{//分页/当前页数,从0计数
					$_GET['_p']=intval($_GET['_p']);
				}

				if(isset($_GET['_npp']))
				{//分页/每页数量
					$_GET['_npp']=intval($_GET['_npp']);
				}

			}
			if($_POST)
			{
				array_walk_recursive($_POST,function(&$item)
				{
					$item=htmlentity_encode(trim($item));
				});
				if(isset($_POST['id']))
				{
					$_POST['id']=intval($_POST['id']);
				}
				if(var_isavailable($_POST['ids']))
				{
					if(!\_lp_\Validate::is_ints($_POST['ids']))
					{
						R_alert('[error-1417]'.\_lp_\Validate::lasterror_msg());
					}
				}
			}

		}

		if(1)
		{
			define('__route_module__',strtolower($__route__modulename));
			define('__route_controller__',strtolower($__route_controllername));
			define('__route_action__',strtolower($__route_actionname));
		}

		if(1)
		{//运行控制器
			$____controller=false;

			if(__m_access__)
			{
				$temp='\\_mobile_\\controller\\'.$__route__modulename.'\\'.ucwords($__route_controllername);
				if(class_exists($temp))
				{
					$____controller=new $temp;
				}
			}

			if(!$____controller)
			{
				$temp='\\controller\\'.$__route__modulename.'\\'.ucwords($__route_controllername);
				$____controller=new $temp;
			}


			if(method_exists($____controller,$__route_actionname))
			{

				$method=new \ReflectionMethod($____controller,$__route_actionname);

				if($method->isPublic()&&!$method->isStatic())
				{

					$params_define=$method->getParameters();

					$params_data=[];

					foreach($params_define as $v)
					{
						$name=$v->getName();

						if(isset($_GET[$name]))
						{
							$params_data[]=$_GET[$name];
						}
						else if($v->isDefaultValueAvailable())
						{
							$params_data[]=$v->getDefaultValue();
						}
						else
						{
							R_exception('error-5303/controller/action/缺失参数/'.$name,404);
						}

					}

					$method->invokeArgs($____controller,$params_data);

				}
				else
				{
					R_exception('[error-5454]/controller/action/无法调用方法/'.$__route_controllername.'/'.$__route_actionname,404);
				}
			}
			else
			{
				if(method_exists($____controller,'__call'))
				{
					$____controller->__call($__route_actionname,false);
				}
				else
				{
					R_exception('[error-5443/无法调用路由]/'.$__route_controllername.'/'.$__route_actionname,404);
				}
			}
		}

	}
	static function php_autoload($class)
	{

		static $__map=
		[

			'_lp_'=>__lp_dir__.'/class',

			'_skel_'=>__lp_dir__.'/skel/class',

			'_widget_'=>__lp_dir__.'/widget/class',

			'_mobile_'=>__m_dir__.'/class',

		];

		$filepath=false;
		foreach($__map as $k=>$v)
		{
			if(0===strpos($class,$k.'\\'))
			{
				$filepath=$v.'/'.str_replace($k.'\\','',$class).'.class.php';
				break;
			}
		}

		if(!$filepath)
		{
			$filepath=__prj_dir__.'/class/'.$class.'.class.php';
		}

		$filepath=str_replace('\\','/',$filepath);

		if(is_file($filepath))
		{
			return require_once $filepath;
		}
		else
		{
			return false;
		}

	}
	static function php_shutdown_function()
	{//捕获fatalError
		$e=error_get_last();
		if($e)
		{
			self::php_error_handler($e['type'],$e['message'],$e['file'],$e['line']);
		}
	}
	static function php_error_handler($code,$message,$file,$line,$args=false,$aaa=false,$bbb=false)
	{

		static $errorcode_namemap=
		[
			E_ERROR=>'E_ERROR',
			E_RECOVERABLE_ERROR=>'E_RECOVERABLE_ERROR',
			E_WARNING=>'E_WARNING',
			E_PARSE=>'E_PARSE',
			E_NOTICE=>'E_NOTICE',
			E_STRICT=>'E_STRICT',
			E_DEPRECATED=>'E_DEPRECATED',
			E_CORE_ERROR=>'E_CORE_ERROR',
			E_CORE_WARNING=>'E_CORE_WARNING',
			E_COMPILE_ERROR=>'E_COMPILE_ERROR',
			E_COMPILE_WARNING=>'E_COMPILE_WARNING',
			E_USER_ERROR=>'E_USER_ERROR',
			E_USER_WARNING=>'E_USER_WARNING',
			E_USER_NOTICE=>'E_USER_NOTICE',
			E_USER_DEPRECATED=>'E_USER_DEPRECATED',
			E_ALL=>'E_ALL'
		];

		static $errorcode_mustreport_list=
		[
			E_ERROR,
			E_PARSE,
			E_CORE_ERROR,
			E_COMPILE_ERROR,
			E_USER_ERROR
		];

		static $errormsg_mustreport_list=
		[

			'Undefined property:',						//如果访问了没有声明的实例属性,报错

			'Use of undefined constant',					//裸体字符串数组下标,报错

//			'Non-static method',							//类中方法如果没有加static关键字则不能static调用

//			'Illegal string offset',						//把字符串当数组用且角标不是数字时会报错

//			'Invalid argument supplied for foreach',			//非数组变量foreach
			'failed to open stream',						//读取文件失败
//			'Undefined index',							//访问了数组冲不存在的角标
			'Trying to get property',						//把数据当类去访问对象,方法之类的

			'unserialize(): Error'

		];

		if(in_array_1($code,$errorcode_mustreport_list))
		{
			goto reportError;
		}
		foreach($errormsg_mustreport_list as $v)
		{
			if(false!==strpos($message,$v))
			{
				$trace='';

				$backtrace=debug_backtrace();

				if('unserialize(): Error'==$v)
				{
					foreach($backtrace as $v)
					{
						if('unserialize_safe'==$v['function'])
						{
							break 2;
						}
					}
				}

				$sep='';
				foreach($backtrace as $kk=>$vv)
				{

					$templine='';

					$templinesep='';

					if($vv['file'])
					{
						$templine.=$vv['file'].'('.$vv['line'].')';
						$templinesep=' : ';
					}

					if($vv['function'])
					{
						$templine.=$templinesep.$vv['function'];
					}

					$trace.=$sep.'#'.$kk.' '.$templine;

					$sep='<br>';
				}
				goto reportError;
			}
		}

		return;

		reportError:

		$codeStr=$code.($errorcode_namemap[$code]?'&nbsp;['.$errorcode_namemap[$code].']&nbsp;':'');

		self::error_echohtml('Error',$codeStr,$message,$file,$line,$trace,$args);

	}
	static function php_exception_handler($e)
	{
		self::error_echohtml(get_class($e)/*Exception/Error*/,$e->getCode(),$e->getMessage(),$e->getFile(),$e->getLine(),nl2br($e->getTraceAsString()));
	}
	static function error_echohtml($pagetitle,$codeStr,$message,$file,$line,$trace=null,$args=null)
	{
		if(__cli_iscli__)
		{
			$trace=str_replace('<br />',"\n",$trace);
			echo $message;
			echo "\n".$codeStr;
			echo "\n".$file.'('.$line.')';
			echo "\n".$trace;
			exit;
		}

		$__logdna=false;

		if(__error_recordlog__)
		{
			$__logdna=dd_log('error',"{$message}\r\n{$file}({$line})");
		}

		if(!__error_pageshow__)
		{
			R_http_404(404,'未找到页面'.(0&&$__logdna/*如果想在前台爆出便于查询log的dna*/?'<br>'.$__logdna:''));
		}

		if(404==$codeStr)
		{
			$hideMessage='404:Not found';
		}
		else if(500==$codeStr)
		{
			$hideMessage='500:Server error';
		}
		else
		{
			$hideMessage='Something wrong...';
		}

		ob_end_clean();

		if(__ajax_isajax__)
		{
			$alert=_div__('','text-align:left;','',_b__('','','',nl2br($message)).'<br>'.$file.'('.$line.')'.'<br>'.$trace);
			R_alert($alert);
		}

		header('HTTP/1.1 404 Not Found');
		header('Status:404 Not Found');

		echo '<html>';

		echo '<title>'.$pagetitle.'</title>';

		echo '<body style="padding:20px 20px;margin:0;word-break:break-all;'.(0?'font-size:3vw;':'').'">';//word-break:break-all;

		echo '<div style="font-weight:bold;font-size:32px;">['.$pagetitle.']'.(nl2br($message)).'</div>';

		if(1)
		{
			echo '<div style="margin-top:30px;"><div style="font-weight:bold;">Code:&nbsp;'.$codeStr.'</div></div>';

			echo '<div style="margin-top:10px;"><div style="font-weight:bold;">Location:</div><div>'.$file.'&nbsp;&nbsp;&nbsp;&nbsp;line:'.$line.'</div></div>';

			if(isset($trace))
			{
				echo '<div style="margin-top:10px;"><div style="font-weight:bold;">Trace:</div><div>'.$trace.'</div></div>';
			}
			if(isset($args))
			{
				if(1)
				{
					echo '<div style="margin-top:10px;"><div style="font-weight:bold;">Args:</div><pre style="padding:0;margin:0;">'.var_export($args,true).'</pre></div>';
				}
				else
				{
					echo '<div style="margin-top:10px;"><div style="font-weight:bold;">Args:</div><div>'.nl2br(htmlentity_encode(var_export($args,true))).'</div></div>';
				}
			}
		}

		echo '	<div style="margin-top:10px;">
					<div><b>Lovephp</b>&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999;">'.\Prjconfig::project_config['project_slogan'].'</span></div>
				</div>';

		echo '</body>';
		echo '</html>';
		exit;

	}
}
