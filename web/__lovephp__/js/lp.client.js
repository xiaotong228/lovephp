
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

function client_is_mobile_js()
{
	return __lpvar__.client_clientinfo.is_mobile;
}
function client_is_app_js()
{
	if(1)
	{
		return __lpvar__.client_clientinfo.is_app;
	}
	else
	{
		return 'undefined'!==typeof(plus);
	}
}
function client_is_wap_js()
{
	return __lpvar__.client_clientinfo.is_wap;
}
function client_is_android_js()
{
	return __lpvar__.client_clientinfo.is_android;
}
function client_is_iphone_js()
{
	return __lpvar__.client_clientinfo.is_iphone;
}

function client_is_plus_js()
{
	return 'undefined'!==typeof(plus);
}

