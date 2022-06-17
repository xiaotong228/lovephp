<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



/*

参考:https://developer.mozilla.org/zh-CN/docs/Web/HTML/Element

模板代码

//1 {__tag_name__}
function _{__tag_name__}($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('{__tag_name__}'):0;return '<{__tag_name__} '.$tail.' >';}
function _{__tag_name__}_(){__htmltag_check__?htmltag_pop('{__tag_name__}'):0;return '</{__tag_name__}>';}
function _{__tag_name__}__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<{__tag_name__} '.$tail.' >'.$inhtml.'</{__tag_name__}>';}

*/

//1 htmltag
function htmltag_push($tag=null)
{
	global $____htmltag_stack;
	$____htmltag_stack[]=$tag;
}
function htmltag_pop($tag=null)
{
	global $____htmltag_stack;

	$top_tag=end($____htmltag_stack);

	if($top_tag!=$tag)
	{
		R_exception('[error-3527/html标签闭合错误]:'.$tag);
	}

	array_pop($____htmltag_stack);

}
function htmltag_check()
{

	global $____htmltag_stack;

	if(count($____htmltag_stack))
	{
		R_exception('[error-4115/html标签闭合错误]:'.impd($____htmltag_stack));
	}

}

//1 x
function _x($tag,$cls=null,$sty=null,$tail=null)
{
	$cls?$tail.=' class=\''.$cls.'\'':0;
	$sty?$tail.=' style=\''.$sty.'\'':0;
	__htmltag_check__?htmltag_push($tag):0;
	return '<'.$tag.' '.$tail.' >';
}
function _x_($tag)
{
	__htmltag_check__?htmltag_pop($tag):0;
	return '</'.$tag.'>';
}
function _x__($tag,$cls=null,$sty=null,$tail=null,$inhtml=null)
{
	$cls?$tail.=' class=\''.$cls.'\'':0;
	$sty?$tail.=' style=\''.$sty.'\'':0;
	return '<'.$tag.' '.$tail.' >'.$inhtml.'</'.$tag.'>';
}

//1 div
function _div($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('div'):0;return '<div '.$tail.' >';}
function _div_(){__htmltag_check__?htmltag_pop('div'):0;return '</div>';}
function _div__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<div '.$tail.' >'.$inhtml.'</div>';}

//1 span
function _span($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('span'):0;return '<span '.$tail.' >';}
function _span_(){__htmltag_check__?htmltag_pop('span'):0;return '</span>';}
function _span__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<span '.$tail.' >'.$inhtml.'</span>';}

//1 i
function _i($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('i'):0;return '<i '.$tail.' >';}
function _i_(){__htmltag_check__?htmltag_pop('i'):0;return '</i>';}
function _i__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<i '.$tail.' >'.$inhtml.'</i>';}

//1 s
function _s($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('s'):0;return '<s '.$tail.' >';}
function _s_(){__htmltag_check__?htmltag_pop('s'):0;return '</s>';}
function _s__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<s '.$tail.' >'.$inhtml.'</s>';}

//1 b
function _b($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('b'):0;return '<b '.$tail.' >';}
function _b_(){__htmltag_check__?htmltag_pop('b'):0;return '</b>';}
function _b__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<b '.$tail.' >'.$inhtml.'</b>';}

//1 u
function _u($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('u'):0;return '<u '.$tail.' >';}
function _u_(){__htmltag_check__?htmltag_pop('u'):0;return '</u>';}
function _u__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<u '.$tail.' >'.$inhtml.'</u>';}

//1 pre
function _pre($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('pre'):0;return '<pre '.$tail.' >';}
function _pre_(){__htmltag_check__?htmltag_pop('pre'):0;return '</pre>';}
function _pre__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<pre '.$tail.' >'.$inhtml.'</pre>';}

//1 label
function _label($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('label'):0;return '<label '.$tail.' >';}
function _label_(){__htmltag_check__?htmltag_pop('label'):0;return '</label>';}
function _label__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<label '.$tail.' >'.$inhtml.'</label>';}

//1 table
function _table($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('table'):0;return '<table '.$tail.' >';}
function _table_(){__htmltag_check__?htmltag_pop('table'):0;return '</table>';}
function _table__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<table '.$tail.' >'.$inhtml.'</table>';}

//1 tr
function _tr($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('tr'):0;return '<tr '.$tail.' >';}
function _tr_(){__htmltag_check__?htmltag_pop('tr'):0;return '</tr>';}
function _tr__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<tr '.$tail.' >'.$inhtml.'</tr>';}

//1 th
function _th($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('th'):0;return '<th '.$tail.' >';}
function _th_(){__htmltag_check__?htmltag_pop('th'):0;return '</th>';}
function _th__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<th '.$tail.' >'.$inhtml.'</th>';}

//1 td
function _td($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('td'):0;return '<td '.$tail.' >';}
function _td_(){__htmltag_check__?htmltag_pop('td'):0;return '</td>';}
function _td__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<td '.$tail.' >'.$inhtml.'</td>';}

//1 a
function _a_()
{
	__htmltag_check__?htmltag_pop('a'):0;return '</a>';
}
function _a($url=null,$cls=null,$sty=null,$tail=null)
{

	$url?$tail.=' href=\''.$url.'\'':0;

	$cls?$tail.=' class=\''.$cls.'\'':0;
	$sty?$tail.=' style=\''.$sty.'\'':0;
	__htmltag_check__?htmltag_push('a'):0;
	return '<a '.$tail.' >';

}
function _a__($url=null,$cls=null,$sty=null,$tail=null,$inhtml=null)
{

	$url?$tail.=' href=\''.$url.'\'':0;

	$cls?$tail.=' class=\''.$cls.'\'':0;
	$sty?$tail.=' style=\''.$sty.'\'':0;

	return '<a '.$tail.' >'.$inhtml.'</a>';
}

function _a0($cls=null,$sty=null,$tail=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;__htmltag_check__?htmltag_push('a'):0;return '<a '.$tail.' >';}
function _a0__($cls=null,$sty=null,$tail=null,$inhtml=null){$cls?$tail.=' class=\''.$cls.'\'':0;$sty?$tail.=' style=\''.$sty.'\'':0;return '<a '.$tail.' >'.$inhtml.'</a>';}

function _an($url=null,$cls=null,$sty=null,$tail=null)
{

	$url?$tail.=' href=\''.$url.'\'':0;

	$cls?$tail.=' class=\''.$cls.'\'':0;
	$sty?$tail.=' style=\''.$sty.'\'':0;
	__htmltag_check__?htmltag_push('a'):0;
	return '<a '.$tail.' target=_blank >';

}
function _an__($url=null,$cls=null,$sty=null,$tail=null,$inhtml=null)
{

	$url?$tail.=' href=\''.$url.'\'':0;

	$cls?$tail.=' class=\''.$cls.'\'':0;
	$sty?$tail.=' style=\''.$sty.'\'':0;

	return '<a '.$tail.' target=_blank >'.$inhtml.'</a>';
}
function _a_external__($url=null,$cls=null,$sty=null,$tail=null,$inhtml=null)
{
	if(client_is_app())
	{
		return _a__($url,$cls,$sty,$tail.' target=_external',$inhtml);
	}
	else
	{
		return _an__($url,$cls,$sty,$tail,$inhtml);
	}
}
function _a_webview__($url=null,$cls=null,$sty=null,$tail=null,$inhtml=null)
{
	if(client_is_app())
	{
		return _a__($url,$cls,$sty,$tail.' target=_webview',$inhtml);
	}
	else
	{
		return _an__($url,$cls,$sty,$tail,$inhtml);
	}
}

function _a_self__($url=null,$cls=null,$sty=null,$tail=null,$inhtml=null)
{
	return _a__($url,$cls,$sty,$tail.' target=_self',$inhtml);
}
function _img($url=null,$cls=null,$sty=null,$tail=null)
{

	if(!$url)
	{
		if(__online_isonline__)
		{
			$url='/assets/img/empty/empty.transparent.gif';
		}
		else
		{
			$url='/assets/img/empty/empty.holder.png';
		}
	}


	$url?$tail.=' src=\''.$url.'\'':0;

	$cls?$tail.=' class=\''.$cls.'\'':0;
	$sty?$tail.=' style=\''.$sty.'\'':0;

	return '<img '.$tail.' />';

}

//1 img

function _button($type=null,$inhtml=null,$cls=null,$sty=null,$tail=null)
{

	$type?$tail.=' type=\''.$type.'\'':0;

	$cls?$tail.=' class=\''.$cls.'\'':0;
	$sty?$tail.=' style=\''.$sty.'\'':0;

	return '<button '.$tail.' >'.$inhtml.'</button>';
}

//1 form
function _form($url=null,$method=null,$tail=null)
{


	$url?$tail.=' action=\''.$url.'\'':0;
	$url?$tail.=' method=\''.$method.'\'':0;

	__htmltag_check__?htmltag_push('form'):0;

	return '<form '.$tail.' enctype=\'multipart/form-data\' >';

}
function _form_()
{
	__htmltag_check__?htmltag_pop('form'):0;
	return '</form>';
}
//1 input
function _input($name=null,$value=null,$plh=null,$cls=null,$sty=null,$tail=null,$type='text')
{

	var_isavailable($name)?$tail.=' name=\''.$name.'\'':0;

	isset($value)?$tail.=' value=\''.htmlentity_encode($value).'\'':0;

	$type?$tail.=' type=\''.$type.'\'':0;

	$plh?$tail.=' placeholder=\''.$plh.'\'':0;

	$cls?$tail.=' class=\''.$cls.'\'':0;

	$sty?$tail.=' style=\''.$sty.'\'':0;

	return '<input '.$tail.' autocomplete=off />';
}
function _input_file($name=null,$value=null,$plh=null,$cls=null,$sty=null,$tail=null)
{
	return _input($name,$value,$plh,$cls,$sty,$tail,'file');
}
function _input_date($name=null,$value=null,$plh=null,$cls=null,$sty=null,$tail=null)
{
	return _input($name,$value,$plh,$cls,$sty,$tail,'date');
}
function _input_time($name=null,$value=null,$plh=null,$cls=null,$sty=null,$tail=null)
{
	return _input($name,$value,$plh,$cls,$sty,$tail,'time');
}
function _input_number($name=null,$value=null,$plh=null,$cls=null,$sty=null,$tail=null)
{
	return _input($name,$value,$plh,$cls,$sty,$tail,'number');
}
function _input_password($name=null,$value=null,$plh=null,$cls=null,$sty=null,$tail=null)
{
	return _input($name,$value,$plh,$cls,$sty,$tail,'password');
}
function _input_hidden($name=null,$value=null,$tail=null)
{
	return _input($name,$value,'','','','','hidden');
}
//1 textarea
function _textarea($name=null,$value=null,$plh=null,$cls=null,$sty=null,$tail=null)
{

	var_isavailable($name)?$tail.=' name=\''.$name.'\'':0;

	$plh?$tail.=' placeholder=\''.$plh.'\'':0;

	$cls?$tail.=' class=\''.$cls.'\'':0;

	$sty?$tail.=' style=\''.$sty.'\'':0;

	return '<textarea '.$tail.' autocomplete=off >'.htmlentity_encode($value).'</textarea>';
}
//1 select
function _select($name=null,$currentvalue=null,$cls=null,$sty=null,$tail=null)
{

	static $currentvalue_cache=null;

	if(cmd_get===$name)
	{
		return $currentvalue_cache;
	}

	if(var_isavailable($currentvalue))
	{
		$currentvalue_cache=$currentvalue;
	}
	else
	{
		$currentvalue_cache=null;
	}

	var_isavailable($name)?$tail.=' name=\''.$name.'\'':0;

	$cls?$tail.=' class=\''.$cls.'\'':0;
	$sty?$tail.=' style=\''.$sty.'\'':0;

	htmltag_push('select');

	return '<select '.$tail.' autocomplete=off >';

}
function _select_()
{
	__htmltag_check__?htmltag_pop('select'):0;return '</select>';
}
function _option($value=null,$inhtml=null,$cls=null,$sty=null,$tail=null)
{

	$current_value=_select(cmd_get);

	if(isset($current_value)&&($current_value==$value))
	{
		$tail.=' selected=selected';
	}

	$cls?$tail.=' class=\''.$cls.'\'':0;

	$sty?$tail.=' style=\''.$sty.'\'':0;

	return '<option value=\''.$value.'\' '.$tail.' >'.$inhtml.'</option>';

}
//1 _checkbox
function _checkbox($name=null,$value=null,$checked=false,$domset=[])
{
	$tail=$domset['tail'];

	var_isavailable($name)?$tail.=' name=\''.$name.'\'':0;
	isset($value)?$tail.=' value=\''.$value.'\'':0;

	$domset['cls']?$tail.=' class=\''.$domset['cls'].'\'':0;
	$domset['sty']?$tail.=' style=\''.$domset['sty'].'\'':0;

	if($checked)
	{
		$tail.=' checked=checked';
	}

	return '<input '.$tail.' autocomplete=off type=checkbox />';

}
function _checkbox_1($name=null,$value=null,$checked=false,$domset=[],$labeltxt=null)
{

	$H.=_label('g_checkbox_wrap');
		$H.=_checkbox($name,$value,$checked,$domset);
		$H.=_u__('','','',$labeltxt);
	$H.=_label_();

	return $H;

}
function _radio($name=null,$value=null,$checked=false,$domset=[])
{
	$tail=$domset['tail'];

	var_isavailable($name)?$tail.=' name=\''.$name.'\'':0;
	isset($value)?$tail.=' value=\''.$value.'\'':0;

	$domset['cls']?$tail.=' class=\''.$domset['cls'].'\'':0;
	$domset['sty']?$tail.=' style=\''.$domset['sty'].'\'':0;

	if($checked)
	{
		$tail.=' checked=checked';
	}

	return '<input '.$tail.' autocomplete=off type=radio />';

}
function _radio_1($name=null,$value=null,$checked=false,$domset=[],$labeltxt=null)
{

	$H.=_label('g_checkbox_wrap');
		$H.=_radio($name,$value,$checked,$domset);
		$H.=_u__('','','',$labeltxt);
	$H.=_label_();

	return $H;

}
//1 module
function _module($cls=null,$sty=null,$tail=null)
{//skel module 专用

	global $____skel_module;

	$tail.=' __skelmodule__=skelmodule';
	$tail.=' skelmodule_configid='.$____skel_module['module_configid'];
	$tail.=' skelmodule_name='.$____skel_module['module_name'];

	return _div($cls,$sty,$tail);

}
function _module_()
{

	return _div_();

}
//1 sep
function _sep($height=null,$sty=null)
{//生成一个小的clear both的div

	if(0)
	{
		$height=floatval($height);
	}

	if(__m_access__)
	{
		return _div__('__clb__','height:'.mpx_to_vw($height).';'.$sty);
	}
	else
	{
		return _div__('__clb__','height:'.$height.'px;'.$sty);
	}

}

function _status($status,$yes_inhtml,$no_inhtml)
{

	return $status?_span__('__color_green__','font-weight:bold;','',$yes_inhtml):_span__('__color_red__','font-weight:bold;','',$no_inhtml);

}

function _sty($key,$value)
{

	$value=strval($value);
	if(''===$value||('px'===$value)||('url()'===$value))
	{
		return;
	}
	else
	{
		return $key.':'.$value.';';
	}

}

function _tails($list)
{
	if(array_is_list($list))
	{
		return impd($list,' ');
	}

	$H='';

	$sep='';

	foreach($list as $k=>$v)
	{
		if(is_array($v))
		{
			$v='\''.json_encode_1($v).'\'';
		}

		$H.=$sep.$k.'='.$v;
		$sep=' ';
	}

	return $H;
}