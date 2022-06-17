
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

function touchevent_regist
(

	__target,//原生

	__event,//原生

	__move,

	__end=false,

	__listendirection=false/*x|y|x+|x-|y+|y-*/

)
{

	var __data={};

	__data.__target=__target;

	var temp=[];
	for(let i =0;i<__event.touches.length;i++)
	{
		temp.push(
		{
			x:__event.touches[i].clientX,
			y:__event.touches[i].clientY,
		});
	}

	if(test____multitouch)
	{
		temp.push(
		{
			x:temp[0].x*2,
			y:temp[0].y*2,
		});
	}

	__data.touchstart_touchpos=temp;
	__data.touchmove_movecount=0;
	__data.touchmove_listendirection=__listendirection;

	var __unregist=function()
	{

		__target.removeEventListener('touchmove',__move_1);
		__target.removeEventListener('touchend',__end_1);
		__target.removeEventListener('touchcancel',__end_1);

	};

	var __end_1=function(event)
	{

		let endresult=0;

		if(__end)
		{
			endresult=__end(event);
		}

		if(endresult&cmd_touchevent_preventdefault)
		{
			event.preventDefault();
		}

		if(endresult&cmd_touchevent_stoppropagation)
		{
			event.stopPropagation();
		}

		__unregist();

	};

	var __move_1=function(event)
	{

		var touchposinfo=touchevent_touchposinfo_get(event,__data.touchstart_touchpos);

		var directionmatch;

		if(0==__data.touchmove_movecount&&__listendirection)
		{//截取到第一次移动event的时判断移动方向是否匹配
			if(
				(__listendirection==touchposinfo.move_direction)||
				('x'==__listendirection&&('x+'==touchposinfo.move_direction||'x-'==touchposinfo.move_direction))||
				('y'==__listendirection&&('y+'==touchposinfo.move_direction||'y-'==touchposinfo.move_direction))
			)
			{
				directionmatch=true;
			}
			else
			{
				directionmatch=false;
			}
		}
		else
		{
			directionmatch=true;
		}

		if(directionmatch)
		{

			let moveresult=__move(event,touchposinfo,__data.touchmove_movecount);

			moveresult=int_intval(moveresult);

			if(moveresult&cmd_touchevent_preventdefault)
			{
				event.preventDefault();
			}

			if(moveresult&cmd_touchevent_stoppropagation)
			{
				event.stopPropagation();
			}

			if(moveresult&cmd_touchevent_unregist)
			{
				__unregist();
			}

		}
		else
		{
			__unregist();
		}

		__data.touchmove_movecount++;

	};

	__target.addEventListener('touchmove',__move_1);
	__target.addEventListener('touchend',__end_1);
	__target.addEventListener('touchcancel',__end_1);

}

function touchevent_touchposinfo_get(event,touchstart_posinfo/*touchstart_posinfo*/)
{

	var __posinfo={};

	__posinfo.pos_current=
	{
		x:event.touches[0].clientX,
		y:event.touches[0].clientY
	};

	__posinfo.pos_offset=
	{
		x:__posinfo.pos_current.x-touchstart_posinfo[0].x,
		y:__posinfo.pos_current.y-touchstart_posinfo[0].y
	};

	if(Math.abs(__posinfo.pos_offset.x)>=Math.abs(__posinfo.pos_offset.y))
	{
		if(__posinfo.pos_offset.x>=0)
		{
			__posinfo.move_direction='x+';
		}
		else
		{
			__posinfo.move_direction='x-';
		}
	}
	else
	{
		if(__posinfo.pos_offset.y>=0)
		{
			__posinfo.move_direction='y+';
		}
		else
		{
			__posinfo.move_direction='y-';
		}
	}

		var multitouch_info=false;

		if(test____multitouch)
		{
			multitouch_info={};
			multitouch_info.multitouch_poslist=[];
			multitouch_info.multitouch_poslist.push(__posinfo.pos_current);
			multitouch_info.multitouch_poslist.push(
			{
				x:__posinfo.pos_current.x*2,
				y:__posinfo.pos_current.y*2,
			});
		}
		else
		{

			if(event.touches.length>=2&&touchstart_posinfo.length>=2)
			{

				multitouch_info={};
				multitouch_info.multitouch_poslist=[];

				for(let i=0;i<event.touches.length;i++)
				{
					multitouch_info.multitouch_poslist.push(
					{
						x:event.touches[i].clientX,
						y:event.touches[i].clientY,
					});
				}
			}

		}
		if(multitouch_info)
		{
			multitouch_info.te_centerpos=
			{
				x:(touchstart_posinfo[0].x+touchstart_posinfo[1].x)/2,
				y:(touchstart_posinfo[0].y+touchstart_posinfo[1].y)/2,
			};
			multitouch_info.te_scaleratio=
				distance_calcdistance(multitouch_info.multitouch_poslist[0],multitouch_info.multitouch_poslist[1])/
				distance_calcdistance(touchstart_posinfo[0],touchstart_posinfo[1])
				;
		}

	__posinfo.multitouch_info=multitouch_info;

	return __posinfo;

}

function touchevent_regist_hover
(
	__target,//原生,
	__end
)
{

	var __end_1=function(event)
	{

		__end(event);

		__target.removeEventListener('touchmove',__end_1);
		__target.removeEventListener('touchend',__end_1);
		__target.removeEventListener('touchcancel',__end_1);

	};

	__target.addEventListener('touchmove',__end_1,{once:true});
	__target.addEventListener('touchend',__end_1,{once:true});
	__target.addEventListener('touchcancel',__end_1,{once:true});
}


