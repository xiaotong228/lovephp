<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

namespace db;

class Userlog
{

	use \_lp_\datamodel\Superdb;

	static function db_table_config()
	{

		return
		[

			'db_table_serializedfileds'=>
			[
				'userlog_tracedata',
			],

		];
	}

	static function userlog_addllog
	(
		int $uid,
		$actionname,
		string $itemids=null,//记录操作对象的id,可以是多个,中间用,分隔
		$tracedata=null
	)
	{

		$data=[];

		$data['uid']=$uid;

		$data['userlog_createtime']=time();

		$data['userlog_ip']=client_ip();

		$data['userlog_name']=$actionname;

		$data['userlog_useragent']=client_useragent();

		$data['userlog_url']=server_url_current(1);

		if($itemids)
		{
			$data['userlog_itemids']=$itemids;
		}

		if(!is_null($tracedata))
		{
			$data['userlog_tracedata']=$tracedata;
		}

		return self::add($data);

	}

}
