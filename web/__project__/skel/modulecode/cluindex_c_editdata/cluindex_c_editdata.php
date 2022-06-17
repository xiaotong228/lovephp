<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



function m_cluindex_usermobile()
{

	if(0)
	{
		$H.=_div__('c_warnbox','','','新增记录去列表尾部查看.&emsp;&emsp;删除后果:&emsp;&emsp;相关的商品品牌属性被清零;');
	}

	$H.=_div('g_module_header');
		$H.=_b__('','','','设置手机号');
	$H.=_div_();

	$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin(url_build('usermobile_1'));

		$H.=_div('g_form_edit');

			$H.=_div('singlelinez');

				$H.=_div__('leftlabel __musthave__','','','手机号');

				$H.=_div('rightbdz');
					$H.=_input('user_mobile','','','','','ajaxform_role=field');
				$H.=_div_();

			$H.=_div_();

			$H.=_div('singlelinez');
				$H.=_div__('leftlabel __musthave__','','','图片验证码');
				$H.=_div('rightbdz');
					$H.=_input('vcode_imgvcode','','','','width:140px;','ajaxform_role=fieldz');

					$H.=\_widget_\Widget::imgvcode_html();


				$H.=_div_();
			$H.=_div_();

			$H.=_div('singlelinez');

				$H.=_div__('leftlabel __musthave__','','','短信验证码');

				$H.=_div('rightbdz');
					$H.=_input('vcode_smsvcode','','','','width:140px;');
					$H.=\_widget_\Widget::smsvcode_html('smsvcode_clu_changemobile');
				$H.=_div_();

			$H.=_div_();

			$H.=_div('singlelinez');
				$H.=_div('rightbdz');
					$H.=_button('submit','确定','','','__button__="medium color0 solid w200" ');
				$H.=_div_();
			$H.=_div_();

		$H.=_div_();

	$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

	return $H;
}
function m_cluindex_userpassword()
{

	global $____controller;

	$H.=_div('g_module_header');
		$H.=_b__('','','','设置密码');
	$H.=_div_();


	$__cludata=clu_data();

	if($__cludata['user_mobile'])
	{//如果绑定了手机号

		if(1)
		{
			$H.=_div('c_warnbox');
			$H.=_span__('__color_orange__','','','我们将向您在本站绑定的手机&nbsp;'.\_lp_\Mask::mobile_num($__cludata['user_mobile']).'&nbsp;发送一条短信以验证您的身份');
			$H.=_div_();
		}

		$H.=_div('','','id=cluindexpassword_step_0');

			$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin(url_build('userpassword_1'));

				$H.=_div('g_form_edit');

					$H.=_div('singlelinez');
						$H.=_div__('leftlabel __musthave__','','','图片验证码');
						$H.=_div('rightbdz');
							$H.=_input('vcode_imgvcode','','','','width:140px;','ajaxform_role=fieldz');

							$H.=\_widget_\Widget::imgvcode_html();


						$H.=_div_();
					$H.=_div_();

					$H.=_div('singlelinez');

						$H.=_div__('leftlabel __musthave__','','','短信验证码');

						$H.=_div('rightbdz');
							$H.=_input('vcode_smsvcode','','','','width:140px;');
							$H.=\_widget_\Widget::smsvcode_html('smsvcode_clu_changepassword');
						$H.=_div_();

					$H.=_div_();

					$H.=_div('singlelinez');
						$H.=_div('rightbdz');
							$H.=_button('submit','确定','','','__button__="medium color0 solid w200" ');
						$H.=_div_();
					$H.=_div_();

				$H.=_div_();

			$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

		$H.=_div_();

		$H.=_div('','display:none;','id=cluindexpassword_step_1');

			$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin(url_build('userpassword_2'));

				$H.=_div('g_form_edit');

					$H.=_div('singlelinez');
						$H.=_div__('leftlabel __musthave__','','','新密码');

						$H.=_div('rightbdz');
							$H.=_input_password('password_0','','','','','ajaxform_role=fieldz');
						$H.=_div_();

					$H.=_div_();

					$H.=_div('singlelinez');

						$H.=_div__('leftlabel __musthave__','','','重复新密码');

						$H.=_div('rightbdz');
							$H.=_input_password('password_1','','','','','ajaxform_role=fieldz');
						$H.=_div_();

					$H.=_div_();

					$H.=_div('singlelinez');
						$H.=_div('rightbdz');
							$H.=_button('submit','确定','','','__button__="medium color0 solid w200" ');
						$H.=_div_();
					$H.=_div_();

				$H.=_div_();

			$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

		$H.=_div_();

	}
	else
	{

		$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin(url_build('userpassword_3'));

			$H.=_div('g_form_edit');

				$H.=_div('singlelinez');
					$H.=_div__('leftlabel __musthave__','','','当前密码');

					$H.=_div('rightbdz');
						$H.=_input_password('password','','','','','ajaxform_role=fieldz');
					$H.=_div_();

				$H.=_div_();

				$H.=_div('singlelinez');
					$H.=_div__('leftlabel __musthave__','','','新密码');

					$H.=_div('rightbdz');
						$H.=_input_password('password_0','','','','','ajaxform_role=fieldz');
					$H.=_div_();

				$H.=_div_();

				$H.=_div('singlelinez');

					$H.=_div__('leftlabel __musthave__','','','重复新密码');

					$H.=_div('rightbdz');
						$H.=_input_password('password_1','','','','','ajaxform_role=fieldz');
					$H.=_div_();

				$H.=_div_();

				$H.=_div('singlelinez');
					$H.=_div('rightbdz');
						$H.=_button('submit','确定','','','__button__="medium color0 solid w200" ');
					$H.=_div_();
				$H.=_div_();


			$H.=_div_();

		$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();
	}


	return $H;

}
function m_cluindex_username()
{

	$H.=_div('g_module_header');
		$H.=_b__('','','','更改用户名');
	$H.=_div_();

	if(1)
	{
		$H.=_div__('c_warnbox','','','用户名2~16字之间,只能含有中英文数字下划线,不能以数字或下划线开头,每'.\Prjconfig::clu_config['clu_editusername_firewall_day'].'天只能更改一次,请慎重');
	}

	$H.=\_widget_\Ajaxform::jswidget_ajaxform_begin(url_build('username_1'));

		$H.=_div('g_form_edit');

			$H.=_div('singlelinez');

				$H.=_div__('leftlabel __musthave__','','','新用户名');

				$H.=_div('rightbdz');
					$H.=_input('user_name','','','','','ajaxform_role=field');
				$H.=_div_();

			$H.=_div_();

			$H.=_div('singlelinez');
				$H.=_div('rightbdz');
					$H.=_button('submit','确定','','','__button__="medium color0 solid w200" ');
				$H.=_div_();
			$H.=_div_();

		$H.=_div_();

	$H.=\_widget_\Ajaxform::jswidget_ajaxform_end();

	return $H;
}
$func='m_'.__route_controller__.'_'.__route_action__;

echo _module();

	if(function_exists($func))
	{
		echo $func();
	}

echo _module_();

