<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace _mobile_\controller\foreground\index;

trait Index_example
{

	function _example_html()
	{


		if(1)
		{
			$H.=_a('/example/widget_button','','','__pagemenu__=menu pm_rightarrow');
				$H.=_i__('','','','&#xf09f;');
				$H.=_span__('','','','按钮');
				$H.=_s__('','','','button');
			$H.=_a_();
			$H.=_a('/example/widget_pullrefresh','','','__pagemenu__=menu pm_rightarrow');
				$H.=_i__('','','','&#xf09f;');
				$H.=_span__('','','','下拉刷新/滚动加载');
				$H.=_s__('','','','pullrefresh/scrollappend');
			$H.=_a_();

			$H.=_a('/example/widget_sliderbox','','','__pagemenu__=menu pm_rightarrow');
				$H.=_i__('','','','&#xf09f;');
				$H.=_span__('','','','滑动单元格');
				$H.=_s__('','','','sliderbox');
			$H.=_a_();

			$H.=_a('/example/widget_picgallery','','','__pagemenu__=menu pm_rightarrow');
				$H.=_i__('','','','&#xf09f;');
				$H.=_span__('','','','图片浏览');
				$H.=_s__('','','','picgallery');
			$H.=_a_();
		}

		if(1)
		{
			$H.=_sep(20);


			$H.=_a('/example/widget_uploadfile','','','__pagemenu__=menu pm_rightarrow');
				$H.=_i__('','','','&#xf09f;');
				$H.=_span__('','','','上传文件');
				$H.=_s__('','','','uploadfile');
			$H.=_a_();

			$H.=_a('/example/widget_uploadpic','','','__pagemenu__=menu pm_rightarrow');
				$H.=_i__('','','','&#xf09f;');
				$H.=_span__('','','','上传图片');
				$H.=_s__('','','','uploadpic');
			$H.=_a_();

			$config=
			[
				'uploadavatartrigger_saveurl'=>'/example/widget_uploadavatar_1',
			];

			$H.=_a0('','','__pagemenu__=menu pm_rightarrow '.\_widget_\Widget::domtail('uploadavatartrigger',$config));
				$H.=_i__('','','','&#xf09f;');
				$H.=_span__('','','','上传头像');
				$H.=_s__('','','','uploadavatar');
			$H.=_a_();
		}
		if(1)
		{
			$H.=_sep(20);

			$H.=_a0('','','__pagemenu__=menu pm_rightarrow onclick="ui_alert(\'[error-0341]\')"');
				$H.=_i__('','','','&#xf09f;');
				$H.=_span__('','','','ui_alert');
			$H.=_a_();

			$H.=_a0('','','__pagemenu__=menu pm_rightarrow onclick="ui_confirm(\'[error-0343]\')"');
				$H.=_i__('','','','&#xf09f;');
				$H.=_span__('','','','ui_confirm');
			$H.=_a_();

			$H.=_a0('','','__pagemenu__=menu pm_rightarrow onclick="ui_toast(\'[error-4918]\')"');
				$H.=_i__('','','','&#xf09f;');
				$H.=_span__('','','','ui_toast');
			$H.=_a_();

		}

		if(1)
		{
			$H.=_sep(20);

			$H.=_a('/example/openpage','','','__pagemenu__=menu pm_rightarrow');
				$H.=_i__('','','','&#xf09f;');
				$H.=_span__('','','','打开页面(内部)');
			$H.=_a_();

			$H.=_a_external__('http://www.lovephp.com','','','__pagemenu__=menu pm_rightarrow',_i__('','','','&#xf09f;')._span__('','','','打开页面(app下/外部浏览器)'));
			$H.=_a_webview__('http://www.lovephp.com','','','__pagemenu__=menu pm_rightarrow',_i__('','','','&#xf09f;')._span__('','','','打开页面(app下/新webview)'));

		}

		if(1)
		{

			$temp=
			[
				'small_to_big',
				'left_to_right',
				'right_to_left',
				'bottom_to_top',
				'top_to_bottom',
			];

			$H.=_sep(20);

			foreach($temp as $v)
			{
				$H.=_a('/example/openmodal?effect='.$v,'','','__pagemenu__=menu pm_rightarrow');
					$H.=_i__('','','','&#xf09f;');
					$H.=_span__('','','','打开modal('.$v.')');
				$H.=_a_();
			}

		}

		$H.=_sep(80);

		return $H;

	}

}

