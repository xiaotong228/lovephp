<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _widget_;
class Treeshow
{

	static function treeshow_html($tree_treedata,$config,$defaultopen_lv=0,array $__domset=null)
	{//目前一个页面上只能展示一个treeshow,展示多个需要调整代码

		$H.=_div($__domset['cls'],$__domset['sty'],\_widget_\Widget::domtail('treeshow',$config).' '.$__domset['tail']);

			if(1)
			{
				$__buildnodefunc=function ($tree_treedata,$lv=0) use
				(&$__buildnodefunc,$defaultopen_lv,&$getnodeinfo_func)
					{
						foreach($tree_treedata as $k=>$node)
						{

							$node_open=($lv<=$defaultopen_lv)?'yes':'no';

							if($node['subtree'])
							{
								$node_end='no';
							}
							else
							{
								$node_end='yes';
								$node_open='no';
							}


							$tails=[];

							$tails[]='treeshow_role=node';
							$tails[]='treeshow_nodedna='.$node['dna'];
							$tails[]='treeshow_nodelv='.$lv;
							$tails[]='treeshow_nodeopenstatus='.$node_open;
							$tails[]='treeshow_nodeend='.$node_end;

							$H.=_div('','',impd($tails,' '));

								$H.=_div('','','treeshow_role=node_self');
									$H.=_a0__('','','treeshow_role=node_self_toggle');

									if(1)
									{
										$H.=_div('','','treeshow_role=node_self_self');
											$H.=_div('','','treeshow_role=node_self_self_header');

												if($node['self']['@node_self_icon'])
												{
													$temp=expd($node['self']['@node_self_icon'],'@');
													$H.=_i__('','color:#fff;'._sty('background',$temp[1]),'',$temp[0]);
												}

												$H.=_span__('','','',$node['self']['name']);
												$H.=_s__('','','',$node['dna']);
											$H.=_div_();
											if($node['self']['@node_self_body'])
											{
												$H.=_div('','','treeshow_role=node_self_self_body');
													$H.=$node['self']['@node_self_body'];
												$H.=_div_();
											}
										$H.=_div_();
									}

									if(0)
									{
										$H.=_div('','','treeshow_role=node_self_self');
											$H.=_span('name');
												$H.=$node['self']['name'];
											$H.=_span_();

											$H.=_span__('dna fake','','',$node['dna']);
											$H.=_span__('dna show','','',$node['dna']);

										$H.=_div_();
									}

									if(0==$lv)
									{
										$H.=_a0__('','','treeshow_role=openall','全部展开');
										$H.=_a0__('','','treeshow_role=closeall','全部收拢');
									}

								$H.=_div_();

								if($node['subtree'])
								{
									$H.=_div('','','treeshow_role=node_subtree');
									$H.=$__buildnodefunc($node['subtree'],$lv+1);
									$H.=_div_();
								}

							$H.=_div_();
						}
						return $H;
					};
				$H.=$__buildnodefunc($tree_treedata,0);
			}

		$H.=_div_();

		return $H;

	}



}