<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/
function R_assemble($func)
{

	if(0)
	{//演示,用于同时向前端发送多个指令
		$temp=1;
		R_assemble(function() use ($temp)
		{
			R_alert($temp);
			R_toast('222');
			R_jscode('console_log(\'39\',\'lovephp/0609/5739\');');
		});
	}

	global $____return_assemble;

	$____return_assemble=1;

	$func();

	R_sink();

}
function R_sink($data=null)
{

	global $____return_assemble;

	static $assemble_data=[];

	$echo_data=[];

	if(is_null($data))
	{
		$echo_data=$assemble_data;
		goto sink_return;
	}
	else
	{

		$new_data=[];

		foreach($data as $k=>$v)
		{
			$new_data['@'.$k]=$v;
		}

		if($____return_assemble)
		{
			$assemble_data=array_merge_1($assemble_data,$new_data);
			return;
		}
		else
		{
			$echo_data=$new_data;
		}
	}

	sink_return:

	if(!ob_get_length())
	{
		header('Content-Type:application/json;charset=utf-8');
	}

	echo json_encode_1($echo_data);

	exit;

}
function R_origdata($data)
{//直接返回json数据,没有cmd指令码

	if(!ob_get_length())
	{
		header('Content-Type:application/json;charset=utf-8');
	}

	echo json_encode_1($data);

	exit;
}
//1 exception
function R_exception($msg,$code=0)
{
	throw new \Exception($msg,$code);
}
//1 jump
function R_jump($url=false,$msg=false)
{
	if(__ajax_isajax__)
	{

		$data=
		[
			\Lovephp::returncode_jump=>
			[
				'jump_url'=>$url,
				'jump_message'=>$msg,
			]
		];

		R_sink($data);

	}
	else
	{

		if(!$url)
		{
			$url='/';
		}

		if($msg)
		{
			R_http_404(404,$msg,$url);
		}
		else
		{
			if(headers_sent())
			{
				echo '<meta http-equiv=Refresh content=\'0;URL='.$url.'\'>';
			}
			else
			{
				header('Location:'.$url);
			}
			exit;
		}
	

	}

}
function R_jump_module($url=false,$msg=false)
{//考虑__route_module__的jump

	if('/'===$url)
	{
		$url='';
	}

	$url='/'.__route_module__.$url;

	return R_jump($url,$msg);
}
//1 ui
function R_alert($msg,$func=false)
{

	$data=
	[
		\Lovephp::returncode_ui_alert=>
		[
			'alert_message'=>$msg,
			'alert_func'=>$func,
		]
	];

	R_sink($data);

}
function R_toast($msg)
{

	$data=
	[
		\Lovephp::returncode_ui_toast=>
		[
			'toast_message'=>$msg,
		]
	];

	R_sink($data);

}
function R_confirm($msg,$func)
{

	$data=
	[
		\Lovephp::returncode_ui_confirm=>
		[
			'confirm_message'=>$msg,
			'confirm_func'=>$func,
		]
	];

	R_sink($data);

}
//1 true&false
function R_true($data=true)
{

	$data=
	[
		\Lovephp::returncode_bool_true=>$data
	];

	R_sink($data);

}
function R_false($data=false)
{

	$data=
	[
		\Lovephp::returncode_bool_false=>$data
	];

	R_sink($data);

}
function R_error($key=false,$message)
{
	if($_POST['@ajaxform_submit']&&$key)
	{
		\_widget_\Ajaxform::jswidget_ajaxform_returnerror($key,$message);
	}
	else
	{
		R_alert($message);
	}
}
//1 code
function R_jscode($code)
{

	$data=
	[
		\Lovephp::returncode_jscode=>
		[
			'jscode_jscode'=>$code,
		]
	];

	R_sink($data);

}
//1 R_http
function R_http_404($code=404,$message=null,$backurl='/')
{

	if(!$message)
	{
		if(403==$code)
		{
			$message='禁止访问';
		}
		else if(404==$code)
		{
			$message='无此页面';
		}
		else
		{
			$message=$code;
		}
	}


	if(__ajax_isajax__)
	{
		R_alert($code.'/'.$message);
	}

	http_response_code($code);

	if(__m_access__)
	{
		$css_url=ltrim(__m_dir__,'.').'/assets/mobile.core.less';
	}
	else
	{
		$css_url='/assets/pc.core.less';
	}

	htmlecho_css_addurl($css_url,true);

	$css_code=htmlecho_css_getcode();

        echo '<!DOCTYPE html>';

	echo '<html>';

		echo '<head>';
			echo '<meta charset="utf-8">';
			echo '<link rel="icon" href="/favicon.ico">';
			echo '<title>'.$message.'-'.\Prjconfig::project_config['project_name'].'</title>';
			echo $css_code;
		echo '</head>';
		echo '<body httpcode_404>';

			echo _div('logoz');echo _div_();
			echo _div__('messagez','','',$message);

			echo _a($backurl,'','','__button__="medium black solid w200" ');
				echo '返回';
			echo _a_();

		echo '</body>';

	echo '</html>';

	exit;

}

//1 window
function R_window($inhtml,array $domset=[])
{

	if(__htmltag_check__)
	{
		htmltag_check();
	}

	if(__m_access__)
	{
		R_alert('[error-1037]不能mobile调用');
	}

	$data=[];

	$data[\Lovephp::returncode_ui_window]=
		[
			'window_inhtml'=>$inhtml,
			'window_cls'=>$domset['cls'],
			'window_sty'=>$domset['sty'],
			'window_tail'=>$domset['tail'],
		];

	R_sink($data);

}

function R_window_xml($__xmlfile,$__submiturl/*url|js_function_name(string)*/,$__data=false,$title_tail=false)
{

	$H='';

	$inner_html=\_lp_\Xmlparser::xmlwindow_inhtml_get($__xmlfile,$title_xml,$__data);

	if(!$title_xml)
	{
		$title_xml='__无标题__';
	}

	if(1)
	{

		$title=[];
		if($title_xml)
		{
			$title[]=$title_xml;
		}

		if($title_tail)
		{
			$title[]=$title_tail;
		}

		$title=impd($title,'/');

		$H.=_div('','','xmlwindow=head movebox_role=dragbox_wreckage');//没有打开可拖动功能,打开之后没法复制xml文件路径了

			if($title)
			{
				$H.=_b__('','','',$title);
			}
			$H.=_span__('','','',$__xmlfile);
			$H.=_a0__('','','xmlwindow_role=save');
			$H.=_a0__('','','uiwindow_role=close');
		$H.=_div_();
	}

	if(1)
	{

		$H.=_form('','','onsubmit="$(this).closest(\'[__xmlwindow__=xmlwindow]\').find(\'[xmlwindow_role=save]\').click();return false;"');
			$H.=_div('','','xmlwindow_role=body __tabshow__=tabshow');
				$H.=$inner_html;
			$H.=_div_();
		$H.=_form_();

	}

	$domset=[];
	$domset['tail']='__xmlwindow__=xmlwindow __drag__=drag_wreckage xmlwindow_submiturl="'.$__submiturl.'" ';

	R_window($H,$domset);

}
//1 needlogin
function R_needlogin($continue=false)
{

	if(__m_access__)
	{

		$jscode='mobile_page_open(\'/connect/login\');';

		R_jscode($jscode);

	}
	else
	{

		if(!$continue)
		{
			if(__ajax_isajax__)
			{
				$continue=server_url_referer();
			}
			else
			{
				$continue=server_url_current();
			}
		}

		$continue=urlencode($continue);

		R_jump('/connect/login?_continue='.urlencode($continue));

	}

}

function R_echofile($filepath,$filename=false)
{

	$file_size=filesize($filepath);

	if(false===$file_size)
	{
		R_alert('[error-2510]输出文件不存在或不能读取');
	}
	if($file_size>\Prjconfig::file_echofile_maxsize)
	{
		R_alert('[error-2542]输出文件不能超过'.datasize_oralstring(\Prjconfig::file_echofile_maxsize));
	}

	$info=path_info($filepath);

	if($filename)
	{
		$filename=htmlentity_decode($filename);
	}
	else
	{
		$filename=$info[1];
	}

	$filename=addslashes($filename);

	$data=fs_file_read($filepath);

	header('content-type:application/'.$info[3]);
	header('Content-Disposition:attachment; filename="'.$filename.'"');

	echo $data;

	exit;

}