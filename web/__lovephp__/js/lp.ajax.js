
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


function ajax_async
(

	__url,

	__postdata=false,

	__on_true=false,

	__on_false=false,

	__ajax_setting=false

)
{

	if(__lpvar__.ajax_preloaddata&&__lpvar__.ajax_preloaddata[__url])
	{
		ajax_on_success(__lpvar__.ajax_preloaddata[__url]);
		return;
	}

	if('undefined'!==typeof(alp_isalp))
	{
		if(client_is_mobile_js()&&alp_isalp()&&0==__url.indexOf('/'))
		{

			if(__ajax_setting.ajax_on_error)
			{
				console_log_wreckage('59','lovephp/0326/ajax_on_errorajax_on_errorajax_on_errorajax_on_error');
				function_call(__ajax_setting.ajax_on_error);
			}
			if(__ajax_setting.ajax_on_complete)
			{
				console_log_wreckage('57','lovephp/0326/ajax_on_completeajax_on_completeajax_on_completeajax_on_complete');
				function_call(__ajax_setting.ajax_on_complete);
			}

			alp_tryconnectserver(__url);

			return;

		}
	}

	var __setting_base=
	{

		type:'post',

		url:__url,

		timeout:<?php echo \Prjconfig::ajax_requesttimeout*1000;?>,

		success:function(data,textstatus,jqxhr)
		{

			if(1)
			{
				if('string'==typeof(data))
				{
					try
					{
						data=JSON.parse(data)
					}
					catch(e)
					{
						ui_toast(e.message);
						return;
					}
				}
				if('object'==typeof(data))
				{
				}
				else
				{
					ui_toast('[error-1843]数据获取错误:'+data);
					return;
				}
			}

			if(__ajax_setting.ajax_on_complete_before)
			{
				__ajax_setting.ajax_on_complete_before(data);
			}

			console_log_wreckage('59','lovephp/ajax_async/success',data);

			ajax_on_success(data,__on_true,__on_false);

		},

		error:function
		(
			jqxhr,
			textstatus,
			errorthrown
		)
		{

			console_log_wreckage('17','lovephp/ajax/error',[jqxhr,textstatus,errorthrown]);
			if('abort'==textstatus)
			{//正在请求的时候刷新页面算abort
				if(__ajax_setting.ajax_on_abort)
				{
					function_call(__ajax_setting.ajax_on_abort,jqxhr,textstatus,errorthrown);
				}
			}
			else
			{

				if(__ajax_setting.ajax_on_error&&cmd_ajax_nodefaulterrortips===function_call(__ajax_setting.ajax_on_error,jqxhr,textstatus,errorthrown))
				{

				}
				else
				{
					ui_toast('[error-2658]网络连接错误,请稍后重试('+textstatus+')');
				}

			}

		},
		complete:function
		(
			jqxhr,
			textstatus
		)
		{

			console_log_wreckage('29','lovephp/ajax/complete',[jqxhr,textstatus]);
			if(__ajax_setting.ajax_on_complete)
			{
				function_call(__ajax_setting.ajax_on_complete,jqxhr,textstatus);
			}
		},
		beforeSend:function
		(
			jqxhr,
			settings
		)
		{

			console_log_wreckage('59','lovephp/ajax/beforesend',[jqxhr,settings]);
			if(__ajax_setting.ajax_on_beforesend)
			{
				function_call(__ajax_setting.ajax_on_beforesend,jqxhr,settings);
			}
		},

	};

	if(__postdata)
	{
		__setting_base.data=__postdata;
	}

	if(__ajax_setting)
	{
		__setting_base=$.extend(__setting_base,__ajax_setting);
	}

	console_log_wreckage('12','lovephp/ajax/sink',__setting_base);

	return $.ajax(__setting_base);

}

function ajax_sync(

	__url,

	__postdata=false,

	__on_true=false,

	__on_false=false,

	__ajax_setting={}

)
{

	__ajax_setting.async=false;

	return ajax_async(__url,__postdata,__on_true,__on_false,__ajax_setting);

}
//1 success
function ajax_on_success(__data,__on_true=false,__on_false=false)
{

	if(1)
	{//判断下是不是约定的标准格式的数据
		for(var i in __data)
		{
			if(0!==i.indexOf('@'))
			{
				function_call(__on_true,__data);
				return;
			}
		}
	}

	for(var i in __data)
	{

		var cmd_cmd=int_intval(i.substring(1));
		var cmd_data=__data[i];

//1 true&false
		if(__lpconfig__.returncode.returncode_bool_true==cmd_cmd)
		{
			if(__on_true)
			{
				function_call(__on_true,cmd_data);
			}
		}
		else if(__lpconfig__.returncode.returncode_bool_false==cmd_cmd)
		{
			if(__on_false)
			{
				function_call(__on_false,cmd_data);
			}
		}
//1 jump
		else if(__lpconfig__.returncode.returncode_jump==cmd_cmd)
		{
			if(cmd_data.jump_message)
			{
				ui_alert(cmd_data.jump_message,function()
					{
						jump_jump(cmd_data.jump_url);
					});
			}
			else
			{
				jump_jump(cmd_data.jump_url);
			}
		}
//1 ui
		else if(__lpconfig__.returncode.returncode_ui_alert==cmd_cmd)
		{
			ui_alert(cmd_data.alert_message,cmd_data.alert_func);
		}
		else if(__lpconfig__.returncode.returncode_ui_toast==cmd_cmd)
		{
			ui_toast(cmd_data.toast_message);
		}
		else if(__lpconfig__.returncode.returncode_ui_confirm==cmd_cmd)
		{
			ui_confirm(cmd_data.confirm_message,cmd_data.confirm_func);
		}
		else if(__lpconfig__.returncode.returncode_ui_window==cmd_cmd)
		{
			ui_window_open
			(
				cmd_data.window_inhtml,
				cmd_data.window_cls,
				cmd_data.window_sty,
				cmd_data.window_tail
			);
		}

//1 code
		else if(__lpconfig__.returncode.returncode_jscode==cmd_cmd)
		{
			function_call(cmd_data.jscode_jscode);
		}
//1 mobile
		else if(__lpconfig__.returncode.mobile_returncode_openpage==cmd_cmd)
		{
			mobile_page_open_data(cmd_data);
		}
		else if(__lpconfig__.returncode.mobile_returncode_openmodal==cmd_cmd)
		{
			mobile_modal_open_data(cmd_data);
		}
//1 else
		else
		{
			ui_toast('[error-3058]不支持的指令:'+cmd_cmd)
		}

	}

}
//1 uploadfile
function ajax_uploadfile(

	__url,

	__file,

	__on_success=false,

	__on_fail=false,

	__on_progress=false,

	__on_abort=false,

)
{//不管服务器返回的false,或者链接失败,都算__on_fail

	var __postdata=new FormData();

	__postdata.append('0',__file);

	var __xhr=new XMLHttpRequest();

	__xhr.current_uploading_file=__file;

	if(__on_progress)
	{
		__xhr.upload.onprogress=function(event)
		{
			var percent=Math.round(event.loaded*100/event.total);
			function_call(__on_progress,percent);
		};
	}

	var __ajax_setting=
	{

		processData:false,

		contentType:false,

		timeout:<?php echo \controller\foreground\Upload::uploadfile_timeout*1000;?>,

		xhr:function()
		{
			return __xhr;
		},

		ajax_on_error:function()
		{
			function_call(__on_fail,'上传失败,网络连接错误');
			return cmd_ajax_nodefaulterrortips;
		},

		ajax_on_abort:__on_abort

	};

	var result=ajax_async
	(
		__url,
		__postdata,
		__on_success,
		__on_fail,
		__ajax_setting
	);
	result.current_uploading_file=__file;

	return result;

}