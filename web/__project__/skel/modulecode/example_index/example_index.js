
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


function exampleindex_numberrange_setcallback(_widget,value)
{
	console_log_wreckage('35','lovephp/0221/1635/exampleindex_numberrange_setcallback',_widget,value);
}
function exampleindex_timecount_endcallback(_this)
{
	ui_alert('[error-0556]0#倒计时结束了');
}
function exampleindex_timecount_settime(_this,index)
{

	_this=$(_this);

	var time=prompt('输入时间(秒)');
	time=int_intval(time);

	if(time)
	{
		__lpwidget__.timecount.tc_restart(_this.closest('.floorz').find('[__timecount__=timecount]').eq(index),time);
	}

}
