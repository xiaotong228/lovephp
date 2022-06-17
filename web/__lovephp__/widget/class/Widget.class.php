<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _widget_;
class Widget
{
	static function domtail($widget,$config=false)
	{

		$tails=[];

		$tails[]='__'.$widget.'__='.$widget;

		if($config)
		{
			$tails[]=$widget.'_config=\''.json_encode_1($config).'\'';
		}

		return impd($tails,' ');

	}
//1 imgvcode
	static function imgvcode_html($cls=null,$sty=null,$tail=null)
	{

		return _img(
			'/vcode/imgvcode_imgvcode?'.math_salt(),
			$cls,
			$sty,
			'__imgvcode__=imgvcode '.$tail);

	}
	static function imgvcode_html_blank($cls=null,$sty=null,$tail=null)
	{

		return _img(
			'/assets/img/empty/empty.transparent.gif',
			$cls,
			$sty,
			'__imgvcode__=imgvcode '.$tail);

	}

//1 smsvcode
	static function smsvcode_html($action,$domset=[])
	{

		$tails=[];
		$tails[]='__smsvcode__=smsvcode';
		$tails[]='smsvcode_action='.$action;

		$H.=_div('','',impd($tails,' '));

			if(1)
			{
				$H.=_a0('','','smsvcode_role=sendbtn');
					$H.='获取验证码';
				$H.=_a_();
			}
			if(1)
			{
				$H.=_span('','','smsvcode_role=frozentime');
					$H.='..';
				$H.=_span_();
			}

		$H.=_div_();

		return $H;

	}

}
