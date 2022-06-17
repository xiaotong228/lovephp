<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace _mobile_\controller\foreground;

class Api extends \controller\foreground\Api
{

	function widgetpage_uploadavatar()
	{


		$config=[];
		$config['@upload_config']=\_widget_\Uploadavatar::uploadavatar_uploadconfig_get();
		$config['uploadavatar_saveurl']=$_POST['uploadavatar_saveurl'];

		if(1)
		{

			$H.=_div('','','uploadavatar_role=ua_operpanel');

				$H.=_div('','display:none;','uploadavatar_role=ua_cutbox_wrap');

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


			$H.=_div('','','uploadavatar_role=ua_operz');

				$H.=_div__('','','uploadavatar_role=rotate_left','&#xf0a8;');
				$H.=_div__('','','uploadavatar_role=rotate_right','&#xf0a7;');

				$H.=_a0__('','','__button__="big black" __mobileback__=mobileback','取消');
				$H.=_a0__('','','__button__="big color0 solid" uploadavatar_role=ua_savebtn ','保存');

			$H.=_div_();

		}

		\_mobile_\Mobile::return_mobilepage($H,
		[
			'tail'=>\_widget_\Widget::domtail('uploadavatar',$config),//'__avatarset__=avatarset',
			'statusbarstyle'=>\_mobile_\Mobile::statusbarstyle_light
		]);

	}
	function widgetpage_picgallery()
	{

		if(1)
		{
			$pics=$_POST['pics'];
		}
		else
		{//test

			$pics=
			[
				'/example/img/0.jpg',
				'/example/img/1.jpg',
				'/example/img/2.jpg',
				'/example/img/3.jpg',
				'/example/img/chaogao.jpg',
				'/example/img/chaokuan.jpg',
			];

		}

		if(!$pics)
		{
			$pics=[];
		}

		$pics_index=intval($_POST['index']);
		$pics_count=count($pics);

		if($pics_count>\Prjconfig::widget_config['picgallery_maxframenum'])
		{
			R_alert('[error-1736]超过最大frame数限制');
		}

		$H.=_div('','','picgallery_role=viewzone');

			$H.=_div('','width:'.$pics_count.'00vw','picgallery_role=framewrap');

			foreach($pics as $k=>$v)
			{
				$H.=_div('','','picgallery_role=frame');
					$H.=_img($v);
				$H.=_div_();
			}

			$H.=_div_();

		$H.=_div_();

		if($pics_count>1)
		{
			$H.=_div__('','','picgallery_role=eclipse_left');
			$H.=_div__('','','picgallery_role=eclipse_right');

			$H.=_div('','','picgallery_role=page_ind');
			$H.=_div_();
		}

		$H.=_div__('','','__mobileback__=mobileback');
		$H.=_div__('','','picgallery_role=save','保存');

		\_mobile_\Mobile::return_mobilepage
		(
			$H,
			[
				'tail'=>'__picgallery__=picgallery picgallery_frame_index='.$pics_index.' picgallery_frame_count='.$pics_count,
				'statusbarstyle'=>\_mobile_\Mobile::statusbarstyle_light
			],
			'position_bottom100',
			'position_fullfill'
		);

	}
	static function anv_check($return=0,$showtoast=0,$forceshow=0)
	{

		if(0&&!client_is_app())
		{
			R_alert('[error-4949]');
		}

		if(client_is_iphone())
		{
			$__server_versioninfo=\Prjconfig::mobile_config['mobile_app_newestversion']['iphone'];
		}
		else
		{//默认读安卓的
			$__server_versioninfo=\Prjconfig::mobile_config['mobile_app_newestversion']['android'];
		}

		if(0===strpos($__server_versioninfo['downloadurl'],'/'))
		{
			$__server_versioninfo['downloadurl']=server_host_http().$__server_versioninfo['downloadurl'];
		}

		$__server_versionnum=nf_versionnum($__server_versioninfo['versionnum']);
		$__client_versionnum=nf_versionnum(client_app_version());

		if($forceshow)
		{
			$__client_versionnum=0;
		}

		if($__server_versionnum>$__client_versionnum)
		{
			if($return)
			{
				return $__server_versioninfo['versionnum'];
			}
			$H='';

			$H.=_div__('p0_logoz');

			$H.=_div('p1_textz');
				$H.='发现新版本&nbsp;'.$__server_versioninfo['versionnum'];
			$H.=_div_();

			$H.=_div__('p2_descz','','',$__server_versioninfo['releasenote']);

			$H.=_div('p3_btnz','','__buttonwrap__');
				$H.=_a0__('','','__button__="big color0 solid" onclick="anv_upgrade(this,\''.$__server_versioninfo['downloadurl'].'\')" ','立即更新');
				$H.=_a0__('','','__button__="big black " mobilemodal_role=close ','稍后再说');
			$H.=_div_();

			$H.=_div__('p3_downloadprogress','','','0%');

			\_mobile_\Mobile::return_modal_open($H,['cls'=>'anv_check_modal'],'small_to_big');

		}
		else
		{
			if($return)
			{
				return false;
			}
			else if($showtoast)
			{
				R_toast('当前已是最新版本');
			}
			else
			{
				R_false();
			}

		}

	}
	function anv_check_public($showtoast=0,$forceshow=0)
	{
		return $this->anv_check(0,$showtoast,$forceshow);
	}
//1 alp
	function alp_getonlineserver()
	{//此处返回给app land page应该跳转到网址,如果因为其他原因需要控制跳转到其他网址作为线上首页,在这里控下

		if($_POST['alpconnect_config'])
		{
			session_set('alpconnect_config',$_POST['alpconnect_config']);
		}
		else
		{
			session_delete('alpconnect_config');
		}

		$host=$this->alpbuild_getserverhost();

		$data=[];
		$data['onlineserver_host']=$host;
		$data['onlineserver_sessionid']=session_id();

		header('Access-Control-Allow-Origin:*');

		R_true($data);

	}
	function alp_firststartagree()
	{

		$project_name=\Prjconfig::project_config['project_name'];

		$service_title=\Prjconfig::project_config['project_name'].\controller\foreground\Help::service_title;
		$service_url='/help/terms_service';

		$privacy_title=\Prjconfig::project_config['project_name'].\controller\foreground\Help::privacy_title;
		$privacy_url='/help/terms_privacy';

		$txts=[];

		$txts[]='感谢您信任并使用'.$project_name;
		$txts[]='';
		$txts[]='我们将依据《'.$service_title.'》和《'.$privacy_title.'》来帮助您了解我们在收集,使用,存储和共享您个人信息的情况以及您享有的相关权利';
		$txts[]='';
		$txts[]='在您使用'.$project_name.'服务时,我们将收集您的设备信息,操作日志及浏览记录等信息.在您使用'.$project_name.'内容上传,评论,收藏等服务时,我们需要获取您设备的相机权限,相册权限,位置权限等信息';
		$txts[]='';
		$txts[]='您可以在相关页面访问,修改,删除您的个人信息或管理您的授权';
		$txts[]='';
		$txts[]='我们会采用行业内领先的安全技术来保护您的个人信息';


		$H='';
		$H.=_div__('p0','','','欢迎使用'.$project_name);

		$H.=_div('p1');
			$H.=impd($txts,'<br>');
		$H.=_div_();

		$H.=_div('p2');
			$H.='你可以通过阅读完整的';
			$H.=_a__($service_url,'','','','《'.$service_title.'》');
			$H.='和';
			$H.=_a__($privacy_url,'','','','《'.$privacy_title.'》');
			$H.='来了解详细信息';
		$H.=_div_();

		$H.=_div('p3','','__buttonwrap__');
			$H.=_a0__('','','__button__="big color0 solid" onclick="alp_firststartagree_yes(this)" ','同意并继续');
			$H.=_a0__('','','__button__="big black " onclick="alp_firststartagree_no(this)" ','不同意');
		$H.=_div_();

		\_mobile_\Mobile::return_modal_open($H,['cls'=>'alp_fststartagree_modal','tail'=>'mobilemodal_ani=none'],'small_to_big');

	}
//1 alpbuild
	static function alpbuild_getserverhost()
	{

		if(\Prjconfig::mobile_config['alp_serverhost'])
		{
			$host=\Prjconfig::mobile_config['alp_serverhost'];
		}
		else
		{
			$host=server_host_http();
		}

		return $host;
	}
	function alpbuild_step_0()
	{
		$errormsg=[];

		if(clu_id())
		{
			$errormsg[]='[error-2648]请先退出登录';
		}
		if(__online_isonline__)
		{
			$errormsg[]='[error-2831]不能在线上模式下使用';
		}
		if(client_is_app())
		{
			$errormsg[]='[error-0205]不能在app模式下使用';
		}

		if($errormsg)
		{
			R_alert(impd($errormsg,'<br>'));
		}

		$data=[];

		$data['alp_serverhost']=self::alpbuild_getserverhost();
		$data['alp_preloadurls']=\Prjconfig::mobile_config['alp_preloadurls'];

		$data['alp_message']=[];

		$data['alp_message'][]='服务器主机:'.$data['alp_serverhost'];

		$data['alp_message'][]='输出路径:'.\Prjconfig::mobile_config['alp_build_to_dirpath'];

		$data['alp_message'][]='预加载url:'.impd($data['alp_preloadurls']);

		$data['alp_message'][]='代码压缩:'.(__codepack_compress__?'开启':'关闭');

		$data['alp_message'][]='继续?';
		$data['alp_message']=impd($data['alp_message'],'<br>');

		R_true($data);

	}
	function alpbuild_step_1()
	{//存储预加载的url数据,用json包装下,否则整数0会变成'0',回到js环境影响if('0')判断

		$data=$_POST['data'];
		$data=htmlentity_decode($data);
		$data=json_decode_1($data);

		fs_file_save_data(__temp_dir__.'/alp/pagedatamap.data',$data);

		R_true();

	}
}
