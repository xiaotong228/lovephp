<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

namespace db;

class Adminlog
{

	use \_lp_\datamodel\Superdb;

	static function db_table_config()
	{

		return
		[

			'db_table_serializedfileds'=>
			[
				'adminlog_tracedata',
			],

		];
	}
	static function adminlog_addlog
	(
//		int $aid,
		$actionname,
		string $itemids=null,//记录操作对象的id,可以是多个,中间用,分隔
		$tracedata=null
	)
	{

		$data=[];

		$data['aid']=clu_admin_id();//直接读取当前的adminid,不用参数传入,和前台的操作记录不一样

		$data['adminlog_createtime']=time();

		$data['adminlog_ip']=client_ip();

		$data['adminlog_name']=$actionname;

		$data['adminlog_useragent']=client_useragent();

		$data['adminlog_url']=server_url_current(1);

		if($itemids)
		{
			$data['adminlog_itemids']=$itemids;
		}

		if(!is_null($tracedata))
		{
			$data['adminlog_tracedata']=$tracedata;
		}

		return self::add($data);

	}

}
