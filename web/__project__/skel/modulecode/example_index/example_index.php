<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

echo _module();

	echo _div('c_warnbox','margin-bottom:40px;');
		echo _span__('__color_orange__','','','本页所有的演示数据都会在关闭浏览器后丢失,上传的图片和文件也会隔天删除');
	echo _div_();

	if(1)
	{//1 db
		echo _div('floorz floor_svg');

			if(1)
			{
				echo _div__('__color_0__','','','直接用Superdb提供的静态方法');
				$temp=\db99\Example::find(2);
				var_dump($temp);
			}

			if(1)
			{
				echo _div__('__color_0__','margin-top:20px;','','用Superdb提供的Database对象(带缓存),此种情况依然会自动调整表结构和同步触发器,同时会自动转换db_table_serializedfileds定义的字段');
				$__db=\db99\Example::db_instance();
				$temp=$__db->orderby('id desc')->find();
				var_dump($temp);
			}

			if(1)
			{
				echo _div__('__color_0__','margin-top:20px;','','自行new一个Database对象(不带缓存),如果没有table_config参数的话,并不会自动调整表结构和同步触发器');
				$__db=new \_lp_\datamodel\Database(\Dbconfig::db_connect_main,'example');
				$temp=$__db->orderby('id asc')->find();
				var_dump($temp);
			}

			echo _div('group_tt');
				echo '数据库查询(db)';
			echo _div_();

		echo _div_();
	}

	if(1)
	{//1 tablelist
		$__table_header=
		[
			'ID'=>'100px',
			'字段0'=>'200px',
			'字段1'=>'200px',
			'字段2'=>false,
		];

		$__table_body=[];

		for($i=0;$i<10;$i++)
		{
			$temp=[];
			$temp[]=$i;
			for($j=0;$j<3;$j++)
			{
				$temp[]='值'.$i.'-'.$j;
			}
			$__table_body[]=$temp;

		}
		echo _div('floorz');

			echo \_widget_\Tablelist::tablelist_html($__table_header,$__table_body,1);
			echo _div('group_tt');
				echo '列表(tablelist)';
				echo _a0__('','','onclick="alert(__lpwidget__.tablelist.tl_getvalue($(this).closest(\'.floorz\').find(\'[__tablelist__=tablelist]\')));"','取值');
			echo _div_();

		echo _div_();

	}

	if(1)
	{//1 timecount
		echo _div('floorz floor_timecount');

			if(1)
			{//如果想做的细一些可以算好天时分秒的数据预先填到dom里面

				$config=[];

				$config['timecount_dir']='inc';
				$config['timecount_timebegin']=strtotime(date('Y',time()).'-1-1');

				echo _div('','',\_widget_\Widget::domtail('timecount',$config));
					echo _s__('','','','今年已经过去(正计时):');
					echo _b__('','','timecount_role=day');
					echo _span__('','','','天');
					echo _b__('','','timecount_role=hour');
					echo _span__('','','','时');
					echo _b__('','','timecount_role=min');
					echo _span__('','','','分');
					echo _b__('','','timecount_role=sec');
					echo _span__('','','','秒');
				echo _div_();

			}
			if(1)
			{
				$config=[];
				$config['timecount_dir']='dec';//方向,倒计时或者正向及时
				$config['timecount_timeend']=strtotime((date('Y',time())+1).'-1-1');
				$config['timecount_timeend_callback']='exampleindex_timecount_endcallback';

				echo _div('','margin-top:10px;',\_widget_\Widget::domtail('timecount',$config));
					echo _s__('','','','今年还剩时间(倒计时,不显示"天"):');
					echo _b__('','','timecount_role=hour');
					echo _span__('','','','时');
					echo _b__('','','timecount_role=min');
					echo _span__('','','','分');
					echo _b__('','','timecount_role=sec');
					echo _span__('','','','秒');
				echo _div_();

			}

			echo _div('group_tt');
				echo '计时器(timecount)';
				echo _a0__('','','onclick="exampleindex_timecount_settime(this,1)"','设置倒计时#1');
			echo _div_();

		echo _div_();

	}

	if(1)
	{//1 tabshow

		if(1)
		{

			$__frames=[];
			$__frames[]='示例内容0';
			$__frames[]='示例内容1';

			if(1)
			{
				$imgs=[];

				$imgs[]='/assets/img/codelogo/php.svg';
				$imgs[]='/assets/img/codelogo/html5.svg';
				$imgs[]='/assets/img/codelogo/js.svg';

				$config=[];

				$config['sliderbox_effect']='leftloop';
				$config['sliderbox_ind_triggertype']='mouse';
				$config['sliderbox_ani_switchtime']=300;//动画切换时间
				$config['sliderbox_autoplay']=true;
				$config['sliderbox_autoplay_delaytime']=3000;
				$config['sliderbox_autoplay_hoverstop']=true;

				$frames1=[];
				foreach($imgs as $k=>$v)
				{
					$frames1[]=_div__('','background-image:url('.$v.');');
				}

				$tailhtml='';
				$tailhtml.=_div__('','','sliderbox_role=prev');
				$tailhtml.=_div__('','','sliderbox_role=next');
				$tailhtml.=_div('','','sliderbox_role=ind');
					foreach($frames1 as $k=>$v)
					{
						$tailhtml.=_a0__('','','',$k);
					}
				$tailhtml.=_div_();

				$__frames[]=\_widget_\Sliderbox::sliderbox_html($frames1,$tailhtml,$config,['cls'=>'exampleindex_sliderboxcommon']);

			}

			echo _div('floorz floor_tabshow');

				if(1)
				{
					echo _div('','','__tabshow__=tabshow');

						echo _div('','','tabshow_role=nav');
							$tail='tabshow_navstatus=active';
							foreach($__frames as $k=>$v)
							{
								echo _a0__('','',$tail,'选项卡'.$k);
								$tail='';
							}
						echo _div_();

						echo _div('','','tabshow_role=viewzone');
							$sty='';
							foreach($__frames as $k=>$v)
							{
								echo _div('',$sty);
									echo $v;
								echo _div_();
								$sty='display:none;';
							}
						echo _div_();

					echo _div_();
				}
				if(1)
				{
					echo _div('','margin-left:20px;','__tabshow__=tabshow tabshow_triggertype=mouse');

						echo _div('','','tabshow_role=nav');
							$tail='tabshow_navstatus=active';
							foreach($__frames as $k=>$v)
							{
								echo _a0__('','',$tail,'选项卡'.$k);
								$tail='';
							}
						echo _div_();

						echo _div('','','tabshow_role=viewzone');
							$sty='';
							foreach($__frames as $k=>$v)
							{
								echo _div('',$sty);
									echo $v;
								echo _div_();
								$sty='display:none;';
							}
						echo _div_();

					echo _div_();
				}
				echo _div('group_tt');
					echo '选项卡切换(tabshow)&emsp;&emsp;0#click触发&emsp;&emsp;1#hover触发';
				echo _div_();


			echo _div_();

		}

	}


	if(1)
	{//1 sliderbox
		echo _div('floorz floor_sliderbox');
			if(1)
			{
				$imgs=[];

				$imgs[]='/assets/img/codelogo/php.svg';
				$imgs[]='/assets/img/codelogo/html5.svg';
				$imgs[]='/assets/img/codelogo/js.svg';

				$config=[];

				$config['sliderbox_effect']='leftloop';
				$config['sliderbox_ind_triggertype']='click';
				$config['sliderbox_ani_switchtime']=300;//动画切换时间
				if(0)
				{
					$config['sliderbox_autoplay']=true;
					$config['sliderbox_autoplay_delaytime']=3000;
					$config['sliderbox_autoplay_hoverstop']=true;
				}

				$frames=[];
				foreach($imgs as $k=>$v)
				{
					$frames[]=_div__('','background-image:url('.$v.');');
				}

				$tailhtml='';
				$tailhtml.=_div__('','','sliderbox_role=prev');
				$tailhtml.=_div__('','','sliderbox_role=next');
				$tailhtml.=_div('','','sliderbox_role=ind');
					foreach($frames as $k=>$v)
					{
						$tailhtml.=_a0__('','','',$k);
					}
				$tailhtml.=_div_();

				echo \_widget_\Sliderbox::sliderbox_html($frames,$tailhtml,$config,['cls'=>'exampleindex_sliderboxcommon']);

			}
			if(1)
			{
				$imgs=[];

				$imgs[]='/assets/img/codelogo/jquery.svg';
				$imgs[]='/assets/img/codelogo/css3.svg';
				$imgs[]='/assets/img/codelogo/less.svg';

				$config=[];

				$config['sliderbox_effect']='toploop';
				$config['sliderbox_ind_triggertype']='mouse';
				$config['sliderbox_ani_switchtime']=300;//动画切换时间
				$config['sliderbox_autoplay']=true;
				$config['sliderbox_autoplay_delaytime']=3000;
				$config['sliderbox_autoplay_hoverstop']=true;

				$frames=[];
				foreach($imgs as $k=>$v)
				{
					$frames[]=_div__('','background-image:url('.$v.');');
				}

				$tailhtml='';
				$tailhtml.=_div__('','','sliderbox_role=prev');
				$tailhtml.=_div__('','','sliderbox_role=next');
				$tailhtml.=_div('','','sliderbox_role=ind');
					foreach($frames as $k=>$v)
					{
						$tailhtml.=_a0__('','','',$k);
					}
				$tailhtml.=_div_();

				echo \_widget_\Sliderbox::sliderbox_html($frames,$tailhtml,$config,['cls'=>'exampleindex_sliderboxcommon']);

			}

			echo _div('group_tt');
				echo '轮播(sliderbox)&emsp;&emsp;0#左右切换/指示器click触发/不自动轮播&emsp;&emsp;1#上下切换/指示器hover触发/自动轮播/鼠标悬浮暂停自动播放';
			echo _div_();

		echo _div_();

	}
	if(1)
	{//1 popupbox

		echo _div('floorz floor_popupbox');

			if(1)
			{
				$trigger=[];
				$layer=[];
				$config=[];

				$trigger['tag']='a';
				$trigger['cls']='';
				$trigger['sty']='';
				$trigger['tail']='__button__="medium color0 solid" ';
				$trigger['inhtml']='click触发/触发元素左下角和弹出元素左上角对齐';

				$layer['cls']='exampleindex_popupbox_layer';
				$layer['inhtml'].=_span__('__color_orange__','font-size:14px;','','内嵌其他widget时会自动初始化');

				$config['popupbox_triggertype']='click';
				$config['popupbox_aligntype']='lb,lt';
				$config['popupbox_alignoffset']='0,0';

				if(1)
				{
					$imgs=[];

					$imgs[]='/assets/img/codelogo/php.svg';
					$imgs[]='/assets/img/codelogo/html5.svg';
					$imgs[]='/assets/img/codelogo/js.svg';

					$config_1=[];
					$config_1['sliderbox_effect']='leftloop';
					$config_1['sliderbox_ind_triggertype']='mouse';
					$config_1['sliderbox_ani_switchtime']=300;//动画切换时间
					$config_1['sliderbox_autoplay']=true;
					$config_1['sliderbox_autoplay_delaytime']=3000;
					$config_1['sliderbox_autoplay_hoverstop']=true;

					$frames=[];
					foreach($imgs as $k=>$v)
					{
						$frames[]=_div__('','background-image:url('.$v.');');
					}

					$tailhtml='';
					$tailhtml.=_div__('','','sliderbox_role=prev');
					$tailhtml.=_div__('','','sliderbox_role=next');
					$tailhtml.=_div('','','sliderbox_role=ind');
						foreach($frames as $k=>$v)
						{
							$tailhtml.=_a0__('','','',$k);
						}
					$tailhtml.=_div_();

					$layer['inhtml'].=\_widget_\Sliderbox::sliderbox_html($frames,$tailhtml,$config_1,[
							'cls'=>'exampleindex_sliderboxcommon',
							'sty'=>'margin-top:10px;'
						]);
				}

				echo \_widget_\Popupbox::popupbox_html($trigger,$layer,$config);

			}

			if(1)
			{
				$trigger=[];
				$layer=[];
				$config=[];

				$trigger['tag']='a';
				$trigger['cls']='';
				$trigger['sty']='';
				$trigger['tail']='__button__="medium color0 solid" ';
				$trigger['inhtml']='hover触发/触发元素右下角和弹出元素右上角对齐';

				$layer['cls']='exampleindex_popupbox_layer';
				$layer['inhtml'].=_span__('__color_orange__','font-size:14px;','','内嵌其他widget时会自动初始化');

				if(1)
				{
					$imgs=[];

					$imgs[]='/assets/img/codelogo/php.svg';
					$imgs[]='/assets/img/codelogo/html5.svg';
					$imgs[]='/assets/img/codelogo/js.svg';

					$config_1=[];
					$config_1['sliderbox_effect']='leftloop';
					$config_1['sliderbox_ind_triggertype']='mouse';
					$config_1['sliderbox_ani_switchtime']=300;//动画切换时间
					$config_1['sliderbox_autoplay']=true;
					$config_1['sliderbox_autoplay_delaytime']=3000;
					$config_1['sliderbox_autoplay_hoverstop']=true;

					$frames=[];
					foreach($imgs as $k=>$v)
					{
						$frames[]=_div__('','background-image:url('.$v.');');
					}

					$tailhtml='';
					$tailhtml.=_div__('','','sliderbox_role=prev');
					$tailhtml.=_div__('','','sliderbox_role=next');
					$tailhtml.=_div('','','sliderbox_role=ind');
						foreach($frames as $k=>$v)
						{
							$tailhtml.=_a0__('','','',$k);
						}
					$tailhtml.=_div_();

					$layer['inhtml'].=\_widget_\Sliderbox::sliderbox_html($frames,$tailhtml,$config_1,[
							'cls'=>'exampleindex_sliderboxcommon',
							'sty'=>'margin-top:10px;'
						]);
				}

				$config['popupbox_triggertype']='mouse';
				$config['popupbox_aligntype']='rb,rt';
				$config['popupbox_alignoffset']='0,0';

				echo \_widget_\Popupbox::popupbox_html($trigger,$layer,$config);

			}

			echo _div('group_tt');
				echo '弹出框(popupbox)';
			echo _div_();
		echo _div_();

	}

	if(1)
	{

		$config=[];
		$config['treeshow_nodepopupmenuurl']='/example/treedata_nodemenu';
		$config['treeshow_updatehtmlurl']='/example/treedata_html_update';

		echo _div('floorz');

			echo $____controller->treedata_html(2);

			echo _div('group_tt');
				echo '树形数据(treeshow),右键节点操作';
			echo _div_();

		echo _div_();
	}

	if(1)
	{

		$config=[];

		$config['@upload_config']=\controller\foreground\Upload::uploadtoken_set(['jpg','jpeg','png','bmp','pdf','zip','rar','ppt','pptx','doc','docx'],10*datasize_1mb,'example');

		$config['uploadfile_filemaxnum']=10;

		$config['uploadfile_inputname']='uploadfile_4654';
		$default_file_urls=
		[
			'/example/file/0.pptx',
			['/example/file/1.pptx','已上传文件1.pptx'],
			['/example/file/2.pptx','已上传文件2.pptx',9568],

		];

		echo _div('floorz');

			echo \_widget_\Uploadfile::uploadfile_html($config,$default_file_urls);

			echo _div('group_tt','','','上传文件(uploadfile)');
				echo '上传文件(uploadfile)';
				echo _a0__('','','onclick="alert(__lpwidget__.uploadfile.uf_getvalue($(this).closest(\'.floorz\').find(\'[__uploadfile__=uploadfile]\')));"','取值');
			echo _div_();

		echo _div_();

	}

	if(1)
	{

		$maxpixels=1600*1200;

		$config=[];
		$config['@upload_config']=\controller\foreground\Upload::uploadtoken_set(\Prjconfig::file_pic_exts,2*datasize_1mb,'example');

		$config['uploadpic_filemaxnum']=10;
		$config['uploadpic_picmaxpixels']=$maxpixels;
		$config['uploadpic_inputname']='uploadpic_2011';

		$default_file_urls=
		[
			'/example/img/0.jpg',
			'/example/img/1.jpg',
			'/example/img/2.jpg',
		];

		echo _div('floorz');
			echo \_widget_\Uploadpic::uploadpic_html($config,$default_file_urls);
			echo _div('group_tt');
				echo '上传图片(uploadpic,像素数超过'.$maxpixels.'会被自动缩小)';
				echo _a0__('','','onclick="alert(__lpwidget__.uploadpic.up_getvalue($(this).closest(\'.floorz\').find(\'[__uploadpic__=uploadpic]\')));"','取值');
			echo _div_();
		echo _div_();

	}
	if(1)
	{

		$config=[];
		$config['uploadavatar_saveurl']='/example/avatar_set_1';

		echo _div('floorz');

			echo \_widget_\Uploadavatar::uploadavatar_html($config);
			echo _div('group_tt');
				echo '上传头像(uploadavatar)';
			echo _div_();
		echo _div_();

	}

	if(1)
	{

		$config=[];
		$config['stickybox_offsety']=0;

		echo _div('floorz');
			echo _div('','',\_widget_\Widget::domtail('stickybox',$config));
				echo _div('','','stickybox_role=viewzone');
					echo 'stickybox';
				echo _div_();
			echo _div_();

			echo _div__('group_tt','','','粘性单元格(stickybox)');
		echo _div_();

	}

	if(1)
	{

		echo _div('floorz floor_button');


			$size_map=['small','medium','big',];

			$color_map=
			[

				'color0 w200',
				'color1 w200',

				'black w200',

				'red w200',
				'green w200',
				'blue w200',
				'yellow w200',

				'aqua w200',
				'fuchsia w200',
				'orange w200',
				'purple w200',
				'grey w200',

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

			$sep='';

			foreach($size_map as $v)
			{
				echo $sep;

				foreach($color_map as $vv)
				{
					if(cmd_sep===$vv)
					{
						echo _sep();
					}
					else
					{

						$button_set=$v.' '.$vv;
						echo _a0__('','','__button__="'.$button_set.'"',_i__('','','','&#xf092;').$button_set);
					}
				}

				$sep=_div__('sepline');

			}


			echo _div__('group_tt','','','按钮(button)');

		echo _div_();
	}


	if(1)
	{

		echo _div('floorz');
			if(1)
			{
				$items=['A','B','C','D'];

				echo _div('','','__selectitem__=selectitem');
					$tail=' selectitem_status=active';
					foreach($items as $k=>$v)
					{
						echo _a0__('','','selectitem_role=item'.$tail,$k.'/单选/'.$v);
						$tail='';
					}

					echo _input_hidden('selectitem_0507',0,'','','background:red;');//如果需要input承载当前选择值的话,便于form提交之类的
				echo _div_();
			}
			if(1)
			{
				$items=['A','B','C','D'];
				echo _div('','margin-top:20px;','__selectitem__=selectitem selectitem_mode=multi');
					foreach($items as $k=>$v)
					{
						echo _a0__('','','selectitem_role=item selectitem_value='.$v,$k.'/多选/'.$v);
					}
					echo _input_hidden('selectitem_0535','','','','background:red;');
				echo _div_();
			}

			echo _div('group_tt');
				echo '选择项目(selectitem)';

				echo _a0__('','','onclick="
					alert(__lpwidget__.selectitem.si_getvalue($(this).closest(\'.floorz\').find(\'[__selectitem__=selectitem]\').eq(0)));
					"','取值#单选');
				echo _a0__('','','onclick="
					alert(__lpwidget__.selectitem.si_getvalue($(this).closest(\'.floorz\').find(\'[__selectitem__=selectitem]\').eq(1)));
					"','取值#多选');

			echo _div_();

		echo _div_();

	}

	if(1)
	{
		echo _div('floorz floor_button');

			echo _a0__('','','__button__="small color0 solid" onclick="ajax_async(\'/example/ui_window\');"','ui_window(内嵌其他widget时会自动初始化)');

			echo _a0__('','','__button__="small color0 solid" onclick="ajax_async(\'/example/ui_window_xml\');"','ui_window_xml(通用xml配置)');

			echo _a0__('','','__button__="small color0 w150" onclick="

				ui_alert(\'[error-2144]\',function()
				{
					ui_toast(\'点击了确定\');
				});

				"','ui_alert');

			echo _a0__('','','__button__="small color0 w150" onclick="
				ui_confirm(\'[error-2416]\',function()
				{
					ui_toast(\'点击了确定\');
				});
				"','ui_confirm');

			echo _a0__('','','__button__="small color0 w150" onclick="

				ui_toast(\'[error-4036]\');

				"','ui_toast');

			echo _div('group_tt');
				echo 'ui交互(ui)';
			echo _div_();

		echo _div_();
	}

	if(1)
	{
		echo _div('floorz floor_toggleshow','','__toggleshow__=toggleshow toggleshow_status=active');

				echo _div('','','toggleshow_role=blinkzone');
					echo math_salt();
				echo _div_();
			echo _div('group_tt');
				echo '显隐框(toggleshow)';
				echo _a0__('','','toggleshow_role=trigger','显隐切换');
			echo _div_();

		echo _div_();
	}


	if(1)
	{
		echo _div('floorz floor_button');

			echo _a0__('','','__button__="small color0 w150" onclick="
				__lpwidget__.popupmenu.pm_open(event,\'/example/popumenu_menu\');
				"','弹出菜单');

			echo _div('group_tt');
				echo '弹出菜单(popupmenu)';
			echo _div_();

		echo _div_();
	}
	if(1)
	{

		$config=[];

		$config['limittextarea_maxlength']=100;

		echo _div('floorz');

			echo _div('','',\_widget_\Widget::domtail('limittextarea',$config));

				echo _textarea('limittextarea_1019','测试文本测试文本测试文本测试文本测试文本/error-0901','','','height:100px;padding:10px;');

				echo _div('','','limittextarea_role=ind');
				echo _div_();

			echo _div_();

			echo _div('group_tt');
				echo '限定字数输入(limittextarea)';
			echo _div_();
		echo _div_();

	}

	if(1)
	{

		$config=[];
		$config['numberrange_min']=1;
		$config['numberrange_max']=100;
		$config['numberrange_default']=1;
		$config['numberrange_callback']='exampleindex_numberrange_setcallback';

		if(!$config['numberrange_default'])
		{
			$config['numberrange_default']=$config['numberrange_min'];
		}

		$tail_dec='';
		$tail_inc='';

		if($config['numberrange_default']<=$config['numberrange_min'])
		{//想做的细一点可以判断下增减按钮的默认状态是啥
			$tail_dec=' numberrange_status=disable';
		}

		if($config['numberrange_default']>=$config['numberrange_max'])
		{
			$tail_inc=' numberrange_status=disable';
		}

		echo _div('floorz');

			echo _div('','',\_widget_\Widget::domtail('numberrange',$config));

				echo _div__('','','numberrange_role=dec'.$tail_dec);

				echo _input('numberrange_2005',$config['numberrange_default']);

				echo _div__('','','numberrange_role=inc'.$tail_inc);

			echo _div_();

			echo _div('group_tt');
				echo '数字范围输入(numberrange)';
			echo _div_();

		echo _div_();
	}

	if(1)
	{//1 svg
		echo _div('floorz floor_svg');

			if(0)
			{
				echo _img('/assets/img/ring/ring.pullrefreshloading_1.svg');
			}

			echo fs_file_read_xml('./assets/img/ring/ring.pullrefreshloading.svg');

			echo fs_file_read_xml('./assets/img/ring/ring.uploadprogress.svg');

			echo _div('group_tt');

				echo 'svg';

				echo _a0__('','','onclick="$(this).closest(\'.floorz\').find(\'[__svg__=ring_pullrefreshloading] .svg_1 \').toggleClass(\'svg_ani_runing\');"','启停动画');

				for($i=0;$i<=100;$i+=25)
				{
					echo _a0__('','','onclick="
								$(this).closest(\'.floorz\').find(\'[__svg__=ring_uploadprogress]\').removeClass(\'svg_done\');
								__lpwidget__._upload_commonuse.svgprogress_setpercent($(this).closest(\'.floorz\').find(\'[__svg__=ring_uploadprogress]\'),'.$i.');"',
								$i.'%');
				}

				echo _a0__('','','onclick="
							__lpwidget__._upload_commonuse.svgprogress_setpercent($(this).closest(\'.floorz\').find(\'[__svg__=ring_uploadprogress]\'),100);
							__lpwidget__._upload_commonuse.svgprogress_setdone($(this).closest(\'.floorz\').find(\'[__svg__=ring_uploadprogress]\'),'.$i.');"',
							'完成');

			echo _div_();

		echo _div_();
	}


echo _module_();

