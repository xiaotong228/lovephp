<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace db;
class Smssendlog
{

	use \_lp_\datamodel\Superdb;


	const type_vcode=1;
	const type_other=99;

	const type_namemap=
	[
		self::type_vcode=>'验证码',
		self::type_other=>'其他',
	];

	const channel_aliyun=1;
	const channel_tencent=2;
	const channel_baidu=3;
	const channel_other=99;

	const channel_namemap=
	[
		self::channel_aliyun=>'阿里云',
		self::channel_tencent=>'腾讯云',
		self::channel_baidu=>'百度云',
		self::channel_other=>'其他'
	];

}
