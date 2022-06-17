
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


//ajax
const cmd_ajax_nodefaulterrortips='<>cmd_ajax_nodefaulterrortips.1';

//slider
const cmd_slider_prev='<>cmd_slider_prev.10';
const cmd_slider_next='<>cmd_slider_next.11';

//touchevent
const cmd_touchevent_preventdefault=0b00000001;

const cmd_touchevent_stoppropagation=0b00000010;

const cmd_touchevent_unregist=0b00000100;

const time_serveroffset=__lpvar__.sever_currenttime-time_js();

$.fn.extend(new function()
{

	this.tag_tagname_get=function()
	{
		if(this[0].tagName)
		{
			return this[0].tagName.toLowerCase();
		}
		else
		{
			return false;
		}

	};
	this.css_bgimage_get=function()
	{

		var image_url=this.css('background-image');

		var reg=/url\(\"?([^\"]*)\"?\)/i;

		var data=reg.exec(image_url);

		return data?data[1]:'';

	};
	this.input_focustailcursor=function()
	{
		var temp=this.val();
		this.val('').focus().val(temp);
	};
	this.find_includeself=function(sel)
	{
		if(this.is(sel))
		{//如果自身满足条件,就返回自身
			return this;
		}
		else
		{
			return this.find(sel);
		}
	};

//1 dompos
	this.dompos_get=function()
	{

		var offset=this.offset();
		var position=this.position();

		return {
			x:position.left,
			y:position.top,
			abs_x:offset.left,
			abs_y:offset.top,
			width:this.width(),
			height:this.height(),
			outer_width:this.outerWidth(),
			outer_height:this.outerHeight(),
		};
	};
	this.dompos_physic=function()
	{//返回元素在屏幕中的绝对位置,包含边框,考虑scale

		var temp=this[0].getBoundingClientRect();

		return {
			x:temp.x,
			y:temp.y,
			width:temp.width,
			height:temp.height,
		};
	};
//1 scrollpos
	this.scrollpos_get=function()
	{
		var pos=this.dompos_get();

		var temp=
		{
			x:this[0].scrollLeft,
			y:this[0].scrollTop,
			width:this[0].scrollWidth,
			height:this[0].scrollHeight
		};

		temp.remain_x=temp.width-pos.width-temp.x;
		temp.remain_y=temp.height-pos.height-temp.y;

		temp.viewport_width=pos.width;
		temp.viewport_height=pos.height;

		return temp;

	};

	this.scrollpos_set_x=function(value)
	{
		this[0].scrollLeft=value;
		return this;
	};

	this.scrollpos_set_y=function(value)
	{
		this[0].scrollTop=value;
		return this;
	};
//1 data
	this.data_getconfig=function(key)
	{
		return this.data_get(key+'_config');
	};
	this.data_setconfig=function(key,data)
	{
		return this.data_set(key+'_config',data);
	};

	this.data_get=function(key)
	{

		var data=this.attr(key);

		if(data)
		{
			data=JSON.parse(data);
		}
		else
		{
			data=false;
		}

		return data;

	};

	this.data_set=function(key,data)
	{

		data=JSON.stringify(data);

		return this.attr(key,data);

	};

//1 ani
	this.ani_sink=function(cb_before,cb_after=false)
	{

		var _this=this;

		cb_before.call(_this);

		var duration=_this.css('transition-duration');

		var reg0=/[\d\.]+ms$/;
		var reg1=/[\d\.]+s$/;

		if(reg0.test(duration))
		{
			duration=float_floatval(duration);
		}
		else if(reg1.test(duration))
		{
			duration=float_floatval(duration)*1000;
		}
		else
		{
			duration=0;
		}

		_this.off('transitionend').one('transitionend',function(event)
		{
			if(cb_after)
			{
				cb_after.call(this);
				cb_after=false;
			}
		});

		if(_this.visible_isvisible())
		{
			if(duration)
			{
				setTimeout(function()
				{//保底
					if(cb_after)
					{
						cb_after.call(_this[0]);
					}
					else
					{

					}

				},duration+100);
			}
			else
			{//可能是子元素有ani,父元素截取冒泡事件

			}

		}
		else
		{
			cb_after.call(_this[0]);
		}

		return this;

	}
	this.ani_css=function(cssobj,callback)
	{
		return this.ani_sink(function()
		{
			this.css(cssobj);
		},callback);
	};
	this.ani_css_commonani=function(cssobj,callback)
	{

		var _this=this;
		return this.addClass('__ani_common__').ani_css(cssobj,function()
		{
			_this.removeClass('__ani_common__');
			if(callback)
			{
				callback.call(this);
			}
		});


	};

	this.ani_attr=function(attrobj,callback)
	{
		return this.ani_sink(function()
		{
			this.attr(attrobj);
		},callback);

	};

	this.ani_attr_remove=function(key,callback)
	{
		return this.ani_sink(function()
		{
			this.removeAttr(key);
		},callback);
	};
//1 visible
	this.visible_isvisible=function()
	{
		return this.is(':visible');
	};
//1 exist
	this.exist_isexist=function()
	{//是否存在于body之中
		return this.closest('body').length?true:false;
	};
//1 serialize_object
	this.serialize_object=function(domName)
	{

		var data=this.serializeArray();

		var new_data={};

		var reg=/\[\]$/;

		for(var i in data)
		{
			var key=data[i].name;
			var value=data[i].value;

			if(reg.test(key))
			{
				key=key.replace(reg,'');

				if(undefined===new_data[key])
				{
					new_data[key]=[];

				}
				new_data[key].push(value);
			}
			else
			{
				new_data[key]=value;
			}

		}

		return new_data;
	};

	this.attr_toggle=function(key,value)
	{

		var currentvalue=this.attr(key);

		if(value==currentvalue)
		{
			return this.removeAttr(key);
		}
		else
		{
			return this.attr(key,value);
		}

	};

});

var _window=$(window);
_window.window_width_cache=_window.width();
_window.window_height_cache=_window.height();

var _document=$(document);

var _body=$('body');

var test____0;
var test____1;
var test____2;
var test____3;
var test____4;
var test____5;
var test____6;
var test____7;
var test____8;
var test____9;

var test____multitouch=0;

var test____pullrefresh_delay=0;

