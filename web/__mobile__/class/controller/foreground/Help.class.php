<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _mobile_\controller\foreground;
class Help extends \controller\foreground\Help
{

	function aboutus()
	{

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','',\controller\foreground\Help::aboutus_title));

		if(1)
		{//__body__

			$H.=_div('','','mobilepage_role=body');

				$H.=_div('helpaboutus_appinfoz');

					$H.=_div__('logoz_img');
					$H.=_div__('namez','','',\Prjconfig::project_config['project_name']);

					if(client_is_app())
					{
						$H.=_div__('descz','','','当前版本:v'.client_app_version());
					}
					$H.=_div('descz');
						$H.=\Prjconfig::project_config['project_officialsite'];
					$H.=_div_();
				$H.=_div_();

				if(client_is_app())
				{
					$H.=_sep(20);
					$H.=_a0('','','__pagemenu__=menu pm_rightarrow onclick="anv_check(1)"');

						$H.=_i__('','','','&#xf07e;');
						$H.=_span__('','','','检查版本');

						$newversion=\_mobile_\controller\foreground\Api::anv_check(1);
						if($newversion)
						{
							$H.=_s__('__color_orange__','','','发现新版:v'.$newversion);
						}

					$H.=_a_();
					$H.=_a0('','','__pagemenu__=menu pm_rightarrow onclick="helpappcache_clear()"');
						$H.=_i__('','','','&#xf0af;');
						$H.=_span__('','','','清除缓存');
						$H.=_s__('__color_orange__','','id=appcache_size','...');
					$H.=_a_();
				}

				if(1)
				{
					$H.=_sep(20);

					$H.=_a('/help/terms_service','','','__pagemenu__=menu pm_rightarrow');
						$H.=_span__('','','',\controller\foreground\Help::service_title);
					$H.=_a_();

					$H.=_a('/help/terms_privacy','','','__pagemenu__=menu pm_rightarrow');
						$H.=_span__('','','',\controller\foreground\Help::privacy_title);
					$H.=_a_();

					$H.=_a_external__('http://www.lovephp.com','','','__pagemenu__=menu pm_rightarrow',_span__('','','','访问官网')._s__('','','',\Prjconfig::project_config['project_officialsite']));

				}

			$H.=_div_();

		}

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}

	function terms_service()
	{//使用协议

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','',\controller\foreground\Help::service_title));

		if(1)
		{//__body__

			$H.=_div('','','mobilepage_role=body');
				$H.=$this->terms_service_inhtml();
				$H.=_sep(30);
			$H.=_div_();
		}

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}
	function terms_privacy()
	{//隐私条款

		$H.=\_mobile_\Mobile::mobilepage_header(cmd_default,_b__('','','',\controller\foreground\Help::privacy_title));

		if(1)
		{//__body__

			$H.=_div('','','mobilepage_role=body');
				$H.=$this->terms_privacy_inhtml();
				$H.=_sep(30);
			$H.=_div_();

		}

		\_mobile_\Mobile::return_mobilepage($H,['tail'=>'mobilepage_grid=normal']);

	}

}
