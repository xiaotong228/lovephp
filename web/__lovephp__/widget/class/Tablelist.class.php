<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _widget_;
class Tablelist
{

	static function tablelist_html($header,$body,$showcheckbox=false,array $domset=[])
	{

		$H.=_table($domset['cls'],$domset['sty'],'__tablelist__=tablelist '.$domset['tail']);

			$H.='<thead>';

				$H.=_tr();
					$first=1;
					foreach($header as $th_name=>$th_width)
					{

						$sty=$th_width?'width:'.$th_width:'';
						$H.=_th('',$sty);
							if($first&&$showcheckbox)
							{
								$H.=_checkbox_1('','',0,['tail'=>'tablelist_role=checkid_checkall'],$th_name);
							}
							else
							{
								$H.=$th_name;
							}
						$H.=_th_();
						$first=0;
					}
				$H.=_tr_();

			$H.='</thead>';

			$H.='<tbody>';

				foreach($body as $v)
				{
					$H.=_tr('','','managetable_value='.$v[0]);

						foreach($v as $kk=>$vv)
						{
							if($showcheckbox&&0==$kk)
							{
								$vv=_checkbox_1('',$vv,'',['tail'=>'tablelist_role=checkid_checksingle'],$vv);
							}
							$H.=_td__('','','',$vv);
						}

					$H.=_tr_();

				}

			$H.='</tbody>';
		$H.=_table_();
		return $H;
	}

}
