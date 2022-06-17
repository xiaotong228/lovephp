
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

function file_ext_get_js(url/*url|filename*/)
{

	url=url.split('?')[0];

	url=url.split('/');

	url=url[url.length-1];

	if(-1==url.indexOf('.'))
	{
		return false;
	}
	else
	{

	    var index=url.lastIndexOf('.');

	    var ext=url.substr(index+1).toLowerCase();

		return ext?ext:false;

	}

}

//1 download
function file_download_file(url,filename='')
{

	var web_download_sink=function()
	{//普通web下载流程
		console_log_wreckage('49','lovephp/0414/web_download_sink/web_download_sink',url,filename);

		var link=document.createElement('a');

		link.href=url;

		link.download=filename;

		link.click();

		window.URL.revokeObjectURL(link.href);//回收

		if(client_is_app_js())
		{
			ui_toast('启动下载后下拉状态栏查看进度');
		}
	};

	if(client_is_app_js())
	{
		mobile_app_download_file(url,filename,web_download_sink);
	}
	else
	{
		web_download_sink();
	}

}
function file_download_file_localfile(file)
{

	var blob=new Blob([file],{type: ''});

	var link=document.createElement('a');

	link.href=window.URL.createObjectURL(blob);

	link.download=file.name;

	link.click();

	window.URL.revokeObjectURL(link.href);//回收

	if(client_is_app_js())
	{
		ui_toast('启动下载后下拉状态栏查看进度');
	}

}
function file_base64_to_file(base64str,filename)
{

	var arr=base64str.split(',');

	var mime=arr[0].match(/:(.*?);/)[1];

	var bstr=atob(arr[1]);

	var n=bstr.length;

	var u8arr =new Uint8Array(n);

	while(n--)
	{
		u8arr[n]=bstr.charCodeAt(n);
	}

	return new File([u8arr],filename,{type:mime});

}
//1 img
async function img_load_from_file(_file)
{

	if(undefined!==_file.file_img_cache)
	{
		console_log_wreckage('00','lovephp/img_load_from_file/图片已缓存');
		return _file.file_img_cache;
	}

	return new Promise(function(_resolve)
	{

		var _reader=new FileReader();

		_reader.onload = function(event)
		{
			var _img=new Image();

			_img.onerror=function(a)
			{
				_file.file_img_cache=false;
				_resolve(false);
			};
			_img.onload=function()
			{
				_file.file_img_cache=_img;
				_resolve(_img);
			};

			_img.src=this.result;

		}

		_reader.readAsDataURL(_file);

	});

}
async function img_load_from_url(_url)
{

	return new Promise(function(_resolve)
	{

		var _img=new Image();

		_img.onerror=function(a)
		{
			_resolve(false);
		};
		_img.onload=function()
		{
			_resolve(_img);
		};

		_img.src=_url;

	});

}
function img_to_base64(img)
{
	var canvas=document.createElement('canvas');
	canvas.width=img.width;
	canvas.height=img.height;

	var ctx=canvas.getContext('2d');
	ctx.drawImage(img,0,0,img.width, img.height);

	var ext=file_ext_get_js(img.src);

	if('jpg'==ext||'jpeg'==ext)
	{
		ext='jpeg';
		img.img_file_ext='jpg';
	}
	else
	{
		ext='png';
		img.img_file_ext='png';
	}

	var dataURL=canvas.toDataURL('image/'+ext);

	return dataURL;

}

//1 imgfile
async function imgfile_resize_maxpixel(_file,max_pixels)
{

	var _img=await img_load_from_file(_file);

	var current_pixel=_img.width*_img.height;

	var ratio=false;

	if(current_pixel<=max_pixels)
	{
		return _file;
	}
	else
	{
		ratio=Math.sqrt(max_pixels/current_pixel);
		return await imgfile_cut(_file,0,0,0,0,int_intval(_img.width*ratio),int_intval(_img.height*ratio));
	}

}
async function imgfile_cut
(
	_file,

	cut_x=0,

	cut_y=0,

	cut_width=0,

	cut_height=0,

	max_width=0,

	max_height=0,

	rotate_angle=false
)
{
/*
cut_width=0:读取图片原始宽度
cut_height=0:读取图片原始高度
*/

	var _img=await img_load_from_file(_file);

	if(!_img)
	{
		return false;
	}

	var __ext=file_ext_get_js(_file.name);

	var __type;

	if('jpg'==__ext||'jpeg'==__ext)
	{//除了jpg之外全部按png处理
		__ext='jpg';
		__type='image/jpeg';
	}
	else
	{
		__ext='png';
		__type='image/png';
	}


	if(!cut_width)
	{
		cut_width=_img.width;
	}
	if(!cut_height)
	{
		cut_height=_img.height;
	}

	var canvas_width_0=cut_width;
	var canvas_height_0=cut_height;

	var canvas_width_1=cut_width;
	var canvas_height_1=cut_height;

	var canvas_width;
	var canvas_height;

	if(1)
	{//考虑缩放设置canvas尺寸
		if(max_width&&cut_width>max_width)
		{
			canvas_width_0=max_width;
			canvas_height_0=canvas_width_0*(cut_height/cut_width);
		}
		if(max_height&&cut_height>max_height)
		{
			canvas_height_1=max_height;
			canvas_width_1=canvas_height_1*(cut_width/cut_height);
		}

		canvas_width=int_intval(Math.min(canvas_width_0,canvas_width_1));
		canvas_height=int_intval(Math.min(canvas_height_0,canvas_height_1));
	}

	return new Promise(function(_resolve)
	{

		var _canvas=document.createElement('canvas');

		var context=_canvas.getContext('2d');

		if(90==rotate_angle||-90==rotate_angle)
		{
			_canvas.width=canvas_height;
			_canvas.height=canvas_width;
		}
		else
		{
			_canvas.width=canvas_width;
			_canvas.height=canvas_height;
		}

		context.clearRect(0,0,canvas_width,canvas_height);

		if(90==rotate_angle)
		{
			context.rotate(rotate_angle*Math.PI/180);
			context.drawImage(_img,cut_x,cut_y,cut_width,cut_height,0,-canvas_height,canvas_width,canvas_height);
//						context.drawImage(_img,cut_x,cut_y,cut_width,cut_height,-100,-100,canvas_width,canvas_height);
		}
		else if(-90==rotate_angle)
		{
			context.rotate(rotate_angle*Math.PI/180);
			context.drawImage(_img,cut_x,cut_y,cut_width,cut_height,-canvas_width,0,canvas_width,canvas_height);
//						context.drawImage(_img,cut_x,cut_y,cut_width,cut_height,-100,-100,canvas_width,canvas_height);
//						context.drawImage(_img,-cut_width,0,cut_width,cut_height,0,0,canvas_width,canvas_height);
		}
		else if(180==rotate_angle)
		{
			context.rotate(rotate_angle*Math.PI/180);
			context.drawImage(_img,cut_x,cut_y,cut_width,cut_height,-canvas_width,-canvas_height,canvas_width,canvas_height);
//						context.drawImage(_img,-cut_width,-cut_height,cut_width,cut_height,0,0,canvas_width,canvas_height);
		}
		else
		{
			context.drawImage(_img,cut_x,cut_y,cut_width,cut_height,0,0,canvas_width,canvas_height);
		}

		_canvas.toBlob(function(blob)
		{
			var tempfile=new File([blob],math_salt_js()+'.'+__ext,{type:__type});

			if(0)
			{
				_body.append(_canvas);
			}

			_resolve(tempfile);

		},__type);


/*
		_body.append($(_canvas).css(
				{
					position:'absolute',
						left:0,
						top:0,
						background:'red'
						}));
		*/


	});

}
async function imgfile_rotate(file,rotate_angle)
{//rotate_angle=90/-90/180

	var file_new=await imgfile_cut(file,0,0,0,0,0,0,rotate_angle);
	return file_new;

/*
	rotate_angle=int_intval(rotate_angle);

	if(!rotate_angle&&device_isPhone())
	{//只针对iphone

	    EXIF.getData(_file,function()
		{

//			alert(EXIF.pretty(this));//展示exif信息
//	        EXIF.getAllTags(this);

	        var/*protect_3901* / orientation=EXIF.getTag(this,'Orientation');

//			alert(orientation);

			orientation=int_intval(orientation);

			if(6==orientation)
			{
				rotate_angle=90;
			}
			else if(8==orientation)
			{
				rotate_angle=-90;
			}
			else if(3==orientation)
			{
				rotate_angle=180;
			}
			else
			{

			}

			sink_sinkfunc();

	    });


	}
	else
	{
		sink_sinkfunc();
	}
	*/
}
