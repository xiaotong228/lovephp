<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/
function article_articleurl($id)
{
	return '/article/'.$id;
}
function ip_ipbox($ip)
{

	$address=\_lp_\Ipaddress::ipaddress_get($ip);
	$address=$ip.'/'.$address;
	return $ip?_an__('https://www.baidu.com/s?wd='.$ip,'','','',$address):'/';

}
function htmlcache_set($user_ids=false,$article_ids=false)
{

	static $user_ids_cache=[];
	static $article_ids_cache=[];

	if(cmd_get===$user_ids)
	{
		return
		[
			array_unique($user_ids_cache),
			array_unique($article_ids_cache)
		];
	}
	else
	{
		if($user_ids)
		{
			if(!is_array($user_ids))
			{
				$user_ids=[$user_ids];
			}
			$user_ids_cache=array_merge_1($user_ids_cache,$user_ids);
		}
		if($article_ids)
		{
			if(!is_array($article_ids))
			{
				$article_ids=[$article_ids];
			}
			$article_ids_cache=array_merge_1($user_ids_cache,$article_ids);
		}
	}

}
function htmlcache_replace($H)
{

	static $hascalled=null;

	if(is_null($hascalled))
	{
		$hascalled=1;
	}
	else
	{
		R_alert('[error-0846]htmlcache_replacehtml重复调用');
	}

	$user_ids=false;
	$article_ids=false;
	list($user_ids,$article_ids)=htmlcache_set(cmd_get);

	$__replacemap=[];

	if($user_ids)
	{

		$__db=\db\User::db_instance();

		$list=$__db->field(['id','user_name','user_avatar'])->where(['id'=>[db_in,$user_ids]])->select();

		foreach($list as $v)
		{

			$uid=$v['id'];
			$__replacemap['{htmlcache_username_'.$uid.'}']=$v['user_name'];
			$__replacemap['{htmlcache_useravatar_'.$uid.'}']=$v['user_avatar'];

		}

	}

	if($article_ids)
	{//预留,如果需要替换article的相关信息

	}

	$H=strtr($H,$__replacemap);

	return $H;

}

