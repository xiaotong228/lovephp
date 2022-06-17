<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace _lp_\datamodel\databasedriver;

class Mysql
{

	public $__pdo=false;

	private $__config=false;

	function __construct($__config)
	{

		if(0)
		{//没啥用,也可关闭
			$this->__config=$__config;
		}

		$this->__pdo=new \PDO
			(
				'mysql:dbname='.$__config['db_driver_databasename'].';
				host='.$__config['db_driver_host'].';
				port='.$__config['db_driver_port'].';
				charset='.$__config['db_driver_charset'],
				$__config['db_driver_user'],
				$__config['db_driver_password']
			);

	}
	function driver_querysql($sql)
	{

		$sql=trim($sql);

		if(__db_recordsqllog__)
		{
			dd_time_ms();
		}
		if(0)
		{//test
			echo _pre__('','','',$sql);
		}
		$__result=$this->__pdo->query($sql);

		if(__db_recordsqllog__)
		{
			dd_log('mysql',dd_time_ms()."ms\n".$sql,0/*,1,如果想记录调用堆栈的话*/);
		}

		if(!$__result)
		{

			$errorinfo=$this->__pdo->errorInfo();
			$errorinfo=impd($errorinfo,'/');

			$errorinfo.="\n".$sql;

			throw new \Exception($errorinfo);

		}

		if(0===stripos($sql,'insert'))
		{
			return intval($this->__pdo->lastInsertId());
		}
		else if(
			0===stripos($sql,'update')||
			0===stripos($sql,'delete')
		)
		{
			return $__result->rowCount();
		}
		else
		{//select,show啥的

			return $__result->fetchAll(\PDO::FETCH_ASSOC);

		}

	}

}



