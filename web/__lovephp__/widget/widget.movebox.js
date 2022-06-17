
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


_document.ready(function()
{

	if($('[__movebox__=movebox]').length)
	{
		_document.on('mousedown','[__movebox__=movebox] [movebox_role=dragbox]',function(event)
		{

			var _drag=$(this).closest('[__movebox__=movebox]');

			var _drag_pos=_drag.dompos_get();

			mouseevent_regist(event,function(pos_offset,pos_abs)
			{
				_drag.css(
				{
					left:(pos_offset.x+_drag_pos.x)+'px',
					top:(pos_offset.y+_drag_pos.y)+'px',
				});
			});

		});

	}

});

