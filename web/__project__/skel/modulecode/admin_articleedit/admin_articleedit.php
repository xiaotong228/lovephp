<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



if($_GET['id'])
{
	$__article=\db\Article::find($_GET['id']);
}


htmlecho_js_addurl(ltrim(__vendor_dir__,'.').'/wangeditor/wangEditor.min.js');

$uploadconfig=\controller\foreground\Upload::uploadtoken_set(\Prjconfig::file_pic_exts,2*datasize_1mb,'article');
$uploadconfig['upload_url'].='&scene=wangeditor';

htmlecho_js_addvar('wangeditor_uploadconfig',$uploadconfig);

echo _module();

	echo \_widget_\Ajaxform::jswidget_ajaxform_begin(url_build('edit_1?id='.$_GET['id']));

		echo _div('g_form_edit');

			echo _div('singlelinez');

				echo _div__('leftlabel __musthave__','','','文章名称');
				echo _div('rightbdz');
					echo _input('article_title',$__article['article_title'],'','','','ajaxform_role=field');
				echo _div_();

			echo _div_();


			echo _div('singlelinez');
				echo _div__('leftlabel','','','文章分类');
				echo _div('rightbdz');
				echo _select('article_category',$__article['article_category']);
					foreach(\db\Article::category_namemap as $k=>$v)
					{
						echo _option($k,$v);
					}
				echo _select_();
				echo _div_();
			echo _div_();

			echo _div('singlelinez');
				echo _div__('leftlabel __musthave__','','','文章描述(seo)');
				echo _div('rightbdz');
					echo _textarea('article_desctxt',$__article['article_desctxt']);
				echo _div_();
			echo _div_();

			if(1)
			{
				$config=[];
				$config['@upload_config']=\controller\foreground\Upload::uploadtoken_set(\Prjconfig::file_pic_exts,4*datasize_1mb,'article');
				$config['uploadpic_filemaxnum']=1;
				$config['uploadpic_inputname']='article_thumb';

				echo _div('singlelinez');
					echo _div__('leftlabel __musthave__','','','文章缩略图');
					echo _div('rightbdz');
						echo \_widget_\Uploadpic::uploadpic_html($config,$__article['article_thumb']?[$__article['article_thumb']]:[]);
					echo _div_();
				echo _div_();
			}

			echo _div('singlelinez');

				echo _div('','','id=wangeditor_div');
					echo htmlentity_decode($__article['article_bodyhtml']);
//					echo '<p>欢迎使用 <b>wangEditor</b> 富文本编辑器</p>';
				echo _div_();
				echo _textarea('article_bodyhtml','','','','display:none;background:red;','id=wangeditor_textarea');
			echo _div_();

			echo _div('singlelinez');
				echo _div('rightbdz');

					echo _button('submit','确定','','','__button__="medium color0 solid w200" ');

				echo _div_();
			echo _div_();

		echo _div_();

	echo \_widget_\Ajaxform::jswidget_ajaxform_end();

echo _module_();

