<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

$otheroper_html='';

$otheroper_html.=_div('otheroperz');
	$otheroper_html.=_a__('/connect/regist','','','','注册账号');
	$otheroper_html.=_a__('/connect/retrieve','','','','找回密码');
$otheroper_html.=_div_();

echo _module();

	if(1)
	{

		echo _div('mainz','','__tabshow__=tabshow');


			if(1)
			{
				if(1)
				{
					echo _div('ttz','','');
						echo _b__('','','','登录');
						echo _div('','','tabshow_role=nav');
							echo _a0__('','','onclick="connectlogin_loginmode_switch(this,0)" tabshow_navstatus=active','密码登录');
							echo _a0__('','','onclick="connectlogin_loginmode_switch(this,1)"','短信登录');
						echo _div_();
					echo _div_();
				}

				if(1)
				{
					echo _div('','','tabshow_role=viewzone');
						if(1)
						{
							echo _div('g_connect_loginbox');

								if(1)
								{
									echo \_widget_\Ajaxform::jswidget_ajaxform_begin('/connect/login_1_password?_continue='.urlencode($_GET['_continue']));

										echo _div('singlelinez','','ajaxform_role=field');
											echo _i__('icon','','','&#xf07c;');
											echo _input('user_name','','用户名或手机号');
										echo _div_();

										echo _div('singlelinez','','ajaxform_role=field');
											echo _i__('','','','&#xf081;');
											echo _input_password('user_password','','密码');
										echo _div_();

										echo _div('singlelinez','','ajaxform_role=field');
											echo _i__('','','','&#xf077;');
											echo _input('vcode_imgvcode','','图片验证码','','width:177px;');
											echo \_widget_\Widget::imgvcode_html();
										echo _div_();

										echo _button('submit','登录','','margin-top:20px;','__button__="medium black solid block" ');

									echo \_widget_\Ajaxform::jswidget_ajaxform_end();
								}
								echo $otheroper_html;

							echo _div_();

						}

						if(1)
						{

							echo _div('g_connect_loginbox','display:none;');

								if(1)
								{
									echo \_widget_\Ajaxform::jswidget_ajaxform_begin('/connect/login_1_smsvcode?_continue='.urlencode($_GET['_continue']));

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

											echo \_widget_\Widget::smsvcode_html('smsvcode_connect_login');

										echo _div_();

										echo _button('submit','登录','','margin-top:20px;','__button__="medium black solid block" ');

									echo \_widget_\Ajaxform::jswidget_ajaxform_end();
								}
								echo $otheroper_html;
							echo _div_();

						}

					echo _div_();
				}

			}

		echo _div_();

	}

echo _module_();

