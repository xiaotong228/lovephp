
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

__lpwidget__.uploadfile=new function()
{
//1 public
	this.uf_getvalue=function(_widget)
	{

		var list=_widget.find('[uploadfile_role=uf_fileitem][uploadfile_status=done]');

		var data=[];

		list.each(function()
			{
				data.push($(this).find('.filename a').attr('href'));
			});

		return data;
	};

//1 private
	this.uf_render=function(_widget)
	{

		var _config=_widget.data_getconfig('uploadfile');

		var currentvalue=__lpwidget__.uploadfile.uf_getvalue(_widget);

		var currentnum=_widget.find('[uploadfile_role=uf_fileitem]').length;
		var totalnum=_config.uploadfile_filemaxnum;

		_widget.find('[uploadfile_role=uf_selectfile] span').html(currentnum+'/'+totalnum);

		if(_config.uploadfile_inputname)
		{
			_widget.find('input[name="'+_config.uploadfile_inputname+'"]').val(currentvalue.toString());
		}

	};
	this.uf_selectedfiles_uploadloop=function()
	{

		var list=$('[__uploadfile__=uploadfile] [uploadfile_role=uf_fileitem][uploadfile_status=waiting]');

		if(list.length)
		{

			var _item=list.eq(0);

			var _item_svg=_item.find('svg');

			var _widget=_item.closest('[__uploadfile__=uploadfile]');

			var _config=_widget.data_getconfig('uploadfile');

			var _item_id=_item.attr('uploadfile_id');

			var _file=__lpwidget__._upload_commonuse.selectfile_selectedfilesmap[_item_id];

			__lpwidget__._upload_commonuse.ajax_uploading_jqxhr=ajax_uploadfile
			(

				_config['@upload_config']['upload_url'],

				_file,

				function(data)
				{

					_item.attr('uploadfile_status','done');
					_item.find('.filename a').attr('href',data);

					__lpwidget__._upload_commonuse.svgprogress_setdone(_item_svg);

					__lpwidget__.uploadfile.uf_render(_widget);
					__lpwidget__.uploadfile.uf_selectedfiles_uploadloop();

				},
				function(errormsg)
				{//fail
					_item.remove();
					ui_toast(errormsg);
					__lpwidget__.uploadfile.uf_render(_widget);
					__lpwidget__.uploadfile.uf_selectedfiles_uploadloop();
				},
				function(percent)
				{
					__lpwidget__._upload_commonuse.svgprogress_setpercent(_item_svg,percent);
				},
				function(jqxhr)
				{//abort
					_item.remove();
					__lpwidget__.uploadfile.uf_render(_widget);
					__lpwidget__.uploadfile.uf_selectedfiles_uploadloop();
				}
			);
		}
		else
		{
			__lpwidget__._upload_commonuse.selectfile_selectedfilesmap={};
		}
	};

};

_document.on('click','[__uploadfile__=uploadfile] [uploadfile_role=uf_selectfile]',function(event)
{

	var _widget=$(this).closest('[__uploadfile__=uploadfile]');

	var _config=_widget.data_getconfig('uploadfile');

	if(!$.isEmptyObject(__lpwidget__._upload_commonuse.selectfile_selectedfilesmap))
	{
		ui_toast('请等待当前上传结束');
		return;
	}

	var max=_config.uploadfile_filemaxnum-__lpwidget__.uploadfile.uf_getvalue(_widget).length;

	if(max<=0)
	{
		ui_toast('不能选择更多的文件了');
		return;
	}

	_widget.find('input[type=file]').click();

});


_document.on('change','[__uploadfile__=uploadfile] input[type=file]',function(event)
{

	var _this=$(this);

	var _widget=_this.closest('[__uploadfile__=uploadfile]');

	var _config=_widget.data_getconfig('uploadfile');

	var upload_config=_config['@upload_config'];

	var max=_config.uploadfile_filemaxnum-__lpwidget__.uploadfile.uf_getvalue(_widget).length;

	var _files=this.files;

	if(!__lpwidget__._upload_commonuse.selectfile_precheck(_files,upload_config,max))
	{
		return;
	}

	__lpwidget__._upload_commonuse.selectfile_selectedfilesmap={};

	var inhtml='';

	for(let i=0;i<_files.length;i++)
	{

		let file=_files[i];
		let id=math_salt_js();

		inhtml+='<div uploadfile_role=uf_fileitem uploadfile_id='+id+' uploadfile_status=waiting>';

			inhtml+=__lpwidget__._upload_commonuse.svgprogress_template;

			inhtml+='<div class=filename>';
				inhtml+='<span>'+file.name+'</span>';
				inhtml+='<a target=_blank >'+file.name+'</a>';
				inhtml+='<br><s>'+datasize_oralstring_js(file.size)+'</s>';
			inhtml+='</div>';

			inhtml+='<div class=operz>';

				inhtml+='<a class=move_up></a>';
				inhtml+='<a class=move_down></a>';
				inhtml+='<a class=delete></a>';
			inhtml+='</div>';

		inhtml+='</div>';

		__lpwidget__._upload_commonuse.selectfile_selectedfilesmap[id]=file;

	}

	_widget.find('[uploadfile_role=uf_filelist]').append(inhtml);

	__lpwidget__.uploadfile.uf_render(_widget);

	__lpwidget__.uploadfile.uf_selectedfiles_uploadloop();

	_this.val('');//清掉当前选的文件,这样2次都选同一个文件也会触发change

});

_document.on('click','[__uploadfile__=uploadfile] [uploadfile_role=uf_fileitem] a.delete',function(event)
{
	var _this=$(this).closest('[uploadfile_role=uf_fileitem]');

	var _widget=_this.closest('[__uploadfile__=uploadfile]');

	ui_confirm('确定删除?',function()
	{

		var upload_id=_this.attr('uploadfile_id');

		var _file=false;

		if(upload_id)
		{
			_file=__lpwidget__._upload_commonuse.selectfile_selectedfilesmap[upload_id];
		}
		if(_file&&_file===__lpwidget__._upload_commonuse.ajax_uploading_jqxhr.current_uploading_file)
		{

			console_log_wreckage('13','lovephp/0329/0013/删除/取消上传');

			__lpwidget__._upload_commonuse.ajax_uploading_jqxhr.abort();

		}
		else
		{

			console_log_wreckage('23','lovephp/0328/2523/删除/直接删除');

			_this.remove();

			__lpwidget__.uploadfile.uf_render(_widget);

		}

	});

});


_document.on('click','[__uploadfile__=uploadfile] [uploadfile_role=uf_fileitem] a.move_up',function(event)
{
	var _this=$(this);
	var _widget=_this.closest('[__uploadfile__=uploadfile]');

	_this=_this.closest('[uploadfile_role=uf_fileitem]');
	_this.insertBefore(_this.prev());
	__lpwidget__.uploadfile.uf_render(_widget);
});
_document.on('click','[__uploadfile__=uploadfile] [uploadfile_role=uf_fileitem] a.move_down',function(event)
{
	var _this=$(this);
	var _widget=_this.closest('[__uploadfile__=uploadfile]');

	_this=_this.closest('[uploadfile_role=uf_fileitem]');
	_this.insertAfter(_this.next());
	__lpwidget__.uploadfile.uf_render(_widget);
});


