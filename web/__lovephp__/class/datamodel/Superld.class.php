<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _lp_\datamodel;
trait Superld
{
	static function __getDataFilePath($dataext='data')
	{

		$basename=class_corename(__CLASS__,1);

		$datapath=__data_dir__.'/ld/'.$basename.'/'.$basename.'.'.$dataext;

		return $datapath;
	}
//1 list
	static function list_select($dataext='data')
	{
		return fs_file_read_data(self::__getDataFilePath($dataext),fs_loose);
	}
	static function list_save($data,$dataext='data')
	{

		$path=self::__getDataFilePath($dataext);

		$result=fs_file_save_data($path,$data);

		return $result;

	}
	static function list_itemnames()
	{

		$data=self::list_select();
		foreach($data as &$v)
		{
			$v=$v['name'];
		}
		unset($v);
		return $data;

	}
//1 find
	static function item_finditem($id)
	{

		if(!$id)
		{
			return false;
		}

		$data=self::list_select();

		$id=intval($id);

		return $data[$id]?$data[$id]:false;

	}
	static function item_finditems(array $ids)
	{

		$data=self::list_select();

		return array_keep_keys($data,$ids);

	}
//1 add
	static function item_additem($itemdata)
	{

		$data=self::list_select();

		if(!$itemdata['id'])
		{
			$itemdata['id']=fs_file_idautoinc(path_ext_change(self::__getDataFilePath(),'lastid.data'));
		}

		$data[$itemdata['id']]=$itemdata;

		self::list_save($data);

		return $itemdata['id'];
	}
//1 edit
	static function item_edititem(int $id,$save,$merge=false)
	{

		if($merge)
		{
			$item=self::item_finditem($id);
			$item=array_merge_1($item,$save);
		}
		else
		{
			$item=$save;
		}

		$item['id']=$id;

		$data=self::list_select();

		$data[$id]=$item;

		return self::list_save($data);

	}
//1 delete
	static function item_deleteitem($id)
	{
		$data=self::list_select();
		unset($data[$id]);
		self::list_save($data);
	}
//1 move
	static function item_moveitem($id,$dir)
	{

		$data=self::list_select();

		if(-1==$dir&&$id==array_key_first($data))
		{
			R_alert('首节点不能上移');
		}
		else if(1==$dir&&$id==array_key_last($data))
		{
			R_alert('末节点不能下移');
		}
		else
		{

		}

		$data=array_item_move($data,$id,$dir);

		self::list_save($data);

	}

//1 uniquename
	static function item_uniquename($name,$exceptid=0)
	{

		$name=strtolower($name);

		$list=self::list_select();

		foreach($list as $k=>$v)
		{

			if($exceptid==$k)
			{
				continue;
			}

			if(strtolower($v['name'])==$name)
			{
				return false;
			}

		}

		return true;

	}

}
