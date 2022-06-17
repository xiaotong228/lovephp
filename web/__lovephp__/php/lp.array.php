<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



function array_is_allint($ary)
{//判断array中的所有值是不是全是int,同时key也是0,1,2...

	if(!$ary)
	{
		return false;
	}

	if(!array_is_list($ary))
	{
		return false;
	}

	foreach($ary as $v)
	{
		if(!isint_isint($v))
		{
			return false;
		}
	}

	return true;

}
//1 array_key
function array_key_convertto_subscript($key)
{

	$chars=str_split('[]{}=!<>');

	foreach($chars as $v)
	{//剔除一些危险字符串
		if(false!==strpos($key,$v))
		{
			R_alert('[error-4055]');
		}
	}

	$key=expd($key,'/');

	foreach($key as &$v)
	{
		$v='[\''.$v.'\']';
	}
	unset($v);

	return impd($key,'');

}
function array_key_expd($ary)
{

	$result=[];

	foreach($ary as $key=>$value)
	{
		eval('$result'.array_key_convertto_subscript($key).'=$value;');
	}

	return $result;
}

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
