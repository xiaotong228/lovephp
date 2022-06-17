
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

<?php
	require __lp_dir__.'/widget/widget.uploadpic.js';
?>

_document.on('click','[__uploadpic__=uploadpic] [uploadpic_role=up_picitem]>a',function(event)
{

	var _this=$(this).closest('[uploadpic_role=up_picitem]');

	var index=_this.index();

	var urls=[];

	_this.parent().find('[uploadpic_status=done]>a').each(function()
	{
		urls.push($(this).attr('href'));
	});

	__lpwidget__.picgallery.pg_open(urls,index);

	event.preventDefault();

});

