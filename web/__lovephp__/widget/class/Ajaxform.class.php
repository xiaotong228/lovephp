<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _widget_;
class Ajaxform
{

	static function jswidget_ajaxform_begin($url=null,array $config=[],array $postdata=[]/*,array $postdata=[],$cls=null,$sty=null,$tail=null*/)
	{

		$tails=[];

		$tails[]='__ajaxform__=ajaxform';

		if($config)
		{
			$tails[]='ajaxform_config=\''.json_encode_1($config).'\'';
		}

		if($postdata)
		{
			$tails[]='ajaxform_appenddata=\''.json_encode_1($postdata).'\'';
		}

		if($tail)
		{
			$tails[]=$tail;
		}

		return _form($url,'post',impd($tails,' '));

	}

	static function jswidget_ajaxform_end()
	{

		return _form_();

	}
	static function jswidget_ajaxform_returnerror($key,$errormsg,$url=false)
	{
		$data=[];

		$data['ajaxform_error_key']=$key;
		$data['ajaxform_error_msg']=$errormsg;

		R_false($data);

	}

}
