<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\foreground;

class Article extends super\Superforeground
{

	const article_countviewnum_maxnum=20;

	function index()
	{
		R_alert('[error-4140]废弃');
		_skel();
	}

	function article($id)
	{
		_skel();
	}
	function article_countviewnum($id)
	{

		$currentdata=session_get('article_countviewnum_session');

		if($currentdata&&in_array_1($id,$currentdata))
		{
		}
		else
		{
			$currentdata=array_pipe_push($currentdata,[$id],self::article_countviewnum_maxnum,1);
			\db\Article::save_fieldplus($id,'article_viewnum',1);
			session_set('article_countviewnum_session',$currentdata);
		}

		R_true();

	}
	static function article_countviewnum_hascount($id)
	{

		$currentdata=session_get('article_countviewnum_session');

		if($currentdata&&in_array_1($id,$currentdata))
		{
			return true;
		}
		else
		{
			return false;
		}

	}

}
