<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _widget_;
class Sliderbox
{

	static function sliderbox_html($frames=[],$tailhtml='',$config=[],$domset=[])
	{

		if(0)
		{//示例,要指定好viewzone和frame的高度,否则可能显示异常
			$config=[];

			$config['sliderbox_effect']='toploop';//toploop,leftloop
			$config['sliderbox_ind_triggertype']='mouse';//mouse,click
			$config['sliderbox_ani_switchtime']=300;//ms

			$config['sliderbox_autoplay']=true;//true,false
			$config['sliderbox_autoplay_delaytime']=3000;//ms
			$config['sliderbox_autoplay_hoverstop']=true;//true,false
		}

		$frames_num=count($frames);

		if($frames_num>\Prjconfig::widget_config['sliderbox_maxframenum'])
		{
			R_alert('[error-0652]超过最大frame数限制');
		}

		$frames_1=array_merge_1([$frames[$frames_num-1]],$frames,[$frames[0]]);
		$frames_1_count=count($frames_1);

		$domset['tail'].=' sliderbox_frame_index=0';
		$domset['tail'].=' sliderbox_frame_num='.$frames_num;

		if(cmd_default===$tailhtml)
		{

			$tailhtml='';
			$tailhtml.=_div('','','sliderbox_role=ind');

				$tail='sliderbox_ind_status=active';
				foreach($frames as $k=>$v)
				{
					$tailhtml.=_s__('','',$tail);
					$tail='';
				}

			$tailhtml.=_div_();
		}

		if(__m_access__)
		{

			$H.=_div($domset['cls'],$domset['sty'],\_widget_\Widget::domtail('sliderbox',$config).' '.$domset['tail']);

				if(1)
				{
					$H.=_div('',_sty('width',$frames_1_count.'00%'),'sliderbox_role=framewrap');
						foreach($frames_1 as $k=>$v)
						{
							$H.=$v;
						}
					$H.=_div_();
				}

				$H.=$tailhtml;

			$H.=_div_();

		}
		else
		{
			$domset['tail'].=' sliderbox_effect='.$config['sliderbox_effect'];
			$domset['tail'].=' sliderbox_triggertype='.$config['sliderbox_ind_triggertype'];

			$H.=_div($domset['cls'],$domset['sty'],\_widget_\Widget::domtail('sliderbox',$config).' '.$domset['tail']);

				$H.=_div('','','sliderbox_role=viewzone');

					if(1)
					{
						$H.=_div('','leftloop'==$config['sliderbox_effect']?'width:'.(100*$frames_1_count).'%;':'','sliderbox_role=framewrap');
							foreach($frames_1 as $v)
							{
								$H.=$v;
							}
						$H.=_div_();
					}

				$H.=_div_();

				$H.=$tailhtml;

			$H.=_div_();
		}

		return $H;

	}

}