<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace _mobile_\controller\foreground;

class Example extends \controller\foreground\Example
{

//1 button
	function widget_button()
	{


		$size_map=['small','medium','big',];

		$color_map=
		[

			'color0',
			'color1',

			'black',

			'red',
			'green',
			'blue',
			'yellow',

			'aqua',
			'fuchsia',
			'orange',
			'purple',
			'grey',

			cmd_sep,
		];
		foreach($color_map as $v)
		{
			if(cmd_sep===$v)
			{
				continue;
			}

			$color_map[]=$v.' solid';
		}

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','','按钮'));

		$H.=_div('','','mobilepage_role=body');

			$sep='';

			foreach($size_map as $v)
			{
				$H.=$sep;

				foreach($color_map as $vv)
				{
					if(cmd_sep===$vv)
					{
						$H.=_sep();
					}
					else
					{
						$button_set=$v.' '.$vv;
						$H.=_a0__('','','__button__="'.$button_set.'"',_i__('','','','&#xf092;').$button_set);
					}
				}

				$sep=_div__('sepline');
			}

		$H.=_div_();

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}

//1 pullrefresh
	function widget_pullrefresh($pullrefresh=0)
	{

		$pullrefresh_config=[];
		$pullrefresh_config['pullrefresh_refreshurl']=url_build('widget_pullrefresh?pullrefresh=1');

		$scrollappend_config=[];
		$scrollappend_config['scrollappend_loadurl']=url_build('widget_pullrefresh_scrollappend');
		$scrollappend_config['scrollappend_getpostdata']='examplewidget_getpostdata';

		$in_html=$this->widget_pullrefresh_inhtml();
		$dragbox_html.=_div('','','pullrefresh_role=dragbox '.\_widget_\Widget::domtail('scrollappend',$scrollappend_config));
			$dragbox_html.=$in_html;
		$dragbox_html.=_div_();

		if($pullrefresh)
		{
			$data=[];
			$data['pullrefresh_html']=$dragbox_html;
			$data['pullrefresh_successtips']='数据已更新';
			R_true($data);
		}

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','','下拉刷新/滚动加载'));

		$H.=_div('','','mobilepage_role=body');

			$H.=_div('','',\_widget_\Widget::domtail('pullrefresh',$pullrefresh_config));

				$H.=$dragbox_html;

			$H.=_div_();

		$H.=_div_();

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}
	function widget_pullrefresh_inhtml(&$nomoredata=0)
	{

		$npp=20;

		$p=floor($_POST['currentitemnum']/$npp);

		$H='';

		$colors=['red','green','blue'];

		$time=time_str();

		for($i=0;$i<20;$i++)
		{

			$H.=_div('','','__pagemenu__=menu');
				$H.=_span__('','color:'.$colors[$i%count($colors)],'','[error-2444]'.$p.'-'.$i);
				$H.=_s__('','','',$time);
			$H.=_div_();
		}

		if($p>=4)
		{
			$nomoredata=true;
		}

		return $H;

	}
	function widget_pullrefresh_scrollappend()
	{

		$nomoredata=false;

		$in_html=$this->widget_pullrefresh_inhtml($nomoredata);

		$data=[];
		$data['scrollappend_html']=$in_html;
		$data['scrollappend_nomoredata']=$nomoredata;

		R_true($data);

	}
//1 slider
	function widget_sliderbox()
	{

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','','滑动单元格'));

		$H.=_div('','','mobilepage_role=body');

			if(0)
			{
				for($i=0;$i<100;$i++)
				{
					$H.=math_salt().'<br>';
				}
			}

			if(1)
			{

				$imgs=[];

				$imgs[]='/assets/img/codelogo/php.svg';
				$imgs[]='/assets/img/codelogo/html5.svg';
				$imgs[]='/assets/img/codelogo/js.svg';

				$frames=[];
				foreach($imgs as $v)
				{
					$frames[]=_div__('','background-image:url('.$v.');');
				}

				$config=[];
				$config['sliderbox_autoplay']=false;
				$config['sliderbox_autoplay_delaytime']=3000;
				$config['sliderbox_ani_switchtime']=300;

				$H.=\_widget_\Sliderbox::sliderbox_html($frames,cmd_default,$config);

			}

			if(1)
			{
				$imgs=[];
				$imgs[]='/assets/img/codelogo/jquery.svg';
				$imgs[]='/assets/img/codelogo/css3.svg';
				$imgs[]='/assets/img/codelogo/less.svg';

				$frames=[];
				foreach($imgs as $v)
				{
					$frames[]=_div__('','background-image:url('.$v.');');
				}

				$config=[];
				$config['sliderbox_autoplay']=true;
				$config['sliderbox_autoplay_delaytime']=3000;
				$config['sliderbox_ani_switchtime']=300;

				$H.=\_widget_\Sliderbox::sliderbox_html($frames,cmd_default,$config);

			}

			if(0)
			{
				for($i=0;$i<100;$i++)
				{
					$H.=math_salt().'<br>';
				}
			}

		$H.=_div_();

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}

//1 picgallery
	function widget_picgallery()
	{

		$pics=
		[
			'/example/img/0.jpg',
			'/example/img/1.jpg',
			'/example/img/2.jpg',
			'/example/img/3.jpg',
			'/example/img/chaogao.jpg',
			'/example/img/chaokuan.jpg',
		];


		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','','图片浏览'));

		$H.=_div('','','mobilepage_role=body');

			$H.=_div('picsz');
				foreach($pics as $v)
				{
					$H.=_div('pic','background-image:url('.$v.');','onclick="example_picgallery_openpic(this)"');

					$H.=_div_();
				}
			$H.=_div_();

		$H.=_div_();

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}
	function widget_uploadfile()
	{

		$config=[];

		$config['@upload_config']=\controller\foreground\Upload::uploadtoken_set(['jpg','jpeg','png','bmp','gif','pdf','zip','rar','ppt','pptx','doc','docx','mp4','mov'],10*datasize_1mb,'example');

		$config['uploadfile_filemaxnum']=10;

		$config['uploadfile_inputname']='uploadfile_5111';
		$default_file_urls=
		[
			'/example/file/0.pptx',
			['/example/file/1.pptx','已上传文件1.pptx'],
			['/example/file/2.pptx','已上传文件2.pptx',9568],
		];

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','','上传文件'));

		$H.=_div('','','mobilepage_role=body');

			$H.=\_widget_\Uploadfile::uploadfile_html($config,$default_file_urls);

			$margin=mpx_to_vw(40);
			$H.=_a0__('','margin:'.$margin.' '.$margin.' 0 '.$margin,'__button__="big color0 solid" onclick="ui_alert(__lpwidget__.uploadfile.uf_getvalue($(this).closest(\'[mobilepage_role=body]\').find(\'[__uploadfile__=uploadfile]\')));"','取值');

		$H.=_div_();

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}
	function widget_uploadpic()
	{

		$config=[];

		$config['@upload_config']=\controller\foreground\Upload::uploadtoken_set(\Prjconfig::file_pic_exts,2*datasize_1mb,'example');

		$config['uploadpic_filemaxnum']=10;
		$config['uploadpic_inputname']='uploadpic_2011';
		$config['uploadpic_picmaxpixels']=1600*1200;//限定图片像素

		$default_file_urls=
		[
			'/example/img/0.jpg',
			'/example/img/1.jpg',
			'/example/img/2.jpg',
		];

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','','上传图片'));

		$H.=_div('','','mobilepage_role=body');

			$H.=\_widget_\Uploadpic::uploadpic_html($config,$default_file_urls);

			$margin=mpx_to_vw(40);
			$H.=_a0__('','margin:'.$margin.' '.$margin.' 0 '.$margin,'__button__="big color0 solid" onclick="ui_alert(__lpwidget__.uploadpic.up_getvalue($(this).closest(\'[mobilepage_role=body]\').find(\'[__uploadpic__=uploadpic]\')));"','取值');

		$H.=_div_();

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}
	function widget_uploadavatar_1()
	{

		$url=$_POST['@uploadavatar_resultimgurl'];

		$jscode='ui_confirm("[error-4935]是否现在查看?<br>'.$_POST['@uploadavatar_resultimgurl'].'",function()
		{
		
			__lpwidget__.picgallery.pg_open("'.$_POST['@uploadavatar_resultimgurl'].'");

		})';

		R_jscode($jscode);

	}

	function openpage($effect=false,$index=0)
	{

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','','打开新页面('.$index++.')'));

		$H.=_div('','','mobilepage_role=body');

			$H.=_sep(20);

			$H.=_a('/example/openpage?index='.$index,'','','__pagemenu__=menu pm_rightarrow');
				$H.=_span__('','','','打开新页面(右→左)');
			$H.=_a_();

			$H.=_a('/example/openpage?effect=left&index='.$index,'','','__pagemenu__=menu pm_rightarrow');
				$H.=_span__('','','','打开新页面(左→右)');
			$H.=_a_();


			$H.=_a('/example/openpage?effect=bottom&index='.$index,'','','__pagemenu__=menu pm_rightarrow');
				$H.=_span__('','','','打开新页面(下→上)');
			$H.=_a_();

			$H.=_a('/example/openpage?effect=top&index='.$index,'','','__pagemenu__=menu pm_rightarrow');
				$H.=_span__('','','','打开新页面(上→下)');
			$H.=_a_();

			$H.=_a('/example/openpage?effect=small&index='.$index,'','','__pagemenu__=menu pm_rightarrow');
				$H.=_span__('','','','打开新页面(小→大)');
			$H.=_a_();

			$H.=_sep(20);
			$H.=_div('','','__pagemenu__=text');
				$H.=time_str();
			$H.=_div_();

		$H.=_div_();

		if('left'==$effect)
		{
			\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal'],'position_left100','');
		}
		else if('bottom'==$effect)
		{
			\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal'],'position_bottom100','');
		}
		else if('top'==$effect)
		{
			\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal'],'position_top100','');
		}
		else if('small'==$effect)
		{
			\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal'],'position_centersmall','');
		}
		else
		{
			\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);
		}

	}
	function openmodal($effect)
	{

		$H='';

		$H.=_a0__('','','__button__="big color0 solid" mobilemodal_role=close','关闭');
		$H.='<br><br>';
		$H.=_a__('/example/openpage','__color_link__','','','打开页面(内部)');
		$H.='<br><br>';
		$H.=_a_external__('http://www.lovephp.com','__color_link__','','','打开页面(app下/外部浏览器)');
		$H.='<br><br>';
		$H.=_a_webview__('http://www.lovephp.com','__color_link__','','','打开页面(app下/新webview)');
		$H.='<br><br>';
		$H.=_a0__('__color_link__','','onclick="alert(\'[error-3546]\');" ','onclick响应');

		\_mobile_\Mobile::return_modal_open($H,['cls'=>'example_openmodal'],$effect,1);

	}

}
