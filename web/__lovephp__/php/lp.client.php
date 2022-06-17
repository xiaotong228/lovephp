<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



function client_clientinfo()
{

	$data=[];

	$data['is_mobile']=client_is_mobile();
	$data['is_app']=client_is_app();
	$data['is_wap']=client_is_wap();
	$data['is_android']=client_is_android();
	$data['is_iphone']=client_is_iphone();

	return $data;
}
function client_is_mobile()
{

	static $cache=null;

	if(is_null($cache))
	{

		if(client_is_android()||client_is_iphone()||client_is_app())
		{
			$cache=true;
			goto sink_return;
		}

		if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
		{
			$cache=true;
			goto sink_return;
		}

		if(isset ($_SERVER['HTTP_VIA'])&&false!==stristr($_SERVER['HTTP_VIA'],'wap'))
		{
			$cache=true;
			goto sink_return;
		}

		$__useragent=strtolower(client_useragent());

		if($__useragent)
		{

			$keywords=
			[
				'nokia',
				'sony',
				'ericsson',
				'mot',
				'samsung',
				'htc',
				'sgh',
				'lg',
				'sharp',
				'sie-',
				'philips',
				'panasonic',
				'alcatel',
				'lenovo',
				'iphone',
				'ipod',
				'blackberry',
				'meizu',
				'android',
				'netfront',
				'symbian',
				'ucweb',
				'windowsce',
				'palm',
				'operamini',
				'operamobi',
				'openwave',
				'nexusone',
				'cldc',
				'midp',
				'wap',
				'mobile'
			];

			if (preg_match('/('.implode('|',$keywords).')/i',$__useragent))
			{
				$cache=true;
				goto sink_return;
			}

		}


		$__accept=strtolower($_SERVER['HTTP_ACCEPT']);

		if($__accept)
		{// 协议法，因为有可能不准确，放到最后判断
		// 如果只支持wml并且不支持html那一定是移动设备
		// 如果支持wml和html但是wml在html之前则是移动设备
			if (
				false!==strpos($__accept,'vnd.wap.wml')&&
				(
					false===strpos($__accept,'text/html')||
					strpos($__accept,'vnd.wap.wml')<strpos($__accept,'text/html')
				)
			)
			{
				$cache=true;
				goto sink_return;
			}
		}

		$cache=false;

	}

	sink_return:

	return $cache;

}
function client_is_wap()
{//是mobile且不是app时判断为wap访问
	return client_is_mobile()&&(!client_is_app());
}
function client_is_mobile_baidu()
{
	static $cache=null;

	if(is_null($cache))
	{
		$cache=(false===strpos(client_useragent(),'baiduboxapp'))?false:true;
	}

	return $cache;
}
function client_is_mobile_weixin()
{
	static $cache=null;

	if(is_null($cache))
	{
		$cache=(false===strpos(client_useragent(),'MicroMessenger'))?false:true;
	}

	return $cache;
}
function client_is_android()
{

	static $cache=null;
	if(is_null($cache))
	{
		$cache=(false===strpos(client_useragent(),'Android'))?false:true;
	}
	return $cache;

}
function client_is_iphone()
{

	static $cache=null;
	if(is_null($cache))
	{
		$cache=(false===strpos(client_useragent(),'iPhone'))?false:true;
	}
	return $cache;

}

function client_is_app()
{

	if(__alp_access__)
	{
		return true;
	}

	$r=client_app_version();

	$r=$r?true:false;

	return $r;

}
function client_app_version()
{

	static $cache=null;

	if(is_null($cache))
	{

		$matchs=[];

		preg_match('/\['.\Prjconfig::mobile_config['mobile_app_useragent'].'\/(.*?)\]/',client_useragent(),$matchs);

//		$cache=floatval($matchs[1]);
		$cache=$matchs[1];

		$cache=$cache?$cache:false;

	}

	return $cache;

}

function client_app_statusbarheight()
{

	if(0&&!__online_isonline__)
	{//test
		return 30;
	}

	static $cache=null;

	if(is_null($cache))
	{
		$matchs=[];
		preg_match('/\(Immersed\/(.*)\)/',client_useragent(),$matchs);
		$cache=nf_2($matchs[1]);
	}

	return $cache;

}
function client_ip()
{

/*根据协议判断的话,会被伪造ip,cdn转发之类的情况要考虑

	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
	    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_X_FORWARDED']))
	    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
	    $ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
	    $ipaddress = $_SERVER['REMOTE_ADDR'];
	else
	    $ipaddress = 'UNKNOWN';
	return $ipaddress;

*/

	$cdn_ip=false;

	$maybecdnforward=true;

	if($cdn_ip)
	{

		if($cdn_ip==$_SERVER['REMOTE_ADDR'])
		{//如果是cdn转发,且ip相符
			$maybecdnforward=true;
		}

		return $_SERVER['REMOTE_ADDR'];
	}

	if($maybecdnforward)
	{
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$arr=explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);

			$pos=array_search('unknown',$arr);

			if(false!==$pos)
			{
				unset($arr[$pos]);
			}

			return trim($arr[0]);
		}
		else if(isset($_SERVER['HTTP_CLIENT_IP']))
		{
			return $_SERVER['HTTP_CLIENT_IP'];
		}
		else
		{
			return $_SERVER['REMOTE_ADDR'];
		}
	}
	else
	{

		return $_SERVER['REMOTE_ADDR'];

	}

}

function client_useragent()
{
	return $_SERVER['HTTP_USER_AGENT'];
}

