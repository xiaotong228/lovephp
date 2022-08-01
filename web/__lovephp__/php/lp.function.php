<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


//1 php核心函数,不同的php版本可能不同
if(!function_exists('array_is_list'))
{
	function array_is_list($ary)
	{
		if(!is_array($ary))
		{
			return false;
		}

		$ary_keys=array_keys($ary);
		$ary_count=count($ary);

		$ary_keys_1=[];

		for($i=0;$i<$ary_count;$i++)
		{
			$ary_keys_1[]=$i;
		}

		return $ary_keys_1===$ary_keys;

	}

}

if(!function_exists('array_key_first'))
{
	function array_key_first($ary)
	{
		return key($ary);
	}
}

if(!function_exists('array_key_last'))
{
	function array_key_last($ary)
	{
		end($ary);
		return key($ary);
	}
}
if(!function_exists('str_starts_with'))
{
	function str_starts_with($haystack,$needle)
	{
		return ''!==(string)$needle&&strncmp($haystack,$needle,strlen($needle))===0;
	}
}
if(!function_exists('str_ends_with'))
{
	function str_ends_with($haystack,$needle)
	{
		return $needle!==''&&substr($haystack,-strlen($needle))===(string)$needle;
	}
}
if(!function_exists('str_contains'))
{
	function str_contains($haystack,$needle)
	{
		return $needle!==''&&mb_strpos($haystack,$needle)!==false;
	}
}
function json_encode_1($data)
{

	return json_encode($data,JSON_UNESCAPED_UNICODE);

}
function json_decode_1($string)
{

	return json_decode($string,true);

}
function in_array_1($a,$b)
{

	return $b&&in_array($a,$b);

}
function array_merge_1(...$args)
{

	foreach($args as &$v)
	{
		if(null===$v||false===$v/*||''===$v*/)
		{
			$v=[];
		}
	}
	unset($v);

	return array_merge(...$args);

}
function count_1($a)
{

	if(!$a)
	{
		return 0;
	}

	return count($a);

}
//1 skel页面框架输出
function _skel()
{
	\_skel_\Skelcore::echohtml_echo();
}
//1 math
function math_salt()
{
	return str_shuffle("abcdefghij").mt_rand(1,999999);
}
function math_salt_num($numDigit=6)
{
	$begin=pow(10,($numDigit-1));
	$end=pow(10,$numDigit)-1;
	return (string)mt_rand($begin,$end);
}
function math_divi($total_width,$num,$margin=0,$duo_yu_de_fenpei_dao=null)
{//结果的第0个元素的['width']值就是整个宽度里面的最大值
//$duo_yu_de_fenpei_dao可取值,margin/width
	$num=max($num,1);
	$margin=max($margin,0);
	$res=[];
	$boxwidth=floor(($total_width-($num-1)*$margin)/$num);
	for($i=0; $i<$num; $i++)
	{
		$res[]=array('width'=>$boxwidth,'margin'=>$margin);
	}
	$res[0]['margin']=0;
	$yushu=$total_width-$boxwidth*$num-($num-1)*$margin;
	if('margin'==$duo_yu_de_fenpei_dao)
	{
		$tag='margin';
		$begin=1;
	}
	else if('width'==$duo_yu_de_fenpei_dao)
	{
		$tag='width';
		$begin=0;
	}
	else
	{
		if($margin>2)
		{
			$tag='margin';
			$begin=1;
		}
		else
		{
			$tag='width';
			$begin=0;
		}
	}
	while($yushu)
	{
		for($i=$begin; $i<$num; $i++)
		{
			$res[$i][$tag]++;
			$yushu--;
			if(!$yushu)
			{
				break;
			}
		}
	}
	return $res;
}
//1 nf=number format
function nf_2($num,$digit=2)
{
	return floatval(number_format($num,$digit,'.',''));
}
function nf_int_oralstring(int $num)
{
	if($num<10000)
	{
		return $num;
	}
	else
	{
		$num=nf_2($num/10000);
		return $num.'万';
	}
}
function nf_versionnum($version)
{

	$digit=4;
	$logicnum=0;
	$version=expd($version,'.');

	for($i=0;$i<$digit;$i++)
	{
		$logicnum+=intval($version[$i])*pow(10,($digit-$i-1)*4);
	}

	return $logicnum;

}
//1 datasize
function datasize_oralstring($size)
{
	if($size<datasize_1kb)
	{
		return $size.'字节';
	}
	else if($size<datasize_1mb)
	{
		$size=$size/datasize_1kb;
		$size=nf_2($size);
		return $size.'KB';
	}
	else
	{
		$size=$size/datasize_1mb;
		$size=nf_2($size);
		return $size.'MB';
	}

}
//1 var
function var_isavailable($v)
{
	return (isset($v)&&(''!==$v))?true:false;
}
//1 expd
function expd($str=null,$sepLv0=',',$sepLv1=null,$sepLv2=null)
{//默认以逗号对字符串爆破

	if(!var_isavailable($str))
	{
		return [];
	}

	$__result=explode($sepLv0,$str);
	foreach($__result as &$v)
	{
		$v=trim($v);
	}
	unset($v);

	if(!var_isavailable(end($__result)))
	{
		array_pop($__result);
	}
	if(!is_null($sepLv1))
	{
		array_walk($__result,function(&$item) use ($sepLv1)
		{
			$item=expd($item,$sepLv1);
		});
	}
	if(!is_null($sepLv2))
	{
		array_walk_recursive($__result,function(&$item) use ($sepLv2)
		{
			$item=expd($item,$sepLv2);
		});
	}

	return $__result;

}
function impd($ary=null,$sepLv0=',',$sepLv1=null)
{

	if(!$ary)
	{
		return '';
	}

	if(!is_null($sepLv1))
	{
		array_walk($ary,function(&$item) use ($sepLv0)
		{
			$item=impd($item,$sepLv0);
		});
		$sepLv0=$sepLv1;
	}

	return implode($sepLv0,$ary);
}
//1 route
function route_judge($module_name=cmd_ignore,$controller_name=cmd_ignore,$action_name=cmd_ignore)
{

	if(
		(!$module_name||cmd_ignore===$module_name)&&
		(!$controller_name||cmd_ignore===$controller_name)&&
		(!$action_name||cmd_ignore===$action_name)
	)
	{
		R_alert('[error-1556]');
	}

	if(cmd_ignore===$module_name)
	{
		$module_name=__route_module__;
	}

	if(cmd_ignore===$controller_name)
	{
		$controller_name=__route_controller__;
	}

	if(cmd_ignore===$action_name)
	{
		$action_name=__route_action__;
	}

	return 	__route_module__==strtolower($module_name)&&
			__route_controller__==strtolower($controller_name)&&
			__route_action__==strtolower($action_name);

}
//1 curl
function curl_curl($url,$post_data=false,array $headers=[],string $useragent=null,$jsondecode=false)
{

	$ch=curl_init();

	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);

	if($headers)
	{
		curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
	}

	if($useragent)
	{
		curl_setopt($ch,CURLOPT_USERAGENT,$useragent);
	}

	if($post_data)
	{

		if(is_array($post_data))
		{
			$post_data=http_build_query($post_data);
		}

		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);

	}

	$result=curl_exec($ch);

	curl_close($ch);

	if($jsondecode)
	{
		$result=json_decode_1($result);
	}

	return $result;

}

function curl_jsondata($url,$post_data=false,array $headers=[],string $useragent=null)
{

	return curl_curl($url,$post_data,$headers,$useragent,1);

}
//1 bin
function bin_encode($data)
{
	return bin2hex(serialize($data));
}
function bin_decode($data)
{
	return unserialize(hex2bin($data));
}
//1 url
function url_build($__baseurl=null,array $__args=null,$__fakestatic=false)
{

	$__baseurl_get_func=function($action=null)
	{

		$baseurl='';

		if(\Prjconfig::route_config['route_defaultmodule']!==__route_module__)
		{
			$baseurl.='/'.__route_module__;
		}

		$baseurl.='/'.__route_controller__;

		$baseurl.='/'.($action?$action:__route_action__);

		return $baseurl;

	};

	if($__baseurl)
	{
		if(
			0===strpos($__baseurl,'/')
		)
		{
			$__baseurl=rtrim($__baseurl,'/');
		}
		else if
		(
			0===stripos($__baseurl,'http://')||
			0===stripos($__baseurl,'https://')
		)
		{


		}
		else
		{
			$action=$__baseurl;
			$__baseurl=$__baseurl_get_func($action);
		}

	}
	else
	{
		$__baseurl=$__baseurl_get_func();
	}

	if($__fakestatic)
	{
		foreach($__args as $k=>$v)
		{
			if(var_isavailable($v))
			{
				$__baseurl.='/'.$k.'/'.$v;
			}
		}

		if(\Prjconfig::html_fakestatic_ext)
		{
			$__baseurl.=\Prjconfig::html_fakestatic_ext;
		}

	}
	else
	{
		$sep='?';
		foreach($__args as $k=>$v)
		{
			$__baseurl.=$sep.$k.'='.$v;
			$sep='&';
		}
	}

	return $__baseurl;

}
function url_build_static($__baseurl=null,array $__args=null)
{
	return url_build($__baseurl,$__args,true);
}
//1 unserialize
function unserialize_safe($data)
{
	return unserialize($data);
}
//1 md5
function md5_md5()
{//参数可以是数组或者标量,参数数量可以任意
	return md5(serialize(func_get_args()));
}
function isint_isint($value)
{
	return is_numeric($value)&&false===strpos($value,'.');
}
function isfloat_isfloat($value)
{
	return is_numeric($value);
}
//1 xml
function xml_getxmlfilepath($corename=__route_action__)
{//$file:xxx或者xxx/yyy

	if(false===strpos($corename,'/'))
	{
		$corename=__route_controller__.'/'.$corename;
	}

	return __prj_dir__.'/class/controller/'.__route_module__.'/'.$corename.'.xml';

}
//1 mobile
function mpx_to_vw($mpx,$tail='vw')
{
	return (($mpx/\Prjconfig::mobile_config['mobile_page_design_px'])*100).$tail;
}

function postdata_assert($map)
{

	$imgvcode_keys=
	[
		'vcode_imgvcode'
	];

	foreach($map as $k=>$v)
	{

		$value=$_POST[$k];

		if(!$value)
		{
			R_error($k,$v.'不能为空');
		}

		if(in_array_1($k,$imgvcode_keys))
		{

			$verify=\_lp_\Vcode::vcodeverify_verify(\_lp_\Vcode::vcodetype_img,$value);

			if(true!==$verify)
			{
				R_error($k,$verify);
			}

		}

	}

}
//1 pathinfo
function path_info($filepath)
{

	$data=pathinfo($filepath);

	if('\\'==$data['dirname'])
	{
		$data['dirname']='/';
	}

	return [$data['dirname'],$data['basename'],$data['filename'],strtolower($data['extension'])];

}
function path_dir($filepath)
{
	return path_info($filepath)[0];
}
function path_filename($filepath)
{
	return path_info($filepath)[1];
}
function path_filename_core($filepath)
{
	return path_info($filepath)[2];
}
function path_ext($path)
{

	$temp=path_info($path);
	return $temp[3];

}
function path_ext_tolowercase($path)
{

	$path=expd($path,'.');

	$path_count=count($path);

	if($path_count<=1)
	{
		R_alert('[error-5217]错误的路径');
	}

	$path[$path_count-1]=strtolower($path[$path_count-1]);

	return impd($path,'.');

}
function path_ext_change($path,$ext)
{

	$path=expd($path,'.');

	$path_count=count($path);

	if($path_count<=1)
	{
		R_alert('[error-4931]错误的路径');
	}

	if(cmd_clear===$ext)
	{
		unset($path[$path_count-1]);
	}
	else
	{
		$path[$path_count-1]=$ext;
	}

	return impd($path,'.');

/*
	$path=expd($path,'.');
	$path[count($path)-1]=strtolower($path[count($path)-1]);
	return impd($path,'.');

	$info=path_info($path);

	return $info[0].'/'.$info[2].(cmd_clear===$ext?'':'.'.$ext);
*/

}
function path_isdir_ignorecase($dirpath)
{//路径的最后一层不区分大小写检测是否存在,linux下文件目录是区分大小写的

	if(is_dir($dirpath))
	{
		return true;
	}

	$pathinfo=path_info($dirpath);
	$basename=strtolower($pathinfo[1]);

	$dad_dir=dirname($dirpath);

	$list=fs_dir_list($dad_dir);
	foreach($list['dir'] as $v)
	{
		if(strtolower($v)==$basename)
		{
			return true;
		}
	}

	return false;

}
//1 dd=debug dump调试用函数
function dd($data,$return=false)
{

	if($return)
	{
		ob_start();
	}

	if(1)
	{//显示调用信息
		$temp=debug_backtrace();
		echo $temp[0]['file'].'(line:'.$temp[0]['line'].')';
	}

	require_once __vendor_dir__.'/krumo/class.krumo.php';

	\_vendor_krumo_\krumo::dump($data);

	if($return)
	{
		return ob_get_clean();
	}

}
function dd_time_ms()
{

	static $last_time=null;

	$current_time=time_ms();

	if(is_null($last_time))
	{
		$last_time=$current_time;
	}

	return nf_2($current_time-$last_time);

}
function dd_log($subdir,$message,$record_backtrace=0)
{//记录log

	$__date=date_str_num();

	$__salt=math_salt();

	$sep=str_repeat('█',160);

	$filepath=__temp_dir__.'/log/'.$subdir.'/'.$__date.'.log';

	if(is_array($message))
	{
		$message=json_encode_1($message);
	}

	$message=explode("\n",$message);//不能用expd($message,"\n");会被trim

	foreach($message as &$v)
	{
		$v="█\t".$v;
	}
	unset($v);

	$message=array_merge_1(['█'],$message,['█']);

	if($record_backtrace)
	{

		$message[]=$sep;
		$temp=debug_backtrace();
		unset($temp[0]);

		$message[]='█';
		foreach($temp as $v)
		{
			$temp=[];
			if($v['file'])
			{
				$temp[]=$v['file'].'('.$v['line'].')';
			}

			if($v['class'])
			{
				$temp[]=$v['class'].'::'.$v['function'];
			}
			else
			{
				$temp[]=$v['function'];
			}

			$message[]="█\t".impd($temp,"\t");

		}
		$message[]='█';

	}

	$message=array_merge_1([time_str().'/'.client_ip().'/'.$__salt."\t".server_url_current(1)."\t".client_useragent(),$sep],$message,[$sep]);
	$message=impd($message,"\n");

	fs_file_append($filepath,"\n\n\n\n".$message);

	return $__date.'-'.$__salt;

}
function dd_trace($key,$data)
{//记录data

	static $count=0;

	$basename=time_str_num();

	fs_file_save_data(__temp_dir__.'/trace/'.$basename.'_'.str_pad($count,6,'0',STR_PAD_LEFT).'_'.$key.'.data',$data);

	$count++;

}
