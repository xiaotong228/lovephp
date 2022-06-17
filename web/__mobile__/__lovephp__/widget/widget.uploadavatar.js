
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


//1 uploadavatartrigger
_document.on('click','[__uploadavatartrigger__=uploadavatartrigger]',function(event)
{

	var _this=$(this);

	var _inputfile=_this.find('input[type=file]');

	if(!_inputfile.length)
	{
		_inputfile=$('<input type=file autocomplete=off accept="image/*" style="display:none;" />');//不要指定具体的文件扩展名,实测手机上选择图片框时没有相册选项
		_this.append(_inputfile);
	}

	if(!__lpwidget__.uploadavatar.ua_cutbox_minwidth_in_px)
	{
		__lpwidget__.uploadavatar.ua_cutbox_minwidth_in_px=mpx_to_vw_js(__lpwidget__.uploadavatar.ua_cutbox_minwidth_in_mpx);
	}

	var _config=_this.data_getconfig('uploadavatartrigger');
	__lpwidget__.uploadavatar.ua_runtime={};
	__lpwidget__.uploadavatar.ua_runtime.uploadavatartrigger_config=_config;

	_inputfile.click();

});

_document.on('click','[__uploadavatartrigger__=uploadavatartrigger] input[type=file]',function(event)
{
	event.stopPropagation();
});

_document.on('change','[__uploadavatartrigger__=uploadavatartrigger] input[type=file]',async function(event)
{

	var _this=$(this);

	var _file=this.files[0];

	__lpwidget__.uploadavatar.ua_runtime._file=_file;

	if(0)
	{
		var _img=await img_load_from_file(_file);
		_img=$(_img);
		_img.css(
		{
			width:'100px',
			height:'100px',
		});

		$('[pageroute_controller=cluindex][pageroute_action=index]').append(_img);
	}

	_this.val('');

	mobile_page_open('/api/widgetpage_uploadavatar',
	{
		uploadavatar_saveurl:__lpwidget__.uploadavatar.ua_runtime.uploadavatartrigger_config.uploadavatartrigger_saveurl
	});

});

//1 uploadavatar
__lpwidget__.uploadavatar=new function()
{

	this.ua_runtime=false;

	this.ua_cutbox_minwidth_in_mpx=180;

	this.ua_cutbox_minwidth_in_px=false;

};
//1 mobilepage_event_create
_document.on(mpe_create,'[pageroute_controller=api][pageroute_action=widgetpage_uploadavatar]',async function(event)
{

	var test_img_url=false;
	if(0)
	{//test
		test_img_url='/example/img/0.jpg';
	}
	var _error=function(msg)
	{

		setTimeout(function()
		{
				ui_alert(msg,function()
				{
					mobile_route_back();
				});
		},__lpconfig__.mobile_page_ani_time+500);

	};

	if(test_img_url)
	{

		var _img=await img_load_from_url(test_img_url);

		var base64=img_to_base64(_img);

		__lpwidget__.uploadavatar.ua_runtime={};
		__lpwidget__.uploadavatar.ua_runtime._file=file_base64_to_file(base64,'test.'+_img.img_file_ext);

	}

	if(!__lpwidget__.uploadavatar.ua_runtime._file)
	{
		_error('请先选择图片');
		return;
	}
	__lpwidget__.uploadavatar.ua_runtime._file=await imgfile_resize_maxpixel(__lpwidget__.uploadavatar.ua_runtime._file,<?php echo \Prjconfig::file_avatar_preselect_maxpixels;?>);

	var _file=__lpwidget__.uploadavatar.ua_runtime._file;

	var _img=await img_load_from_file(_file);

	if(!_img)
	{
		_error('不是有效的图片');
		return;
	}

	var _widget=$(event.target);

	__lpwidget__.uploadavatar.ua_runtime._widget=_widget;

	var _operpanel=_widget.find('[uploadavatar_role=ua_operpanel]');
	var _operpanel_pos=_operpanel.dompos_get();

	var _cutbox_wrap=_widget.find('[uploadavatar_role=ua_cutbox_wrap]');
	var _cutbox_wrap_css={};
	var _cutbox_wrap_img_size={};

	var _cutbox_cutbox=_widget.find('[uploadavatar_role=ua_cutbox]');
	var _cutbox_cutbox_css={};

	if(1)
	{

		_cutbox_wrap_css['background-image']='url('+_img.src+')';

		if(_img.width/_img.height>_operpanel_pos.width/_operpanel_pos.height)
		{

			_cutbox_wrap_img_size.width=_operpanel_pos.width;
			_cutbox_wrap_img_size.height=(_img.height/_img.width)*_operpanel_pos.width

			_cutbox_wrap_css.width='100%';//必须指定,否则旋转后会出问题
			_cutbox_wrap_css.height=_cutbox_wrap_img_size.height+'px';

		}
		else
		{

			_cutbox_wrap_img_size.width=(_img.width/_img.height)*_operpanel_pos.height;
			_cutbox_wrap_img_size.height=_operpanel_pos.height;

			_cutbox_wrap_css.width=_cutbox_wrap_img_size.width+'px';
			_cutbox_wrap_css.height='100%';

		}

		_cutbox_wrap.css(_cutbox_wrap_css).show();

	}

	if(1)
	{

		if(_img.width>_img.height)
		{
			_cutbox_cutbox_css.left=(_cutbox_wrap_img_size.width-_cutbox_wrap_img_size.height)/2+'px';
			_cutbox_cutbox_css.top=0;
			_cutbox_cutbox_css.width=_cutbox_wrap_img_size.height+'px';
			_cutbox_cutbox_css.height='100%';
		}
		else
		{

			_cutbox_cutbox_css.left=0;
			_cutbox_cutbox_css.top=(_cutbox_wrap_img_size.height-_cutbox_wrap_img_size.width)/2+'px';
			_cutbox_cutbox_css.width='100%';
			_cutbox_cutbox_css.height=_cutbox_wrap_img_size.width+'px';

		}

		_cutbox_cutbox.css(_cutbox_cutbox_css);

	}

});
_document.on(mpe_destory,'[pageroute_controller=api][pageroute_action=widgetpage_uploadavatar]',async function(event)
{
	console_log_wreckage('02','lovephp/0119/3502/widgetpage_uploadavatar/destory');
	__lpwidget__.uploadavatar.ua_runtime=false;
});

//1 save
_document.on('click','[__uploadavatar__=uploadavatar] [uploadavatar_role=ua_savebtn]',async function(event)
{

	var _widget=$(this).closest('[__uploadavatar__=uploadavatar]');

	var _config=_widget.data_getconfig('uploadavatar');

	var _file=__lpwidget__.uploadavatar.ua_runtime._file;

	var _cutbox_wrap=_widget.find('[uploadavatar_role=ua_cutbox_wrap]');
	var _cutbox_wrap_pos=_cutbox_wrap.dompos_get();

	var _cutbox_cutbox=_widget.find('[uploadavatar_role=ua_cutbox]');
	var _cutbox_cutbox_pos=_cutbox_cutbox.dompos_get();

	var _img=await img_load_from_file(_file);

	var ratio=_img.width/_cutbox_wrap_pos.width;

	var cut_x=_cutbox_cutbox_pos.x;
	var cut_y=_cutbox_cutbox_pos.y;

	var cut_width=_cutbox_cutbox_pos.outer_width;
	var cut_height=_cutbox_cutbox_pos.outer_height;

	cut_x=ratio*cut_x;
	cut_y=ratio*cut_y;
	cut_width=ratio*cut_width;
	cut_height=ratio*cut_height;

	var cut_file=await imgfile_cut(_file,cut_x,cut_y,cut_width,cut_height,
		<?php echo \Prjconfig::file_avatar_final_maxwidth;?>,
		<?php echo \Prjconfig::file_avatar_final_maxwidth;?>
	);

	ajax_uploadfile
	(

		_config['@upload_config']['upload_url'],

		cut_file,

		function(data)
		{
			var postdata={};
			postdata['@uploadavatar_resultimgurl']=data;
			ajax_async(_config.uploadavatar_saveurl,postdata);
		},

		function(errormsg)
		{//fail
			ui_toast(errormsg);
		}

	);

});

//1 rotate
_document.on('click','[__uploadavatar__=uploadavatar] [uploadavatar_role^=rotate_]',async function(event)
{

	var _this=$(this);

	var value=_this.attr('uploadavatar_role');

	var angle=false;

	if('rotate_left'==value)
	{
		angle=-90;
	}
	else if('rotate_right'==value)
	{
		angle=90;
	}
	else
	{
		console_log_wreckage('00','lovephp/0112/3704/不该走这里'+JSON.stringify(0));
		return;
	}

	__lpwidget__.uploadavatar.ua_runtime._file=await imgfile_rotate(__lpwidget__.uploadavatar.ua_runtime._file,angle);
	__lpwidget__.uploadavatar.ua_runtime._widget.trigger(mpe_create);

});
//1 touchstart
_document.on('touchstart','[__uploadavatar__=uploadavatar] [uploadavatar_role=ua_cutbox_drag]',function(event)
{

	var _cutbox_drag=$(this);

	var _cutbox_wrap=_cutbox_drag.closest('[uploadavatar_role=ua_cutbox_wrap]');
	var _cutbox_wrap_pos=_cutbox_wrap.dompos_get();

	var _cutbox_cutbox=_cutbox_drag.closest('[uploadavatar_role=ua_cutbox]');
	var _cutbox_cutbox_pos=_cutbox_cutbox.dompos_get();

	touchevent_regist(_cutbox_drag[0],event.originalEvent,function(__event,__posinfo,__movecount)
	{

		var cssobj={};

		var final_x=_cutbox_cutbox_pos.x+__posinfo.pos_offset.x;
		var final_y=_cutbox_cutbox_pos.y+__posinfo.pos_offset.y;

		final_x=Math.max(final_x,0);
		final_y=Math.max(final_y,0);
		final_x=Math.min(final_x,_cutbox_wrap_pos.width-_cutbox_cutbox_pos.width);
		final_y=Math.min(final_y,_cutbox_wrap_pos.height-_cutbox_cutbox_pos.height);

		cssobj.left=final_x+'px';
		cssobj.top=final_y+'px';

		_cutbox_cutbox.css(cssobj);

		return cmd_touchevent_preventdefault|cmd_touchevent_stoppropagation;

	});

});

_document.on('touchstart','[__uploadavatar__=uploadavatar] [uploadavatar_role=ua_cutbox_point]',function(event)
{

	var _cutbox_point=$(this);

	var _cutbox_wrap=_cutbox_point.closest('[uploadavatar_role=ua_cutbox_wrap]');
	var _cutbox_wrap_pos=_cutbox_wrap.dompos_get();

	var _cutbox_cutbox=_cutbox_point.closest('[uploadavatar_role=ua_cutbox]');
	var _cutbox_cutbox_pos=_cutbox_cutbox.dompos_get();

	var index=int_intval(_cutbox_point.attr('index'));

	touchevent_regist(_cutbox_point[0],event.originalEvent,function(__event,__posinfo,__movecount)
	{

		var offset_x=__posinfo.pos_offset.x;

		var cssobj={};

		if(0==index)
		{

			offset_x=Math.min(offset_x,_cutbox_cutbox_pos.width-__lpwidget__.uploadavatar.ua_cutbox_minwidth_in_px);
			offset_x=Math.max(offset_x,-_cutbox_cutbox_pos.x);
			offset_x=Math.max(offset_x,-_cutbox_cutbox_pos.y);

			cssobj.left=(_cutbox_cutbox_pos.x+offset_x);
			cssobj.top=(_cutbox_cutbox_pos.y+offset_x);
			cssobj.width=(_cutbox_cutbox_pos.width-offset_x);
			cssobj.height=(_cutbox_cutbox_pos.height-offset_x);
		}
		else if(1==index)
		{

			offset_x=Math.max(offset_x,__lpwidget__.uploadavatar.ua_cutbox_minwidth_in_px-_cutbox_cutbox_pos.width);
			offset_x=Math.min(offset_x,_cutbox_wrap_pos.width-_cutbox_cutbox_pos.x-_cutbox_cutbox_pos.width);
			offset_x=Math.min(offset_x,_cutbox_cutbox_pos.y);

			cssobj.top=(_cutbox_cutbox_pos.y-offset_x);
			cssobj.width=(_cutbox_cutbox_pos.width+offset_x);
			cssobj.height=(_cutbox_cutbox_pos.height+offset_x);

		}
		else if(2==index)
		{
			offset_x=Math.max(offset_x,__lpwidget__.uploadavatar.ua_cutbox_minwidth_in_px-_cutbox_cutbox_pos.width);
			offset_x=Math.min(offset_x,_cutbox_wrap_pos.width-_cutbox_cutbox_pos.x-_cutbox_cutbox_pos.width);
			offset_x=Math.min(offset_x,_cutbox_wrap_pos.height-_cutbox_cutbox_pos.y-_cutbox_cutbox_pos.width);

			cssobj.width=(_cutbox_cutbox_pos.width+offset_x);

			cssobj.height=(_cutbox_cutbox_pos.height+offset_x);


		}
		else if(3==index)
		{
			offset_x=Math.min(offset_x,_cutbox_cutbox_pos.width-__lpwidget__.uploadavatar.ua_cutbox_minwidth_in_px);

			offset_x=Math.max(offset_x,-_cutbox_cutbox_pos.x);

			offset_x=Math.max(offset_x,-(_cutbox_wrap_pos.height-_cutbox_cutbox_pos.y-_cutbox_cutbox_pos.outer_height));

			cssobj.left=(_cutbox_cutbox_pos.x+offset_x);
			cssobj.width=(_cutbox_cutbox_pos.width-offset_x);
			cssobj.height=(_cutbox_cutbox_pos.height-offset_x);

		}
		else
		{

		}

		_cutbox_cutbox.css(css_object_append_px(cssobj));

		return cmd_touchevent_preventdefault|cmd_touchevent_stoppropagation;

	});

});