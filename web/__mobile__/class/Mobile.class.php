<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _mobile_;
class Mobile
{

//1 routemode

	const statusbarstyle_light='light';
	const statusbarstyle_dark='dark';

	const statusbarstyle_keymap=
	[
		'statusbarstyle_light'=>self::statusbarstyle_light,
		'statusbarstyle_dark'=>self::statusbarstyle_dark,
	];

	static function articlebox_articlebox_list($__item,$cls='')
	{

		if(0)
		{//test

			$H.=_div('');
				$H.=$__item['id'];
			$H.=_div_();

			return $H;
		}

		if(0&&mt_rand(0,1))
		{//test
			$__item['article_thumb']='';
		}

		$category=\db\Article::category_namemap[$__item['article_category']];

		$H.=_a(article_articleurl($__item['id']),'g_article_articlebox '.($__item['article_thumb']?'has_thumb':' ').' '.$cls);

			if($__item['article_thumb'])
			{
				$H.=_div('left_thumbz','background-image:url('.$__item['article_thumb'].');');
				$H.=_div_();
			}

			$H.=_div('right_contentz');

				$H.=_div__('titlez','','',$__item['id'].'/'.$__item['article_title'].'/'.time_str());

				$H.=_div('timez');

					if($category)
					{
						$H.=_i__('','','',$category);
					}

					$H.=_span__('','','',date_str($__item['article_createtime']));
					$H.=_s__('','','',\db\Article::articlebox_viewnum($__item));

				$H.=_div_();

			$H.=_div_();

		$H.=_a_();

		return $H;

	}

	static function mobilepage_header($left=cmd_default,$center=false,$right=false)
	{

		if(cmd_default===$left)
		{

			$referer=server_url_referer();
			$referer=parse_url($referer);

			if(__ajax_isajax__||$referer['host']==server_host_domain())
			{
				$icon='&#xf055;';//返回
			}
			else
			{
				$icon='&#xf0a9;';//主页
			}

			$left=_i__('','','__mobileback__=mobileback',$icon);

		}

		if($right&&!$center)
		{
			$center=_div__();
		}

		if($center&&!$left)
		{
			$left=_div__();
		}

		$H.=_div('','','mobilepage_role=head');

			$H.=$left;
			$H.=$center;
			$H.=$right;

		$H.=_div_();

		return $H;

	}

//1 return

	static function return_route_back($cluser_updatedata=false,$toast=false)
	{
		if($cluser_updatedata)
		{
			$jscode='mobile_route_back(\'clu_connect_updateuserdata\');';
		}
		else
		{
			$jscode='mobile_route_back();';
		}
		if($toast)
		{
			$jscode.='ui_toast(\''.$toast.'\')';
		}

		R_jscode($jscode);
	}

	static function return_mobilepage
	(
		$newpage_inhtml,

		$newpage_domset=[],

		$newpage_position_from='position_right100',

		$oldpage_position_to='position_lefteclipse',

		$oldpage_mask=0,

		$oldpage_removehistory=0


	)
	{

		if(!$newpage_domset['statusbarstyle'])
		{
			$newpage_domset['statusbarstyle']=self::statusbarstyle_dark;
		}

		$mobilepage_positions=
		[
			'',

			'position_left100',

			'position_right100',

			'position_bottom100',

			'position_top100',

			'position_centersmall',

			'position_lefteclipse',

			'position_fullfill',
		];

		if(
			!in_array_1($newpage_position_from,$mobilepage_positions)||
			!in_array_1($oldpage_position_to,$mobilepage_positions)
		)
		{
			R_alert('[error-3535]不存在的mobilepage_position');
		}
		if(!$newpage_position_from)
		{
			R_alert('[error-3859]必须指定newpage_position_from');
		}

		if(1)
		{
			if($_POST['@mobilepage_pageid'])
			{
				$__newpage_id=$_POST['@mobilepage_pageid'];
			}
			else
			{
				$__newpage_id=math_salt();
			}
			if(__ajax_isajax__)
			{
				$__newpage_url=server_url_current();
			}
			else
			{
				$__newpage_url='';
			}

			$__newpage_tails=[];

			$__newpage_tails[]='id='.$__newpage_id;

			$__newpage_tails[]='__mobilepage__=mobilepage';

			$__newpage_tails[]='mobilepage_url=\''.$__newpage_url.'\'';

			$__newpage_tails[]=htmlecho_body_tail();

			if($newpage_domset['tail'])
			{
				$__newpage_tails[]=$newpage_domset['tail'];
			}
			if($newpage_domset['statusbarstyle'])
			{
				$__newpage_tails[]='mobilepage_statusbarstyle='.$newpage_domset['statusbarstyle'];
			}


			$__newpage_html='';
			$__newpage_html.=_div($newpage_domset['cls'],$newpage_domset['sty'],_tails($__newpage_tails));
				$__newpage_html.=$newpage_inhtml;
			$__newpage_html.=_div_();

		}

		if(__htmltag_check__)
		{
			htmltag_check();
		}

		if(!__alp_access__&&__ajax_isajax__)
		{//如果是ajax方式获取

			$__returndata=[];

			$__returndata['mobilepage_oldpage_set']=
			[
				'oldpage_position_to'=>$oldpage_position_to,
				'oldpage_mask'=>$oldpage_mask,
				'oldpage_removehistory'=>$oldpage_removehistory,
			];

			$__returndata['mobilepage_newpage_set']=
			[
				'newpage_html'=>$__newpage_html,
				'newpage_position_from'=>$newpage_position_from,
			];

			if(__ajax_isajax__)
			{

				if('refresh'==$_POST['@mobilepage_cmd'])
				{
					R_true($__returndata);
				}
				else if('xxx'==$_POST['@mobilepage_cmd'])
				{//预留其他指令
					R_alert('[error-3219]');
				}
				else
				{
					$__returndata=
					[
						\Lovephp::mobile_returncode_openpage=>$__returndata
					];

					R_sink($__returndata);
				}

			}

		}
		else
		{

			if(__alp_access__)
			{
				ob_start();
				fs_dir_delete(\Prjconfig::mobile_config['alp_build_to_dirpath']);
			}

			htmlecho_js_addvar('clu_data_js',clu_data());

			$__body_html='';

			$__body_html.=_div('','','__mobileroot_=mobileroot __devicetype__=mobile');
				$__body_html.=$__newpage_html;
			$__body_html.=_div_();

			htmlecho_css_addurl(
				[
					ltrim(__m_dir__,'.').'/assets/mobile.core.less',
				],true);

			htmlecho_js_addurl(
				[
					\Prjconfig::html_jqueryurl,
					ltrim(__vendor_dir__,'.').'/exifjs/exif.js',
					ltrim(__m_dir__,'.').'/assets/mobile.core.jsraw',
				],true);

			$css_code=htmlecho_css_getcode();
			$js_code=htmlecho_js_getcode();

			echo '<!DOCTYPE html>';
			echo '<html>';

				echo '<head>';

					echo '<meta charset="utf-8" >';

					echo '<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no,viewport-fit=cover" >';

					echo '<meta name=apple-mobile-web-app-capable content="yes" >';
					echo '<meta name=apple-mobile-web-app-status-bar-style content="black-translucent" >';

					echo '<meta name=keywords content="'.htmlecho_page_keywords(cmd_get).'" >';
					echo '<meta name=description content="'.htmlecho_page_description(cmd_get).'" >';

					echo '<link rel=icon href="/favicon.ico" />';

					echo '<title>'.htmlecho_page_title(cmd_get).'</title>';

					if(1)
					{

						echo "\n".'<style id=mobile_app_statusbar_height_def>';

							echo "\n".':root{--mobile_app_statusbarheight:'.client_app_statusbarheight().'px;}';
							echo "\n".':root{--mobile_app_statusbarheight_neg:-'.client_app_statusbarheight().'px;}';

							if(__alp_access__||client_is_iphone())
							{//苹果需要这个,要不bind click 不触发,按理说应该逐个把用到的元素设置这个,但是懒得去排查了,都设置了吧,这个设定挺奇怪的,也许现在苹果已经不需要了吧,没有测试,2022年6月24日15:23:14
								echo "\n".'*{cursor:pointer;}';
							}

						echo "\n".'</style>';
					}

					echo $css_code;

				echo '</head>';

				echo '<body>';
					echo $__body_html;
					echo $js_code;

					if(0)
					{//vconsole调,https://github.com/Tencent/vConsole
						echo '<script src="https://cdn.jsdelivr.net/npm/vconsole@latest/dist/vconsole.min.js"></script>
						<script type="text/javascript">
							let vConsole = new VConsole();
						</script>';
					}
					if(1)
					{//百度统计
						echo
							'
								<script>
								var _hmt = _hmt || [];
								(function() {
								  var hm = document.createElement("script");
								  hm.src = "https://hm.baidu.com/hm.js?cf172aefbfa777ba83ce020d6bb4d253";
								  var s = document.getElementsByTagName("script")[0];
								  s.parentNode.insertBefore(hm, s);
								})();
								</script>

							';
					}
				echo '</body>';

			echo '</html>';

			if(__alp_access__)
			{

				$html=ob_get_clean();

				$html='<!--lovephp/alp/buildtime:'.time_str().'-->'."\n".$html;

				fs_file_save(\Prjconfig::mobile_config['alp_build_to_dirpath'].'/index.html',$html);

				$attach_res_urls=
				[
					\Prjconfig::clu_config['clu_defaultavatar']
				];
				foreach($attach_res_urls as $v)
				{
					fs_file_copy('.'.$v,\Prjconfig::mobile_config['alp_build_to_dirpath'].$v);
				}

				if(__ajax_isajax__)
				{
					R_alert('[error-2431]成功<br>已生成app打包落地页面:'.\Prjconfig::mobile_config['alp_build_to_dirpath']);
				}
				else
				{
					echo $html;
					exit;
				}

			}

		}

		exit;

	}

	static function return_modal_open($inhtml,$domset=[],$effect='small_to_big',$clickbg_to_close=false)
	{

		if(__htmltag_check__)
		{
			htmltag_check();
		}

		$H.=_div($domset['cls'],$domset['sty'],'__mobilemodal__=mobilemodal mobilemodal_effect='.$effect.' '.$domset['tail']);

			if($clickbg_to_close)
			{
				$H.=_div('','','mobilemodal_role=close');
				$H.=_div_();
			}

			$H.=_div('','','mobilemodal_role=viewzone');
				$H.=$inhtml;
			$H.=_div_();

		$H.=_div_();

		$__returndata=[];

		$__returndata['modal_html']=$H;

		$__returndata=
		[
			\Lovephp::mobile_returncode_openmodal=>$__returndata
		];

		R_sink($__returndata);

	}

}
