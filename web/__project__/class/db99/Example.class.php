<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace db99;
class Example
{

	use \_lp_\datamodel\Superdb;

	static function db_connect_id()
	{

		if(0)
		{//演示连接第二数据库,示例代码,别打开
			$__db=\db99\Example::db_instance();
			$__db->add([
					'varchar_0'=>math_salt(),
					'int_signed'=>mt_rand(-100,0),
					'int_unsigned'=>mt_rand(0,100),
					'text_serialized'=>[math_salt(),math_salt(),math_salt()]
				]);
			$itemlist=$__db->select();
		}

		return \Dbconfig::db_connect_other;

	}

	static function db_table_config()
	{

		$triggers=[];

		$code='';

		$code.=	'
					BEGIN
						SET NEW.example_version=NEW.example_version+1;
					END
				';

		$triggers['update/before']=$code;

		return
		[

			'db_table_signedfileds'=>['int_signed'],

			'db_table_serializedfileds'=>['text_serialized'],

			'db_table_triggers'=>$triggers,

		];

	}
}
