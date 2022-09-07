<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

namespace controller\debug;

class Session extends \controller\admin\super\Superadmin
{


	protected $__data_handle=false;

	const datatype_string=1;

	const datatype_integer=2;
	const datatype_float=3;

	const datatype_true=4;
	const datatype_false=5;

	const datatype_null=6;

	const datatype_array=7;

	const datatype_namemap=
	[

		self::datatype_string			=>'[String]',

		self::datatype_integer		=>'[Integer]',
		self::datatype_float			=>'[Float]',

		self::datatype_true			=>'[True]',
		self::datatype_false			=>'[False]',

		self::datatype_null			=>'[Null]',

		self::datatype_array			=>'[Array]',

	];

	function __construct()
	{

		if(route_judge(cmd_ignore,'session'))
		{

			$this->__data_handle=&$_SESSION;

		}
		else if(route_judge(cmd_ignore,'cookie'))
		{

			$this->__data_handle=&$_COOKIE;

		}
		else
		{

			R_alert('[error-0033]');

		}

		parent::__construct();

		if(array_key_exists('data_key',$_POST))
		{

			$_POST['data_key']=htmlentity_decode($_POST['data_key']);

			if(check_hasdangerchar($_POST['data_key']))
			{
				R_alert('[error-0821]key含有禁用字符:<br>'.check_hasdangerchar_plaintext());
			}

		}

		if(array_key_exists('data_value',$_POST))
		{
			$_POST['data_value']=htmlentity_decode($_POST['data_value']);
		}

		if(array_key_exists('keypath',$_GET)&&''!==$_GET['keypath'])
		{

			$_GET['keypath']=htmlentity_decode($_GET['keypath']);

			if(!array_cascade_key_isexist($this->__data_handle,$_GET['keypath']))
			{
				R_alert('[error-4410]keypath不存在');
			}

		}

	}

	function index()
	{
		_skel();
	}

	protected function data_value_get($__postdata)
	{

		$value=null;

		if(self::datatype_string==$__postdata['data_type'])
		{
			$value=strval($__postdata['data_value']);
		}
		else if(self::datatype_integer==$__postdata['data_type'])
		{
			$value=intval($__postdata['data_value']);
		}
		else if(self::datatype_float==$__postdata['data_type'])
		{
			$value=floatval($__postdata['data_value']);
		}
		else if(self::datatype_true==$__postdata['data_type'])
		{
			$value=true;
		}
		else if(self::datatype_false==$__postdata['data_type'])
		{
			$value=false;
		}
		else if(self::datatype_null==$__postdata['data_type'])
		{
			$value=null;
		}
		else if(self::datatype_array==$__postdata['data_type'])
		{
			$value=(''===$__postdata['data_value']?[]:expd($__postdata['data_value']));
		}
		else
		{
			R_alert('[error-5749]');
		}

		return $value;

	}
	function node_menu_get($keypath)
	{

		$__add=0;

		$__edit_key=0;

		$__edit_value=0;

		$__delete=0;

		$__move=0;

		if(check_isavailable($keypath))
		{

			$data=array_cascade_get($this->__data_handle,$keypath);

			$data_type=gettype_1($data);

			if('array'==$data_type)
			{
				$__add=1;
			}
			else
			{
				$__edit_value=1;
			}

			$__edit_key=1;

			$__delete=1;

			$__move=1;

		}
		else
		{
			$__add=1;

		}

		if(1||check_isavailable($keypath))
		{

			$H.=_div__('','','popupmenu_role=text',check_isavailable($keypath)?'keypath:'.$keypath:'root');

			if(0)
			{
				if(check_isavailable($keypath))
				{
					$H.=_div__('','','popupmenu_role=text',$keypath);
				}
				else
				{
					$H.=_div__('','','popupmenu_role=text','[root]');
				}
			}

			$H.=_div__('','','popupmenu_role=sepline');

		}

		if(route_judge(cmd_ignore,'cookie'))
		{

			$__edit_key=0;
			$__move=0;

			if(check_isavailable($keypath)&&0!==strpos($keypath,__cookie_prefix__))
			{
				R_toast('[error-1433]只能操作以'.__cookie_prefix__.'开头的cookie');
			}

		}

		if($__add)
		{
			$H.=_a0__('','','popupmenu_role=menu onclick="debugsession_add(\''.$keypath.'\');"','添加');
		}

		if($__edit_key)
		{
			$H.=_a0__('','','popupmenu_role=menu onclick="debugsession_edit_key(\''.$keypath.'\');"','编辑/key');
		}

		if($__edit_value)
		{
			$H.=_a0__('','','popupmenu_role=menu onclick="debugsession_edit_value(\''.$keypath.'\');"','编辑/value');
		}

		if($__delete)
		{
			$H.=_a0__('','','popupmenu_role=menu onclick="debugsession_delete(\''.$keypath.'\');"','删除');
		}

		if($__move)
		{
			$H.=_div__('','','popupmenu_role=sepline');
			$H.=_a0__('','','popupmenu_role=menu onclick="debugsession_move(\''.$keypath.'\',-1);"','上移一位↑');
			$H.=_a0__('','','popupmenu_role=menu onclick="debugsession_move(\''.$keypath.'\',1);"','下移一位↓');
		}

		R_true($H);

	}

	protected function sink_actiondone($mustexpand_keypath=null)
	{

		if(route_judge(cmd_ignore,'session'))
		{//为了保留节点的打开关闭状态,用js前台更新

			R_jscode('debugsession_update(\''.$mustexpand_keypath.'\')');

		}
		else if(route_judge(cmd_ignore,'cookie'))
		{

			R_jump();

		}
		else
		{

			R_alert('[error-1006]');

		}

	}
	function update()
	{

		R_true(debug_dump($this->__data_handle,-1,true,false));

	}
//1 add
	function add($keypath)
	{
		R_window_xml(xml_getxmlfilepath(),url_build('add_1?keypath='.$keypath));
	}
	function add_1($keypath)
	{


		$data_key=$_POST['data_key'];

		$data_value=$this->data_value_get($_POST);

		if($keypath)
		{

		}
		else
		{
			if(''===$data_key)
			{
				R_alert('[error-0623]根节点下必须指定key');
			}
			if(check_isint($data_key))
			{
				R_alert('[error-0623]根节点下key不能为整数');
			}
		}

		array_cascade_add($this->__data_handle,$keypath,$data_key,$data_value);

		$this->sink_actiondone($keypath);

	}
//1 edit_key
	function edit_key($keypath)
	{

		if(!check_isavailable($keypath))
		{
			R_alert('[error-4256]');
		}

		$temp=expd($keypath,'/');

		R_window_xml(xml_getxmlfilepath(),url_build('edit_key_1?keypath='.$keypath),['data_key'=>end($temp)]);

	}
	function edit_key_1($keypath)
	{

		if(!check_isavailable($keypath))
		{
			R_alert('[error-2449]');
		}

		if(!check_isavailable($_POST['data_key']))
		{
			R_alert('[error-4412]请输入key');
		}

		if(!check_isavailable($keypath))
		{
			R_alert('[error-0127]keypath缺失');
		}


		$temp=expd($keypath,'/');

		if($_POST['data_key']==end($temp))
		{//没改名,啥也不干

		}
		else
		{

			$temp[count($temp)-1]=$_POST['data_key'];

			if(array_cascade_key_isexist($this->__data_handle,impd($temp,'/')))
			{
				R_alert('[error-0626]同名冲突');
			}
			else
			{
				array_cascade_key_rename($this->__data_handle,$keypath,$_POST['data_key']);
			}

		}

		$this->sink_actiondone();

	}


//1 edit_value
	function edit_value($keypath)
	{

		if(!check_isavailable($keypath))
		{
			R_alert('[error-4256]');
		}

		$value=array_cascade_get($this->__data_handle,$keypath);

		$value_type=gettype_1($value);

		$data=[];
		$data['data_value']='';
		$data['data_type']='';

		if(true===$value)
		{
			$data['data_type']=self::datatype_true;
		}
		else if(false===$value)
		{
			$data['data_type']=self::datatype_false;
		}
		else if(null===$value)
		{
			$data['data_type']=self::datatype_null;
		}
		else
		{

			$data['data_value']=$value;

			 if('string'==$value_type)
			 {
				$data['data_type']=self::datatype_string;
			 }
			 else if('integer'==$value_type)
			 {
				$data['data_type']=self::datatype_integer;
			 }
			 else if('float'==$value_type)
			 {
				$data['data_type']=self::datatype_float;
			 }
			 else
			 {
				R_alert('[error-0755]不支持的类型');
			 }

		}

		R_window_xml(xml_getxmlfilepath(),url_build('edit_value_1?keypath='.$keypath),$data);

	}
	function edit_value_1($keypath)
	{

		if(!check_isavailable($keypath))
		{
			R_alert('[error-1213]');
		}

		$data_value=$this->data_value_get($_POST);

		array_cascade_set($this->__data_handle,$keypath,$data_value);

		$this->sink_actiondone();

	}

//1 delete
	function delete($keypath)
	{

		if(!check_isavailable($keypath))
		{
			R_alert('[error-1213]');
		}

		array_cascade_delete($this->__data_handle,$keypath);

		$this->sink_actiondone();

	}

//1 move
	function move($keypath,$direction)
	{

		if(!check_isavailable($keypath))
		{
			R_alert('[error-1213]');
		}

		$result=array_cascade_move($this->__data_handle,$keypath,$direction);

		if($result)
		{
			$this->sink_actiondone();
		}
		else
		{
			if(-1==$direction)
			{
				R_alert('首节点不能上移');
			}
			else if(1==$direction)
			{
				R_alert('末节点不能下移');
			}
			else
			{
				R_alert('[error-5625]');
			}
		}

	}

}
