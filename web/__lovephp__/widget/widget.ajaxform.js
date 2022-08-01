
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.ajaxform=new function()
{
	this.af_errorhandle=function(_this,data)
	{
		if(data.ajaxform_error_key)
		{

			var __this=_this.find('[name='+data.ajaxform_error_key+']');

			var __this1=__this.closest('[ajaxform_role=field]');

			if(__this1.length)
			{
				__this=__this1;
			}

			__this.attr('ajaxform_status','haserror');

		}
		if(data.ajaxform_error_msg)
		{
			ui_toast(data.ajaxform_error_msg);
		}
	}
};

_document.on('submit','[__ajaxform__=ajaxform]',function()
{

	if(
		$('[__uploadfile__=uploadfile] [uploadfile_role=uf_fileitem][uploadfile_status=waiting]').length||
		$('[__uploadpic__=uploadpic] [uploadpic_role=up_picitem][uploadpic_status=waiting]').length
	)
	{
		ui_toast('请等待当前上传进程结束');
		return false;
	}

	var _this=$(this);

	var config=_this.data_getconfig('ajaxform');

	var postdata=_this.data_get('ajaxform_appenddata');

	var action=_this.attr('action');

	if(!postdata)
	{
		postdata={};
	}

	var postdata_1=_this.serialize_object();
	postdata=object_merge(postdata,postdata_1);

	postdata['@ajaxform_submit']=1;

	if(1)
	{

		_this.find('[ajaxform_status]').removeAttr('ajaxform_status');

		ajax_sync(action,postdata,

			function(data)
			{
				console_log_wreckage('48','lovephp/0221/1648');
			},
			function(data)
			{
				__lpwidget__.ajaxform.af_errorhandle(_this,data);
			});

	}

	return false;

});
