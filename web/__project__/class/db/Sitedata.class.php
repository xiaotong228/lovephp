<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace db;
class Sitedata
{

	use \_lp_\datamodel\Superdb;
//1 census
	const census_fieldnamemap=
	[

		'sitedata_user_total'=>'用户/总数',

		'sitedata_user_daylogin'=>'用户/当日登录',

		'sitedata_article_total'=>'文章/总数',

		'sitedata_smssendlog_total'=>'短信发送/总数',

	];
	static function sitedata_census($time)
	{

		$date_begin=false;
		$date_end=false;
		list($date_begin,$date_end)=day_timerange($time);

		$__m_user=\db\User::db_instance();

		$__data=[];
		$__data['sitedata_user_total']=$__m_user->count();

		$where=[];
		$where['user_lastlogin_time#0']=[db_egt,$date_begin];
		$where['user_lastlogin_time#1']=[db_elt,$date_end];
		$__data['sitedata_user_daylogin']=$__m_user->where($where)->count();

		$__data['sitedata_article_total']=\db\Article::count();

		$__data['sitedata_smssendlog_total']=\db\Smssendlog::count();

		return $__data;

	}
	static function sitedata_dailycheck()
	{

		$__preday_time=time()-24*3600;

		$__preday_datestr=date_str_num($__preday_time);

		$filepath=__temp_dir__.'/sitedata_genhistory/'.$__preday_datestr.'.data';

		$__db=\db\Sitedata::db_instance();

		if(!is_file($filepath))
		{

			$item=$__db->where($__preday_datestr)->find();

			if($item)
			{

			}
			else
			{
				$data=self::sitedata_census($__preday_time);
				$data['id']=$__preday_datestr;
				$data['sitedata_createtime']=time();
				$newid=$__db->add($data,cmd_ignore);
			}

			fs_file_save_data($filepath,true);

		}

	}

}
