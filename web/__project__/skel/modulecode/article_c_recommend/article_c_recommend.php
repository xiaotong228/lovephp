<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

$mtts=['热门资讯','最新资讯'];

$__itemList=[];

$__db=\db\Article::db_instance();

$where=[];
$where['article_isdelete']=0;
if(0)
{
	$where['article_createtime']=[db_gt,time()-24*3600*30];
}

$__itemList[]=$__db->where($where)->orderBy('article_viewnum desc')->limit(5)->select();

$where=[];
$where['article_isdelete']=0;
$__itemList[]=$__db->where($where)->orderBy('id desc')->limit(5)->select();

if(route_judge(cmd_ignore,'article','article'))
{
	$sty='margin-top:74px;';
}
else
{
	$sty='';
}

echo _module('',$sty);

	foreach($mtts as $k=>$v)
	{
		echo _div('articlegroupz');

			echo _div__('mttz','','',_span__('','','',$v));

			foreach($__itemList[$k] as $item)
			{
				echo \db\Article::articlebox_recommend($item);
			}

		echo _div_();
	}

echo _module_();

