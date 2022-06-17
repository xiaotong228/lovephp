<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace _mobile_\controller\foreground\index;

trait Index_my
{

	function _my_html($pullrefresh=0)
	{

		$__userdata=clu_data();

		$pullrefresh_config=[];
		$pullrefresh_config['pullrefresh_refreshurl']=url_build('_my_html?pullrefresh=1');

		if(1)
		{
			$H.=_div('','','pullrefresh_role=dragbox');

				if(1)
				{
					$H.=_div('my_userinfoz');

						if($__userdata)
						{

							$H.=_a0();
								$H.=_img($__userdata['user_avatar'],'avatar','','__cluserdata__=user_avatar onclick="
									__lpwidget__.picgallery.pg_open($(this).attr(\'src\'));
								" ');
							$H.=_a_();

							$H.=_a__('/cluindex/index','username','','__cluserdata__=user_name',$__userdata['user_name']);

						}
						else
						{

							$H.=_a0();

								if(__alp_access__)
								{
									$H.=_img('.'.\Prjconfig::clu_config['clu_defaultavatar'],'avatar');
								}
								else
								{
									$H.=_img(\Prjconfig::clu_config['clu_defaultavatar'],'avatar');
								}

							$H.=_a_();

							$H.=_a__('/cluindex/index','username','','__cluserdata__=user_name','登录');

						}

					$H.=_div_();

				}

				$H.=_sep(20);

				$H.=_a('/clubusiness','','','__pagemenu__=menu pm_rightarrow');
					$H.=_i__('','','','&#xf09a;');
					$H.=_span__('','','','业务菜单');
				$H.=_a_();

				$H.=_sep(20);

				$H.=_a('/help/aboutus','','','__pagemenu__=menu pm_rightarrow');

					$H.=_i__('','','','&#xf08a;');

					$H.=_span__('','','','关于'.\Prjconfig::project_config['project_name']);

					if(!__alp_access__&&client_is_app())
					{
						$newversion=\_mobile_\controller\foreground\Api::anv_check(1);
						if($newversion)
						{
							$H.=_s__('__color_orange__','','','发现新版:v'.$newversion);
						}
					}

				$H.=_a_();

				if(1||!__alp_access__)
				{
					if(1)
					{//webview
						$H.=_sep(20);

						$H.=_a0('','','__pagemenu__=menu pm_rightarrow onclick="jump_webview()"');
							$H.=_i__('','','','&#xf07a;');
							$H.=_span__('','','','webview/刷新');
						$H.=_a_();

						$temp=
						[
							'lanhost'=>'http://m.lovephp.lanhost.lovephp.com',
							'onlinehost'=>'http://m.lovephp.onlinehost.lovephp.com',
						];
						foreach($temp as $k=>$v)
						{
							$H.=_a0('','','__pagemenu__=menu pm_rightarrow onclick="
								ui_confirm(\'切换至'.$v.'?\',function()
								{
									jump_webview(\''.$v.'\')
								});
								"');
								$H.=_i__('','','','&#xf07a;');
								$H.=_span__('','','','webview/切换/'.$k);
							$H.=_a_();
						}
					}

					if(1)
					{//调试
						$H.=_sep(20);
						$H.=_a0('','','__pagemenu__=menu pm_rightarrow onclick="console_history_alert()"');
							$H.=_i__('','','','&#xf07a;');
							$H.=_span__('','','','调试/consolehistory/alert');
						$H.=_a_();
						$H.=_a0('','','__pagemenu__=menu pm_rightarrow onclick="console_history_clear()"');
							$H.=_i__('','','','&#xf07a;');
							$H.=_span__('','','','调试/consolehistory/clear');
						$H.=_a_();
						$H.=_a0('','','__pagemenu__=menu pm_rightarrow onclick="alert(\'windowsize:\'+_window.window_width_cache+\'*\'+_window.window_height_cache);"');
							$H.=_i__('','','','&#xf07a;');
							$H.=_span__('','','','调试/0');
						$H.=_a_();
					}

					if(1)
					{
						$H.=_sep(20);
						$H.=_a0('','','__pagemenu__=menu pm_rightarrow onclick="alpbuild_build()"');
							$H.=_i__('','','','&#xf07a;');
							$H.=_span__('','','','APP/打包生成落地页(alp)');
						$H.=_a_();

						$H.=_a('/api/alp_firststartagree','','','__pagemenu__=menu pm_rightarrow ');
							$H.=_i__('','','','&#xf07a;');
							$H.=_span__('','','','APP/首屏用户协议');
						$H.=_a_();

						$H.=_a0('','','__pagemenu__=menu pm_rightarrow onclick="anv_check(1,1)"');
							$H.=_i__('','','','&#xf07a;');
							$H.=_span__('','','','APP/升级页面');
						$H.=_a_();

					}
					if(1)
					{
						$temp=session_get('alpconnect_config');

						$H.=_sep(20);

						$H.=_div('','','__pagemenu__=text');

							$H.='host:'.server_host_http();
							$H.='<br>ip:'.client_ip().'/'.\_lp_\Ipaddress::ipaddress_get(client_ip());
							$H.='<br>session_id:'.session_id();
							$H.='<br>alpconnect_config:'.json_encode_1($temp);
							$H.='<br>time:'.time_str();
							$H.='<br>useragent:'.client_useragent();

						$H.=_div_();

						$H.=_sep(20);

					}
				}

			$H.=_div_();

		}

		if($pullrefresh)
		{
			$data=[];
			$data['pullrefresh_html']=$H;
			$data['pullrefresh_successtips']='数据已更新';
			R_true($data);
		}

		return $H;

	}

}

