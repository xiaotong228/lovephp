
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

_document.ready(function()
{


    const _editor=new window.wangEditor('#wangeditor_div');

    const _textarea=$('#wangeditor_textarea');

	_editor.config.uploadImgServer=__lpvar__.wangeditor_uploadconfig.upload_url;
	_editor.config.uploadImgMaxSize=__lpvar__.wangeditor_uploadconfig.file_maxsize;
	_editor.config.height=700;
	_editor.config.zIndex=10;

	_editor.config.colors=
	[

'#000000',
'#ffffff',
'#c0c0c0',
'#ff0000',

'#ffff00',
'#ff00ff',
'#00ffff',
'#00ff00',

'#0000ff',
'#808080',
'#008000',
'#800000',

'#000080',
'#808000',
'#800080',
'#008080',

	];

	_editor.config.onchange=function(html)
	{
		_textarea.val(html)
	}

	_editor.config.uploadImgHooks=
	{
	    customInsert:function(insertImgFn,result)
	   	{

			ajax_on_success(result,function(data)
			{
				for(let i in data)
				{
					insertImgFn(data[i].url);
				}
			},
			function(data)
			{
				ui_toast(data);
			});
	    }
	}

    _editor.create()

    _textarea.val(_editor.txt.html());

});

