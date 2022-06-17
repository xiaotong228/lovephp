<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace _mobile_\controller\foreground;

class Cluindex extends \controller\foreground\Cluindex
{

//1 index
	function index()
	{

		$__cludata=clu_data();

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','','账号设置'));

		if(1)
		{//__body__

			$H.=_div('','','mobilepage_role=body');

				if(1)
				{
					$H.=_sep(20);
					$H.=_div('','','__pagemenu__=menu');
						$H.=_span__('','','','UID');
						$H.=_s__('','','',$__cludata['id']);
					$H.=_div_();

					$H.=_a('/cluindex/username','','','__pagemenu__=menu pm_rightarrow');
						$H.=_span__('','','','用户名');
						$H.=_s__('','','__cluserdata__=user_name',$__cludata['user_name']);
					$H.=_a_();

					if(1)
					{
						$config=
						[
							'uploadavatartrigger_saveurl'=>'/cluindex/useravatar_1',
						];
						$H.=_div('','','__pagemenu__=menu pm_rightarrow '.\_widget_\Widget::domtail('uploadavatartrigger',$config));
							$H.=_span__('','','','头像');
							$H.=_img($__cludata['user_avatar'],'','','__cluserdata__=user_avatar');
						$H.=_div_();
					}

					$H.=_a('/cluindex/usermobile','','','__pagemenu__=menu pm_rightarrow');
						$H.=_span__('','','','手机号');
						$H.=_s__('','','__cluserdata__=user_mobile',\_lp_\Mask::mobile_num($__cludata['user_mobile']));
					$H.=_a_();
				}

				if(1)
				{
					$H.=_sep(20);

					$H.=_div('','','__pagemenu__=menu');
						$H.=_b__('','','','安全设置');
					$H.=_div_();

					$H.=_a('/cluindex/userpassword','','','__pagemenu__=menu pm_rightarrow');
						$H.=_span__('','','','登录密码');
							$H.=_s__('__color_link__','','','点击修改');
					$H.=_a_();
				}

				if(1)
				{
					$H.=_sep(60);

					$H.=_div('','','__pagemenu__=button');

						$H.=_a0__('','','__button__="big color0 solid" onclick="clu_connect_logout()" ','退出登录');

					$H.=_div_();
				}

			$H.=_div_();

		}

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}
//1 username
	function username()
	{

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','','编辑用户名'));

		if(1)
		{//__body__
			$H.=_div('','','mobilepage_role=body');

				$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin(url_build('username_1'));

				$H.=_sep(20);


				if(1)
				{
					$H.=_div('','','__pagemenu__=notice');
						$H.='用户名每'.\Prjconfig::clu_config['clu_editusername_firewall_day'].'天只可以编辑一次,请慎重<br>';
						$H.='2~16字之间,只能含有中英文数字下划线<br>不能以数字或下划线开头';
					$H.=_div_();

					if(1)
					{
						$H.=_div('','','__pagemenu__=edit');
							$H.=_span__('','','','新用户名');
							$H.=_input('user_name',clu_data()['user_name'],'点击输入用户名','','','__inputdefaultfocus__=inputdefaultfocus');
						$H.=_div_();
					}

					if(1)
					{
						$H.=_sep(60);

						$H.=_div('','','__pagemenu__=button');

							$H.=_button('submit','保存','','','__button__="big color0 solid"');

						$H.=_div_();
					}

				}

				$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

			$H.=_div_();
		}

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}
//1 usermobile
	function usermobile()
	{

		$__cludata=clu_data();

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','','设置手机号'));

		if(1)
		{//__body__
			$H.=_div('','','mobilepage_role=body');

				$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin(url_build('usermobile_1'));

					$H.=_sep(20);

					if(1)
					{
						$H.=_div('','','__pagemenu__=edit');
							$H.=_span__('','','','新手机号');
							$H.=_input('user_mobile','','请输入您想绑定的新手机','w100p');
						$H.=_div_();
					}

					if(1)
					{
						$H.=_div('','','__pagemenu__=edit');
							$H.=_span__('','','','图片验证码');
							$H.=_input('vcode_imgvcode','','请输入图片验证码');
							$H.=\_widget_\Widget::imgvcode_html();
						$H.=_div_();
					}

					if(1)
					{
						$H.=_div('','','__pagemenu__=edit');
							$H.=_span__('','','','短信验证码');
							$H.=_input('vcode_smsvcode','','请输入短信验证码');
//							$H.=\_widget_\Widget::imgvcode_html();
							$H.=\_widget_\Widget::smsvcode_html('smsvcode_clu_changemobile');
						$H.=_div_();
					}


					if(1)
					{
						$H.=_sep(60);

						$H.=_div('','','__pagemenu__=button');

							$H.=_button('submit','确定','','','__button__="big color0 solid"');

						$H.=_div_();
					}

				$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

			$H.=_div_();

		}

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);


	}

//1 userpassword
	function userpassword()
	{

		$__cludata=clu_data();

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','','设置登录密码'));

		if(1)
		{//__body__
			$H.=_div('__body__ __layout_sky1land0__ __bg_lightgrey_0__','overflow-y:auto;');

				if($__cludata['user_mobile'])
				{
					if(1)
					{
						$H.=_div('','','id=cluindexpassword_step_0');

							$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin(url_build('userpassword_1'));

								$H.=_sep(20);

								if(1)
								{

									$H.=_div('','','__pagemenu__=notice');
										$H.='我们将向您在本站绑定的手机&nbsp;'.\_lp_\Mask::mobile_num($__cludata['user_mobile']).'&nbsp;发送一条短信以验证您的身份';
									$H.=_div_();
								}

								if(1)
								{
									$H.=_div('','','__pagemenu__=edit');
										$H.=_span__('','','','图片验证码');
										$H.=_input('vcode_imgvcode','','请输入图片验证码');
										$H.=\_widget_\Widget::imgvcode_html();
									$H.=_div_();
								}
								if(1)
								{
									$H.=_div('','','__pagemenu__=edit');
										$H.=_span__('','','','短信验证码');
										$H.=_input('vcode_smsvcode','','请输入短信验证码');
										$H.=\_widget_\Widget::smsvcode_html('smsvcode_clu_changepassword');
									$H.=_div_();
								}
								if(1)
								{
									$H.=_sep(60);

									$H.=_div('','','__pagemenu__=button');

										$H.=_button('submit','确定','','','__button__="big color0 solid"');

									$H.=_div_();
								}

							$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

						$H.=_div_();
					}

					if(1)
					{
						$H.=_div('','display:none;','id=cluindexpassword_step_1');

							$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin(url_build('userpassword_2'));


								$H.=_sep(20);


								if(1)
								{
									$H.=_div('','','__pagemenu__=edit');
										$H.=_span__('','','','新密码');
										$H.=_input_password('password_0','','请输入新密码','w100p');
									$H.=_div_();
								}


								if(1)
								{
									$H.=_div('','','__pagemenu__=edit');
										$H.=_span__('','','','重复新密码');
										$H.=_input_password('password_1','','请输入重复新密码','w100p');
									$H.=_div_();
								}

								if(1)
								{
									$H.=_sep(60);

									$H.=_div('','','__pagemenu__=button');

										$H.=_button('submit','确定','','','__button__="big color0 solid"');

									$H.=_div_();
								}

							$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

						$H.=_div_();

					}


				}

				else
				{

					$H.=_div();

						$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin(url_build('userpassword_3'));


							$H.=_sep(20);

							if(1)
							{
								$H.=_div('','','__pagemenu__=edit');
									$H.=_span__('','','','当前密码');
									$H.=_input_password('password','','请输入当前密码','w100p');
								$H.=_div_();
							}

							if(1)
							{
								$H.=_div('','','__pagemenu__=edit');
									$H.=_span__('','','','新密码');
									$H.=_input_password('password_0','','请输入新密码','w100p');
								$H.=_div_();
							}


							if(1)
							{
								$H.=_div('','','__pagemenu__=edit');
									$H.=_span__('','','','重复新密码');
									$H.=_input_password('password_1','','请输入重复新密码','w100p');
								$H.=_div_();
							}

							if(1)
							{
								$H.=_sep(60);

								$H.=_div('','','__pagemenu__=button');

									$H.=_button('submit','确定','','','__button__="big color0 solid"');

								$H.=_div_();
							}

						$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

					$H.=_div_();

				}

			$H.=_div_();

		}

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}

}
