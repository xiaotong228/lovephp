<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\foreground;
class Api extends super\Superforeground
{
	function clu_connect_getuserdata()
	{

		$temp=clu_data_db();

		if($temp)
		{
			$temp=array_keep_keys($temp,['id','user_name','user_avatar','user_mobile']);
			$temp['user_mobile']=\_lp_\Mask::mobile_num($temp['user_mobile']);
		}
		else
		{
			$temp=false;
		}

		R_true($temp);

	}
	function qrcode_image($data)
	{
		$data=urldecode(htmlentity_decode($data));
		\_lp_\Qrcode::image_echoimage($data);
	}

}
