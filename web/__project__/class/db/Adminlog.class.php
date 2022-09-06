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
		$actionname,
		string $itemids=null,//记录操作对象的id,可以是多个,中间用,分隔
		$tracedata=null
	)
	{

		$data=[];

		$data['aid']=clu_admin_id();

		$data['adminlog_createtime']=time();

		$data['adminlog_ip']=client_ip();

		$data['adminlog_route']='/'.__route_module__.'/'.__route_controller__.'/'.__route_action__;

		$data['adminlog_name']=$actionname;

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
