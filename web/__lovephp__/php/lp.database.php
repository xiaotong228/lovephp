<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



function db_buildwhere($keywordfields='',$requestdata=false)
{

	if(!$requestdata)
	{
		$requestdata=$_GET;
	}

	$where=[];

	foreach($requestdata as $k=>$v)
	{
		if(!check_isavailable($v))
		{
			continue;
		}

		if('_keyword'==$k&&$keywordfields)
		{
			$where[$keywordfields]=array(db_like,"%{$v}%");
		}
		else if(0===strpos($k,'_datebegin/'))
		{
			$temp=str_replace('_datebegin/','',$k);
			$where[$temp.'#0']=[db_egt,strtotime($v.' 00:00:00')];
		}
		else if(0===strpos($k,'_dateend/'))
		{
			$temp=str_replace('_dateend/','',$k);
			$where[$temp.'#1']=[db_elt,strtotime($v.' 23:59:59')];
		}
		else if
		(
			0===strpos($k,'_')||
			0===strpos($k,'@')
		)
		{//其他的如果是以_@开头的continue
			continue;
		}
		else
		{
			$where[$k]=$v;
		}
	}

	return $where;

}

