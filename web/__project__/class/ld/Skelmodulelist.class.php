<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace ld;
class Skelmodulelist
{

	use \_lp_\datamodel\Superld;

	static function modulecode_get_file_exts()
	{
		$temp=fs_dir_list(__lp_dir__.'/skel/module_mother_template');

		$exts=[];

		foreach($temp['file'] as $v)
		{
			$exts[]=path_ext($v);
		}

		return $exts;
	}

	static function list_select()
	{
		$list=[];

		$dirlist=fs_dir_list(__skel_modulecode_dir__);

		sort($dirlist['dir']);

		$index=1;

		foreach($dirlist['dir'] as $v)
		{

			$temp=[];

			$xml=\_lp_\Xmlparser::xmlfile_structdata_get(__skel_modulecode_dir__."/{$v}/{$v}.xml");

			$temp['name']=$v;
			$temp['id']=$index;

			if($xml['title'])
			{
				$temp['title']=$xml['title'];
			}
			if($xml['thumb'])
			{
				$temp['thumb']=$xml['thumb'];
			}
			if($xml['description'])
			{
				$temp['description']=$xml['description'];
			}

			$list[$index]=$temp;

			$index++;
		}

		return $list;

	}

	static function item_additem($itemdata)
	{
		R_alert('[error-2815]已废弃');
	}

}
