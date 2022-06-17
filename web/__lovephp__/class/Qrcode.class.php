<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _lp_;
class Qrcode
{

	static function image_echoimage($data)
	{

		require_once __vendor_dir__.'/qrcode/phpqrcode.php';
		\_vendor_qrcode_\QRcode::png($data,false,QR_ECLEVEL_H,4,0);

	}
	static function url_genurl($data)
	{

		$data=htmlentity_decode($data);
		return '/api/qrcode_image?data='.urlencode($data);

	}

}
