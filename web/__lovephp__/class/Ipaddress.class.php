<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _lp_;
class Ipaddress
{

	static function ipaddress_get($ip)
	{
		require_once __vendor_dir__.'/ip/ipaddress.php';

		$ipaddress=new \_vendor_ipaddress_\Ipaddress();

		if($ip)
		{

			$address=[];

			$addressinfo=$ipaddress->getlocation($ip);

			if($addressinfo['country'])
			{
				$address[]=$addressinfo['country'];
			}
			if($addressinfo['area'])
			{
				$address[]=$addressinfo['area'];
			}
		}

		return impd($address,'/');

	}

}
