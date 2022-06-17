<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\foreground;

class Example extends super\Superforeground
{
	use \_lp_\controller\Supercontroller_treedata;

	function __construct()
	{
		parent::__construct();

		$this->treedata_filepath=__temp_dir__.'/example/'.date_str_num().'/'.session_id().'_treeshow.data';

		if(!is_file($this->treedata_filepath))
		{//可以直接关闭,展示空树状结构图

			$mother_filepath='./example/treedata_mother.data';
			fs_file_copy($mother_filepath,$this->treedata_filepath);
			fs_file_copy(path_ext_change($mother_filepath,'lastid.data'),path_ext_change($this->treedata_filepath,'lastid.data'));

		}

		$this->treedata_treeobj=new \_lp_\datamodel\Treedata($this->treedata_filepath);

		$this->uiwindowxml_filepath=__temp_dir__.'/example/'.date_str_num().'/'.session_id().'_uiwindowxml.data';

	}

	function index()
	{
		_skel();
	}
//1 examplejump
	function examplejump($key=0)
	{//示例跳转,随便传入key
		R_http_404(200,'跳转演示/key:'.$key);
	}
//1 ajaxform
	function ajaxform_1()
	{

		R_error('aaa','[error-1046]xxx');
		R_alert('[error-1046]');

	}
//1 avatar
	function avatar_set_1()
	{
		R_alert('[error-1718]'._an__($_POST['@uploadavatar_resultimgurl'],'','','',$_POST['@uploadavatar_resultimgurl']));
	}
//1 ui_window
	function ui_window()
	{

		$H.=_div__('logoz');

		if(1)
		{
			$imgs=[];

			$imgs[]='/assets/img/codelogo/php.svg';
			$imgs[]='/assets/img/codelogo/html5.svg';
			$imgs[]='/assets/img/codelogo/js.svg';
			$imgs[]='/assets/img/codelogo/jquery.svg';
			$imgs[]='/assets/img/codelogo/css3.svg';
			$imgs[]='/assets/img/codelogo/less.svg';

			$config=[];
			$config['sliderbox_effect']='leftloop';
			$config['sliderbox_ind_triggertype']='mouse';
			$config['sliderbox_ani_switchtime']=300;//动画切换时间
			$config['sliderbox_autoplay']=true;
			$config['sliderbox_autoplay_delaytime']=3000;
			$config['sliderbox_autoplay_hoverstop']=false;

			$frames=[];
			foreach($imgs as $k=>$v)
			{
				$frames[]=_div__('','background-image:url('.$v.');');
			}

			$tailhtml='';
			$tailhtml.=_div('','','sliderbox_role=ind');

				foreach($imgs as $k=>$v)
				{
					$tailhtml.=_a0__('','background-image:url('.$v.');','',path_filename_core($v));
				}

			$tailhtml.=_div_();

			$H.=\_widget_\Sliderbox::sliderbox_html($frames,$tailhtml,$config);

		}
		if(1)
		{
			$trigger=[];
			$layer=[];
			$config=[];

			$trigger['tag']='a';
			$trigger['tail']='__button__="medium color0 block solid" ';
			$trigger['inhtml']='hover触发/触发元素中上点和弹出元素中下点对齐';

			$layer['cls']='exampleindex_popupbox_layer';
			$layer['sty']='z-index:1010;width:auto;';

			$layer['inhtml'].=_span__('__color_orange__','font-size:14px;','','此弹出层不跟随文档滚动,适用于触发元素是fixed的情况<br>注意z-index覆盖');

			$config['popupbox_triggertype']='mouse';
			$config['popupbox_aligntype']='ct,cb';
			$config['popupbox_alignoffset']='0,0';
			$config['popupbox_layerfixed']=true;

			$H.=\_widget_\Popupbox::popupbox_html($trigger,$layer,$config);

		}

		if(1)
		{
				$config=[];

				$config['timecount_dir']='inc';
				$config['timecount_timebegin']=strtotime(date('Y',time()).'-1-1');
				$H.=_div('','',\_widget_\Widget::domtail('timecount',$config));
					$H.=_s__('','','','今年已经过去(正计时):');
					$H.=_b__('','','timecount_role=day');
					$H.=_span__('','','','天');
					$H.=_b__('','','timecount_role=hour');
					$H.=_span__('','','','时');
					$H.=_b__('','','timecount_role=min');
					$H.=_span__('','','','分');
					$H.=_b__('','','timecount_role=sec');
					$H.=_span__('','','','秒');
				$H.=_div_();
		}

		if(0)
		{
			$config=[];

			$config['limittextarea_maxlength']=100;

			$H.=_div('floorz');

				$H.=_div('','',\_widget_\Widget::domtail('limittextarea',$config));

					$H.=_textarea('limittextarea_1019','测试文本测试文本测试文本测试文本测试文本/error-0901','','','height:100px;padding:10px;');

					$H.=_div('','','limittextarea_role=ind');
					$H.=_div_();

				$H.=_div_();

				$H.=_div('group_tt');
					$H.='限定字数输入(limittextarea)';
				$H.=_div_();
			$H.=_div_();

		}

		if(0)
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

			$H.=_div('floorz');

				$H.=_div('','',\_widget_\Widget::domtail('numberrange',$config));

					$H.=_div__('','','numberrange_role=dec'.$tail_dec);

					$H.=_input('numberrange_2005',$config['numberrange_default']);

					$H.=_div__('','','numberrange_role=inc'.$tail_inc);

				$H.=_div_();

				$H.=_div('group_tt');
					$H.='数字范围输入(numberrange)';
				$H.=_div_();

			$H.=_div_();
		}

		$H.=_div__('sloganz','','',
				\Prjconfig::project_config['project_slogan'].
				'<br>'.\Prjconfig::project_config['project_officialsite']
				);

		$H.=_div__('','','uiwindow_role=close');

		$domset=[];
		$domset['cls']='exampleindex_uiwindow';

		R_window($H,$domset);

	}
	function ui_window_xml()
	{

		$data=fs_file_read_data($this->uiwindowxml_filepath,fs_loose);

		R_window_xml('./example/example.xml',url_build('ui_window_xml_1'),$data,math_salt());

	}
	function ui_window_xml_1()
	{

		fs_file_save_data($this->uiwindowxml_filepath,$_POST);

		R_jump('','[error-5951]已保存');

	}

//1 treeshow
	function treedata_nodemenu($dna)
	{

		$H.=_a0__('','','popupmenu_role=menu onclick="tree_oper(\'treedata_add\',\''.$dna.'\');"','添加');

		if(0==$dna)
		{

		}
		else
		{

			$H.=_a0__('','','popupmenu_role=menu onclick="tree_oper(\'treedata_edit\',\''.$dna.'\');"','编辑');
			$H.=_a0__('','','popupmenu_role=menu onclick="tree_oper(\'treedata_moveup\',\''.$dna.'\');"','上移一位');
			$H.=_a0__('','','popupmenu_role=menu onclick="tree_oper(\'treedata_movedown\',\''.$dna.'\');"','下移一位');
			$H.=_a0__('','','popupmenu_role=menu onclick="tree_oper(\'treedata_delete\',\''.$dna.'\',\'删除\');"','删除');

		}

		R_true($H);

	}
//1 popupmenu
	function popumenu_menu()
	{

		$H.=_a0__('','','popupmenu_role=menu onclick="alert(0);"','菜单0');
		$H.=_a0__('','','popupmenu_role=menu onclick="alert(1);"','菜单1');
		$H.=_a0__('','','popupmenu_role=menu onclick="alert(2);"','菜单2');
		$H.=_div__('','','popupmenu_role=sepline');
		$H.=_div__('','','popupmenu_role=text','示例文字0<br>示例文字1<br>示例文字2');
		$H.=_div__('','','popupmenu_role=sepline');
		$H.=_an__('/example/examplejump?key=2145','','','popupmenu_role=menu ','跳转');

		R_true($H);
	}


}
