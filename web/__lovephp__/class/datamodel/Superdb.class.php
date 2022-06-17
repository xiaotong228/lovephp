<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace _lp_\datamodel;

trait Superdb
{
	static function db_connect_id()
	{//可被覆盖
		return \Dbconfig::db_connect_main;
	}
	static function db_table_config()
	{//可被覆盖
		if(0)
		{//示例代码不要直接用

			return
			[
				'db_table_prikey'=>'id',
				'db_table_signedfileds'=>['aaa','bbb'],
				'db_table_serializedfileds'=>['ccc','ddd'],
				'db_table_adjuststruct_enable'=>false,
				'db_table_adjuststruct_maxrownum'=>1000000,
				'db_table_triggers'=>['update/before'=>'
					BEGIN
						xxx
					END
				'],
			];

		}

		return [];

	}
	static function db_instance()
	{

		$db_connect_id=self::db_connect_id();

		$table_config=self::db_table_config();

		if(!is_array($table_config))
		{
			R_alert('[error-0244]需为数组');
		}

		$table_config=array_merge_1(\Dbconfig::db_connect_configmap[$db_connect_id]['db_table_defaultconfig'],$table_config);

		return class_instanceclass('\\_lp_\\datamodel\\Database',$db_connect_id,class_camelname_to_snakename(class_corename(__CLASS__)),$table_config);

	}
//1 find
	static function find($where,array $fields=null,$orderby=false)
	{
		if(!$where)
		{
			return false;
		}

		$__db=self::db_instance();

		$__db->where($where);

		if($fields)
		{
			$__db->field($fields);
		}
		if($orderby)
		{
			$__db->orderby($orderby);
		}

		return $__db->find();
	}
	static function select($where=null,array $fields=null,$order=null)
	{

		$__db=self::db_instance();

		if($where)
		{
			$__db->where($where);
		}

		if($order)
		{
			$__db->orderby($order);
		}

		return $__db->select();

	}
	static function add($data)
	{
		$__db=self::db_instance();
		return $__db->add($data);
	}
	static function count($where=null)
	{
		$__db=self::db_instance();

		if($where)
		{
			$__db->where($where);
		}

		return $__db->count();

	}
	static function save($where,$data)
	{
		if(!$where)
		{
			R_alert('[error-0139]');
		}
		$__db=self::db_instance();
		return $__db->where($where)->save($data);
	}
	static function delete($where)
	{
		if(!$where)
		{
			R_alert('[error-0150]');
		}
		$__db=self::db_instance();
		return $__db->where($where)->delete();
	}
	static function queryhistory()
	{
		$__db=self::db_instance();
		return $__db->queryhistory();
	}
	static function sum($where=null,$field)
	{

		$__db=self::db_instance();

		if($where)
		{
			$__db->where($where);
		}

		return $__db->sum($field);

	}
	static function save_fieldset($where,$field,$fieldvalue)
	{

		if(!$where)
		{
			R_alert('[error-0700]');
		}

		$__db=self::db_instance();

		return $__db->where($where)->save_fieldset($field,$fieldvalue);

	}
	static function save_fieldplus($where,$field,$plusnum)
	{

		if(!$where)
		{
			R_alert('[error-0707]');
		}

		$__db=self::db_instance();

		return $__db->where($where)->save_fieldplus($field,$plusnum);

	}
	static function assertmy(int $where)
	{//结合当前登录用户判断

		if(!$where)
		{
			R_alert('[error-3430]');
		}

		$uid=clu_id();

		if(!$uid)
		{
			R_alert('[error-3438]未登录');
		}

		$item=self::find($where);

		if($uid!=$item['uid'])
		{
			R_alert('[error-4642]非当前登录用户所有');
		}

		return $item;
	}
	static function assertfind(int $where)
	{

		if(!$where)
		{
			R_alert('[error-2801]');
		}

		$item=self::find($where);

		if($item)
		{

			$__db=self::db_instance();

			$tablename=$__db->__table_name;

			if($item[$tablename.'_isdelete'])
			{

				$msg='[error-2520]未在数据库中找到该记录或该记录已被删除/'.$tablename.'/'.$where;

				R_exception($msg);

			}

		}
		else
		{
			R_alert('[error-4339]:没在数据库里找到这条记录');
		}

		return $item;

	}

}

