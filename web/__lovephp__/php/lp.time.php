<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


//1 time
function time_ms()
{//毫秒

	$temp=microtime(true);
	return $temp*1000;

}
function time_str($time=cmd_default,$datesep='-',$onlydate=false)
{

	if(cmd_default===$time)
	{
		$time=time();
	}

	if($onlydate)
	{
		$exp='Y'.$datesep.'m'.$datesep.'d';
	}
	else
	{
		$exp='Y'.$datesep.'m'.$datesep.'d H:i:s';
	}
	return date($exp,$time);
}
function time_str_num($time=cmd_default,$onlydate=false)
{

	if(cmd_default===$time)
	{
		$time=time();
	}

	if($onlydate)
	{
		$exp='Ymd';
	}
	else
	{
		$exp='YmdHis';
	}

	return date($exp,$time);

}
function time_str_cn($time=cmd_default,$onlydate=false)
{

	if(cmd_default===$time)
	{
		$time=time();
	}

	if($onlydate)
	{
		$exp='Y年m月d日';
	}
	else
	{
		$exp='Y年m月d日 H时i分s秒';
	}
	return date($exp,$time);

}

//1 date
function date_str($time=cmd_default,$datesep='-')
{
	return time_str($time,$datesep,1);
}
function date_str_num($time=cmd_default)
{
	return time_str_num($time,1);
}
function date_str_cn($time=cmd_default)
{
	return time_str_cn($time,1);
}
//1 day
function day_timerange($time=cmd_default)
{

	if(cmd_default===$time)
	{
		$time=time();
	}

	$range=[];

	$temp=date('Y-m-d',$time);
	$range[]=strtotime($temp);

	$temp=date('Y-m-d 23:59:59',$time);
	$range[]=strtotime($temp);

	return $range;

}
function day_calcdiff(int $time0,int $time1)
{//算出给出的2个时间点之间差多少天,可能为负数和0
//$time0-$time1
	return intval((strtotime(date("Y-m-d",$time0))-strtotime(date("Y-m-d",$time1)))/86400);
}

