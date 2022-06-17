<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _lp_;
class Vcode
{
	const vcodetype_img=1;
	const vcodetype_sms=2;
	const vcodetype_email=3;

	const vcodetype_namemap=
	[
		self::vcodetype_img=>'图片',
		self::vcodetype_sms=>'短信',
		self::vcodetype_email=>'邮箱',
	];

	const vcodeverify_lifetime=60*10;
	const vcodeverify_verify_timesmax=5;

	const imgvcode_charpool='2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY';

	const smsvcode_digitnum=6;
	const smsvcode_frozentime=10;

//1 vcodeverify
	static function vcodeverify_settoken($type,$vcode,$address=false)
	{
		$vcode=strtolower($vcode);

		$salt=math_salt();

		$expireTime=time()+self::vcodeverify_lifetime;

		$vcodeInfo=[];

		$vcodeInfo['vcode_type']=$type;

		if($address)
		{
			$vcodeInfo['address']=$address;
		}


		$tokenGenData=$vcodeInfo;


		$vcodeInfo['vcode_expiretime']=time()+self::vcodeverify_lifetime;
		$vcodeInfo['vcode_verifytimes']=0;
		$vcodeInfo['vcode_salt']=$salt;

		$vcodeInfo['vcode_token']=\_lp_\Token::token_gen($tokenGenData,$vcodeInfo['vcode_salt'].$vcode);

		if(!__online_isonline__)
		{//test
			$vcodeInfo['vcode_debugtrace']=$vcode;
		}

		unset($vcodeInfo['vcode']);

		session_set('vcode_vcodedata/'.$type,$vcodeInfo);
	}
	static function vcodeverify_verify($type,$vcode,$address=null)
	{

		if(0&&!__online_isonline__)
		{//test
			return true;
		}

		$vcode=strtolower($vcode);

		$vcodeInfo=session_get('vcode_vcodedata/'.$type);

		if(!$vcodeInfo||($vcodeInfo['vcode_expiretime']<time())||($vcodeInfo['vcode_verifytimes']>self::vcodeverify_verify_timesmax))
		{
			session_delete('vcode_vcodedata/'.$type);

			if(self::vcodetype_img==$type)
			{
				return self::vcodetype_namemap[$type].'图片验证码过期,点击图片重新获取';
			}
			else
			{
				return self::vcodetype_namemap[$type].'验证码过期,请重新获取';
			}
		}

		if(
			($vcodeInfo['_controller']&&0!==strcasecmp($vcodeInfo['_controller'],__route_controller__))||
			($vcodeInfo['_action']&&0!==strcasecmp($vcodeInfo['_action'],__route_action__))
		)
		{
			session_set('vcode_vcodedata/'.$type.'/vcode_verifytimes',$vcodeInfo['vcode_verifytimes']+1);
			return self::vcodetype_namemap[$type].'验证码不正确';
		}

		$tokenGenData=[];
		$tokenGenData['vcode_type']=$type;

		if($address)
		{
			$tokenGenData['address']=$address;
		}

		if(!\_lp_\Token::token_check($tokenGenData,$vcodeInfo['vcode_salt'].$vcode,$vcodeInfo['vcode_token']))
		{
			session_set('vcode_vcodedata/'.$type.'/vcode_verifytimes',$vcodeInfo['vcode_verifytimes']+1);
			return self::vcodetype_namemap[$type].'验证码不正确';
		}

		session_delete('vcode_vcodedata/'.$type);

		return  true;
	}
//1 imgvcode
	static function imgvcode_echoimg()
	{

		$__charpool_length=strlen(self::imgvcode_charpool);

		$__vcode_str='';

		for($i=0;$i<4;$i++)
		{
			$__vcode_str.=self::imgvcode_charpool[mt_rand(0,$__charpool_length-1)];
		}

		$temp=[2,4,6];
		$temp=$temp[array_rand($temp)];

		$__font_filepath=realpath('./assets/font/vcode/'.$temp.'.ttf');

		self::vcodeverify_settoken(self::vcodetype_img,$__vcode_str);

		if(__m_access__)
		{
			return self::imgvcode_echoimg_1(600,120,$__font_filepath,$__vcode_str);
		}
		else
		{
			return self::imgvcode_echoimg_1(150,30,$__font_filepath,$__vcode_str);
		}

	}
	static function imgvcode_echoimg_1($__width,$__height,$__font_filepath,$__vcode_str)
	{

		$__font_filepath=realpath($__font_filepath);

		$__vcode_str_length=strlen($__vcode_str);

		$__fontsize=intval($__height*2/3);

		$__image=imagecreate($__width,$__height);

		imagecolorallocate($__image,255,255,255);

		$__charpool_length=strlen(self::imgvcode_charpool);

		if(1)
		{//背景杂色
			for($i=0;$i<10;$i++)
			{
				$noise_color=imagecolorallocate($__image,mt_rand(187,225),mt_rand(187,225),mt_rand(187,225));
				for($j=0;$j<5;$j++)
				{
					imagestring($__image,5,mt_rand(-10,$__width),mt_rand(-10,$__height),self::imgvcode_charpool[mt_rand(0,$__charpool_length-1)],$noise_color);
				}
			}
		}
		if(1)
		{//干扰线

			$__curvecolor=imagecolorallocate($__image,mt_rand(0,187),mt_rand(0,187),mt_rand(0,187));

			$px=$py=0;

			//曲线前部分
			$A=mt_rand(1,$__height/2);//振幅
			$b=mt_rand(-$__height/4,$__height/4);//Y轴方向偏移量
			$f=mt_rand(-$__height/4,$__height/4);//X轴方向偏移量
			$T=mt_rand($__height,$__width*2);//周期
			$w=(2*M_PI)/$T;

			$px1=0;//曲线横坐标起始位置
			$px2=mt_rand($__width/2,$__width*0.8);//曲线横坐标结束位置

			for($px=$px1;$px<=$px2;$px=$px+1)
			{
				if(0!=$w)
				{
					$py=$A*sin($w*$px+$f)+$b+$__height/2;//y=Asin(ωx+φ)+b
					$i=floor($__height/10);
					while($i>0)
					{
						imagesetpixel($__image,$px+$i,$py+$i,$__curvecolor);//这里(while)循环画像素点比imagettftext和imagestring用字体大小一次画出（不用这while循环）性能要好很多
						$i--;
					}
				}
			}

			//曲线后部分
			$A=mt_rand(1,$__height/2);//振幅
			$f=mt_rand(-$__height/4,$__height/4);//X轴方向偏移量
			$T=mt_rand($__height,$__width*2);//周期
			$w=(2*M_PI)/$T;
			$b=$py-$A*sin($w*$px+$f)-$__height/2;
			$px1=$px2;
			$px2=$__width;

				for($px=$px1;$px<=$px2;$px=$px+1)
				{
					if(0!=$w)
					{
						$py=$A*sin($w*$px+$f)+$b+$__height/2;//y=Asin(ωx+φ)+b
						$i=intval($__fontsize/5);
						while($i>0)
						{
							imagesetpixel($__image,$px+$i,$py+$i,$__curvecolor);
							$i--;
						}
					}
				}
		}
		if(1)
		{//写字
			$str_map=[];
			$charbox_width_total=0;
			for($i=0;$i<$__vcode_str_length;$i++)
			{
				$temp=[];

				if($i==$__vcode_str_length-1)
				{
					$charBoxwidth=$__fontsize;
				}
				else
				{
					$charBoxwidth=mt_rand($__fontsize*1.2,$__fontsize*1.6);
				}

				$temp[]=$__vcode_str[$i];
				$temp[]=$charBoxwidth;
				$temp[]=mt_rand(-20,20);

				if(1)
				{//直接用曲线颜色,这样更难被机器识别
					$temp[]=$__curvecolor;
				}
				else
				{
					$temp[]=imagecolorallocate($__image,mt_rand(0,187),mt_rand(0,187),mt_rand(0,187));
				}

				$str_map[]=$temp;

				$charbox_width_total+=$charBoxwidth;

			}

			$drawbegin_x=intval(($__width-$charbox_width_total)/2);
			$drawbegin_y=intval(($__height+$__fontsize)/2);
			foreach($str_map as $v)
			{
				imagettftext($__image,$__fontsize,$v[2],$drawbegin_x,$drawbegin_y,$v[3],$__font_filepath,$v[0]);
				$drawbegin_x+=$v[1];
			}
		}

		header('Cache-Control:private,max-age=0,no-store,no-cache,must-revalidate');
		header('Cache-Control:post-check=0,pre-check=0',false);
		header('Pragma:no-cache');
		header("content-type:image/png");

		//输出图像
		imagepng($__image);
		imagedestroy($__image);

	}

}
