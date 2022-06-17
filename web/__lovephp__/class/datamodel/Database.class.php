<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace _lp_\datamodel;

class Database
{

	const fieldtype_int=1;
	const fieldtype_float=2;
	const fieldtype_char=10;
	const fieldtype_text=11;

	const fieldtype_other=99;


	const fieldtype_origtypemap=
	[
		self::fieldtype_int=>
			[
				'bit',
				'tinyint',
				'smallint',
				'mediumint',
				'int',
				'integer',
				'bigint',
			],
		self::fieldtype_float=>
			[
				'decimal',
				'float',
				'double',
			],
		self::fieldtype_char=>
			[
				'char',
				'varchar',
			],
		self::fieldtype_text=>
			[
				'text',
				'tinytext',
				'mediumtext',
				'longtext',
			],
		self::fieldtype_other=>
			[

			],

	];

	const exp_expmap=
	[
		db_eq			=>'=',
		db_neq			=>'<>',

		db_gt			=>'>',
		db_egt			=>'>=',

		db_lt			=>'<',
		db_elt			=>'<=',

		db_like			=>'LIKE',
		db_notlike		=>'NOT LIKE',

		db_in			=>'IN',
		db_notin		=>'NOT IN',

		db_isnull		=>'IS NULL',
		db_isnotnull		=>'IS NOT NULL',

		db_findinset		=>'FIND_IN_SET',
	];

	private $__db_connectid=false;

	private $__driver=false;
	private $__driver_config=false;

	private $__query_option=[];
	private $__query_option_back=[];
	private $__query_jointable=[];
	private $__query_jointable_back=[];

	public $__table_name=false;//外部有可能用到
	public $__table_config=false;
	public $__table_struct=false;

	public function __construct(int $__connect_id,$__table_name,$__table_config=false)
	{

		$__driver_config=\Dbconfig::db_connect_configmap[$__connect_id]['db_driver_config'];

		if(!$__driver_config||!$__table_name)
		{
			R_exception('[error-3539]配置错误');
		}

		$this->__db_connectid=$__connect_id;

		$this->__table_name=$__table_name;
		$this->__table_config=$__table_config;

		if(0)
		{
			$this->__driver_config=$__driver_config;
		}

		$this->__driver=class_instanceclass
			(
				'\\_lp_\\datamodel\\databasedriver\\'.ucwords($__driver_config['db_driver_type']),
				$__driver_config
			);

		$this->tablestruct_init();

		$this->query_option_reset();

	}

//1 query
	function query_querysql($sql)
	{

		$result=$this->__driver->driver_querysql($sql);

		return $result;

	}
	function query_option_reset()
	{

		$this->__query_option_back=$this->__query_option;
		$this->__query_jointable_back=$this->__query_jointable;


		$this->__query_option=[];
		$this->__query_jointable=[];

	}
	function query_option_recover()
	{

		$this->__query_option=$this->__query_option_back;
		$this->__query_jointable=$this->__query_jointable_back;

	}
//1 where
	function where($t0_where=[],$t1_where=[])
	{

		if(!$t0_where&&!$t1_where)
		{
			return $this;
			R_exception('[error-0347]where不能为空');
		}

		$t0_where_str=$this->where_parse($t0_where,'T0',$this->__table_struct);

		if($this->__query_jointable&&$t1_where)
		{
			$t1_where_str=$this->where_parse($t1_where,'T1',$this->__query_jointable['jointable_obj']->__table_struct);
		}

		if($t0_where_str&&$t1_where_str)
		{
			$where_str_final='('.$t0_where_str.') and ('.$t1_where_str.')';
		}
		else
		{
			$where_str_final=$t0_where_str.$t1_where_str;
		}

		if($where_str_final)
		{
			$this->__query_option['where']='where ('.$where_str_final.')';
		}

		return $this;

	}
	function where_parse($where,$__tablename=false,$__table_fieldmap)
	{

		$__parse_singleitem=function($__key,$__val) use ($__tablename,$__table_fieldmap)
		{

			$__exp=db_eq;

			if(is_array($__val))
			{
				if($__val[0])
				{
					$__exp=$__val[0];
				}

				$__val=$__val[1];

			}

			if(1)
			{//key里面带#号,表示存在相同的key关键字,滤掉#号后面的部分,比如同一个key但是需要满足多个条件

				$pos=strpos($__key,'#');

				if(false!==$pos)
				{
					$__key=substr($__key,0,$pos);
				}

			}

			$__fieldtype=$__table_fieldmap[$__key];
			if(!$__fieldtype)
			{
				R_exception('[error-2533]未找到字段:'.$__key);
			}

			$__key=($__tablename?'`'.$__tablename.'`.':'').'`'.$__key.'`';

			if(
				(
					self::fieldtype_int==$__fieldtype||
					self::fieldtype_float==$__fieldtype||
					db_exp===$__exp
				)&&db_like!==$__exp&&db_notlike!==$__exp
			)
			{

			}
			else
			{

				if(is_array($__val))
				{
					foreach($__val as &$v)
					{
						$v='\''.addslashes($v).'\'';
					}
					unset($v);
				}
				else
				{
					$__val='\''.addslashes($__val).'\'';
				}

			}

			if(

				db_eq===$__exp||
				db_neq===$__exp||

				db_gt===$__exp||
				db_egt===$__exp||

				db_lt===$__exp||
				db_elt===$__exp

			)
			{
				$__exp=self::exp_expmap[$__exp];
			}
			else if
			(
				db_like==$__exp||
				db_notlike==$__exp
			)
			{
				$__exp=self::exp_expmap[$__exp];
			}
			else if
			(
				db_in===$__exp||
				db_notin===$__exp
			)
			{

				$__exp=self::exp_expmap[$__exp];

				if(!is_array($__val))
				{
					R_exception('[error-0642]in/notin必须数组');
				}

				$__val='('.impd($__val).')';

			}
			else if(db_findinset===$__exp)
			{
				return self::exp_expmap[$__exp].'('.$__val.','.$__key.')';

			}
			else if(
				db_isnull===$__exp||
				db_isnotnull===$__exp
			)
			{

				return $__key.' '.self::exp_expmap[$__exp];

			}
			else if(db_exp===$__exp)
			{

				$__exp='';

				return $__key.' '.$__val;

			}
			else
			{
				R_exception('[error-5114]exp表达式错误/'.$__exp);
			}

			$str=$__key.' '.$__exp.' '.$__val;

			return $str;

		};

		$__parse_recu=function($where) use ($__tablename,&$__parse_recu,&$__parse_singleitem)
		{

			$__logic=$where[db_logic]??'and';
			unset($where[db_logic]);

			$str='';
			$sep='';

			foreach($where as $k=>$v)
			{

				if(is_null($v))
				{
					R_exception('[error-1002]where含null');
				}

				if(strpos($k,'|'))
				{
					$keylist=expd($k,'|');

					$new_where=[];
					foreach($keylist as $vv)
					{
						$new_where[$vv]=$v;
					}
					$new_where[db_logic]='or';

					$str.=$sep.'('.$__parse_recu($new_where).')';

				}
				else if(strpos($k,'&'))
				{

					$keylist=expd($k,'&');

					$new_where=[];
					foreach($keylist as $vv)
					{
						$new_where[$vv]=$v;
					}
					$new_where[db_logic]='and';

					$str.=$sep.'('.$__parse_recu($new_where).')';

				}
				else if(is_numeric($k))
				{
					$str.=$sep.'('.$__parse_recu($v).')';
				}
				else
				{
					$str.=$sep.$__parse_singleitem($k,$v);
				}

				$sep=' '.$__logic.' ';

			}
			return $str;
		};

		if(!$where)
		{
			return '';
		}

		if(isint_isint($where))
		{
			$where=
			[
				$this->__table_config['db_table_prikey']=>$where
			];
		}
		else if(array_is_allint($where))
		{
			$where=
			[
				$this->__table_config['db_table_prikey']=>[db_in,$where]
			];
		}
		else if(is_array($where))
		{

		}
		else
		{
			R_exception('[error-5700]/where设置错误');
		}

		return $__parse_recu($where,$__tablename);

	}
//1 construct
	function tablestruct_init()
	{


		if(__online_isonline__)
		{//读取缓存
			$__cache_dna='database_tablestruct/'.$this->__db_connectid.'/'.$this->__table_name;
		}
		else
		{
			$__cache_dna=false;
		}

		if($__cache_dna)
		{

			$temp=\_lp_\Cache::cache_get($__cache_dna);

			if(!is_null($temp))
			{
				$this->__table_struct=$temp;
				return;
			}

		}

		$__fieldtype_map_orig=[];

		if(1)
		{

			$__item_list=$this->query_querysql('SHOW FULL COLUMNS FROM `'.$this->__table_name.'`');

			foreach($__item_list as $v)
			{

				if(1)
				{//全部转小写,便于后续判断
					foreach($v as &$vv)
					{
						if(!is_null($vv))
						{
							$vv=strtolower($vv);
						}

					}
					unset($vv);
				}

				if(1)
				{//分析原始类型
					$matchs=[];
					preg_match('/([a-z]+)(?:\(([\d,]+)\))?(?:\s([a-z]+))?/',$v['Type'],$matchs);

					$orig_type=[];
					if($matchs[1])
					{
						$orig_type['origtype_type']=$matchs[1];
					}
					else
					{
						R_exception('[error-5800]');
					}

					if($matchs[2])
					{
						$orig_type['origtype_digits']=$matchs[2];
					}

					if($matchs[3])
					{
						$orig_type['origtype_tail']=$matchs[3];
					}

					$v['@orig_type']=$orig_type;
				}

				if(1)
				{//分析逻辑类型
					$v['@logic_type']=self::fieldtype_other;
					foreach(self::fieldtype_origtypemap as $kk=>$vv)
					{
						if(in_array_1($orig_type['origtype_type'],$vv))
						{
							$v['@logic_type']=$kk;
							break;
						}

					}

					$__fieldtype_map_orig[$v['Field']]=$v;
				}

			}

		}
//1 adjust tablestruct
		if($this->__table_config&&$this->__table_config['db_table_adjuststruct_enable'])
		{//new方式创建的时候可能没有$this->__table_config信息,不处理

			$rownum=$this->count();

			if($rownum>$this->__table_config['db_table_adjuststruct_maxrownum'])
			{
				R_exception('[error-4558]超过数据量限制,不能自动调整表结构');
			}

			$__adjust_sql='';

			foreach($__fieldtype_map_orig as $field_key=>$field_data)
			{

				$__adjust_needadjust=false;

				$__adjust_part_type=$field_data['Type'];

				$__adjust_part_notnull=true;

				$__adjust_part_defaultvalue=$field_data['Default']?$field_data['Default']:0;

				if(self::fieldtype_int==$field_data['@logic_type']||self::fieldtype_float==$field_data['@logic_type'])
				{

					if('yes'==$field_data['Null'])
					{//not null
						$__adjust_needadjust=true;
					}

					if(1)
					{//unsigned
						if('unsigned'==$field_data['@orig_type']['origtype_tail']&&in_array_1($field_data['Field'],$this->__table_config['db_table_signedfileds']))
						{
							$__adjust_needadjust=true;
							$__adjust_part_type=$field_data['@orig_type']['origtype_type'].'('.$field_data['@orig_type']['origtype_digits'].')';
						}
						else if('unsigned'!=$field_data['@orig_type']['origtype_tail']&&!in_array_1($field_data['Field'],$this->__table_config['db_table_signedfileds']))
						{
							$__adjust_needadjust=true;
							$__adjust_part_type=$field_data['@orig_type']['origtype_type'].'('.$field_data['@orig_type']['origtype_digits'].') unsigned';
						}
						else
						{

						}
					}

					if(
						''===$field_data['Default']||
						is_null($field_data['Default'])
					)
					{
						if(false===strpos($field_data['Extra'],'auto_increment'))
						{
							$__adjust_needadjust=true;
						}
						else
						{//auto_increment不能有default
							$__adjust_part_defaultvalue=cmd_ignore;
						}
					}

				}
				else if(self::fieldtype_char==$field_data['@logic_type'])
				{

					if('yes'==$field_data['Null'])
					{//not null
						$__adjust_needadjust=true;
					}

					if(
						is_null($field_data['Default'])
					)
					{
						$__adjust_needadjust=true;
						$__adjust_part_defaultvalue='';
					}
					else
					{

					}

					$__adjust_part_defaultvalue='\''.addslashes($__adjust_part_defaultvalue).'\'';

				}

				else if(self::fieldtype_text==$field_data['@logic_type'])
				{//text不对not null和默认值调整,mysql的text类型默认值有些混乱,有的可以有的不可以,猜测和mysql的严格/宽松模式/具体版本有关

				}
				else if(self::fieldtype_other==$field_data['@logic_type'])
				{

				}
				else
				{
					R_exception('[error-4002]');
				}

				if($__adjust_needadjust)
				{

					$__adjust_sql.="\n".'#'.$this->__table_name.'/'.$field_key;

					if(cmd_ignore!==$__adjust_part_defaultvalue)
					{
						$__adjust_sql.="\n".'UPDATE `'.$this->__table_name.'` SET `'.
							$field_key.'`='.$__adjust_part_defaultvalue.
							' WHERE `'.$field_key.'` IS NULL;';
					}

					$__adjust_sql.="\n".'ALTER TABLE `'.$this->__table_name.'` MODIFY COLUMN `'.$field_key.'`';
					$__adjust_sql.=' '.$__adjust_part_type;

					if($v['Collation'])
					{
						$__adjust_sql.=' COLLATE '.$v['Collation'];
					}

					if(cmd_ignore!==$__adjust_part_defaultvalue)
					{
						$__adjust_sql.=' DEFAULT '.$__adjust_part_defaultvalue;
					}

					if($field_data['Extra'])
					{
						$__adjust_sql.=' '.$field_data['Extra'];
					}
					if($__adjust_part_notnull)
					{
						$__adjust_sql.=' NOT NULL';
					}

					if($v['Comment'])
					{
						$__adjust_sql.=' COMMENT \''.addslashes($v['Comment']).'\'';
					}

					$__adjust_sql.=';';
				}

			}

			if(0)
			{//test
		 		echo '<pre>';
		 			echo $__adjust_sql;
		  		echo '</pre>';
			}

	 		if($__adjust_sql)
	 		{
		 		$this->query_querysql($__adjust_sql);
	 		}

		}

//1 trigger
		if($this->__table_config&&cmd_ignore!==$this->__table_config['db_table_triggers'])
		{	//new方式创建的时候可能没有$this->__table_config信息,不处理
			//同步trigger,把代码中的触发器同步过去,代码里没有触发器,数据库的触发器也会被删除

			$__triggers_old=[];

			$__triggers_new=[];

			if(1)
			{//old trigger

				$__db_trigger_list=$this->query_querysql('SHOW TRIGGERS LIKE "'.$this->__table_name.'"');

				foreach($__db_trigger_list as $v)
				{

					$temp=[
						'event'=>strtolower($v['Event']),
						'timing'=>strtolower($v['Timing']),
						'code'=>$v['Statement']
					];
					$matchs=[];
					preg_match('/#packdna=(.*)/',$temp['code'],$matchs);
					$temp['code_dna']=$matchs[1];

					$__triggers_old[strtolower($v['Trigger'])]=$temp;
				}
				ksort($__triggers_old);
			}
			if(1)
			{//new trigger
				foreach($this->__table_config['db_table_triggers'] as $k=>$v)
				{

					$v=trim($v);

					$k=expd($k,'/');

					$temp=[];
					$temp['event']=$k[0];
					$temp['timing']=$k[1];
					$temp['code']=$v;
					$temp['code_dna']=md5($v);

					if(!$temp['code'])
					{
						R_exception('[error-0320]');
					}

					$__triggers_new[$this->__table_name.'_'.$k[0].'_'.$k[1]]=$temp;

				}
				ksort($__triggers_new);//要排序,否则多个trigger的情况下,md5校验不对
			}

			if(1)
			{//准备对比新旧数据

				$__triggers_old_check=$__triggers_old;
				foreach($__triggers_old_check as &$v)
				{
					unset($v['code']);
				}
				unset($v);

				$__triggers_new_check=$__triggers_new;
				foreach($__triggers_new_check as &$v)
				{
					unset($v['code']);
				}
				unset($v);
			}

			if(md5_md5($__triggers_old_check)==md5_md5($__triggers_new_check))
			{//此时无需更新

			}
			else
			{
				$__trigger_sql='';

				foreach($__triggers_old as $k=>$v)
				{
					$__trigger_sql.="\n".'DROP TRIGGER `'.$k.'`;';
				}

				if($__trigger_sql)
				{
					$this->query_querysql($__trigger_sql);
				}

				$__trigger_sql='';

				foreach($__triggers_new as $k=>$v)
				{
					$v['code']=str_replace("BEGIN\n","BEGIN\n#".\_lp_\Codepack::packcode_headinfo."\n#packdna=".$v['code_dna']."\n#packtime=".time_str()."\n",$v['code']);

					$__trigger_sql='
						CREATE TRIGGER `'.$k.'` '.$v['timing'].' '.$v['event'].'
						ON `'.$this->__table_name.'` FOR EACH ROW
						'.$v['code'].'
						;';

					if(0)
					{//test
						echo _pre__('','','',$__trigger_sql);
					}

					$this->query_querysql($__trigger_sql);
				}
			}
		}

		if(1)
		{
			$this->__table_struct=[];
			foreach($__fieldtype_map_orig as $k=>$v)
			{
				$this->__table_struct[$k]=$v['@logic_type'];
			}

			if($__cache_dna)
			{
				\_lp_\Cache::cache_set($__cache_dna,$this->__table_struct);
			}
		}

	}

//1 field
	function field(array $t0_field=null,array $t1_field=null)
	{

		$__result=[];

		if($t0_field)
		{
			foreach($t0_field as $v)
			{
				$__result[]='`T0`.`'.$v.'`';
			}
		}
		else
		{
			$__result[]='`T0`.*';
		}

		if($this->__query_jointable)
		{

			if($t1_field)
			{

			}
			else
			{
				$t1_field=array_keys($this->__query_jointable['jointable_obj']->__table_struct);

			}

			foreach($t1_field as $v)
			{
				$__result[]='`T1`.`'.$v.'` as `@T1|'.$v.'`';
			}

		}

		$this->__query_option['field']=impd($__result);

		return $this;

	}
//1 orderby
	function orderby(string $order/*纯字符串传进来,特殊情况再自己写吧*/)
	{

		$this->__query_option['orderby']='order by '.$order;
		return $this;

	}
//1 groupby
	function groupby(string $groupby)
	{
		$this->__query_option['groupby']='group by '.$groupby;
		return $this;
	}
//1 limit
	function limit(int $a,$b=cmd_ignore)
	{
		$temp=[];

		$temp[]=$a;

		if(cmd_ignore!==$b)
		{
			$temp[]=intval($b);
		}

		$this->__query_option['limit']='limit '.impd($temp);

		return $this;
	}
//1 select
	function select($dontreset=false)
	{

		if(!$this->__query_option['field'])
		{//不要直接写'*',需要初始化一下,连表情况会复杂些
			$this->field();
		}

		$__sql='SELECT

		'.$this->__query_option['field'].'

		FROM `'.$this->__table_name.'` as `T0`

		'.$this->__query_jointable['jointable_joinstring'].'

		'.$this->__query_option['where'].'

		'.$this->__query_option['groupby'].'

		'.$this->__query_option['orderby'].'

		'.$this->__query_option['limit'];

		if(0)
		{
			echo _pre__('','','',$__sql);
		}

		$__itemlist=$this->query_querysql($__sql);

		if($this->__query_jointable)
		{

			$__itemlist_t1=[];

			if(1)
			{
				foreach($__itemlist as &$v)
				{
					$temp=[];

					foreach($v as $kk=>$vv)
					{
						if(0===strpos($kk,'@T1|'))
						{
							unset($v[$kk]);//删除连表出来的原始数据
							$temp[str_replace('@T1|','',$kk)]=$vv;
						}
					}

					if(1)
					{
						$allnull=true;

						foreach($temp as $vv)
						{
							if(!is_null($vv))
							{
								$allnull=false;
								break;
							}
						}
						if($allnull)
						{
							$temp=false;
						}
					}

					$__itemlist_t1[]=$temp;
				}
				unset($v);
			}

			$this->__query_jointable['jointable_obj']->select_after($__itemlist_t1);

			foreach($__itemlist as $k=>&$v)
			{
				$v['@'.$this->__query_jointable['jointable_obj']->__table_name]=$__itemlist_t1[$k];
			}

		}

		$this->select_after($__itemlist);

		if($dontreset)
		{

		}
		else
		{
			$this->query_option_reset();
		}

		return $__itemlist;

	}
	function select_after(&$list)
	{

		$__single_func=function(&$__item) use ($floats_fields)
		{

			foreach($__item as $k=>&$v)
			{

				if(in_array_1($k,$this->__table_config['db_table_serializedfileds']))
				{
					if($v)
					{
						$v=unserialize($v);
					}
					else
					{
						$v='';
					}
				}
				else if(self::fieldtype_int==$this->__table_struct[$k])
				{
					$v=intval($v);
				}
				else if(self::fieldtype_float==$this->__table_struct[$k])
				{
					$v=floatval($v);
				}
				else
				{

				}

			}
			unset($v);

		};

		foreach($list as &$v)
		{
			$__single_func($v);
		}
		unset($v);

	}

	function select_splitpage
	(
		int $page_index,
		int $page_npp,
		&$__totalpagenum=cmd_ignore,
		&$__totalitemnum=cmd_ignore
	)
	{//分页查询

		$page_index=intval($page_index);

		if($page_npp<1)
		{
			R_exception('[error-2115]select_splitpage/参数错误');
		}

		$result=$this->limit($page_index*$page_npp,$page_npp)->select(1);

		if(cmd_ignore!==$__totalpagenum)
		{

			$__totalitemnum=$this->count();

			$__totalpagenum=ceil($__totalitemnum/$page_npp);

		}

		return $result;

	}
//1 find
	function find()
	{
		$result=$this->limit(1)->select();
		return $result[0]?$result[0]:[];
	}
//1 add
	function add(array $data,$cmd=false)
	{

		if(!$data)
		{
			R_exception('[error-5537]data不能空');
		}

		$this->save_before($data);

		$__fieldname_str='';
		$__fieldvalue_str='';

		$sep='';
		foreach($data as $k=>$v)
		{

			$__fieldname_str.=$sep.'`'.$k.'`';

			$__fieldvalue_str.=$sep.$v;

			$sep=',';
		}

		$__sql='INSERT'.(cmd_ignore===$cmd?' IGNORE':'').' INTO
		`'.$this->__table_name.'`
		 ('.$__fieldname_str.') VALUES ('.$__fieldvalue_str.')';

		if(0)
		{
			echo _pre__('','','',$__sql);
		}

		$result=$this->query_querysql($__sql);

		if(cmd_ignore!==$cmd&&!$result)
		{
			R_exception('[error-0536]添加数据失败');
		}

		$this->query_option_reset();

		return $result;

	}
	function save(array $data)
	{

		if(!$data)
		{
			R_exception('[error-2624]data不能空');
		}

		if(!$this->__query_option['where'])
		{
			R_exception('[error-3950]需要where');
		}

		$this->save_before($data);

		$__savestr='SET ';
		$sep='';
		foreach($data as $k=>$v)
		{
			$__savestr.=$sep.'`'.$k.'`='.$v;
			$sep=',';
		}

		$__sql='UPDATE
		`'.$this->__table_name.'` as `T0`
		'.$__savestr.'
		'.$this->__query_option['where'];

		if(0)
		{
			echo _pre__('','','',$__sql);
		}

		$result=$this->query_querysql($__sql);

		$this->query_option_reset();

		return $result;

	}
	function save_before(&$data)
	{

		if($this->__table_config['db_table_serializedfileds'])
		{
			foreach($this->__table_config['db_table_serializedfileds'] as $k)
			{
				if(array_key_exists($k,$data))
				{
					if($data[$k])
					{
						$data[$k]=serialize($data[$k]);
					}
					else
					{
						$data[$k]='';
					}
				}
			}
		}

		foreach($data as $k=>&$v)
		{
			if(!$this->__table_struct[$k])
			{
				R_exception('[error-3846]字段错误/'.$this->__table_name.'/'.$k);
			}
			if(db_null===$v)
			{
				$v='NULL';
			}
			else
			{
				if(is_array($v))
				{
					if(db_exp===$v[0])
					{
						$v=$v[1];
					}
					else
					{
						R_exception('[error-2607]exp错误/'.$this->__table_name.'/'.$k);
					}
				}
				else
				{

					if(self::fieldtype_int==$this->__table_struct[$k])
					{
						if(!isint_isint($v))
						{
							R_exception('[error-2832]字段错误/'.$this->__table_name.'/'.$k);
						}
						$v=intval($v);
					}
					else if(self::fieldtype_float==$this->__table_struct[$k])
					{
						if(!isfloat_isfloat($v))
						{
							R_exception('[error-2833]字段错误/'.$this->__table_name.'/'.$k);
						}
						$v=floatval($v);
					}
					else
					{
						$v='\''.addslashes($v).'\'';
					}

				}
			}

		}
		unset($v);

	}
	function save_fieldset($field_name,$field_value)
	{
		return $this->save(
		[
			$field_name=>$field_value
		]);
	}
	function save_fieldplus($field,float $plusnum)
	{

		$save=[];

		if(!$plusnum)
		{
			return;
		}

		if($plusnum>0)
		{
			$save[$field]=[db_exp,'`'.$field.'`+'.$plusnum];
		}
		else
		{
			$save[$field]=[db_exp,'`'.$field.'`'.$plusnum];
		}

		return $this->save($save);

	}
//1 count
	function count()
	{

		$__sql='SELECT
		COUNT(*) AS `total_num`
		FROM `'.$this->__table_name.'` as `T0`
		'.$this->__query_jointable['jointable_joinstring'].'
		'.$this->__query_option['where'];

		$result=$this->query_querysql($__sql);

		$this->query_option_reset();

		return intval($result[0]['total_num']);

	}
//1 sum
	function sum(string $t0_field=null,string $t1_field=null)
	{

		$final_field='';

		if($t0_field)
		{
			$final_field='`T0`.`'.$t0_field.'`';
		}
		else if($t1_field)
		{
			$final_field='`T1`.`'.$t1_field.'`';
		}
		else
		{
			R_exception('[error-1839]sum设置错误');
		}

		$__sql='SELECT

		SUM('.$final_field.') AS `total_num`

		FROM `'.$this->__table_name.'` as `T0`

		'.$this->__query_jointable['jointable_joinstring'].'

		'.$this->__query_option['where'];

		$result=$this->query_querysql($__sql);

		$this->query_option_reset();

		return floatval($result[0]['total_num']);

	}
//1 delete
	function delete()
	{

		if(!$this->__query_option['where'])
		{
			R_exception('[error-3950]需要where');
		}

		$__sql='DELETE `T0` FROM

		`'.$this->__table_name.'` as `T0`

		'.$this->__query_option['where'];

		$result=$this->query_querysql($__sql);

		$this->query_option_reset();

		return $result;

	}

//1 jointable
	function jointable_join
	(
		\_lp_\datamodel\Database $jointable_obj,
		$jointable_condition,
		$jointable_type='left'
	)
	{

		if($this->__query_option)
		{
			R_exception('[error-2002]jointable_join必须在链式操作的第一个调用');
		}

		$this->__query_jointable['jointable_obj']=$jointable_obj;

		$temp=expd($jointable_condition,'=');

		$this->__query_jointable['jointable_joinstring']=$jointable_type.' join `'.$jointable_obj->__table_name.'` as `T1` on `T0`.`'.$temp[0].'`=`T1`.`'.$temp[1].'`';

		return $this;

	}
//1 transaction
	function transaction_start()
	{

		if(0)
		{//示例代码写法

			$__db/*\_lp_\datamodel\Databasenew*/->transaction_start();

			try
			{
				$ccc=$__db->add(
				[
					'xxx'=>1
				]);

				if(0)
				{//如需额外校验数据合法性
					throw new \Exception('xxx');
				}

				$__db->transaction_commit();

			}
			catch(\Exception $e)
			{

				$__db->transaction_rollback();
				throw $e;

			}

		}

		return $this->__driver->__pdo->beginTransaction();

	}
	function transaction_commit()
	{

		if(!$this->__driver->__pdo->inTransaction())
		{
			R_exception('[error-4222]pdo不在事务中');
		}

		return $this->__driver->__pdo->commit();

	}
	function transaction_rollback()
	{

		if(!$this->__driver->__pdo->inTransaction())
		{
			R_exception('[error-4406]pdo不在事务中');
		}

		return $this->__driver->__pdo->rollBack();

	}

}



