<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _lp_\datamodel;

class Treedata
{
	public $data_treedata=[];

	public $data_filepath;

//1 instance
	static function td_instance(...$args)
	{
		return class_instanceclass(__CLASS__,...$args);
	}

//1 construct
	function __construct($__filepath/*string(filepath)|array(treedata)*/)
	{

		if(is_string($__filepath))
		{
			$this->data_treedata=fs_file_read_data($__filepath,fs_loose);
			$this->data_filepath=$__filepath;
		}
		else
		{
			$this->data_treedata=$__filepath;
			$this->data_filepath=null;
		}

		if(!$this->data_treedata)
		{
			$this->data_treedata=
				[
					0=>
						[
							'dna'=>0,
							'self'=>['name'=>'root']
						]

				];
		}
	}
//1 tree
	function tree_walknodes($__walkcallback)
	{

		$__recu=function(&$tree_data,$node_lv=0) use (&$__recu,$__walkcallback)
		{

			foreach($tree_data as $node_dna=>&$node_data)
			{

				$result=$__walkcallback($node_data,$node_lv);

				if(cmd_recu_breakrecu===$result)
				{

					$tree_data[$node_dna]=$node_data;

					throw new \Exception(cmd_recu_breakrecu);

				}
				else if(cmd_recu_deleteme===$result)
				{

					unset($tree_data[$node_dna]);
					continue;

				}
				else
				{}

				if($node_data['subtree'])
				{
					$__recu($node_data['subtree'],$node_lv+1);
				}

				if(!$node_data['subtree'])
				{//如果没有了就unset掉,避免留着一个空数组
					unset($node_data['subtree']);
				}

				$tree_data[$node_dna]=$node_data;

			}
			unset($node_data);

		};

		try
		{
			$__recu($this->data_treedata,0);
		}
		catch(\Exception $e)
		{

			if(cmd_recu_breakrecu===$e->getMessage())
			{
			}
			else
			{
				throw  $e;
			}

		}

	}
//1 file
	function file_savetofile($filepath=null)
	{

		$filepath=$filepath??$this->data_filepath;

		if(!$filepath)
		{
			R_alert('[error-4035]');
		}

		if(1)
		{//是否要做遍历purge动作?

		}

		fs_file_save_data($filepath,$this->data_treedata);

	}
//1 add
	function node_addnode($dad_dna,$node_dna,$node_self)
	{

		$__found=false;

		$this->tree_walknodes(function(&$node,$lv) use ($dad_dna,$node_dna,$node_self,&$__found)
		{

			if($dad_dna==$node['dna'])
			{

				$node['subtree'][$node_dna]=
				[
					'dna'=>$node_dna,
					'self'=>$node_self
				];

				$__found=true;

				return cmd_recu_breakrecu;
			}

		});
		if(!$__found)
		{
			R_alert('[error-0751]未找到节点');
		}

	}
//1 edit
	function node_editnode($dna,$node_self)
	{//只能编辑selfdata

		$__found=false;

		$this->tree_walknodes(function(&$node,$lv) use ($dna,&$__found,$node_self)
		{
			if($dna==$node['dna'])
			{
				$__found=true;
				$node['self']=$node_self;
				return cmd_recu_breakrecu;
			}
		});

		if(!$__found)
		{
			R_alert('[error-5819]未找到节点');
		}

		return $__found;

	}
//1 uniquename
	function node_addnode_uniquename($dna,$name)
	{

		$dad=$this->node_findnode($dna);

		if($dad['subtree'])
		{
			foreach($dad['subtree'] as $v)
			{
				if(strtolower($name)==strtolower($v['self']['name']))
				{
					return false;
				}
			}
		}

		return true;

	}
	function node_editnode_uniquename($dna,$name)
	{

		$acsts=$this->node_nodeacsts($dna,1);

		$dad=$acsts[count($acsts)-2];

		foreach($dad['subtree'] as $k=>$v)
		{
			if(strtolower($v['self']['name'])==strtolower($name)&&$k!=$dna)
			{
				return false;
			}
		}
		return true;

	}
//1 node
	function node_deletenode($dna)
	{
		$__found=false;
		$this->tree_walknodes(function($node,$lv) use ($dna,&$__found)
		{
			if($dna==$node['dna'])
			{
				$__found=true;
				return cmd_recu_deleteme;
			}
		});
		if(!$__found)
		{
			R_alert('[error-4619]未找到节点');
		}
		return true;
	}
	function node_movenode($dna,$dir)
	{

		$__found=false;

		$this->tree_walknodes(function(&$node,$lv) use ($dna,&$__found,$dir)
		{
			if($node['subtree']&&$node['subtree'][$dna])
			{

				$__found=true;

				if(-1==$dir&&$dna==array_key_first($node['subtree']))
				{
					R_alert('首节点不能上移');
				}
				else if(1==$dir&&$dna==array_key_last($node['subtree']))
				{
					R_alert('末节点不能下移');
				}
				else
				{

				}

				$node['subtree']=array_item_move($node['subtree'],$dna,$dir);

				return cmd_recu_breakrecu;

			}

		});

		if(!$__found)
		{
			R_alert('[error-2647]没有找到节点('.$dna.')');
		}

		return true;

	}

	function node_nodeacsts($dna,$keepsubtree=false)
	{//节点继承关系,包括自己

		$__result=[];

		$__found=false;

		$this->tree_walknodes(

		function($node,$lv) use ($dna,&$__result,&$__found)
		{
			$__result[$lv]=$node;
			if($node['dna']==$dna)
			{
				$__result=array_slice($__result,0,$lv+1);
				$__found=true;
				return cmd_recu_breakrecu;
			}
		});

		if(!$keepsubtree)
		{
			foreach($__result as &$v)
			{
				unset($v['subtree']);
			}
			unset($v);
		}
		if($__found)
		{
			return $__result;
		}
		else
		{
			return false;
		}

	}
	function node_findnode($dna)
	{

		$__result=false;

		$this->tree_walknodes(function($node,$lv) use ($dna,&$__result)
		{
			if($dna==$node['dna'])
			{
				$__result=$node;
				return cmd_recu_breakrecu;
			}
		});

		return $__result;

	}

	function node_findnodes(array $dnas)
	{

		$__result=[];

		$dnas=array_unique($dnas);

		$this->tree_walknodes(function($node,$lv) use ($dnas,&$__result)
		{

			if(in_array_1($node['dna'],$dnas))
			{

				$__result[$node['dna']]=$node;

				if(count($dnas)==count($__result))
				{
					return cmd_recu_breakrecu;
				}

			}

		});

		return $__result;

	}
	function node_nodelv($dna)
	{
		$__result=false;

		$this->tree_walknodes(function($node,$lv) use ($dna,&$__result)
		{
			if($dna==$node['dna'])
			{
				$__result=$lv;
				return cmd_recu_breakrecu;
			}
		});

		return intval($__result);
	}
	function node_flatnodes($keepsubtree=false)
	{
		$__result=[];

		$this->tree_walknodes(function($node,$lv) use ($keepsubtree,&$__result)
		{

			$temp=$node;

			if($keepsubtree)
			{

			}
			else
			{
				unset($temp['subtree']);
			}

			$__result[$node['dna']]=$temp;

		});

		return $__result;

	}
	function node_routepath($dna,$keeproot=false)
	{

		$acsts=$this->node_nodeacsts($dna);

		if($keeproot)
		{
		}
		else
		{
			$acsts=array_slice($acsts,1);
		}

		$__result=[];

		foreach($acsts as $v)
		{
			$__result[]=$v['self']['name'];
		}

		return impd($__result,'/');

	}

}
