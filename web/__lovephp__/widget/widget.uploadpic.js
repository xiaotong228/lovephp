
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

__lpwidget__.uploadpic=new function()
{

//1 public
	this.up_getvalue=function(_this)
	{

		var list=_this.find('[uploadpic_role=up_picitem][uploadpic_status=done] a.imgwrapz >img');

		var data=[];

		list.each(function()
			{
				data.push($(this).attr('src'));
			});

		return data;

	};

//1 private
	this.up_selectedfiles_uploadloop=function()
	{

		var list=$('[__uploadpic__=uploadpic] [uploadpic_role=up_picitem][uploadpic_status=waiting]');

		if(list.length)
		{

			var _item=list.eq(0);

			var _item_svg=_item.find('svg');

			var _widget=_item.closest('[__uploadpic__=uploadpic]');

			var _config=_widget.data_getconfig('uploadpic');

			var _item_id=_item.attr('uploadpic_id');

			var _file=__lpwidget__._upload_commonuse.selectfile_selectedfilesmap[_item_id];

			__lpwidget__._upload_commonuse.ajax_uploading_jqxhr=ajax_uploadfile
			(

				_config['@upload_config']['upload_url'],

				_file,

				function(data)
				{

					_item.attr('uploadpic_status','done');
					_item.find('a.imgwrapz').attr('href',data);
					_item.find('a.imgwrapz img').attr('src',data);

					__lpwidget__._upload_commonuse.svgprogress_setdone(_item_svg);

					__lpwidget__.uploadpic.up_render(_widget);
					__lpwidget__.uploadpic.up_selectedfiles_uploadloop();

				},
				function(errormsg)
				{//fail
					_item.remove();
					ui_toast(errormsg);
					__lpwidget__.uploadpic.up_render(_widget);
					__lpwidget__.uploadpic.up_selectedfiles_uploadloop();
				},
				function(percent)
				{
					__lpwidget__._upload_commonuse.svgprogress_setpercent(_item_svg,percent);
				},
				function(jqxhr)
				{//abort
					_item.remove();
					__lpwidget__.uploadpic.up_render(_widget);
					__lpwidget__.uploadpic.up_selectedfiles_uploadloop();
				}
			);
		}
		else
		{
			__lpwidget__._upload_commonuse.selectfile_selectedfilesmap={};
		}
	};
//1 render
	this.up_render=function(_widget)
	{

		var _config=_widget.data_getconfig('uploadpic');

		var currentvalue=__lpwidget__.uploadpic.up_getvalue(_widget);

		var currentnum=_widget.find('[uploadpic_role=up_picitem]').length;
		var totalnum=_config.uploadpic_filemaxnum;

		_widget.find('[uploadpic_role=up_selectfile] span').html(currentnum+'/'+totalnum);

		if(_config.uploadpic_inputname)
		{
			_widget.find('input[name="'+_config.uploadpic_inputname+'"]').val(currentvalue.toString());
		}

	};

};

_document.on('click','[__uploadpic__=uploadpic] [uploadpic_role=up_selectfile]',function(event)
{
	var _widget=$(this).closest('[__uploadpic__=uploadpic]');

	var _config=_widget.data_getconfig('uploadpic');
	console_log_wreckage('59','lovephp/0412/5759',_config);

	if(!$.isEmptyObject(__lpwidget__._upload_commonuse.selectfile_selectedfilesmap))
	{
		ui_toast('请等待当前上传结束');
		return;
	}

	var max=_config.uploadpic_filemaxnum-__lpwidget__.uploadpic.up_getvalue(_widget).length;

	if(max<=0)
	{
		ui_toast('不能选择更多的文件了');
		return;
	}

	_widget.find('input[type=file]').click();

});
_document.on('change','[__uploadpic__=uploadpic] input[type=file]',async function(event)
{

	var _this=$(this);

	var _widget=_this.closest('[__uploadpic__=uploadpic]');

	var _config=_widget.data_getconfig('uploadpic');

	var upload_config=_config['@upload_config'];

	var max=_config.uploadpic_filemaxnum-__lpwidget__.uploadpic.up_getvalue(_widget).length;

	var _file_list=[];

	for(let i=0;i<this.files.length;i++)
	{//检测下是否为图片,如果超过uploadpic_picmaxpixels要缩小

		let temp_file=this.files[i];

		let temp_img=await img_load_from_file(temp_file);

		if(temp_img)
		{

			if(_config.uploadpic_picmaxpixels)
			{
				temp_file=await imgfile_resize_maxpixel(temp_file,_config.uploadpic_picmaxpixels);
			}
			else
			{

			}

		}
		else
		{
			temp_file=false;
		}

		if(temp_file)
		{
			_file_list.push(temp_file);
		}
		else
		{
			ui_toast(this.files[i].name+'不是正确的图片文件');
		}

	}

	if(!_file_list.length)
	{
		return;
	}

	if(!__lpwidget__._upload_commonuse.selectfile_precheck(_file_list,upload_config,max))
	{
		return;
	}

	__lpwidget__._upload_commonuse.selectfile_selectedfilesmap={};

	var _piclist=_widget.find('[uploadpic_role=up_piclist]');

	for(let i=0;i<_file_list.length;i++)
	{

		let file=_file_list[i];

		let id=math_salt_js();

		let _img=await img_load_from_file(file);

		let inhtml='';

		inhtml+='<div uploadpic_role=up_picitem uploadpic_id='+id+' uploadpic_status=waiting>';

			inhtml+='<a class=imgwrapz target=_blank><img /></a>';

			inhtml+='<div class=progressz>';
				inhtml+=__lpwidget__._upload_commonuse.svgprogress_template_fff;
			inhtml+='</div>';

			inhtml+='<div class=operz>';
				inhtml+='<a class=move_left title="左移一位"></a>';
				inhtml+='<a class=move_right title="右移一位"></a>';
				inhtml+='<a class=delete  title="删除"></a>';
			inhtml+='</div>';

		inhtml+='</div>';

		let _temp=$(inhtml);

		_temp.find('img').attr('src',_img.src);

		_piclist.append(_temp);

		__lpwidget__._upload_commonuse.selectfile_selectedfilesmap[id]=file;

	}

	__lpwidget__.uploadpic.up_render(_widget);

	__lpwidget__.uploadpic.up_selectedfiles_uploadloop();

	_this.val('');

});

_document.on('click','[__uploadpic__=uploadpic] [uploadpic_role=up_picitem] a.delete',function(event)
{
	var _this=$(this).closest('[uploadpic_role=up_picitem]');

	var _widget=_this.closest('[__uploadpic__=uploadpic]');

	ui_confirm('确定删除?',function()
	{

		var upload_id=_this.attr('uploadpic_id');

		var _file=false;

		if(upload_id)
		{
			_file=__lpwidget__._upload_commonuse.selectfile_selectedfilesmap[upload_id];
		}
		if(_file&&_file===__lpwidget__._upload_commonuse.ajax_uploading_jqxhr.current_uploading_file)
		{
			console_log_wreckage('13','lovephp/0329/2925/删除/取消上传');
			__lpwidget__._upload_commonuse.ajax_uploading_jqxhr.abort();
		}
		else
		{

			console_log_wreckage('23','lovephp/0328/2928/删除/直接删除');

			_this.remove();

			__lpwidget__.uploadpic.up_render(_widget);

		}

	});

});


_document.on('click','[__uploadpic__=uploadpic] [uploadpic_role=up_picitem] a.move_left',function(event)
{

	var _this=$(this);
	var _widget=_this.closest('[__uploadpic__=uploadpic]');

	_this=_this.closest('[uploadpic_role=up_picitem]');
	_this.insertBefore(_this.prev());
	__lpwidget__.uploadpic.up_render(_widget);

});
_document.on('click','[__uploadpic__=uploadpic] [uploadpic_role=up_picitem] a.move_right',function(event)
{

	var _this=$(this);
	var _widget=_this.closest('[__uploadpic__=uploadpic]');

	_this=_this.closest('[uploadpic_role=up_picitem]');
	_this.insertAfter(_this.next());
	__lpwidget__.uploadpic.up_render(_widget);

});

