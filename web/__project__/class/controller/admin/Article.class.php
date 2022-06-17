<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\admin;
class Article extends super\Superadmin
{

	function index()
	{
		_skel();
	}
	function delete_yes($id)
	{

		\db\Article::save_fieldset($id,'article_isdelete',1);

		R_jump();
	}
	function delete_no($id)
	{

		\db\Article::save_fieldset($id,'article_isdelete',0);

		R_jump();

	}
	function edit($id=0)
	{
		_skel();
	}
	function edit_1($id=0)
	{

		postdata_assert(
		[
			'article_title'=>'文章标题',
			'article_desctxt'=>'文章描述',
			'article_thumb'=>'文章缩略图',
			'article_bodyhtml'=>'文章内容',
		]);


		$data=[];
		$data['article_title']=$_POST['article_title'];
		$data['article_desctxt']=$_POST['article_desctxt'];
		$data['article_thumb']=$_POST['article_thumb'];
		$data['article_bodyhtml']=$_POST['article_bodyhtml'];

		$data['article_category']=$_POST['article_category'];

		if(!$id)
		{
			$data['aid']=clu_admin_id();
		}

		if($id)
		{
			\db\Article::save($id,$data);
		}
		else
		{
			$data['article_createtime']=time();
			\db\Article::add($data);
		}

		R_jump_module('/article','完成');

	}

}
