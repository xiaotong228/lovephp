<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _widget_;
class Uploadavatar
{

	static function uploadavatar_html(array $config=[],$domset=[])
	{

		$config['@upload_config']=self::uploadavatar_uploadconfig_get();

		$H.=_div('','',\_widget_\Widget::domtail('uploadavatar',$config));

			$H.=_div('','','__button__="medium color0 w200" uploadavatar_role=ua_selectfile');
				$H.=_i__('','','','&#xf0ad;');
				$H.='选择头像';
			$H.=_div_();

			$H.=_div('','display:none;','uploadavatar_role=ua_operpanel');

				$H.=_div('','','uploadavatar_role=ua_cutbox_wrap');

					$H.=_div('','','uploadavatar_role=ua_cutbox');

						$H.=_div__('','','uploadavatar_role=ua_cutbox_drag');

						for($i=0;$i<4;$i++)
						{
							$H.=_div__('','','uploadavatar_role=ua_cutbox_shadow index='.$i);
						}
						for($i=0;$i<4;$i++)
						{
							$H.=_div__('','','uploadavatar_role=ua_cutbox_point index='.$i);
						}

					$H.=_div_();

				$H.=_div_();

			$H.=_div_();

			$H.=_a0('','margin-top:10px;display:none;','__button__="medium color0 solid w200" uploadavatar_role=ua_savebtn');
				$H.='保存头像';
			$H.=_a_();

			$H.=_input_file('','','','','display:none;','accept="'.$config['@upload_config']['file_exts_acceptstr'].'" '.($config['uploadfile_filemaxnum']>1?' multiple=multiple':''));

		$H.=_div_();

		return $H;

	}

	static function uploadavatar_uploadconfig_get()
	{
		return \controller\foreground\Upload::uploadtoken_set(\Prjconfig::file_pic_exts,1*datasize_1mb,'avatar');
	}

}
