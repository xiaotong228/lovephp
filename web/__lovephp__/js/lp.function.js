
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

//1 console
var console_history_data=[];

function console_log()
{//输出consolelog,上线时建议关闭

	if(0&&__lpvar__.__online_isonline__)
	{
		return;
	}

	var arg_0=int_intval(arguments[0]);
	var arg_1=arguments[1];

	if(0)
	{//辅助调试,如果是没法调试的浏览器环境,用这个凑合一下,也有些开源的js可以辅助调试,可以去网上找下

		var text=[];
		for(var i in arguments)
		{
			if(object_isobject(arguments[i]))
			{
				text.push(JSON.stringify(arguments[i]));
			}
			else
			{
				text.push(arguments[i]);
			}
		}
		console_history_data.push(text.join('/'));

	}

	arguments[0]='%c'+arg_1;
	arguments[1]='color:#fff;background:#'+__lpconfig__.html_randomcolors[arg_0]+';';

	return console.log.apply(this,arguments);

}

function console_log_wreckage()
{

}

function console_history_alert()
{//需要在console_log开启记录history

	alert(console_history_data.join("\n"));

}
function console_history_clear()
{

	if(confirm('确定清除?'))
	{
		console_history_data=[];
		ui_toast('已清除');
	}

}
//1 route
function route_judge_js(module,controller,action)
{

	if(false===module)
	{
		module=__lpvar__.route_routeinfo.module;
	}

	if(false===controller)
	{
		controller=__lpvar__.route_routeinfo.controller;
	}

	if(false===action)
	{
		action=__lpvar__.route_routeinfo.action;
	}

	return (
		__lpvar__.route_routeinfo.module==module&&
		__lpvar__.route_routeinfo.controller==controller&&
		__lpvar__.route_routeinfo.action==action
	);

}
//1 array

function array_reverse_js(ary)
{

	var ary_new=[];

	for(var i=ary.length-1;i>=0;i--)
	{
		ary_new.push(ary[i]);
	}

	return ary_new;

}
function array_unique_js(ary)
{

	var ary_new=[];

	for(var i in ary)
	{
		if(-1===ary_new.indexOf(ary[i]))
		{
			ary_new.push(ary[i]);
		}
	}

	return ary_new;

}
function array_isarray(ary)
{
	if(0)
	{//为啥不用这个,忘了,2022年1月18日16:37:19
		return Array.isArray(ary);
	}

	return ary instanceof Array;

}
function array_isempty(ary)
{
	for(var i in ary)
	{
		if(undefined!==ary[i])
		{
			return false;
		}
	}

	return true;
}
function array_inarray(key,ary)
{
	return (ary.indexOf(key)>=0)?true:false;
}
function array_deletevalue(ary,value)
{
	for(var i=0; i<ary.length; i++)
	{
		if(ary[i]==value)
		{
			ary.splice(i,1);
		}
	}
	return ary;
}
function array_randkey(ary)
{

	var index=Math.floor(Math.random()*ary.length);

	index=Math.min(ary.length-1,index);

	return index;

}
//1 math
var math_salt_js_index=0;
function math_salt_js()
{
	if(1)
	{//生成4位字母+8位数字的随机字符串
		var chars=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
		var res='';
		for(var i=0; i<4; i ++)
		{
			var id = Math.floor(Math.random()*26);
			res+=chars[id];
		}
		res+=Math.floor(Math.random()*99999999);
		return res;
	}
	else
	{//如果不想随机只是想挨个递增
		math_salt_js_index++;
		return 'salt'+math_salt_js_index;
	}
}
//1 time
function time_js()
{
	return int_intval((new Date().getTime())/1000);
}
function time_server_js()
{//混根据服务器下发的时间校准
	return time_js()+time_serveroffset;
}
function time_ms_js()
{
	return int_intval(new Date().getTime());
}
function time_str_js(time,onlynum=false)
{

	if(!time)
	{
		time=time_js();
	}

	time=int_intval(time)*1000;

	var date=new Date(time);

	var temp=
	[
		date.getFullYear(),
		date.getMonth()+1,
		date.getDate(),
		date.getHours(),
		date.getMinutes(),
		date.getSeconds()
	];

	for(let i in temp)
	{

		temp[i]=temp[i].toString();

		if(0==i)
		{
			temp[i]=temp[i].padStart(4,'0');
		}
		else
		{
			temp[i]=temp[i].padStart(2,'0');
		}

	}

	if(onlynum)
	{
		return temp[0]+''+temp[1]+''+temp[2]+'_'+temp[3]+''+temp[4]+''+temp[5];
	}
	else
	{
		return temp[0]+'.'+temp[1]+'.'+temp[2]+' '+temp[3]+':'+temp[4]+':'+temp[5];
	}

}
function time_str_num_js(time)
{
	return time_str_js(time,1);
}
//1 jump
function jump_jump(url)
{//window.top.location.href=url;window.top.location.reload();

	if(url)
	{
		location.href=url;
	}
	else
	{
		location.reload();
	}

}
function jump_opennewwindow(url)
{
	window.open(url);
}
function jump_webview(url,headers=false)
{

	if(client_is_app_js())
	{

		if(url)
		{
			if(0===url.indexOf('/'))
			{//加了这一段,还没有测试,也许不用添加orign也可以,需要看下dcloud的文档
				url+=location.origin;
			}

			plus.webview.currentWebview().loadURL(url,headers)
		}
		else
		{
			plus.webview.currentWebview().reload();
		}

	}
	else
	{
		return jump_jump(url);
	}

}
//1 url
function url_build_js(_url,_args=false)
{//_url=new URL(_url);不要用这个,这个必须以http开头

	var sep;

	if(-1===_url.indexOf('?'))
	{
		sep='?';
	}
	else
	{
		sep='&';

	}

	for(var i in _args)
	{
		if(var_isavailable_js(_args[i]))
		{
			_url+=sep+i+'='+encodeURIComponent(_args[i]);
			sep='&';
		}
	}

	return _url;

}
function url_get_hash(url)
{

	url=url.split('#');

	url=url[1];

	return url?url:'';

};

//1 object
function object_copy(a)
{
	return object_merge(a);
}
function object_merge(a,b,c,d)
{
	a=a?a:{};
	b=b?b:{};
	c=c?c:{};
	d=d?d:{};
	return $.extend({},a,b,c,d);
}
function object_merge_deep(a,b,c,d)
{
	a=a?a:{};
	b=b?b:{};
	c=c?c:{};
	d=d?d:{};
	return $.extend(true,{},a,b,c,d);
}
function object_isobject(data)
{

	var type=typeof(data);

	if('object'==type&&!array_isarray(data))
	{
		return true;
	}
	else
	{
		return false;
	}

}

//1 function
function function_call()
{

	arguments=Array.prototype.slice.apply(arguments);

	var func=arguments[0];

	if(!func)
	{
		return;
	}

	var args=arguments.splice(1);

	if(function_isfunction(func))
	{
		if('string'==typeof func)
		{
			func=eval(func);
		}

		return func.apply(this,args);
	}
	else
	{
		return eval(func);
	}

}
function function_isfunction(value)
{

	var preg=/^[a-zA-Z_][a-zA-Z_\d]*$/;

	if('function'===typeof(value))
	{
		return true;
	}
	else if('string'===typeof(value))
	{//用eval判断会多次执行

		return preg.test(value);

		if(0)
		{
			var temp=false;
			try
			{
				temp=typeof(eval(value));
			}
			catch(e)
			{

			}
			if('function'===temp)
			{
				return true;
			}
			else
			{
				return false;
			}

		}

	}
	else
	{
		return false;
	}

}
//1 databind
function databind_databind(_this,key,set_cb)
{//Proxy也可以做到,就是比较麻烦

	let cache=_this[key];

	Object.defineProperty(_this,key,
	{

		get:function()
		{
			return cache;
		},

	    set: function(data)
		{
			let cache_before=cache;
			cache=data;
			set_cb(data,cache_before);
		}

	});

}
function mpx_to_vw_js(mpx)
{
	var width=_window.window_width_cache;

	var px=mpx*width/__lpconfig__.mobile_page_design_px;

	return px;
}
function distance_calcdistance(pos0,pos1)
{

    var x=pos0.x-pos1.x;

    var y=pos0.y-pos1.y;

    return Math.sqrt((x*x)+(y*y));

}
function css_object_append_px(pos)
{
	var css_obj={};

	for(var k in pos)
	{

		var v=pos[k];

		if('x'==k)
		{
			k='left';
		}
		if('y'==k)
		{
			k='top';
		}

		if(
			'left'==k||
			'top'==k||
			'right'==k||
			'bottom'==k||
			'width'==k||
			'height'==k
		)
		{
			css_obj[k]=v+'px';
		}
	}
	return css_obj;

}
//1 var
function var_isavailable_js(data)
{
	if(null===data||''===data||'undefined'===typeof(data))
	{
		return false;
	}
	else
	{
		return true;
	}
}

//1 int
function int_intval(str)
{

	if(!str)
	{
		str=0;
	}

	var num=str.toString();

	num=parseInt(num);

	if(isNaN(num))
	{
		return 0;
	}
	else
	{
		return num;
	}
}
//1 float
function float_floatval(str)
{

	if(!str)
	{
		str=0;
	}

	var num=str.toString();

	num=parseFloat(num);

	if(isNaN(num))
	{
		return 0;
	}
	else
	{
		return num;
	}
}


//1 br2nl
function br2nl_js(str)
{
	return str.replace(/\<\s*br\s*\/?\s*\>/ig,"\n");
}
//1 document
function document_events()
{//返回当前document上面注册的events

	return $._data(document,'events');

}
//1 copy
function copy_copytext(text,showcontent)
{
    var _input=document.createElement('input')

    _input.setAttribute('value',text);

    document.body.appendChild(_input);

    _input.select();

    var result=document.execCommand('copy');

    document.body.removeChild(_input);

	if(result)
	{
		if(showcontent)
		{
			ui_toast('复制成功:<br>'+text);
		}
		else
		{
			ui_toast('复制成功');
		}

	}
	else
	{
		ui_toast('复制失败,你的浏览器不支持此操作');
	}

}
//1 datasize
function datasize_oralstring_js(size)
{
	if(size<<?php echo datasize_1kb;?>)
	{
		return size+'字节';
	}
	else if(size<<?php echo datasize_1mb;?>)
	{
		size=size/<?php echo datasize_1kb;?>;
		size=nf_2_js(size);
		return size+'KB';
	}
	else
	{
		size=size/<?php echo datasize_1mb;?>;
		size=nf_2_js(size);
		return size+'MB';
	}

}
//1 nf
function nf_2_js(num,digit=2)
{

	digit=Math.pow(10,digit);

	return Math.round(num*digit)/digit;

}
