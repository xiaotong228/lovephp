
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


function connectlogin_action_switch(_this,index)
{

	var action=_this.attr('connectlogin_action_frame');

	if('login'==action)
	{
		__lpwidget__.tabshow.ts_switchframe_switch(_this.find('[tabshow_role=nav] >*').eq(0));
	}
	else if('regist'==action)
	{
		$('#connectregist_step_0').show();
		$('#connectregist_step_1').hide();
		_this.find('[__imgvcode__=imgvcode]').click();
	}
	else if('retrieve'==action)
	{
		$('#connectretrieve_step_0').show();
		$('#connectretrieve_step_1').hide();
		_this.find('[__imgvcode__=imgvcode]').click();
	}
	else
	{
		console_log_wreckage(54,'lovephp/0127/5754/不该走这');
	}

}
function connectlogin_login_switch(_this,index)
{
	_this.find('[__imgvcode__=imgvcode]').click();
}

function connectlogin_retrieve_done()
{
	console_log_wreckage('03','lovephp/0127/5003');

	ui_toast('密码已重置');

	__lpwidget__.tabshow.ts_switchframe_switch($('[__mobilepage__=mobilepage][pageroute_controller=connect][pageroute_action=login] [mobilepage_role=body] >[tabshow_role=nav] >*').eq(0));

}
