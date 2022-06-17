
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


<?php
	require __lp_dir__.'/widget/widget.uploadfile.js';
?>

_document.on('click','[__uploadfile__=uploadfile] [uploadfile_role=uf_fileitem] .filename>a',function(event)
{
	event.preventDefault();
});

_document.on('click','[__uploadfile__=uploadfile] [uploadfile_role=uf_fileitem] .filename',function(event)
{

	var _this=$(this).closest('[uploadfile_role=uf_fileitem]');

	var _this_a;

	if('done'==_this.attr('uploadfile_status'))
	{
		_this_a=_this.find('a');
		file_download_file(_this.find('a').attr('href'),_this_a.html());
	}

});