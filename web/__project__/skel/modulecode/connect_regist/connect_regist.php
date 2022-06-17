<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



echo _module();

	if(route_judge(cmd_ignore,'connect','regist'))
	{

		$otheroper_html='';

		$otheroper_html.=_div('otheroperz');
			$otheroper_html.=_a__('/connect/login','','','','登录账号');
			$otheroper_html.=_a__('/connect/retrieve','','','','找回密码');
		$otheroper_html.=_div_();

		echo _div('mainz','','id=connectregist_step_0');

			echo _div('ttz','','');
				echo _b__('','','','注册账号(步骤1/2)');
			echo _div_();

			if(1)
			{

				echo _div('g_connect_loginbox','');

					if(1)
					{
						echo \_widget_\Ajaxform::jswidget_ajaxform_begin('/connect/regist_1');

							echo _div('singlelinez','','ajaxform_role=field');
								echo _i__('icon','','','&#xf084;');
								echo _input('user_mobile','','手机号');
							echo _div_();

							echo _div('singlelinez','','ajaxform_role=field');
								echo _i__('','','','&#xf077;');
								echo _input('vcode_imgvcode','','图片验证码','','width:177px;');
								echo \_widget_\Widget::imgvcode_html();
							echo _div_();

							echo _div('singlelinez','','ajaxform_role=field');

								echo _i__('','','','&#xf087;');

								echo _input('vcode_smsvcode','','短信验证码','','width:177px;');

								echo \_widget_\Widget::smsvcode_html('smsvcode_connect_regist');

							echo _div_();

							echo _div('agreelinez');
								echo _checkbox_1('agree',1,false,[],'我已阅读并同意:');
								echo _an__('/help/terms_service','','margin-left:10px;','',\controller\foreground\Help::service_title);
								echo _span__('','margin-left:10px;','','和');
								echo _an__('/help/terms_privacy','','margin-left:10px;','',\controller\foreground\Help::privacy_title);
							echo _div_();

							echo _button('submit','下一步','','margin-top:20px;','__button__="medium black solid block" ');

						echo \_widget_\Ajaxform::jswidget_ajaxform_end();
					}
					echo $otheroper_html;

				echo _div_();
			}

		echo _div_();

		echo _div('mainz','display:none;','id=connectregist_step_1');

			echo _div('ttz','','');
				echo _b__('','','','注册账号(步骤2/2)');
			echo _div_();

			if(1)
			{

				echo _div('g_connect_loginbox','');

					if(1)
					{
						echo \_widget_\Ajaxform::jswidget_ajaxform_begin('/connect/regist_2');

							echo _div('singlelinez','','ajaxform_role=field');
								echo _i__('icon','','','&#xf084;');
								echo _input('user_name','','您想注册的用户名');
							echo _div_();

							echo _div('singlelinez','','ajaxform_role=field');
								echo _i__('icon','','','&#xf081;');
								echo _input_password('password_0','','密码');
							echo _div_();

							echo _div('singlelinez','','ajaxform_role=field');
								echo _i__('icon','','','&#xf081;');
								echo _input_password('password_1','','重复密码');
							echo _div_();

							echo _button('submit','确定','','margin-top:20px;','__button__="medium black solid block" ');

						echo \_widget_\Ajaxform::jswidget_ajaxform_end();
					}

					echo $otheroper_html;

				echo _div_();

			}

		echo _div_();
	}
	else if(route_judge(cmd_ignore,'connect','retrieve'))
	{

		$otheroper_html='';

		$otheroper_html.=_div('otheroperz');
			$otheroper_html.=_a__('/connect/login','','','','登录账号');
			$otheroper_html.=_a__('/connect/regist','','','','注册账号');
		$otheroper_html.=_div_();

		echo _div('mainz','','id=connectretrieve_step_0');

			echo _div('ttz','','');
				echo _b__('','','','找回密码(步骤1/2)');
			echo _div_();

			if(1)
			{

				echo _div('g_connect_loginbox','');

					if(1)
					{
						echo \_widget_\Ajaxform::jswidget_ajaxform_begin('/connect/retrieve_1');

							echo _div('singlelinez','','ajaxform_role=field');
								echo _i__('icon','','','&#xf084;');
								echo _input('user_mobile','','您在本站注册的手机号');
							echo _div_();

							echo _div('singlelinez','','ajaxform_role=field');
								echo _i__('','','','&#xf077;');
								echo _input('vcode_imgvcode','','图片验证码','','width:177px;');
								echo \_widget_\Widget::imgvcode_html();
							echo _div_();

							echo _div('singlelinez','','ajaxform_role=field');

								echo _i__('','','','&#xf087;');

								echo _input('vcode_smsvcode','','短信验证码','','width:177px;');

								echo \_widget_\Widget::smsvcode_html('smsvcode_connect_retrieve');

							echo _div_();

							echo _button('submit','下一步','','margin-top:20px;','__button__="medium black solid block" ');

						echo \_widget_\Ajaxform::jswidget_ajaxform_end();
					}

					echo $otheroper_html;

				echo _div_();

			}

		echo _div_();

		echo _div('mainz','display:none;','id=connectretrieve_step_1');

			echo _div('ttz','','');
				echo _b__('','','','找回密码(步骤2/2)');
			echo _div_();

			if(1)
			{

				echo _div('g_connect_loginbox','');

					if(1)
					{
						echo \_widget_\Ajaxform::jswidget_ajaxform_begin('/connect/retrieve_2');


							echo _div('singlelinez','','ajaxform_role=field');
								echo _i__('icon','','','&#xf081;');
								echo _input_password('password_0','','输入新密码');
							echo _div_();

							echo _div('singlelinez','','ajaxform_role=field');
								echo _i__('icon','','','&#xf081;');
								echo _input_password('password_1','','重复新密码');
							echo _div_();

							echo _button('submit','确定','','margin-top:20px;','__button__="medium black solid block" ');

						echo \_widget_\Ajaxform::jswidget_ajaxform_end();
					}

					echo $otheroper_html;

				echo _div_();

			}

		echo _div_();

	}
	else
	{
		R_alert('[error-4923]');
	}

echo _module_();

