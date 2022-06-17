<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace db;
class Adminuser
{

	use \_lp_\datamodel\Superdb;

	const loginhistory_recordnum=100;

	static function db_table_config()
	{

		$triggers=[];

		$code='';

		$code.='

			BEGIN
				IF
					NEW.adminuser_isban!=OLD.adminuser_isban OR
					NEW.adminuser_isdelete!=OLD.adminuser_isdelete OR
					NEW.adminuser_password_hash!=OLD.adminuser_password_hash

				THEN

					SET NEW.adminuser_version=NEW.adminuser_version+1;

				END IF;

			END

			';

		$triggers['update/before']=$code;

		return
		[

			'db_table_serializedfileds'=>
			[
				'adminuser_authority',
				'adminuser_cloud_filetree',
				'adminuser_loginhistory',
			],

			'db_table_triggers'=>$triggers,
		];

	}


}
