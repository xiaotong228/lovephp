<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

//1 array_item
function array_item_move($ary,$key,$direction/*1|-1*/)
{//item向上或者向下移动,保留key

	$index=array_search($key,array_keys($ary));

	if(-1==$direction&&0==$index)
	{
		return $ary;
	}
	else if(1==$direction&&$index==(count($ary)-1))
	{
		return $ary;
	}
	else{}

	if(-1==$direction)
	{
		$ary=array_reverse($ary,true);
	}

	$new_ary=[];

	$cache=[];

	foreach($ary as $k=>$v)
	{

		if($key==$k)
		{
			$cache['key']=$k;
			$cache['value']=$v;
			continue;
		}
		else
		{
			$new_ary[$k]=$v;
		}
		if($cache)
		{
			$new_ary[$cache['key']]=$cache['value'];
			$cache=[];
		}

	}

	if(-1==$direction)
	{
		$new_ary=array_reverse($new_ary,true);
	}

	return $new_ary;

}

function array_item_swap($ary,$key0,$key1,$swapkey=false)
{

	if($swapkey)
	{

		$ary_new=[];

		foreach($ary as $k=>$v)
		{
			if($key0==$k)
			{
				$ary_new[$key1]=$ary[$key1];
			}
			else if($key1==$k)
			{
				$ary_new[$key0]=$ary[$key0];
			}
			else
			{
				$ary_new[$k]=$v;
			}
		}

		return $ary_new;

	}
	else
	{

		$temp=$ary[$key0];
		$ary[$key0]=$ary[$key1];
		$ary[$key1]=$temp;
		return $ary;

	}

}
function array_pipe_push($data,array $pushitem,$max,$unique=false)
{

	if(!$data)
	{
		$data=[];
	}

	$data=array_merge_1($data,$pushitem);

	$data=array_reverse($data);

	if($unique)
	{
		$data=array_unique($data);
	}

	$data=array_slice($data,0,$max);

	$data=array_reverse($data);

	return $data;

}

function array_pipe_prepend($data,array $prependitem,$max,$unique=false)
{//pipe前方插入

	if(!$data)
	{
		$data=[];
	}

	$data=array_merge_1($prependitem,$data);

	if($unique)
	{
		$data=array_unique($data);
	}

	$data=array_slice($data,0,$max);

	return $data;

}

function array_keep_keys(array $ary,array $keys)
{
	$ary=array_intersect_key($ary,array_flip($keys));
	return $ary;
}



//1 array_cascade,数组级联操作

function array_cascade_get($ary,$keypath)
{

	$keypath=expd($keypath,'/');

	$needle=$ary;

	foreach($keypath as $v)
	{
		$needle=$needle[$v];
	}

	return $needle;

}
function array_cascade_set(&$ary,$keypath,$value)
{

	$keypath=expd($keypath,'/');

	$keypath_count=count($keypath);

	$needle=&$ary;

	foreach($keypath as $k=>$v)
	{

		if(is_null($needle))
		{
			$needle=[];
		}

		if(!array_key_exists($v,$needle))
		{
			$needle[$v]=[];
		}

		$needle=&$needle[$v];

		if($keypath_count-1==$k)
		{
			break;
		}

	}

	$needle=$value;

}

function array_cascade_delete(&$ary,$keypath)
{

	$keypath=expd($keypath,'/');

	$keypath_count=count($keypath);

	$needle=&$ary;

	if(0==$keypath_count)
	{

	}
	else if(1==$keypath_count)
	{
		unset($needle[$keypath[0]]);
	}
	else
	{
		foreach($keypath as $k=>$v)
		{

			if(!array_key_exists($v,$needle))
			{
				return;
			}

			$needle=&$needle[$v];

			if($keypath_count-2==$k)
			{
				unset($needle[$keypath[$keypath_count-1]]);
				break;
			}

		}

	}

}


function array_cascade_add(&$ary,$keypath,$adddata_key,$adddata_value)
{

	$keypath=expd($keypath,'/');

	$keypath_count=count($keypath);

	$needle=&$ary;

	foreach($keypath as $k=>$v)
	{

		if(!array_key_exists($v,$needle))
		{
			$needle[$v]=[];
		}

		$needle=&$needle[$v];

		if($keypath_count-1==$k)
		{
			break;
		}
	}

	if(is_null($adddata_key)||''===$adddata_key)
	{
		$needle[]=$adddata_value;
	}
	else
	{
		$needle[$adddata_key]=$adddata_value;
	}

}

function array_cascade_key_rename(&$ary,$keypath,$keyname_new)
{

	$keypath=expd($keypath,'/');

	$keypath_count=count($keypath);

	$keyname_old=$keypath[$keypath_count-1];

	$needle=&$ary;

	if(0==$keypath_count)
	{
		return;
	}
	else if(1==$keypath_count)
	{

	}
	else
	{
		foreach($keypath as $k=>$v)
		{

			if(!array_key_exists($v,$needle))
			{
				return;
			}

			$needle=&$needle[$v];

			if($keypath_count-2==$k)
			{
				break;
			}

		}

	}

	$needle_new=[];

	unset($needle[$keyname_new]);

	foreach($needle as $k=>$v)
	{
		if($keyname_old==$k)
		{
			$k=$keyname_new;
		}
		$needle_new[$k]=$v;
	}

/*
	array_walk($needle,function($value,$key) use (&$needle_new,$keyname_old,$keyname_new)
	{

		if($keyname_old==$key)
		{
			$key=$keyname_new;
		}

		$needle_new[$key]=$value;

	});

*/
	$needle=$needle_new;

}

function array_cascade_key_expd($ary)
{//把['aaa/bbb'=>1]爆破成['aaa'=>['bbb'=>1]]

	$result=[];

	foreach($ary as $keypath=>$value)
	{
		array_cascade_set($result,$keypath,$value);
	}

	return $result;

}

function array_cascade_key_isexist($ary,$keypath)
{

	$keypath=expd($keypath,'/');

	$keypath_count=count($keypath);

	$needle=&$ary;

	if(0==$keypath_count)
	{
		return false;
	}
	else if(1==$keypath_count)
	{
		return array_key_exists($keypath[0],$needle);
	}
	else
	{
		foreach($keypath as $k=>$v)
		{

			if(!array_key_exists($v,$needle))
			{
				return false;
			}

			$needle=&$needle[$v];

			if($keypath_count-2==$k)
			{
				return array_key_exists($keypath[$keypath_count-1],$needle);
			}

		}

	}

}

function array_cascade_move(&$ary,$keypath,$direction)
{

	if(1!=$direction&&-1!=$direction)
	{
		R_exception('[error-3413]参数错误');
	}

	$keypath=expd($keypath,'/');

	$keypath_count=count($keypath);

	$needle=&$ary;

	if(0==$keypath_count)
	{
		return false;
	}
	else if(1==$keypath_count)
	{

	}
	else
	{

		foreach($keypath as $k=>$v)
		{

			if(!array_key_exists($v,$needle))
			{
				return false;
			}

			$needle=&$needle[$v];

			if($keypath_count-2==$k)
			{
				break;
			}

		}

	}

	if(1)
	{//先判断下是否可以移动
		$index=array_search(end($keypath),array_keys($needle));

		if(-1==$direction&&0==$index)
		{
			return false;
		}
		else if(1==$direction&&$index==(count($needle)-1))
		{
			return false;
		}
		else{}
	}

	$needle=array_item_move($needle,end($keypath),$direction);

	return true;

}
