<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



$__cludata=\db\User::find(clu_id());

echo _module();


	echo _div('g_module_header');
		echo _b__('','','','账户信息');
	echo _div_();

	if(1)
	{

		echo _div('userinfogroupz');

			echo _div('groupbdz');
				echo _div__('leftz','','','UID:');
				echo _div('rightz');
					echo _i__('','','','&#xf078;')._span__('normaltxt','','',$__cludata['id']);
				echo _div_();
			echo _div_();

			echo _div('groupbdz');
				echo _div__('leftz','','','用户名:');
				echo _div('rightz');
					echo _i__('','','','&#xf07c;')._span__('normaltxt','','',$__cludata['user_name']);
					echo _a__(url_build('username'),'operbtn','','','更改用户名');
				echo _div_();
			echo _div_();

			echo _div('groupbdz');

				echo _div__('leftz','','','登录手机号:');

				echo _div('rightz');

					if($__cludata['user_mobile'])
					{
						echo _i__('','','','&#xf084;')._span__('normaltxt','','',\_lp_\Mask::mobile_num($__cludata['user_mobile']));
						echo _a__(url_build('usermobile'),'operbtn','','','设置手机号');
					}
					else
					{
						echo _i__('','','','&#xf084;')._span__('normaltxt __color_grey__','','','未设置');
						echo _a__(url_build('usermobile'),'operbtn','','','设置手机号');
					}

				echo _div_();

			echo _div_();
			echo _div('groupbdz');

				echo _div__('leftz','','','登录密码:');

				echo _div('rightz');
					if($__cludata['user_password_hash'])
					{
						echo _i__('_color_green_','','','&#xf081;')._span__('normaltxt','','','已设置');
						echo _a__(url_build('userpassword'),'operbtn','','','设置登录密码');
					}
					else
					{
						echo _i__('__color_grey__','','','&#xf081;')._span__('normaltxt __color_grey__','','','未设置');
						echo _a__(url_build('userpassword'),'operbtn','','','设置登录密码');
					}
				echo _div_();

			echo _div_();

		echo _div_();

	}

echo _module_();

