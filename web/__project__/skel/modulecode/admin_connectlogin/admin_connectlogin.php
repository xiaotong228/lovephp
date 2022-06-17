<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



echo _module();

	if(1)
	{

		echo _div('mainz');

			echo _div('ttz');
				echo _span__('','','',\Prjconfig::project_config['project_name'].'/后台登录');
			echo _div_();

			if(1)
			{

				echo _div('admin_connectlogin_boxz');

					if(1)
					{
						echo \_widget_\Ajaxform::jswidget_ajaxform_begin('/'.__route_module__.'/connect/login_1');

							echo _div('singlelinez','','ajaxform_role=field');
								echo _i__('icon','','','&#xf07c;');
								echo _input('user_name','','用户名');
							echo _div_();

							echo _div('singlelinez','','ajaxform_role=field');
								echo _i__('','','','&#xf081;');
								echo _input_password('user_password','','密码');
							echo _div_();

							echo _div('singlelinez','','ajaxform_role=field');
								echo _i__('','','','&#xf077;');
								echo _input('vcode_imgvcode','','图片验证码','','width:177px');
								echo \_widget_\Widget::imgvcode_html();
							echo _div_();
							echo _button('submit','登录','','margin-top:20px;','__button__="medium black solid block" ');

						echo \_widget_\Ajaxform::jswidget_ajaxform_end();
					}

				echo _div_();

			}

		echo _div_();
	}

echo _module_();

