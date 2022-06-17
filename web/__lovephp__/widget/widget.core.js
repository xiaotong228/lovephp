
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

var __lpwidget__={};

__lpwidget__._upload_commonuse=new(function()
{

//1 svgprogress
	this.svgprogress_template='<?php
		$temp=string_remove_nl(fs_file_read_xml('./assets/img/ring/ring.uploadprogress.svg'));
		$temp=str_replace('\'','"',$temp);
		echo $temp;
	?>';
	this.svgprogress_template_fff='<?php
		$temp=string_remove_nl(fs_file_read_xml('./assets/img/ring/ring.uploadprogress.fff.svg'));
		$temp=str_replace('\'','"',$temp);
		echo $temp;
	?>';
//'
	this.svgprogress_setpercent=function(_svg,percent)
	{
		_svg.find('circle.svg_1').css('stroke-dashoffset',566*(100-percent)/100);
		_svg.find('text').html(percent+'%');
	};

	this.svgprogress_setdone=function(_svg)
	{
		_svg.addClass('svg_done');
	};

//1 ajax
	this.ajax_uploading_jqxhr=false;

//1 selectfile
	this.selectfile_selectedfilesmap={};

	this.selectfile_precheck=function(files,uploadconfig,max)
	{
		if(files.length>max)
		{
			if(max>0)
			{
				ui_toast('还能选择'+max+'个文件');
			}
			else
			{
				ui_toast('不能选择更多的文件了');
			}
			return false;
		}
		for(let i=0;i<files.length;i++)
		{

			let ext=file_ext_get_js(files[i].name);

			if(-1===uploadconfig.file_exts.indexOf(ext))
			{
				ui_toast('不允许的文件类型:'+ext);
				return false;
			}

			if(files[i].size>uploadconfig.file_maxsize)
			{
				ui_toast('单个文件不能超过'+datasize_oralstring_js(uploadconfig.file_maxsize));
				return false;
			}
		}

		return true;

	};

});
//1 imgvcode
_document.on('click','[__imgvcode__=imgvcode]',function()
{

	var _this=$(this);

	_this.attr('src',__lpconfig__.vcode_imgvcode_url+'?'+Math.random());

});

//1 toggleshow
_document.on('click','[__toggleshow__=toggleshow] [toggleshow_role=trigger]',function()
{

	var _this=$(this);

	var _widget=_this.closest('[__toggleshow__=toggleshow]');

	_widget.attr_toggle('toggleshow_status','active');

});
