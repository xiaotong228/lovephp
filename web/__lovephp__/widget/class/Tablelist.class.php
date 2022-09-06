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
	{//$body中的每组第一个item如果是数组的话,则数组第一个表示label,第二个表示checkbox的value

		$H.=_table($domset['cls'],$domset['sty'],'__tablelist__=tablelist '.$domset['tail']);

			$H.='<thead>';

				$H.=_tr();
					$first=1;
					foreach($header as $th_name=>$th_width)
					{

						if($th_width)
						{
							$sty='width:'.$th_width.';min-width:'.$th_width.';';
						}
						else
						{
							$sty='';
						}

						$H.=_th('',$sty);

							if($first&&$showcheckbox)
							{

								$H.=_checkbox_1('','',0,['tail'=>'tablelist_role=checkid_checkall'],$th_name);

								$H.=\_widget_\Popupbox::popup_tips('左侧选框可以全选/取消全选<br>按住CTRL并勾选下方选框可以范围选择');

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
								if(is_array($vv))
								{//如果是数组进来的,第一个表示label,第二个表示checkbox的value
									$vv=_checkbox_1('',$vv[1],'',['tail'=>'tablelist_role=checkid_checksingle'],$vv[0]);
								}
								else
								{
									$vv=_checkbox_1('',$vv,'',['tail'=>'tablelist_role=checkid_checksingle'],$vv);
								}

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
