
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


_document.on('click','[__xmlwindow__=xmlwindow] [xmlwindow_role=save]',function()
{
	var _this=$(this).closest('[__xmlwindow__=xmlwindow]');

	var url=_this.attr('xmlwindow_submiturl');

	var data=_this.find('form').serialize_object();

	if(function_isfunction(url))
	{
		function_call(url,data);
	}
	else
	{
		ajax_sync(url,data);
	}

});

//1 xmluploadfile
_document.on('input','[xmlwindow_formtype=xmluploadfile] .p_right input[type=text]',function()
{

	var _input=$(this);

	var _this=_input.closest('[xmlwindow_formtype=xmluploadfile]');

	var _this_filepreview=_this.find('.file_preview');

	var _this_filepreview_a=_this.find('.file_preview >a');

	var currentvalue=_input.val();

	currentvalue=$.trim(currentvalue);

	if(currentvalue)
	{

	}
	else
	{
		_this_filepreview.hide();
		return;
	}

	_this_filepreview.show();

	var ext=file_ext_get_js(currentvalue);

	_this_filepreview_a.attr('href',currentvalue);

	if(-1!=<?php echo json_encode_1(\Prjconfig::file_pic_exts);?>.indexOf(ext))
	{
		_this_filepreview_a.html('<img src="'+currentvalue+'"/>');
	}
	else
	{
		_this_filepreview_a.html('');
	}

});

_document.on('click','[xmlwindow_formtype=xmluploadfile] .p_right a.upload',function()
{

	var _this=$(this);

	_this.siblings('input[type=file]').click();

});
_document.on('change','[xmlwindow_formtype=xmluploadfile] input[type=file]',function()
{

	var _input=$(this);

	var _this=_input.closest('[xmlwindow_formtype=xmluploadfile]');

	var _this_filepreview=_this.find('.file_preview');

	var _file=this.files[0];

	var _config=_this.data_getconfig('xmluploadfile');

	_this_filepreview.attr('file_preview_status','uploading').show();
	_this_filepreview.find('span').html(0);

	ajax_uploadfile
	(

		_config['@upload_config']['upload_url'],

		_file,

		function(data)
		{
			_this_filepreview.removeAttr('file_preview_status');
			_this.find('input[type=text]').val(data).trigger('input');
			ui_toast('上传完成');
		},
		function(errormsg)
		{//fail
			ui_alert(errormsg);
			_this_filepreview.removeAttr('file_preview_status');
			_this.find('input[type=text]').trigger('input');

		},
		function(percent)
		{
			_this.find('.file_preview >span').html(percent);
		}
	);

	_input.val('');

});

