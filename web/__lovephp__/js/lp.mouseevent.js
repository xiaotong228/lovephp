
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


var mouseevent_mousemove_callback=false;
var mouseevent_mouseup_callback=false;

var mouseevent_mousedown_snappos=false;

function mouseevent_mousemove(event)
{


	var pos_abs=
	{
		x:event.clientX,
		y:event.clientY
	};

	var pos_offset=
	{
		x:pos_abs.x-mouseevent_mousedown_snappos.x,
		y:pos_abs.y-mouseevent_mousedown_snappos.y
	};

	if(mouseevent_mousemove_callback)
	{
		mouseevent_mousemove_callback(pos_offset,pos_abs);
	}

}
function mouseevent_mouseup(event)
{

	var pos_abs=
	{
		x:event.clientX,
		y:event.clientY
	};

	var pos_offset=
	{
		x:pos_abs.x-mouseevent_mousedown_snappos.x,
		y:pos_abs.y-mouseevent_mousedown_snappos.y
	};

	if(mouseevent_mouseup_callback)
	{
		mouseevent_mouseup_callback(pos_offset,pos_abs)
	}

	mouseevent_mousedown_snappos=false,
	mouseevent_mousemove_callback=false,
	mouseevent_mouseup_callback=false,

	_document.off('mousemove',mouseevent_mousemove);
	_document.off('mouseup',mouseevent_mouseup);

}

function mouseevent_regist(event,mousemove_callback,mouseup_callback)
{
	mouseevent_mousedown_snappos=
	{
		x:event.clientX,
		y:event.clientY
	};

	if(mousemove_callback)
	{
		mouseevent_mousemove_callback=mousemove_callback;
	}
	if(mouseup_callback)
	{
		mouseevent_mouseup_callback=mouseup_callback;
	}

	_document.on('mousemove',mouseevent_mousemove);
	_document.on('mouseup',mouseevent_mouseup);

}
