
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

if(client_is_app_js())
{
	document.addEventListener('plusready',function()
		{//是不是要做自动登录啥的,cookie是否可靠

			var app_exit_tick=0;

			plus.key.addEventListener('backbutton',function()
				{

					console_log_wreckage('35','lovephp/0415/5535');

					if(swv_webview)
					{
						swv_webview.canBack(function(data)
						{
							if(data.canBack)
							{
								swv_webview.back();
							}
							else
							{
								swv_webview.close();
								if(swv_statusbarback)
								{
									mobile_app_statusbar_setstyle(swv_statusbarback);
								}
								swv_webview=false;
								swv_statusbarback=false;
							}
						});

						return;

					}

					var _close=mobile_history_get_currentpage().find('[__mobilemodal__=mobilemodal] [mobilemodal_role=close]');

					if(_close.length)
					{//只在mobilemodal_role=close存在时可以返回,对一些不允许关闭的modal无效,比如强制更新之类的

						_close.click();
						return;

					}

					if(mobile_page_switch_lock)
					{
						return;
					}

					var length=mobile_history_get_length();

					if(1==length)
					{

					    app_exit_tick++;

					    if(app_exit_tick>1)
					    {
							mobile_app_exit();
					    }
					    else
					    {
					        ui_toast('再按一次退出');
					        setTimeout(function()
								{
						            app_exit_tick=0;
						        },2000);
					    }
					}
					else
					{
						mobile_route_back();
					}

				});


			var statusbarstyle=mobile_history_get_currentpage().attr('mobilepage_statusbarstyle');

			mobile_app_statusbar_setstyle(statusbarstyle);

			if(alp_isalp())
			{//检查网络状况,首次打开app的话提示用户协议

				if(plus.navigator.isImmersedStatusbar())
				{

					var height=plus.navigator.getStatusbarHeight();

					if(height)
					{

						var temp='';

						temp+=':root{--mobile_app_statusbarheight:'+height+'px;}';
						temp+=':root{--mobile_app_statusbarheight_neg:-'+height+'px;}';

						$('#mobile_app_statusbar_height_def').html(temp);

					}

				}

				var hasprompt=localstorage_get('alp_firststartagree_hasprompt');

				if(!hasprompt)
				{
					ajax_async('/api/alp_firststartagree');
					setTimeout(function()
						{
							mobile_app_splashscreen_close();
						},200);
					return;
				}

				alp_tryconnectserver(false,function()
				{

					mobile_app_splashscreen_close();
					console_log_wreckage('21','lovephp/0323/alp_tryconnectserver/error/alp_tryconnectserver/error/alp_tryconnectserver/error');
				});

			}
			else
			{
				mobile_app_splashscreen_close();
				anv_check();
			}

			if(1)
			{//cookie自动登录是否可靠,是否要用其他方式保留自动登录信息,注册sns登录,地图分享,之类的动作

			}

		});
}

function mobile_app_splashscreen_close()
{
	console_log_wreckage('42','lovephp/0321/2642/mobile_app_splashscreen_close');
	if(client_is_plus_js())
	{
		plus.navigator.closeSplashscreen();
	}
}

//1 statusbar
function mobile_app_statusbar_setstyle(style)
{

	console_log_wreckage('26','lovephp/0318/mobile_app_statusbar_setstyle',style);

	if(client_is_app_js()&&client_is_plus_js())
	{

		if(!style||plus.navigator.getStatusBarStyle()==style)
		{
			return;
		}

		return plus.navigator.setStatusBarStyle(style);
	}

}

//1 network
function mobile_app_network_hasnetwork()
{

	if(client_is_plus_js()&&plus.networkinfo.CONNECTION_NONE==plus.networkinfo.getCurrentType())
	{
		return false;
	}
	else
	{
		return true;
	}

}
//1 exit
function mobile_app_exit()
{

	var osname=plus.os.name.toLocaleLowerCase();

	if('ios'==osname)
	{
		plus.ios.import("UIApplication").sharedApplication().performSelector("exit");
	}
	else if('android'==osname)
	{
		plus.runtime.quit();
	}
	else
	{

	}

}

function mobile_app_download_pic(url)
{

	if(0===url.indexOf('/'))
	{
		url=location.origin+url;
	}
	var downloadtask=plus.downloader.createDownload(url,{},function(download,status)
	{
	    if(200==status)
		{
			plus.gallery.save(download.filename,function()
			{
				ui_toast('已保存到相册');
			},
			function()
			{
				ui_toast('保存到相册失败,请开启相关权限');
			});
		}
		else
		{
			ui_toast('下载失败');
	    }
	});

	downloadtask.start();

}
function mobile_app_download_file(_url,_filename='',_fail_callback,_retry_tick=0)
{

	if(!_filename)
	{
		_filename='';
	}

	_filename='';//这个参数不用了,后面会自动生成

	var _fail_callback_1=function()
	{
		plus.nativeUI.closeWaiting();
		_fail_callback();
	};

	if(1/*||client_is_android_js()*/)
	{

		if(0===_url.indexOf('/'))
		{
			_url=location.origin+_url;
		}

		if(0==_retry_tick)
		{
			plus.nativeUI.showWaiting( "下载中..." ,{padding:'20px'});
		}

		var downloadtask=plus.downloader.createDownload(_url,{},function(download,status)
		{

			console_log('32','lovephp/0414/3532',download,status);

		    if(200==status)
			{//只依赖状态来判断下载成功,如果是用php组装返回的文件,带权限判断的那种,注意返回特定的状态码

				if(client_is_iphone_js())
				{//如果是苹果直接打开文件

					plus.nativeUI.closeWaiting();
					plus.runtime.openFile(download.filename);
					return;

				}

				plus.io.resolveLocalFileSystemURL(download.filename,

					function(fromfile_entry)
					{

						console_log('04','lovephp/0414/fromfile_entry',fromfile_entry);

						_filename='<?php echo \Prjconfig::project_config['project_name'];?>'+'_'+time_str_num_js()+'.'+file_ext_get_js(fromfile_entry.name);

						var fromfile_fullpath=fromfile_entry.fullPath;
						var todir_fullpath;

						var preg=/\/android\/data\/.*/i;//不知道这样判断准确不准确,我只有小米手机

						if(preg.test(fromfile_fullpath))
						{

							todir_fullpath=fromfile_fullpath.replace(preg,'/Download/')

							console_log('25','lovephp/0523/3225',fromfile_fullpath);
							console_log('56','lovephp/0414/3256',todir_fullpath);

							plus.io.resolveLocalFileSystemURL(todir_fullpath,
								function(todir_entry)
								{
									fromfile_entry.moveTo(todir_entry,_filename,
									function(data)
									{//success,如果目标文件已存在就涉及到一个重名的问题
										console_log('27','lovephp/0413/2127/SUCCESSSUCCESSSUCCESS',data);
										plus.nativeUI.closeWaiting();
										ui_toast('已下载到Download文件夹');
									},
									function(fail_data)
									{//fail

										console_log('32','lovephp/0414/3132/FAILFAILFAIL',fail_data);

										if(0&&_retry_tick<1)
										{//不做重试机制了,用时间做文件名默认没有重复冲突
											console_log('30','lovephp/0414/0530/retry');
											setTimeout(function()
											{
												console_log('30','lovephp/0414/0530/retry1');
												mobile_app_download_file(_url,_filename,_fail_callback,_retry_tick+1);
											},500);
										}
										else
										{
											_fail_callback_1();
										}
									});

								},
								function(fail_data)
								{
									console_log('21','lovephp/0413/4047',fail_data);
									_fail_callback_1();
								});

						}
						else
						{
							console_log('54','lovephp/0414/3554');
							_fail_callback_1();
						}

					},
					function(fail_data)
					{
						console_log('21','lovephp/4058/4054',fail_data);
					});
			}
			else
			{
				console_log('00','lovephp/0414/0000');
				_fail_callback_1();
		    }

		});

		downloadtask.start();

	}
	else if(client_is_iphone_js())
	{
		console_log('43','lovephp/0414/5643/苹果还没做');
		_fail_callback();
	}
	else
	{
		console_log('30','lovephp/0414/5630/不该走这');
	}

}
//1 anv=app new version
var anv_downloadedfile_filepath=false;
function anv_check(showtoast=0,forceshow=0)
{
	ajax_async('/api/anv_check_public?showtoast='+showtoast+'&forceshow='+forceshow);
}
function anv_upgrade(_this,url)
{

	if(client_is_iphone_js())
	{//苹果直接去appstore
		if(1)
		{
			plus.runtime.launchApplication
				(
					{
					    action:url
					},
					function(e)
					{
						console_log('03','lovephp/0523/4403',e);
						ui_toast(e.message);
					}
				);
		}
		else
		{//也可以,没啥区别
			plus.runtime.openURL(url);
		}

		return;

	}

	if(anv_downloadedfile_filepath)
	{
		plus.runtime.install(anv_downloadedfile_filepath);
		return;
	}

	var _this=$(_this).closest('.anv_check_modal');

	var _progress=_this.find('.p3_downloadprogress');

	_this.attr('anv_show_status','downloading');

	_progress.html('0%');

	var downloadtask=plus.downloader.createDownload(url,{},function(download,status)
		{

		    if(200==status)
			{

				if(download.downloadedSize<3000)
				{//说明下载下来的东西不是正常的安装包

					_this.removeAttr('anv_show_status');
					ui_toast('下载安装包失败');

				}
				else
				{

					_this.removeAttr('anv_show_status');
					anv_downloadedfile_filepath=download.filename;
					plus.runtime.install(anv_downloadedfile_filepath);

				}
			}
			else
			{

				_this.removeAttr('anv_show_status');
				ui_toast('下载安装包失败');

		    }

		});
		downloadtask.addEventListener('statechanged',function(task,status)
		{

	        switch(task.state)
			{

				case 1:		//开始

					break;

				case 2:		//已连接到服务器

					break;

				case 3:		//已接收到数据

					var percent=int_intval(100*task.downloadedSize/task.totalSize);
					_progress.html(percent+'%');
					break;

				case 4:		//下载完成

					break;

	        }

		});

	downloadtask.start();

}
//1 alp=app landing page
function alp_isalp()
{
	return __lpvar__.alp_info?true:false;
}
function alp_tryconnectserver(default_openurl,error_callback=false,slient=false)
{

	console_log_wreckage('05','lovephp/0321/2805/alp_tryconnectserver',slient);

	if(mobile_app_network_hasnetwork())
	{

		var postdata={};

		postdata.alpconnect_config={};

		postdata.alpconnect_config.alpconnect_indextab=indexindex_tab_current();

		if(default_openurl)
		{
			postdata.alpconnect_config.alpconnect_defaultopen=default_openurl;
		}

		ajax_async(__lpvar__.alp_info.alp_getonlineserver_url,postdata,

		function(data)
		{
			var headers={};

			if(data.onlineserver_sessionid)
			{//避免sessionid不能保持一致,使用从服务器返回的sessionid
				headers['LOVEPHPSESSIONID']=data.onlineserver_sessionid;
			}

			jump_webview(data.onlineserver_host,headers);

		},

		false,

		{
			ajax_on_error:function(jqxhr,textstatus,errorthrown)
			{
				if(!slient)
				{
					ui_toast('无法连接服务器');
				}

				if(error_callback)
				{
					error_callback();
				}

				return cmd_ajax_nodefaulterrortips;

			}
		});

	}
	else
	{
		console_log_wreckage('09','lovephp/0321/4309');
		if(!slient)
		{
			ui_toast('请开启网络');
		}
		if(error_callback)
		{
			error_callback();
		}
	}


}
function alp_firststartagree_yes(_this)
{

	_this=$(_this).closest('[__mobilemodal__=mobilemodal]');

	if(alp_isalp())
	{
		localstorage_set('alp_firststartagree_hasprompt',1);
		alp_tryconnectserver(false,function()
			{
				mobile_modal_close(_this);
			});
	}
	else
	{
		mobile_modal_close(_this);
	}

}
function alp_firststartagree_no(_this)
{
	mobile_app_exit();
}
//1 alpbuild
function alpbuild_build()
{

	ajax_async('/api/alpbuild_step_0','',function(data)
	{

		ui_confirm(data.alp_message,function()
			{

				var preloadurl_data=
				{

				};

				for(var i in data.alp_preloadurls)
				{
					$.ajax(
						{
							async:false,
							type:'post',
							url:data.alp_preloadurls[i],
							success:function(data_1)
							{
								if('string'==typeof(data_1))
								{
									try
									{
										data_1=JSON.parse(data_1)
									}
									catch(e)
									{
										alert('[error-5139]解析错误');
										return;
									}
								}

								if(!data_1||$.isEmptyObject(data_1))
								{
									alert('[error-2919]解析错误');
									return;
								}
								preloadurl_data[data.alp_preloadurls[i]]=data_1;
							}
						});
				}

				ajax_async('/api/alpbuild_step_1',{data:JSON.stringify(preloadurl_data)},function(data)
				{//不要直接把cache_map提交上去否则整数类型的0提交上去后会变成字符串'0',再返回到js里面if('0')被认定为是true

					ajax_async('/?@alp_access');

				});

			});

	});

}

//1 swv=second webview
var swv_webview=false;
var swv_statusbarback=false;

function swv_open(url)
{//苹果系统下要确保新打开的webview可控,用plus.webview.currentWebview()返回到本app页面
//其实可以重复打开,不推荐,具体需要看下,h5+的文档,https://ask.dcloud.net.cn/docs/

	if(swv_webview)
	{
		console_log_wreckage('55','lovephp/0415/3955/不能重复打开webview');
		return;
	}

	if(0===url.indexOf('/'))
	{
		url=location.origin+url;
	}

	var styles={};

	if(/*1||*/client_is_iphone_js())
	{//苹果没有返回键,需要显示标题,否则回不来了,如果相始终显示标题也可以不判断强行开启

		styles.titleNView=
			{
				titleColor:'#000',
				autoBackButton:true,
				backgroundColor:'#fff'
			};
		styles.statusbar=
			{
				background:'#fff',
			};
	}
	else
	{

		if(0&&plus.navigator.isImmersedStatusbar())
		{//如新页面不可控,可能画面占满全屏后导致状态栏浮在页面头部上方,新页面可控时可以按需开启

			styles.top=plus.navigator.getStatusbarHeight()+'px';

		}

	}

	swv_statusbarback=plus.navigator.getStatusBarStyle();
	mobile_app_statusbar_setstyle('dark');
	swv_webview=plus.webview.create(url,'',styles);
	swv_webview.show('pop-in');

}

