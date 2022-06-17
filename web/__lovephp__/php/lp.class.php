<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



function class_instanceclass($class,...$args)
{

	static $cache=[];

	static $history=[];

	if(cmd_get===$class)
	{
		return $history;
	}

	$inst_dna=md5_md5($class,$args);

	if(!isset($cache[$inst_dna]))
	{

		if(__online_isonline__)
		{

		}
		else
		{
			$history[]=[$class,$args];
		}

		$class=new \ReflectionClass($class);

		$cache[$inst_dna]=$class->newInstanceArgs($args);
		$cache[$inst_dna]->instanceclass_trace=time_str().'/'.math_salt();

	}

	return $cache[$inst_dna];

}

function class_corename($class,$lowercase=false)
{

	$class=substr($class,strrpos($class,'\\')+1);

	if($lowercase)
	{
		$class=strtolower($class);
	}

	return $class;

}

function class_camelname_to_snakename($name)
{//AaaBbb转化成aaa_bbb
        return strtolower(trim(preg_replace('/[A-Z]/', '_$0', $name),'_'));
}
function class_snakename_to_camelname($name)
{//aaa_bbb转化成AaaBbb

	$name='_'.$name;
	return preg_replace_callback(
		'/_([a-z])/',
		function($match)
		{
			return strtoupper($match[1]);
		},
		$name);
}