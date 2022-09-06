<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



$menu_map=[];

foreach($____controller->leftmenu_menumap as $k=>$v)
{

	$temp=expd($v,'/');
	if(count($temp)>1)
	{
		$menu_map[$temp[0]][$k]=$temp[1];
	}
	else
	{
		$menu_map[$k]=$v;
	}

}

echo _module();

	if($menu_map)
	{
		foreach($menu_map as $k=>$v)
		{

			if(is_array($v))
			{

				$inthisgroup=array_key_exists(__route_controller__,$v);

				echo _div('menugroup '.($inthisgroup?'inthisgroup':''),'','__toggleshow__=toggleshow'.($inthisgroup?' toggleshow_status=active':''));

					echo _div__('','','toggleshow_role=trigger',$k);

					echo _div('','','toggleshow_role=blinkzone');

						foreach($v as $kk=>$vv)
						{
							if(__route_controller__==$kk)
							{
								$cls='csel';
							}
							else
							{
								$cls='';
							}
							echo _a__('/'.__route_module__.'/'.$kk,$cls,'','',$vv);
						}

					echo _div_();

				echo _div_();

			}
			else
			{

				if(__route_controller__==$k)
				{
					$cls='csel';
				}
				else
				{
					$cls='';
				}

				$url='/'.__route_module__.'/'.$k;

				if('/debug/test'==$url)
				{
					echo _an__($url,$cls,'','',$v);
				}
				else
				{
					echo _a__($url,$cls,'','',$v);
				}


			}

		}

	}
	else
	{

		echo _a0__($cls,'','','无可用菜单');

	}

echo _module_();

