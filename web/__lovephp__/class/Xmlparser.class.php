<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _lp_;
class Xmlparser
{
//1 xmlfile
	static function xmlfile_structdata_get($xml_filepath/*filepath|filecontent*/)
	{

		if(!$xml_filepath)
		{
			R_alert('[error-5809]');
		}

		if(is_file($xml_filepath))
		{
			$xmlcont=fs_file_read_xml($xml_filepath);
		}
		else
		{
			$xmlcont=$xml_filepath;
		}

		$data=self::xmlobject_to_array(simplexml_load_string($xmlcont));

		if(1)
		{//读取到的数据简单处理下,便于后面用

			$data['name']=$data['name'][0]['@string'];
			$data['title']=$data['title'][0]['@string'];
			$data['params']=$data['params'][0];

			if($data['id'][0]['@string'])
			{
				$data['id']=$data['id'][0]['@string'];
			}
			else
			{
				unset($data['id']);
			}
			if($data['description'][0]['@string'])
			{
				$data['description']=$data['description'][0]['@string'];
			}
			else
			{
				unset($data['description']);
			}
			if($data['thumb'][0]['@string'])
			{
				$data['thumb']=$data['thumb'][0]['@string'];
			}
			else
			{
				unset($data['thumb']);
			}

		}

		return $data;

	}
	static function xmlfile_defaultconfigdata_get($xml_filepath)
	{//根据这个xml文件获取配置的默认值

		$xml=self::xmlfile_structdata_get($xml_filepath);

		$config=[];

		foreach($xml['params']['group'] as $v)
		{
			foreach($v['section'] as $vv)
			{
				foreach($vv['param'] as $vvv)
				{
					if('checkbox'==$vvv['@attributes']['formtype'])
					{
						$config[$vvv['@attributes']['name']]=[];
						foreach($vvv['option'] as $vvvv)
						{
							if('selected'==$vvvv['@attributes']['selected'])
							{
								$config[$vvv['@attributes']['name']][]=$vvvv['@attributes']['value'];
							}
						}
					}
					else if(('select'==$vvv['@attributes']['formtype'])||('radio'==$vvv['@attributes']['formtype']))
					{
						foreach($vvv['option'] as $vvvv)
						{
							if('selected'==$vvvv['@attributes']['selected'])
							{
								$config[$vvv['@attributes']['name']]=$vvvv['@attributes']['value'];
							}
						}
					}
					else
					{
						$config[$vvv['@attributes']['name']]=$vvv['@string'];
					}
				}
			}
		}

		return $config;
	}

	static function xmlfile_namemap_get($xml_filepath/*filepath|filecontent*/)
	{//获取各个配置项的name和label的关系

		$xml=self::xmlfile_structdata_get($xml_filepath);

		$config=[];

		$names=[];

		foreach($xml['params']['group'] as $v)
		{

			$names[0]=$v['@attributes']['title'];
			foreach($v['section'] as $vv)
			{
				$names[1]=$vv['@attributes']['title'];
				foreach($vv['param'] as $vvv)
				{
					$names[2]=$vvv['@attributes']['label'];
					$config[$vvv['@attributes']['name']]=$names;
				}
			}
		}

		return $config;

	}
//1 xmlobject
	static function xmlobject_to_array($xmlObj=null)
	{//此函数解析的时候如果只有单一节点会生成$array[xxx][0]的结构

		$return=[];

		if(is_array($xmlObj))
		{
			foreach($xmlObj as $k=>$v)
			{
				$return[$k]=self::xmlobject_to_array($v);
			}
		}
		else if(is_object($xmlObj))
		{
			$data=get_object_vars($xmlObj);
			$son_tag=[];
			$string=trim($xmlObj->__toString());
			if(var_isavailable($string))
			{
				$return['@string']=$string;
			}
			foreach($data as $k=>$v)
			{
				if('@attributes'==$k)
				{
					$return[$k]=$v;
				}
				else
				{
					$son_tag[]=$k;
				}
			}
			foreach($son_tag as $v)
			{
				foreach($xmlObj->{$v} as $vv)
				{
					$return[$v][]=self::xmlobject_to_array($vv);
				}
			}
		}
		else
		{
			R_alert('[error-2704]xml解析错误');
		}

		return $return;

	}

//1 xmlwindow
	static function xmlwindow_inhtml_get($xml_filepath=null,&$title=null,$data=null)
	{

		$__singleline_html=function($__param,$__current_configdata,&$__param_keys_census)
		{

			$_name=$__param['@attributes']['name'];

			$_label=$__param['@attributes']['label'];

			$_value=$__current_configdata[$_name];

			$_formtype=$__param['@attributes']['formtype'];

			$_description=$__param['@attributes']['description'];

			$__param_keys_census[$_name]++;

			if('hidden'==$_formtype)
			{
				$H.=_input_hidden($_name,$_value);
			}
			else
			{

				$xmluploadconfig=[];

				if('xmluploadfile'==$_formtype)
				{

					$file_exts=$__param['@attributes']['uploadfile_file_exts'];
					$file_exts=expd($file_exts);
					$file_maxsize=intval($__param['@attributes']['uploadfile_file_maxsize']);

					if(!$file_exts||!$file_maxsize)
					{
						R_alert('[error-3554]必须指定上传文件扩展名和文件大小上限/'.$_name);
					}

					$xmluploadconfig=[];
					$xmluploadconfig['@upload_config']=\controller\foreground\Upload::uploadtoken_set($file_exts,$file_maxsize,'xml');

					$_description.=($_description?'/':'').'粘贴url或上传,扩展名:'.impd($file_exts).'/最大:'.datasize_oralstring($file_maxsize).'';

				}

				$H.=_div('paramz_singleline','','xmlwindow_formtype='.$_formtype.' '.('xmluploadfile'==$_formtype?'xmluploadfile_config=\''.json_encode_1($xmluploadconfig).'\'':''));

					$H.=_div('p_left');
						$H.=$_label;
						if(var_isavailable($_description))
						{
							$H.=\_widget_\Popupbox::popup_tips($_description);
						}
						$H.=':';
					$H.=_div_();

					$H.=_div('p_right');

						switch($_formtype)
						{
							case 'text':
								$H.=_input($_name,$_value,$_description);
								break;
							case 'password':
								$H.=_input_password($_name,$_value,$_description);
								break;
							case 'readonly':
								$H.=_input($_name,$_value,$_description,'','','readonly=readonly');
								break;
							case 'textarea':
								$H.=_textarea($_name,$_value,$_description);
								break;
							case 'radio':
								foreach($__param['option'] as $option)
								{
									$H.=_label();
										$H.=_radio($_name,$option['@attributes']['value'],$_value==$option['@attributes']['value']);
										$H.=$option['@string'];
									$H.=_label_();
								}
								break;
							case 'checkbox':
								foreach($__param['option'] as $option)
								{
									if(is_string($_value))
									{
										$_value=expd($_value);
									}

									$H.=_label();
										$H.=_checkbox($_name.'[]',$option['@attributes']['value'],in_array_1($option['@attributes']['value'],$_value));
										$H.=$option['@string'];
									$H.=_label_();

								}
								break;
							case 'select':
								$H.=_select($_name,$_value);
									foreach($__param['option'] as $option)
									{
										$H.=_option($option['@attributes']['value'],$option['@string']);
									}
								$H.=_select_();
								break;
							case 'xmluploadfile':

								$H.=_input($_name,$_value,$_description,'','width:620px;','');

								$H.=_a0__('upload','','','上传');

								$H.=_div('file_preview',$_value?'':'display:none;');
									$H.=_an($_value);
										$ext=path_ext($_value);
										if(in_array_1($ext,\Prjconfig::file_pic_exts))
										{
											$H.=_img($_value);
										}
										else
										{
										}
									$H.=_a_();

									$H.=_span__('','','',0);

								$H.=_div_();

								$H.=_input_file('','','','','display:none;','accept="'.$xmluploadconfig['@upload_config']['file_exts_acceptstr'].'"');

								break;

							default:

								if(0)
								{
								}
								else
								{
									R_alert("err-[0618]不支持的xml配置formType:{$_formtype}");
								}
								break;

						}

					$H.=_div_();

				$H.=_div_();

			}

			return $H;

		};

		if(!is_file($xml_filepath))
		{
			R_alert('[error-0324]未找到xml文件'.$xml_filepath);
		}

		$__xmldata=\_lp_\Xmlparser::xmlfile_structdata_get($xml_filepath);

		$title=[];
		if($__xmldata['name'])
		{
			$title[]=$__xmldata['name'];
		}
		if($__xmldata['title'])
		{
			$title[]=$__xmldata['title'];
		}

		$title=impd($title,'/');

		$group=$__xmldata['params']['group'];

		$data=is_array($data)?$data:[];

		$__current_configdata=array_merge_1(\_lp_\Xmlparser::xmlfile_defaultconfigdata_get($xml_filepath),$data);

		$__param_keys_census=[];

		if(1)
		{
			$H.=_div('','','tabshow_role=nav');
				if(count($group))
				{
					$tail='tabshow_navstatus=active ';
					foreach($group as $v)
					{
						$H.=_a0__('','',$tail,$v['@attributes']['title']);
						$tail='';
					}
				}
				else
				{
					$H.='[error-3749]缺少params节点';
				}
			$H.=_div_();
		}
		$H.=_div('','','tabshow_role=viewzone');

			$temp='';
			foreach($group as $k=>$v)
			{
				$H.=_div('',$temp,'xmlwindow_role=param_group');
					foreach($v['section'] as $kk=>$vv)
					{
						$H.=_div('','','xmlwindow_role=param_section __toggleshow__=toggleshow'.(('true'==$vv['@attributes']['folded'])?'':' toggleshow_status=active'));
							if(1)
							{
								$H.=_div('','','xmlwindow_role=param_section_title');
									$H.=$vv['@attributes']['title'];
									$H.=_div__('','','toggleshow_role=trigger');
								$H.=_div_();
							}
							if(1)
							{
								$H.=_div('','','xmlwindow_role=param_section_body toggleshow_role=blinkzone');
								foreach($vv['param'] as $kkk=>$vvv)
								{
									$H.=$__singleline_html($vvv,$__current_configdata,$__param_keys_census);
								}
								$H.=_div_();
							}
						$H.=_div_();
					}
				$H.=_div_();
				$temp='display:none;';
			}
		$H.=_div_();

		foreach($__param_keys_census as $k=>$v)
		{
			if($v>1)
			{
				$error_msg.="{$k}*{$v};";
			}
		}

		if($error_msg)
		{
			$H=_div__('','color:red;font-weight:bold;line-height:20px;','','错误:存在重复的参数'.$error_msg).$H;
		}

		return $H;

	}

}
