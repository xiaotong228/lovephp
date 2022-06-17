<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _widget_;
class Uploadfile
{

	static function uploadfile_html(array $config,array $default_file_urls=[]/*可能是一个包含文件名和大小的二维数组*/,array $domset=[])
	{


		$__urls=[];
		foreach($default_file_urls as &$v)
		{
			if(!is_array($v))
			{
				$v=[$v,path_filename($v)];
			}

			$__urls[]=$v[0];

		}
		unset($v);

		$config['uploadfile_filemaxnum']=max($config['uploadfile_filemaxnum'],1);

		if(0)
		{//test
			$svg=fs_file_read_xml('./assets/img/ring/ring.uploadprogress.svg');
		}

		$H.=_div($domset['cls'],$domset['sty'],\_widget_\Widget::domtail('uploadfile',$config).' '.$domset['tail']);

			$H.=_div('','','uploadfile_role=uf_filelist');

				foreach($default_file_urls as $k=>$v)
				{

					$H.=_div('','','uploadfile_role=uf_fileitem uploadfile_status=done');

						$H.=_div__('icon_uploaddone');
						if(0)
						{
							$H.=$svg;
						}

						$H.=_div('filename');
							$H.=_an__($v[0],'','','',$v[1]);
							if($v[2])
							{
								$H.='<br>'._s__('','','',datasize_oralstring($v[2]));
							}
						$H.=_div_();

						$H.=_div('operz');
							$H.=_a0__('move_up','','title="上移一位"');
							$H.=_a0__('move_down','','title="下移一位"');
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

			$H.=_div('','','__button__="'.$button.'" uploadfile_role=uf_selectfile');
				$H.=_i__();
				$H.=_span__('','','',count($default_file_urls).'/'.$config['uploadfile_filemaxnum']);
			$H.=_div_();

			if(__m_access__)
			{//啥毛病啊,移动端指定了扩展名后只能弹出"相机",//小米手机

				$H.=_input_file('','','','','display:none;','accept="*.*" '.($config['uploadfile_filemaxnum']>1?' multiple=multiple':''));

			}
			else
			{

				$H.=_input_file('','','','','display:none;','accept="'.$config['@upload_config']['file_exts_acceptstr'].'" '.($config['uploadfile_filemaxnum']>1?' multiple=multiple':''));

			}

			if($config['uploadfile_inputname'])
			{
				$H.=_input_hidden($config['uploadfile_inputname'],impd($__urls),'','','width:1000px;');
			}

		$H.=_div_();

		return $H;

	}

}
