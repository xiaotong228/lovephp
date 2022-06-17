<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _widget_;
class Uploadpic
{

	static function uploadpic_html(array $config,array $default_file_urls=[],array $domset=[])
	{

		$config['uploadpic_filemaxnum']=max(intval($config['uploadpic_filemaxnum']),1);

		if(0)
		{//test
			$svg=fs_file_read_xml('./assets/img/ring/ring.uploadprogress.fff.svg');
		}

		$H.=_div($domset['cls'],$domset['sty'],\_widget_\Widget::domtail('uploadpic',$config).' '.$domset['tail']);

			$H.=_div('','','uploadpic_role=up_piclist');

				foreach($default_file_urls as $k=>$v)
				{

					$H.=_div('','','uploadpic_role=up_picitem uploadpic_status=done');

						$H.=_an($v,'imgwrapz');
							$H.=_img($v);
						$H.=_a_();

						if(0)
						{//test
							$H.=_div('progressz');
								$H.=$svg;
							$H.=_div_();
						}

						$H.=_div('operz');
							$H.=_a0__('move_left','','title="左移一位"');
							$H.=_a0__('move_right','','title="右移一位"');
							$H.=_a0__('delete','','title="删除"');
						$H.=_div_();

					$H.=_div_();

				}

			$H.=_div_();

			if(__m_access__)
			{
				$button='big color0';
			}
			else
			{
				$button='medium color0 w200';
			}

			$H.=_div('','','__button__="'.$button.'" uploadpic_role=up_selectfile');
				$H.=_i__();
				$H.=_span__('','','',count($default_file_urls).'/'.$config['uploadpic_filemaxnum']);
			$H.=_div_();

			if(__m_access__)
			{//啥毛病啊,移动端指定了扩展名后只能弹出"相机",//小米手机

				$H.=_input_file('','','','','display:none;','accept="image/*" '.($config['uploadpic_filemaxnum']>1?' multiple=multiple':''));

			}
			else
			{

				$H.=_input_file('','','','','display:none;','accept="'.$config['@upload_config']['file_exts_acceptstr'].'" '.($config['uploadpic_filemaxnum']>1?' multiple=multiple':''));

			}

			if($config['uploadpic_inputname'])
			{
				$H.=_input_hidden($config['uploadpic_inputname'],impd($default_file_urls),'','','width:1000px;');
			}

		$H.=_div_();

		return $H;

	}
}
