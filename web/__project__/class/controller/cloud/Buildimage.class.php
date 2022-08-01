<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

namespace controller\cloud;

class Buildimage extends \controller\foreground\super\Superforeground
{//不用后台权限,用于根据参数生成对应的图片
	const buildarg_width_map=
	[//限定自动生成的图片宽度,高度,旋转角度

		100,
		200,
		400,
		800

	];
	const buildarg_height_map=
	[

		100,
		200,
		400,
		800

	];
	const buildarg_rotate_map=
	[

		90,
		180,
		270,

	];
//1 buildimage
	function buildimage($imageurl)
	{

		$__url=$imageurl;
		$__ext=path_ext($__url);

		if(0!==strpos($__url,ltrim(__upload_dir__,'.').'/'))
		{//限制路径只允许上传的图片,也可以不限制
			R_exception('[error-0235]不支持的路径');
		}

		if(in_array($__ext,\Prjconfig::file_pic_exts))
		{

			$__buildarg_info=self::buildarg_getinfo($__url);

			$__arg=$__buildarg_info['url_arg'];
			$__from_filepath='.'.$__buildarg_info['url_orig'];
			$__to_filepath='.'.$__url;

			foreach($__arg as $k=>$v)
			{
				if($v)
				{
					if(
						('w'==$k&&!in_array($v,self::buildarg_width_map))||
						('h'==$k&&!in_array($v,self::buildarg_height_map))||
						('r'==$k&&!in_array($v,self::buildarg_rotate_map))
					)
					{
						R_exception('[error-0624]参数错误');
					}
				}
				else
				{

				}
			}

			if(1)
			{//获取原图尺寸
				$temp=getimagesize($__from_filepath);

				if(!$temp)
				{
					R_exception('[error-1145]读取文件错误');
				}
				$__image_width=$temp[0];
				$__image_height=$temp[1];
			}

			$__to_width=0;
			$__to_height=0;
			$__to_rotate=0;

			if($__arg['w']||$__arg['h'])
			{
				if(
					$__arg['w']>=$__image_width||
					$__arg['h']>=$__image_height
				)
				{//宽或高大于等于原始尺寸的话,不强行放大,直接使用原图(如不需要旋转)

				}
				else
				{
					if($__arg['w']&&$__arg['h'])
					{//保持比例,不强行更改宽高

						if(
							($__image_width/$__image_height)>
							($__arg['w']/$__arg['h'])
						)
						{//原图较宽取高,原图较高取宽,就是尽量生成大一点的图片
							unset($__arg['w']);
						}
						else
						{
							unset($__arg['h']);
						}

					}
					if($__arg['w']&&!$__arg['h'])
					{
						$__to_width=$__arg['w'];
						$__to_height=max(round($__arg['w']*$__image_height/$__image_width),1);
					}
					else if(!$__arg['w']&&$__arg['h'])
					{
						$__to_width=max(round($__arg['h']*$__image_width/$__image_height),1);
						$__to_height=$__arg['h'];
					}
					else
					{
						R_exception('[error-1708]参数错误');
					}
				}
			}

			if($__arg['r'])
			{//本来是逆时针转的,改成顺时针转
				$__to_rotate=360-$__arg['r'];
			}

			if(
				$__to_width||
				$__to_height||
				$__to_rotate
			)
			{//如果有任意有效参数,进行处理

				if('jpg'==$__ext||'jpeg'==$__ext)
				{
					self::fs_buildimage_jpg($__from_filepath,$__to_filepath,$__to_width,$__to_height,$__to_rotate);
				}
				else if('png'==$__ext)
				{
					self::fs_buildimage_png($__from_filepath,$__to_filepath,$__to_width,$__to_height,$__to_rotate);
				}
				else if('gif'==$__ext)
				{
					self::fs_buildimage_gif($__from_filepath,$__to_filepath,$__to_width,$__to_height,$__to_rotate);
				}
				else
				{
					R_exception('[error-3048]不支持的扩展名');
				}
			}
			else
			{//直接复制一份
				fs_file_copy($__from_filepath,$__to_filepath);
			}

			R_jump($__url);

		}
		else
		{
			R_exception('[error-2734]不支持的扩展名:'.$__ext);
		}

	}
//1 buildarg
	static function buildarg_getinfo($__url)
	{

		$__url_info=path_info($__url);

		$filename_core=$__url_info[2];

		$__result=[];

		$filename_core_orig=preg_replace('/\[(.*)\]/','',$filename_core);//清除掉所有[]包含的内容

		$matches=[];
		preg_match_all("/\[(w|h|r)(\d+)\]/",$filename_core,$matches);

		$__arg=
		[
			'w'=>0,
			'h'=>0,
			'r'=>0
		];
		foreach($matches[1] as $k=>$v)
		{
			$__arg[$v]=intval($matches[2][$k]);
		}

		if(1)
		{//只允许特定写法,w,h,r依次写
			$filename_core_1=$filename_core_orig;
			foreach($__arg as $k=>$v)
			{
				if($v)
				{
					$filename_core_1.='['.$k.$v.']';
				}

			}
			if($filename_core!=$filename_core_1)
			{
				R_exception('[error-4934]参数组装错误');
			}
		}

		if(
			'/'==$__url_info[0]
		)
		{
			$__result['url_orig']='/';
		}
		else
		{
			$__result['url_orig']=$__url_info[0].'/';
		}
		$__result['url_orig'].=$filename_core_orig.'.'.$__url_info[3];
		$__result['url_arg']=$__arg;

		return $__result;

	}

	static function buildarg_setarg($url,$width,$height,$rotate)
	{
		$arg_str='';

		if($width)
		{
			$arg_str.='[w'.$width.']';
		}

		if($height)
		{
			$arg_str.='[h'.$height.']';
		}
		if($rotate)
		{
			$arg_str.='[r'.$rotate.']';
		}

		$ext=path_ext($url);

		$url=preg_replace('/\.'.$ext.'$/',$arg_str.'.'.$ext,$url);

		return $url;

	}
//1 fs,文件系统
	static function fs_buildimage_jpg($from_filepath,$to_filepath,$to_width,$to_height,$to_rotate)
	{
		if($to_width&&$to_height)
		{//2 宽高均指定或均不指定才可以

			$from_image_width=0;
			$from_image_height=0;

			list($from_image_width,$from_image_height)=getimagesize($from_filepath);

			$from_image=imagecreatefromjpeg($from_filepath);

			$__image=imagecreatetruecolor($to_width,$to_height);

			imagecopyresampled($__image,$from_image,0,0,0,0,$to_width,$to_height,$from_image_width,$from_image_height);

		}
		else if(!$to_width&&!$to_width)
		{
			$__image=imagecreatefromjpeg($from_filepath);
		}
		else
		{
			R_exception('[error-5339]');
		}
		if($to_rotate)
		{
			$__image=imagerotate($__image,$to_rotate,0);
		}
		imagejpeg($__image,$to_filepath,100);
	}
	static function fs_buildimage_png($from_filepath,$to_filepath,$to_width,$to_height,$to_rotate)
	{
		if($to_width&&$to_height)
		{//2 宽高均指定或均不指定才可以

			$from_image_width=0;
			$from_image_height=0;

			list($from_image_width,$from_image_height)=getimagesize($from_filepath);

			$from_image=imagecreatefrompng($from_filepath);

			$__image=imagecreatetruecolor($to_width,$to_height);

			imagealphablending($__image,false);

			imagesavealpha($__image,true);

			imagecopyresampled($__image,$from_image,0,0,0,0,$to_width,$to_height,$from_image_width,$from_image_height);
		}
		else if(!$to_width&&!$to_height)
		{
			$__image=imagecreatefrompng($from_filepath);

			imagealphablending($__image,false);
			imagesavealpha($__image,true);
		}
		else
		{
			R_exception('[error-5331]');
		}
		if($to_rotate)
		{
			$__image=imagerotate($__image,$to_rotate,0);
			imagealphablending($__image,false);
			imagesavealpha($__image,true);
		}
		imagepng($__image,$to_filepath);
	}
	static function fs_buildimage_gif($from_filepath,$to_filepath,$to_width,$to_height,$to_rotate)
	{
		if($to_width&&$to_height)
		{//2 宽高均指定或均不指定才可以

			$from_image_width=0;
			$from_image_height=0;

			list($from_image_width,$from_image_height)=getimagesize($from_filepath);

			$from_image=imagecreatefromgif($from_filepath);

			$__image=imagecreatetruecolor($to_width,$to_height);

			$color=imagecolorallocate($__image,255,255,255);

			imagecolortransparent($__image,$color);

			imagefill($__image,0,0,$color);

			imagecopyresampled($__image,$from_image,0,0,0,0,$to_width,$to_height,$from_image_width,$from_image_height);

		}
		else if(!$to_width&&!$to_height)
		{
			$__image=imagecreatefromgif($from_filepath);
		}
		else
		{
			R_exception('[error-5348]');
		}

		if($to_rotate)
		{
			$__image=imagerotate($__image,$to_rotate,0);
		}

		imagegif($__image,$to_filepath);

	}
}
