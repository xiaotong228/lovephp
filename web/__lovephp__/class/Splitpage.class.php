<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _lp_;
class Splitpage
{

	static function splitpage_gethtml
	(
		int $_page_index,
		int $_page_num,
		$__totalitemnum=false,
		$__fakestatic=false,
		array $__domset=[],
		&$__splitpageinfo=null,
		$__linksmaxnum=20
	)
	{


		$_page_index=min($_page_index,$_page_num);

		$__urlBase='';
		$__urlParam=$_GET;
		$__urlParam['_p']='{__pageindex__}';

		if($__fakestatic)
		{
			$__urlTemplate=url_build_static('',$__urlParam);
		}
		else
		{
			$__urlTemplate=url_build('',$__urlParam);
		}

		if($__domset[3])
		{//如果要在url上面带入"#xxxx"之类的信息
			$__urlTemplate.=$__domset[3];
		}

		$_page_num=max(ceil($_page_num),$_page_index);

		if(0&&$_page_num<=1)
		{//如果只有1页的话就别显示分页了
			return;
		}

		$__pageLink_map=[];

		if($_page_num<=$__linksmaxnum)
		{
			for($i=0;$i<$_page_num;$i++)
			{
				$__pageLink_map[$i]=$i+1;
			}
		}
		else
		{

			$begin=$_page_index-floor($__linksmaxnum/2);
			$begin=max($begin,0);

			$end=$begin+$__linksmaxnum-1;
			$end=min($_page_num-1,$end);

			for($i=$begin;$i<=$end;$i++)
			{
				$__pageLink_map[$i]=$i+1;
			}
			if(count($__pageLink_map)<$__linksmaxnum)
			{//如果没有满,补满

				for($i=$begin-1;true;$i--)
				{
					if(($i<0)||(count($__pageLink_map)>=$__linksmaxnum))
					{
						break;
					}

					$__pageLink_map[$i]=$i+1;
				}
				ksort($__pageLink_map);
			}

			if(1)
			{//把第一页和最后一页显示出来
				if(!isset($__pageLink_map[0]))
				{
					$__pageLink_map[0]=1;
				}
				if(!isset($__pageLink_map[1]))
				{
					$__pageLink_map[0].='...';
				}
				if(!isset($__pageLink_map[$_page_num-1]))
				{
					$__pageLink_map[$_page_num-1]=$_page_num;
				}
				if(!isset($__pageLink_map[$_page_num-2]))
				{
					$__pageLink_map[$_page_num-1]='...'.$__pageLink_map[$_page_num-1];
				}
			}

		}

		ksort($__pageLink_map);

		if(1)
		{//输出html代码

			$H.=_div($__domset[0],$__domset[1],'__splitpage__=splitpage '.$__domset[2]);

				if(false!==$__totalitemnum)
				{
					$H.=_span__('','','splitpage_role=totalitemnum',"共{$__totalitemnum}条");
				}

				if($_page_index>0)
				{
					$url=str_replace('{__pageindex__}',$_page_index-1,$__urlTemplate);
					$__splitpageinfo['prev']=$url;
					$clsTail='';
				}
				else
				{
					$url='';
					$__splitpageinfo['prev']=false;
					$clsTail=' _disable_';
				}

				$H.=_a__($url,'_prev_'.$clsTail,'','','上一页');

				foreach($__pageLink_map as $k=>$v)
				{
					$__urlParam['_p']=$k;
					$cls='';
					if((strlen($v)<=3)||('1...'==$v))
					{
						$cls.=' _width_fixed_';
					}
					else
					{
						$cls.=' _width_auto_';
					}
					if($k==$_page_index)
					{
						$cls.=' _current_';

						$H.=_a0($cls);
							$H.=$v;
						$H.=_a_();
					}
					else
					{
						$H.=_a(str_replace('{__pageindex__}',$k,$__urlTemplate),$cls,'','splitpage_role=pageitem');
							$H.=$v;
						$H.=_a_();
					}
				}

				if($_page_index<$_page_num-1)
				{
					$url=str_replace('{__pageindex__}',$_page_index+1,$__urlTemplate);
					$__splitpageinfo['next']=$url;
					$clsTail='';
				}
				else
				{
					$url='';
					$__splitpageinfo['next']=false;
					$clsTail=' _disable_';
				}

				$H.=_a__($url,'_next_'.$clsTail,'','','下一页');

			$H.=_div_();
		}
		return $H;
	}
}
