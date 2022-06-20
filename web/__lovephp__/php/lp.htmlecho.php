<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


//1 page
function htmlecho_page_title(string $str,$noprjname=false)
{

	static $cache='';

	if(cmd_get===$str)
	{
		return $cache;
	}
	else
	{

		if(!$noprjname)
		{
			$str.='-'.\Prjconfig::project_config['project_name'];
		}

		$cache=$str;

	}

}
function htmlecho_page_keywords(string $str)
{

	static $cache='';

	if(cmd_get===$str)
	{
		return $cache;
	}
	else
	{
		$cache=$str;
	}

}
function htmlecho_page_description(string $str)
{
	static $cache='';

	if(cmd_get===$str)
	{
		return $cache;
	}
	else
	{
		$cache=$str;
	}
}
//1 body
function htmlecho_body_tail()
{

	$tails=[];

	$tails[]='pageroute_module='.__route_module__;

	$tails[]='pageroute_controller='.__route_controller__;

	$tails[]='pageroute_action='.__route_action__;

	$tails[]='pageroute_path=\'/'.__route_module__.'/'.__route_controller__.'/'.__route_action__.'\'';

	return impd($tails,' ');

}
//1 css
function htmlecho_css_addurl($add/*string|array*/,$prepend=false)
{

	static $cache=[];

	if(cmd_get===$add)
	{
		return $cache;
	}
	else
	{
		if(!is_array($add))
		{
			$add=[$add];
		}

		if($prepend)
		{
			$cache=array_merge_1($add,$cache);
		}
		else
		{
			$cache=array_merge_1($cache,$add);
		}
	}

}

function htmlecho_css_getcode()
{

	$list=htmlecho_css_addurl(cmd_get);

	$H="\n".'<!--css_begin-->';


		foreach($list as $v)
		{

			if(0===strpos($v,'/'))
			{//本地的
				if('less'==path_ext($v))
				{
					$v=ltrim(\_lp_\Codepack::sourcecode_pack_file_to_file('.'.$v),'.');
				}

				if(__alp_access__)
				{

					$info=path_info($v);

					if('\\'==$info[0])
					{
						$count=1;
					}
					else
					{
						$count=substr_count($info[0],'/');
					}
					if(0==$count)
					{
						R_exception('[error-0313]分析链接出错:'.$v);
					}
					elseif(1==$count)
					{
						$__res_predir='./';
					}
					else
					{
						$__res_predir=str_repeat('../',$count);
					}

					$__content=fs_file_read('.'.$v);

					$__matchs=[];

					$__local_files=[];
					$__remove_files=[];

					if(1)
					{

						$__content=preg_replace_callback('/\/(assets\/.+\.(svg|png|jpg|jpeg|gif))/U',

						function($matches) use (&$__local_files,$__res_predir)
						{

							$__local_files[]=$matches[1];
							return $__res_predir.$matches[1];

						},$__content);

						$__local_files=array_unique($__local_files);

						foreach($__local_files as $vv)
						{
							if(is_file($vv))
							{
								fs_file_copy('./'.$vv,\Prjconfig::mobile_config['alp_build_to_dirpath'].'/'.$vv);
							}
							else
							{
								R_exception('[error-2023]未找到文件:'.$vv);
							}
						}
					}

					if(1)
					{

						$__content=preg_replace_callback('/(https?:)?\/\/(at\.alicdn\.com\/.+\.(woff2|woff|ttf))/U',

						function($matches) use (&$__remove_files,$__res_predir)
						{

							$__remove_files[]=$matches[2];
							return $__res_predir.$matches[2];

						},$__content);

						$__remove_files=array_unique($__remove_files);

						foreach($__remove_files as $vv)
						{

							$url='http://'.$vv;
							$temp=curl_curl($url);

							if(!$temp)
							{
								R_exception('[error-2140]下载文件出错:'.$url);
							}

							fs_file_save(\Prjconfig::mobile_config['alp_build_to_dirpath'].'/'.$vv,$temp);
						}
					}

					fs_file_save(\Prjconfig::mobile_config['alp_build_to_dirpath'].$v,$__content);

					$v='.'.$v;

				}
				else
				{
					$v.='?'.(__online_isonline__?__codepack_salt__:time());
				}

			}

			$H.="\n".'<link rel=stylesheet href=\''.$v.'\' />';

		}

	$H.="\n".'<!--css_end-->';

	return $H;

}

//1 js
function htmlecho_js_addurl($add/*string|array*/,$prepend=false)
{
	static $cache=[];

	if(cmd_get===$add)
	{
		return $cache;
	}
	else
	{
		if(!is_array($add))
		{
			$add=[$add];
		}

		if($prepend)
		{
			$cache=array_merge_1($add,$cache);
		}
		else
		{
			$cache=array_merge_1($cache,$add);
		}
	}
}
function htmlecho_js_addvar($key,$value=null)
{
	static $cache=[];
	if(cmd_get===$key)
	{
		return $cache;
	}
	else
	{
		$cache[$key]=$value;
	}
}
function htmlecho_js_getcode()
{

	$jsvar_base=[];

	$jsvar_base['__online_isonline__']=__online_isonline__;

	$jsvar_base['route_routeinfo']=
	[
		'module'=>__route_module__,

		'controller'=>__route_controller__,

		'action'=>__route_action__,

		'module_defaultmodule'=>\Prjconfig::route_config['route_defaultmodule'],

		'module_rooturl'=>(\Prjconfig::route_config['route_defaultmodule']===__route_module__?'':'/'.__route_module__),

		'controller_rooturl'=>(\Prjconfig::route_config['route_defaultmodule']===__route_module__?'':'/'.__route_module__).'/'.__route_controller__

	];

	$jsvar_base['client_clientinfo']=client_clientinfo();

	$jsvar_base['sever_currenttime']=time();

	$jsvar_final=array_merge_1($jsvar_base,htmlecho_js_addvar(cmd_get));

	$list=htmlecho_js_addurl(cmd_get);

	$H="\n".'<!--js_begin-->';

	$H.="\n".'<script>';

		$H.="\n".'__lpvar__='.json_encode_1($jsvar_final);

		$H.="\n".'</script>';
		foreach($list as $v)
		{

			if(0===strpos($v,'/'))
			{//本地的

				if('jsraw'==path_ext($v))
				{
					$v=ltrim(\_lp_\Codepack::sourcecode_pack_file_to_file('.'.$v),'.');
				}

				if(__alp_access__)
				{
					$to_filepath=\Prjconfig::mobile_config['alp_build_to_dirpath'].$v;
					$v='.'.$v;
					fs_file_copy($v,\Prjconfig::mobile_config['alp_build_to_dirpath'].$v);
				}
				else
				{
					$v.='?'.(__online_isonline__?__codepack_salt__:time());
				}

			}

			$H.="\n".'<script src=\''.$v.'\'></script>';

		}

	$H.="\n".'<!--js_end-->';

	return $H;
}


//1 sink
function htmlecho_fire($H=null)
{

	if(__htmltag_check__)
	{
		htmltag_check();
	}

	$css_urls=[];

	$js_urls=
	[
		\Prjconfig::html_jqueryurl,
		'/assets/pc.core.jsraw'
	];

	if('foreground'==__route_module__)
	{
		$css_urls[]='/assets/pc.core.less';
	}
	else if('admin'==__route_module__)
	{
		$css_urls[]='/assets/pc.core.less';
		$css_urls[]='/assets/_admin/admin.core.less';

		$js_urls[]='/assets/_admin/admin.core.jsraw';
	}
	else if('skel'==__route_module__)
	{
		if('layoutedit'==__route_controller__)
		{

			$css_urls[]='/assets/_skel/skel.layoutedit.less';

			$js_urls[]='/assets/_skel/skel.layoutedit.jsraw';
			$js_urls[]='/assets/_skel/skel.layoutedit.drag.jsraw';

		}
		else
		{
			$css_urls[]='/assets/pc.core.less';
			$css_urls[]='/assets/_admin/admin.core.less';

			$js_urls[]='/assets/_admin/admin.core.jsraw';

		}

	}
	else if('cloud'==__route_module__)
	{

	}
	else
	{

	}

	htmlecho_css_addurl($css_urls,true);
	htmlecho_js_addurl($js_urls,true);

	$css_code=htmlecho_css_getcode();
	$js_code=htmlecho_js_getcode();

	echo '<!DOCTYPE html>';
	echo '<html>';

		echo '<head>';

			echo '<meta charset="utf-8" />';

			echo '<meta name=renderer  content=webkit />';

			echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />';

			echo '<meta name=keywords content="'.htmlecho_page_keywords(cmd_get).'" />';

			echo '<meta name=description content="'.htmlecho_page_description(cmd_get).'" />';

			echo '<link rel=icon href="/favicon.ico" />';

			echo '<title>'.htmlecho_page_title(cmd_get).'</title>';

			echo $css_code;

		echo '</head>';
		echo '<body __skelroot__=skelroot '.htmlecho_body_tail().' >';

			echo $H;
			echo $js_code;

			if(__online_isonline__&&'foreground'==__route_module__)
			{//百度统计
				echo
					'
						<script>
						var _hmt = _hmt || [];
						(function() {
						  var hm = document.createElement("script");
						  hm.src = "https://hm.baidu.com/hm.js?f0b487f912e6846c19672a813df1ba5f";
						  var s = document.getElementsByTagName("script")[0]; 
						  s.parentNode.insertBefore(hm, s);
						})();
						</script>

					';
			}

		echo '</body>';

	echo '</html>';

	exit;

}

//1 htmlentity
function htmlentity_encode($__str,$__doubleencode=false)
{

//$test='~!@#$%^&*()_+{}|:"<>?`[]\;\',./';
//return htmlspecialchars($data,ENT_QUOTES|ENT_HTML5,'UTF-8');

	static $__map=null;

	if(is_null($__map))
	{
		$__map=
		[

			chr(0x00)=>				'',
			chr(0x01)=>				'',
			chr(0x02)=>				'',
			chr(0x03)=>				'',
			chr(0x04)=>				'',
			chr(0x05)=>				'',
			chr(0x06)=>				'',
			chr(0x07)=>				'',
			chr(0x08)=>				'',
			chr(0x09)=>				' ',//tab转换成空格
			//chr(0x0a)=>				'',//换行
			chr(0x0b)=>				'',
			chr(0x0c)=>				'',
			chr(0x0d)=>				'',//回车
			chr(0x0e)=>				'',
			chr(0x0f)=>				'',


			chr(0x10)=>				'',
			chr(0x11)=>				'',
			chr(0x12)=>				'',
			chr(0x13)=>				'',
			chr(0x14)=>				'',
			chr(0x15)=>				'',
			chr(0x16)=>				'',
			chr(0x17)=>				'',
			chr(0x18)=>				'',
			chr(0x19)=>				'',
			chr(0x1a)=>				'',
			chr(0x1b)=>				'',
			chr(0x1c)=>				'',
			chr(0x1d)=>				'',
			chr(0x1e)=>				'',
			chr(0x1f)=>				'',


			//	/*0x20*/				' '				=>					'&#x20;',
				/*0x21*/				'!'				=>					'&#x21;',
				/*0x22*/				'"'				=>					'&quot;',//'&#x22;',
			//	/*0x23*/				'#'				=>					'&#x23;',
				/*0x24*/				'$'				=>					'&#x24;',
				/*0x25*/				'%'				=>					'&#x25;',
				/*0x26*/				'&'				=>					'&amp;',//'&#x26;',
				/*0x27*/				'\''				=>					'&apos;',//'&#x27;',
				/*0x28*/				'('				=>					'&#x28;',
				/*0x29*/				')'				=>					'&#x29;',
				/*0x2a*/				'*'				=>					'&#x2a;',
			//	/*0x2b*/				'+'				=>					'&#x2b;',
			//	/*0x2c*/				','				=>					'&#x2c;',
			//	/*0x2d*/				'-'				=>					'&#x2d;',
			//	/*0x2e*/				'.'				=>					'&#x2e;',
			//	/*0x2f*/				'/'				=>					'&#x2f;',


			//	/*0x30*/				'0'				=>					'&#x30;',
			//	/*0x31*/				'1'				=>					'&#x31;',
			//	/*0x32*/				'2'				=>					'&#x32;',
			//	/*0x33*/				'3'				=>					'&#x33;',
			//	/*0x34*/				'4'				=>					'&#x34;',
			//	/*0x35*/				'5'				=>					'&#x35;',
			//	/*0x36*/				'6'				=>					'&#x36;',
			//	/*0x37*/				'7'				=>					'&#x37;',
			//	/*0x38*/				'8'				=>					'&#x38;',
			//	/*0x39*/				'9'				=>					'&#x39;',
			//	/*0x3a*/				':'				=>					'&#x3a;',
				/*0x3b*/				';'				=>					'&#x3b;',
				/*0x3c*/				'<'				=>					'&lt;',//'&#x3c;',
				/*0x3d*/				'='				=>					'&#x3d;',
				/*0x3e*/				'>'				=>					'&gt;',//'&#x3e;',
				/*0x3f*/				'?'				=>					'&#x3f;',


			//	/*0x40*/				'@'				=>					'&#x40;',
			//	/*0x41*/				'A'				=>					'&#x41;',
			//	/*0x42*/				'B'				=>					'&#x42;',
			//	/*0x43*/				'C'				=>					'&#x43;',
			//	/*0x44*/				'D'				=>					'&#x44;',
			//	/*0x45*/				'E'				=>					'&#x45;',
			//	/*0x46*/				'F'				=>					'&#x46;',
			//	/*0x47*/				'G'				=>					'&#x47;',
			//	/*0x48*/				'H'				=>					'&#x48;',
			//	/*0x49*/				'I'				=>					'&#x49;',
			//	/*0x4a*/				'J'				=>					'&#x4a;',
			//	/*0x4b*/				'K'				=>					'&#x4b;',
			//	/*0x4c*/				'L'				=>					'&#x4c;',
			//	/*0x4d*/				'M'				=>					'&#x4d;',
			//	/*0x4e*/				'N'				=>					'&#x4e;',
			//	/*0x4f*/				'O'				=>					'&#x4f;',


			//	/*0x50*/				'P'				=>					'&#x50;',
			//	/*0x51*/				'Q'				=>					'&#x51;',
			//	/*0x52*/				'R'				=>					'&#x52;',
			//	/*0x53*/				'S'				=>					'&#x53;',
			//	/*0x54*/				'T'				=>					'&#x54;',
			//	/*0x55*/				'U'				=>					'&#x55;',
			//	/*0x56*/				'V'				=>					'&#x56;',
			//	/*0x57*/				'W'				=>					'&#x57;',
			//	/*0x58*/				'X'				=>					'&#x58;',
			//	/*0x59*/				'Y'				=>					'&#x59;',
			//	/*0x5a*/				'Z'				=>					'&#x5a;',
			//	/*0x5b*/				'['				=>					'&#x5b;',
				/*0x5c*/				'\\'				=>					'&#x5c;',
			//	/*0x5d*/				']'				=>					'&#x5d;',
				/*0x5e*/				'^'				=>					'&#x5e;',
			//	/*0x5f*/				'_'				=>					'&#x5f;',


				/*0x60*/				'`'				=>					'&#x60;',
			//	/*0x61*/				'a'				=>					'&#x61;',
			//	/*0x62*/				'b'				=>					'&#x62;',
			//	/*0x63*/				'c'				=>					'&#x63;',
			//	/*0x64*/				'd'				=>					'&#x64;',
			//	/*0x65*/				'e'				=>					'&#x65;',
			//	/*0x66*/				'f'				=>					'&#x66;',
			//	/*0x67*/				'g'				=>					'&#x67;',
			//	/*0x68*/				'h'				=>					'&#x68;',
			//	/*0x69*/				'i'				=>					'&#x69;',
			//	/*0x6a*/				'j'				=>					'&#x6a;',
			//	/*0x6b*/				'k'				=>					'&#x6b;',
			//	/*0x6c*/				'l'				=>					'&#x6c;',
			//	/*0x6d*/				'm'				=>					'&#x6d;',
			//	/*0x6e*/				'n'				=>					'&#x6e;',
			//	/*0x6f*/				'o'				=>					'&#x6f;',


			//	/*0x70*/				'p'				=>					'&#x70;',
			//	/*0x71*/				'q'				=>					'&#x71;',
			//	/*0x72*/				'r'				=>					'&#x72;',
			//	/*0x73*/				's'				=>					'&#x73;',
			//	/*0x74*/				't'				=>					'&#x74;',
			//	/*0x75*/				'u'				=>					'&#x75;',
			//	/*0x76*/				'v'				=>					'&#x76;',
			//	/*0x77*/				'w'				=>					'&#x77;',
			//	/*0x78*/				'x'				=>					'&#x78;',
			//	/*0x79*/				'y'				=>					'&#x79;',
			//	/*0x7a*/				'z'				=>					'&#x7a;',
				/*0x7b*/				'{'				=>					'&#x7b;',
			//	/*0x7c*/				'|'				=>					'&#x7c;',
				/*0x7d*/				'}'				=>					'&#x7d;',
			//	/*0x7e*/				'~'				=>					'&#x7e;',//波浪线不能被html_entity_decode反解析,2022年2月7日13:49:30
				/*0x7f*/				chr(0x7f)		=>					'',//[del]删除

		];

	}

	if(!$__doubleencode)
	{
		$__str=htmlentity_decode($__str);
	}

	return strtr($__str,$__map);
}
function htmlentity_decode($__str)
{

	return html_entity_decode($__str,ENT_QUOTES|ENT_HTML5,'UTF-8');

}

