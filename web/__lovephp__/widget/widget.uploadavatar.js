
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.uploadavatar=new function()
{

	this.ua_current_file=false;

	this.ua_cutbox_minwidth=50;

};

//1 selectfile
_document.on('click','[__uploadavatar__=uploadavatar] [uploadavatar_role=ua_selectfile]',function(event)
{

	var _this=$(this);

	var _dad=_this.closest('[__uploadavatar__=uploadavatar]');

	_dad.find('input[type=file]').click();

});
//1 file change
_document.on('change','[__uploadavatar__=uploadavatar] input[type=file]',async function(event)
{

	var _widget=$(this).closest('[__uploadavatar__=uploadavatar]');

	var _operpanel=_widget.find('[uploadavatar_role=ua_operpanel]');
	var _operpanel_pos=_operpanel.dompos_get();

	var _cutbox_wrap=_widget.find('[uploadavatar_role=ua_cutbox_wrap]');

	var _cutbox_cutbox=_widget.find('[uploadavatar_role=ua_cutbox]');

	var _file=this.files[0];
	var _img=await img_load_from_file(_file);

	if(!_img)
	{
		ui_alert('不是有效的图片文件');
		return;
	}

	var max_ratio=_operpanel_pos.width/__lpwidget__.uploadavatar.ua_cutbox_minwidth;
	var min_ratio=__lpwidget__.uploadavatar.ua_cutbox_minwidth/_operpanel_pos.width;
	if(
		(_img.width/_img.height)<min_ratio||
		(_img.width/_img.height)>max_ratio
	)
	{
		ui_alert('图片太高或太宽');
		return;
	}

	if(1)
	{
		_operpanel.show();
		_widget.find('[uploadavatar_role=ua_savebtn]').show();
	}

	if(1)
	{

		var _cutbox_wrap_css={};

		_cutbox_wrap_css['background-image']='url('+_img.src+')';

		if(_img.width==_img.height)
		{
			_cutbox_wrap_css['width']='100%';
			_cutbox_wrap_css['height']='100%';
		}
		else if(_img.width>_img.height)
		{
			_cutbox_wrap_css['width']='100%';
			_cutbox_wrap_css['height']=int_intval((_img.height/_img.width)*_operpanel_pos.height)+'px';
		}
		else if(_img.width<_img.height)
		{
			_cutbox_wrap_css['width']=int_intval((_img.width/_img.height)*_operpanel_pos.width)+'px';
			_cutbox_wrap_css['height']='100%';
		}
		else
		{
			console_log_wreckage('00','lovephp/1110/4752/不该出现'+JSON.stringify(0));
		}

		_cutbox_wrap.css(_cutbox_wrap_css);
	}

	if(1)
	{

		var _cutbox_cutbox_css={};
		var _cutbox_wrap_pos=_cutbox_wrap.dompos_get();

		if(_cutbox_wrap_pos.width==_cutbox_wrap_pos.height)
		{
			_cutbox_cutbox_css.left=0;
			_cutbox_cutbox_css.top=0;
			_cutbox_cutbox_css.width=_cutbox_wrap_pos.width;
			_cutbox_cutbox_css.height=_cutbox_wrap_pos.height;
		}
		else if(_cutbox_wrap_pos.width>_cutbox_wrap_pos.height)
		{
			_cutbox_cutbox_css.left=(_cutbox_wrap_pos.width-_cutbox_wrap_pos.height)/2;
			_cutbox_cutbox_css.top=0;
			_cutbox_cutbox_css.width=_cutbox_wrap_pos.height;
			_cutbox_cutbox_css.height=_cutbox_wrap_pos.height;
		}
		else if(_cutbox_wrap_pos.width<_cutbox_wrap_pos.height)
		{
			_cutbox_cutbox_css.left=0
			_cutbox_cutbox_css.top=(_cutbox_wrap_pos.height-_cutbox_wrap_pos.width)/2;
			_cutbox_cutbox_css.width=_cutbox_wrap_pos.width;
			_cutbox_cutbox_css.height=_cutbox_wrap_pos.width;
		}
		else
		{

		}

		_cutbox_cutbox.css(css_object_append_px(_cutbox_cutbox_css));

	}

	__lpwidget__.uploadavatar.ua_current_file=_file;

});
//1 save
_document.on('click','[__uploadavatar__=uploadavatar] [uploadavatar_role=ua_savebtn]',async function(event)
{

	var _widget=$(this).closest('[__uploadavatar__=uploadavatar]');

	var _config=_widget.data_getconfig('uploadavatar');

	var _cutbox_cutbox_pos=_widget.find('[uploadavatar_role=ua_cutbox]').dompos_get();

	var _cutbox_wrap_pos=_widget.find('[uploadavatar_role=ua_cutbox_wrap]').dompos_get();

	var ratio=__lpwidget__.uploadavatar.ua_current_file.file_img_cache.width/_cutbox_wrap_pos.width;

	var cut_x=_cutbox_cutbox_pos.x;
	var cut_y=_cutbox_cutbox_pos.y;

	var cut_width=_cutbox_cutbox_pos.outer_width;
	var cut_height=_cutbox_cutbox_pos.outer_height;

	cut_x=int_intval(ratio*cut_x);
	cut_y=int_intval(ratio*cut_y);
	cut_width=int_intval(ratio*cut_width);
	cut_height=int_intval(ratio*cut_height);

	var cut_file=await imgfile_cut
		(
			__lpwidget__.uploadavatar.ua_current_file,
			cut_x,cut_y,cut_width,cut_height,
			<?php echo \Prjconfig::file_avatar_final_maxwidth;?>,
			<?php echo \Prjconfig::file_avatar_final_maxwidth;?>
		);

	if(0)
	{//test
		file_download_file_localfile(cut_file);
		return;
	}

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
//1 mouseevent
_document.on('mousedown','[__uploadavatar__=uploadavatar] [uploadavatar_role=ua_cutbox_point]',function(event)
{

	var _cutbox_point=$(this);

	var _cutbox_wrap=_cutbox_point.closest('[uploadavatar_role=ua_cutbox_wrap]');
	var _cutbox_wrap_pos=_cutbox_wrap.dompos_get();

	var _cutbox_cutbox=_cutbox_point.closest('[uploadavatar_role=ua_cutbox]');
	var _cutbox_cutbox_pos=_cutbox_cutbox.dompos_get();

	var index=int_intval(_cutbox_point.attr('index'));

	mouseevent_regist(event,function(mousemove_pos_rel,mousemove_pos_abs)
		{

			var cssobj={};

			var final_x=mousemove_pos_rel.x;

			if(0==index)
			{
				final_x=Math.min(final_x,_cutbox_cutbox_pos.outer_width-__lpwidget__.uploadavatar.ua_cutbox_minwidth);
				final_x=Math.max(final_x,-_cutbox_cutbox_pos.x);
				final_x=Math.max(final_x,-_cutbox_cutbox_pos.y);

				cssobj.left=(_cutbox_cutbox_pos.x+final_x);
				cssobj.top=(_cutbox_cutbox_pos.y+final_x);
				cssobj.width=(_cutbox_cutbox_pos.outer_width-final_x);
				cssobj.height=(_cutbox_cutbox_pos.outer_height-final_x);
			}
			else if(1==index)
			{

				final_x=Math.max(final_x,__lpwidget__.uploadavatar.ua_cutbox_minwidth-_cutbox_cutbox_pos.outer_width);
				final_x=Math.min(final_x,_cutbox_wrap_pos.width-_cutbox_cutbox_pos.x-_cutbox_cutbox_pos.outer_width);
				final_x=Math.min(final_x,_cutbox_cutbox_pos.y);

				cssobj.top=(_cutbox_cutbox_pos.y-final_x);
				cssobj.width=(_cutbox_cutbox_pos.outer_width+final_x);
				cssobj.height=(_cutbox_cutbox_pos.outer_height+final_x);

			}
			else if(2==index)
			{

				final_x=Math.max(final_x,__lpwidget__.uploadavatar.ua_cutbox_minwidth-_cutbox_cutbox_pos.outer_width);
				final_x=Math.min(final_x,_cutbox_wrap_pos.width-_cutbox_cutbox_pos.x-_cutbox_cutbox_pos.outer_width);
				final_x=Math.min(final_x,_cutbox_wrap_pos.height-_cutbox_cutbox_pos.y-_cutbox_cutbox_pos.outer_width);

				cssobj.width=(_cutbox_cutbox_pos.outer_width+final_x);
				cssobj.height=(_cutbox_cutbox_pos.outer_height+final_x);

			}
			else if(3==index)
			{

				final_x=Math.min(final_x,_cutbox_cutbox_pos.outer_width-__lpwidget__.uploadavatar.ua_cutbox_minwidth);
				final_x=Math.max(final_x,-_cutbox_cutbox_pos.x);
				final_x=Math.max(final_x,-(_cutbox_wrap_pos.height-_cutbox_cutbox_pos.y-_cutbox_cutbox_pos.outer_height));

				cssobj.left=(_cutbox_cutbox_pos.x+final_x);
				cssobj.width=(_cutbox_cutbox_pos.outer_width-final_x);
				cssobj.height=(_cutbox_cutbox_pos.outer_height-final_x);

			}
			else
			{

			}

			_cutbox_cutbox.css(css_object_append_px(cssobj));

		});

});

_document.on('mousedown','[__uploadavatar__=uploadavatar] [uploadavatar_role=ua_cutbox_drag]',function(event)
{

	var _cutbox_drag=$(this);

	var _cutbox_wrap=_cutbox_drag.closest('[uploadavatar_role=ua_cutbox_wrap]');
	var _cutbox_wrap_pos=_cutbox_wrap.dompos_get();

	var _cutbox_cutbox=_cutbox_drag.closest('[uploadavatar_role=ua_cutbox]');
	var _cutbox_cutbox_pos=_cutbox_cutbox.dompos_get();

	mouseevent_regist(event,function(mousemove_pos_rel,mousemove_pos_abs)
		{
			var cssobj={};

			var final_x=mousemove_pos_rel.x;
			var final_y=mousemove_pos_rel.y;

			final_x=Math.max(final_x,-_cutbox_cutbox_pos.x);
			final_y=Math.max(final_y,-_cutbox_cutbox_pos.y);

			final_x=Math.min(final_x,_cutbox_wrap_pos.width-_cutbox_cutbox_pos.x-_cutbox_cutbox_pos.outer_width);
			final_y=Math.min(final_y,_cutbox_wrap_pos.height-_cutbox_cutbox_pos.y-_cutbox_cutbox_pos.outer_height);

			cssobj.left=(_cutbox_cutbox_pos.x+final_x)+'px';
			cssobj.top=(_cutbox_cutbox_pos.y+final_y)+'px';

			_cutbox_cutbox.css(cssobj);

		});
});

