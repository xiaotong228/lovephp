<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace db;
class Cloud
{

	use \_lp_\datamodel\Superdb;

//1 file_type
	const file_type_pic=1;

	const file_type_doc=2;

	const file_type_audio=10;

	const file_type_video=11;

	const file_type_compress=20;

	const file_type_other=99;

	const file_type_namemap=
	[

		self::file_type_pic=>'图片',

		self::file_type_doc=>'文档',

		self::file_type_audio=>'音频',

		self::file_type_video=>'视频',

		self::file_type_compress=>'压缩包',

		self::file_type_other=>'其他',

	];

	const file_type_extmap=
	[

		self::file_type_pic=>
		[
			'jpg',
			'jpeg',
			'png',
			'gif',
			'bmp',
			'svg',
		],

		self::file_type_doc=>
		[
			'txt',
			'pdf',
			'doc',
			'docx',
			'xls',
			'xlsx',
			'ppt',
			'pptx',
		],
		self::file_type_audio=>
		[
			'mp3',
			'wma',
			'acc',
		],

		self::file_type_video=>
		[
			'mp4',
			'rmvb',
		],

		self::file_type_compress=>
		[
			'zip',
			'rar',
		],

		self::file_type_other=>
		[
			'psd',
			'ai',
			'xxx',
			'yyy',
			'zzz',
		],

	];

//1 cloudtype
	const cloudtype_file=1;
	const cloudtype_folder=2;

	const cloudtype_namemap=
	[
		self::cloudtype_file=>'文件',
		self::cloudtype_folder=>'文件夹'
	];


//1 order

	const order_ordermap=
	[

		'cloud_type desc,id asc'=>'ID↗',

		'cloud_type desc,id desc'=>'ID↘',

		'cloud_type desc,cloud_name asc'=>'名称↗',

		'cloud_type desc,cloud_name desc'=>'名称↘',

		'cloud_type desc,cloud_file_ext asc'=>'类型↗',

		'cloud_type desc,cloud_file_ext desc'=>'类型↘',

		'cloud_type desc,cloud_createtime asc'=>'创建时间↗',
		'cloud_type desc,cloud_createtime desc'=>'创建时间↘',

		'cloud_type desc,cloud_updatetime asc'=>'修改时间↗',
		'cloud_type desc,cloud_updatetime desc'=>'修改时间↘',

		'cloud_type desc,cloud_file_size asc'=>'大小↗',
		'cloud_type desc,cloud_file_size desc'=>'大小↘',

		'cloud_type desc,cloud_file_pic_pixels asc'=>'尺寸↗',
		'cloud_type desc,cloud_file_pic_pixels desc'=>'尺寸↘',

	];

	const order_default='cloud_type desc,cloud_file_ext asc';

	const order_ordermap_recycle=
	[

		'cloud_type desc,id asc'=>'ID↗',

		'cloud_type desc,id desc'=>'ID↘',

		'cloud_type desc,cloud_name asc'=>'名称↗',

		'cloud_type desc,cloud_name desc'=>'名称↘',

		'cloud_type desc,cloud_file_ext asc'=>'类型↗',

		'cloud_type desc,cloud_file_ext desc'=>'类型↘',

		'cloud_type desc,cloud_createtime asc'=>'创建时间↗',
		'cloud_type desc,cloud_createtime desc'=>'创建时间↘',

		'cloud_type desc,cloud_deletetime asc'=>'删除时间↗',
		'cloud_type desc,cloud_deletetime desc'=>'删除时间↘',

		'cloud_type desc,cloud_file_size asc'=>'大小↗',
		'cloud_type desc,cloud_file_size desc'=>'大小↘',

		'cloud_type desc,cloud_file_pic_pixels asc'=>'尺寸↗',
		'cloud_type desc,cloud_file_pic_pixels desc'=>'尺寸↘',

	];

	const order_default_recycle='cloud_type desc,cloud_deletetime desc';

//1 db_table_config
	static function db_table_config()
	{

		$triggers=[];

		$triggers['insert/before']=
		'
			BEGIN

				SET NEW.cloud_createtime=unix_timestamp();

				SET NEW.cloud_updatetime=NEW.cloud_createtime;

				SET NEW.cloud_file_pic_pixels=NEW.cloud_file_pic_width*NEW.cloud_file_pic_height;

			END
		';

		$triggers['update/before']=
		'
			BEGIN

				IF

					OLD.cloud_isdelete=0 AND
					NEW.cloud_isdelete=1

					THEN
					SET NEW.cloud_deletetime=unix_timestamp();

				ELSEIF

					OLD.cloud_isdelete=1 AND
					NEW.cloud_isdelete=0

					THEN
					SET NEW.cloud_deletetime=0;

				END IF;

				IF

					OLD.cloud_name!=NEW.cloud_name OR

					OLD.cloud_folder_dad!=NEW.cloud_folder_dad OR

					OLD.cloud_isdelete!=NEW.cloud_isdelete

					THEN

					SET NEW.cloud_updatetime=unix_timestamp();

				END IF;

				SET NEW.cloud_file_pic_pixels=NEW.cloud_file_pic_width*NEW.cloud_file_pic_height;

			END

		';

		return
		[

			'db_table_triggers'=>$triggers,

		];

	}

//1 folder
	static function folder_acsts(array $item)
	{

		static $cache=[];

		if(!$item['cloud_folder_dad'])
		{
			return [];
		}

		if(!$cache[$item['cloud_folder_dad']])
		{

			$__db=self::db_instance();

			$acsts=[];

			$dad_id=$item['cloud_folder_dad'];

			while(1)
			{
				if(!$dad_id)
				{
					break;
				}
				$temp=$__db->field(['id','cloud_name','cloud_folder_dad'])->where($dad_id)->find();

				$acsts[]=$temp;

				$dad_id=$temp['cloud_folder_dad'];

			}

			$cache[$item['cloud_folder_dad']]=array_reverse($acsts);

		}

		return $cache[$item['cloud_folder_dad']];

	}

//1 file_type
	static function file_type_get($ext)
	{

		foreach(self::file_type_extmap as $k=>$v)
		{
			if(in_array($ext,$v))
			{
				return $k;
			}
		}

		return self::file_type_other;
	}
	static function file_type_allexts()
	{

		static $result=[];

		if(!$result)
		{

			foreach(self::file_type_extmap as $v)
			{
				$result=array_merge($result,$v);
			}

			$a=count($result);

			$result=array_unique($result);

			if(count($result)!=$a)
			{
				R_alert('[error-1823]含有重复的扩展名');
			}

		}

		return $result;

	}

}
