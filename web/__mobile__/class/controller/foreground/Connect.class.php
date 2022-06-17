<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _mobile_\controller\foreground;
class Connect extends \controller\foreground\Connect
{


//1 login
	function login()
	{

		$tabshow_config=[];

		$tabshow_config['tabshow_frame_activecallback']='connectlogin_action_switch';

		$H.=\_mobile_\Mobile::mobilepage_header();

		$H.=_div('','','mobilepage_role=body '.\_widget_\Widget::domtail('tabshow',$tabshow_config));

			$H.=_div__('logoz');

			$H.=_div('','','tabshow_role=viewzone');

				$H.=_div('','','connectlogin_action_frame=login');
					$H.=$this->login_login_inhtml();
				$H.=_div_();

				$H.=_div('','display:none;','connectlogin_action_frame=regist');
					$H.=$this->login_regist_inhtml();
				$H.=_div_();


				$H.=_div('','display:none;','connectlogin_action_frame=retrieve');
					$H.=$this->login_retrieve_inhtml();
				$H.=_div_();

			$H.=_div_();

			if(1)
			{
				$H.=_div('otheroperz','','tabshow_role=nav');
					$H.=_a0__('','','connectlogin_action_navitem=login tabshow_navstatus=active'		,'登录账号');
					$H.=_a0__('','','connectlogin_action_navitem=regist'		,'注册账号');
					$H.=_a0__('','','connectlogin_action_navitem=retrieve'		,'找回密码');
				$H.=_div_();
			}


		$H.=_div_();

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}

	function login_login_inhtml()
	{

		$config=[];

		$config['tabshow_frame_activecallback']='connectlogin_login_switch';

		$H.=_div('mainz','',\_widget_\Widget::domtail('tabshow',$config));

			if(1)
			{
				if(1)
				{
					$H.=_div('ttz');

						$H.=_b__('','','','登录');

						$H.=_div('','','tabshow_role=nav');
							$H.=_a0__('','','tabshow_navstatus=active','密码登录');
							$H.=_a0__('','','','短信登录');
						$H.=_div_();
					$H.=_div_();
				}

				if(1)
				{
					$H.=_div('bdz','','tabshow_role=viewzone');

						if(1)
						{
							$H.=_div('g_connect_loginbox bdz');

								if(1)
								{
									$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin('/connect/login_1_password');

										$H.=_div('singlelinez','','ajaxform_role=field');
											$H.=_i__('icon','','','&#xf07c;');
											$H.=_input('user_name','','用户名或手机号');
										$H.=_div_();

										$H.=_div('singlelinez','','ajaxform_role=field');
											$H.=_i__('','','','&#xf081;');
											$H.=_input_password('user_password','','密码');
										$H.=_div_();

										$H.=_div('singlelinez','','ajaxform_role=field');
											$H.=_i__('','','','&#xf077;');
											$H.=_input('vcode_imgvcode','','图片验证码','','width:177px;');
											$H.=\_widget_\Widget::imgvcode_html();
										$H.=_div_();


										$H.=_div('buttonlinez','','__buttonwrap__');
											$H.=_button('submit','登录','','','__button__="big color0 solid"');
										$H.=_div_();

									$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

								}

							$H.=_div_();

						}

						if(1)
						{

							$H.=_div('g_connect_loginbox bdz','display:none;');

								if(1)
								{
									$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin('/connect/login_1_smsvcode');

										$H.=_div('singlelinez','','ajaxform_role=field');
											$H.=_i__('icon','','','&#xf084;');
											$H.=_input('user_mobile','','手机号');
										$H.=_div_();

										$H.=_div('singlelinez','','ajaxform_role=field');
											$H.=_i__('','','','&#xf077;');
											$H.=_input('vcode_imgvcode','','图片验证码','','width:177px;');
											$H.=\_widget_\Widget::imgvcode_html_blank();
										$H.=_div_();

										$H.=_div('singlelinez','','ajaxform_role=field');

											$H.=_i__('','','','&#xf087;');

											$H.=_input('vcode_smsvcode','','短信验证码','','width:177px;');

											$H.=\_widget_\Widget::smsvcode_html('smsvcode_connect_login');

										$H.=_div_();


										$H.=_div('buttonlinez','','__buttonwrap__');
											$H.=_button('submit','登录','','','__button__="big color0 solid"');
										$H.=_div_();

									$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();
								}

							$H.=_div_();

						}

					$H.=_div_();
				}



			}
		$H.=_div_();

		return $H;

	}

	function login_regist_inhtml()
	{

		$H.=_div('mainz','','id=connectregist_step_0');

			$H.=_div('ttz','','');
				$H.=_b__('','','','注册账号(步骤1/2)');
			$H.=_div_();

			if(1)
			{

				$H.=_div('g_connect_loginbox bdz');

					if(1)
					{
						$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin('/connect/regist_1');

							$H.=_div('singlelinez','','ajaxform_role=field');
								$H.=_i__('icon','','','&#xf084;');
								$H.=_input('user_mobile','','手机号');
							$H.=_div_();

							$H.=_div('singlelinez','','ajaxform_role=field');
								$H.=_i__('','','','&#xf077;');
								$H.=_input('vcode_imgvcode','','图片验证码','','width:177px;');
								$H.=\_widget_\Widget::imgvcode_html_blank();
							$H.=_div_();

							$H.=_div('singlelinez','','ajaxform_role=field');

								$H.=_i__('','','','&#xf087;');

								$H.=_input('vcode_smsvcode','','短信验证码','','width:177px;');

								$H.=\_widget_\Widget::smsvcode_html('smsvcode_connect_regist');

							$H.=_div_();

							$H.=_div('agreelinez');

								$H.=_checkbox_1('agree',1,0,[],'我已阅读并同意:');

								$H.=_a__('/help/terms_service','','','',\controller\foreground\Help::service_title);
								$H.=_span__('','','','和');
								$H.=_a__('/help/terms_privacy','','','',\controller\foreground\Help::privacy_title);

							$H.=_div_();

							$H.=_div('buttonlinez','','__buttonwrap__');
								$H.=_button('submit','下一步','','','__button__="big color0 solid"');
							$H.=_div_();

						$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

					}

				$H.=_div_();

			}
		$H.=_div_();

		$H.=_div('mainz','display:none;','id=connectregist_step_1');

			$H.=_div('ttz','','');
				$H.=_b__('','','','注册账号(步骤2/2)');
			$H.=_div_();

			if(1)
			{

				$H.=_div('g_connect_loginbox bdz');

					if(1)
					{
						$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin('/connect/regist_2');

							$H.=_div('singlelinez','','ajaxform_role=field');
								$H.=_i__('icon','','','&#xf084;');
								$H.=_input('user_name','','您想注册的用户名');
							$H.=_div_();

							$H.=_div('singlelinez','','ajaxform_role=field');
								$H.=_i__('icon','','','&#xf081;');
								$H.=_input_password('password_0','','密码');
							$H.=_div_();

							$H.=_div('singlelinez','','ajaxform_role=field');
								$H.=_i__('icon','','','&#xf081;');
								$H.=_input_password('password_1','','重复密码');
							$H.=_div_();

							$H.=_div('buttonlinez','','__buttonwrap__');
								$H.=_button('submit','确定','','','__button__="big color0 solid"');
							$H.=_div_();

						$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

					}

				$H.=_div_();

			}

		$H.=_div_();

		return $H;

	}
	function login_retrieve_inhtml()
	{

		$H.=_div('mainz','','id=connectretrieve_step_0');

			$H.=_div('ttz','','');
				$H.=_b__('','','','找回密码(步骤1/2)');
			$H.=_div_();

			if(1)
			{

				$H.=_div('g_connect_loginbox bdz');

					if(1)
					{
						$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin('/connect/retrieve_1');

							$H.=_div('singlelinez','','ajaxform_role=field');
								$H.=_i__('icon','','','&#xf084;');
								$H.=_input('user_mobile','','您在本站注册的手机号');
							$H.=_div_();

							$H.=_div('singlelinez','','ajaxform_role=field');
								$H.=_i__('','','','&#xf077;');
								$H.=_input('vcode_imgvcode','','图片验证码','','width:177px;');
								$H.=\_widget_\Widget::imgvcode_html_blank();
							$H.=_div_();

							$H.=_div('singlelinez','','ajaxform_role=field');

								$H.=_i__('','','','&#xf087;');

								$H.=_input('vcode_smsvcode','','短信验证码','','width:177px;');

								$H.=\_widget_\Widget::smsvcode_html('smsvcode_connect_retrieve');

							$H.=_div_();

							$H.=_div('buttonlinez','','__buttonwrap__');
								$H.=_button('submit','下一步','','','__button__="big color0 solid"');
							$H.=_div_();

						$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();
					}

				$H.=_div_();

			}
		$H.=_div_();

		$H.=_div('mainz','display:none;','id=connectretrieve_step_1');

			$H.=_div('ttz','','');
				$H.=_b__('','','','找回密码(步骤2/2)');
			$H.=_div_();

			if(1)
			{

				$H.=_div('g_connect_loginbox bdz');

					if(1)
					{
						$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin('/connect/retrieve_2');


							$H.=_div('singlelinez','','ajaxform_role=field');
								$H.=_i__('icon','','','&#xf081;');
								$H.=_input_password('password_0','','输入新密码');
							$H.=_div_();

							$H.=_div('singlelinez','','ajaxform_role=field');
								$H.=_i__('icon','','','&#xf081;');
								$H.=_input_password('password_1','','重复新密码');
							$H.=_div_();

							$H.=_div('buttonlinez','','__buttonwrap__');
								$H.=_button('submit','确定','','','__button__="big color0 solid"');
							$H.=_div_();

						$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();
					}

				$H.=_div_();

			}
		$H.=_div_();

		return $H;

	}


}
