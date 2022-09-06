<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



namespace _lp_;
class Codepack
{

	const packcode_headinfo='lovephp.com';

	const temp_tempdir=__temp_dir__.'/codepack/tempfile';

	const codetype_css=1;
	const codetype_js=2;

//1 dna
	static function dna_gen_from_filepath($filepath/*string|array*/)
	{

		return md5_md5(
		[

			$filepath,

			__codepack_compress__,

//			__codepack_salt__,//开启会影响编译后的文件的文件名

		]);

	}
	static function dna_gen_from_content($content)
	{

		return md5_md5(
		[

			$content,

			__codepack_compress__

		]);

	}

	static function dna_read_from_file($filepath)
	{

		$matchs=[];
		preg_match('/\/\*packdna=(.*)\*\//',fs_file_read($filepath,fs_loose),$matchs);
		return $matchs[1]?$matchs[1]:false;

	}
//1 temp
	static function tempfile_savecontent_to_file($content,$ext)
	{

		$filepath=self::temp_tempdir.'/'.time_str_num().'_'.math_salt().'.'.$ext;

		if(cmd_get===$content)
		{//此时只返回路径
			return $filepath;
		}

		fs_file_save($filepath,$content);

		return $filepath;

	}
	static function tempfile_clear()
	{
		fs_dir_delete(self::temp_tempdir);
	}
//1 sourcecode
	static function sourcecode_pack_file_to_file($from_filepath)
	{

		$from_ext=path_ext($from_filepath);

		if('less'==$from_ext)
		{
			$codetype=self::codetype_css;
			$to_ext='css';
		}
		else if('jsraw'==$from_ext)
		{
			$codetype=self::codetype_js;
			$to_ext='js';
		}
		else
		{
			R_alert('[error-0859]');
		}

		if(!is_file($from_filepath))
		{//没有对应的less,return
			R_exception('[error-3642]没有找到文件'.$from_filepath);
			return;
		}

		$to_filepath=__temp_dir__.'/codepack/'.path_filename($from_filepath).'_'.self::dna_gen_from_filepath($from_filepath).'.'.$to_ext;

		if(__online_isonline__&&is_file($to_filepath))
		{
			goto sink_return;
		}

		$from_content=self::sourcecode_readcontent_from_file($from_filepath);

		$new_dna=self::dna_gen_from_content($from_content);

		$old_dna=self::dna_read_from_file($to_filepath);

		if($new_dna===$old_dna)
		{
			goto sink_return;
		}

		$temp_filepath=self::tempfile_savecontent_to_file($from_content,$from_ext);

		self::sourcecode_pack_sourcecode_to_file
			(
				$codetype,
				$new_dna,
				$temp_filepath,
				$to_filepath,
				$from_filepath
			);

		sink_return:
		return $to_filepath;

	}
	static function sourcecode_pack_sourcecode_to_file
	(

		$code_type,

		$sourcecode_dna,

		string $sourcecode_filepath,

		$finalcode_filepath,

		$head_tailinfo=null
	)

	{

		$sourcecode_content=fs_file_read($sourcecode_filepath);

		if(!$sourcecode_dna)
		{
			R_alert('[error-4201]必须指定');
		}

		try
		{
			if(self::codetype_css==$code_type)
			{

				$config=[];
				$config['indentation']='	';
				if(__codepack_compress__)
				{
					$config['compress']=true;
				}
				else
				{
					$config['compress']=false;
				}

				require_once __vendor_dir__.'/lessparser/Less.php';

				$less_parser=new \Less_Parser($config);

				$less_parser->parse($sourcecode_content);

				$finalcode_content=$less_parser->getCss();

			}
			else if(self::codetype_js==$code_type)
			{
				if(__codepack_compress__)
				{
					$finalcode_content=self::js_uglyjs($sourcecode_content);
				}
				else
				{
					$finalcode_content=$sourcecode_content;
				}

			}
			else
			{
				R_alert('[error-3816]');
			}
		}
		catch(\Exception $e)
		{
			R_exception('[error-0504/codepack错误]'."\n".$sourcecode_filepath."\n".$finalcode_filepath."\n".$e->getMessage());
		}

		$prependTxt='';
		$prependTxt.="/*".self::packcode_headinfo."*/\n";
		$prependTxt.="/*packcompress=".(__codepack_compress__?'yes':'no')."*/\n";
		$prependTxt.="/*packdna=".$sourcecode_dna."*/\n";
		$prependTxt.="/*packtime=".time_str()."*/\n";

		if($head_tailinfo)
		{
			$prependTxt.="/*{$head_tailinfo}*/\n";
		}

		self::tempfile_clear();

		return fs_file_save($finalcode_filepath,$prependTxt.$finalcode_content);

	}
	static function sourcecode_readcontent_from_file($__content,$__ext=false)
	{

		if(is_file($__content))
		{

			$__ext=path_ext($__content);

			$__content=fs_file_read_php($__content);

		}
		else
		{

		}

		if(__m_access__||'less'==$__ext)
		{//转换移动端专用单位mpx

			$__matchs=[];

			$__content=preg_replace_callback('/([-?\d.]+)mpx([^a-zA-z]?)/',
			function($matches)
			{

				return (nf_2($matches[1]/\Prjconfig::mobile_config['mobile_page_design_px']*100,8)).'vw'.$matches[2];

			},$__content);

		}

		return $__content;

	}
//1 js
	static function js_uglyjs($sourcecode_content)
	{//丑化js代码,输入输出都是txt

		if(1)
		{//用google closure-compiler丑化,需要java,exec权限

			$__dir_root=$_SERVER['DOCUMENT_ROOT'];

			if(1)
			{
				$__cmd_java='java';
			}
			else
			{
				$__cmd_java='"'.$__dir_root.ltrim(__vendor_dir__,'.').'/java/jre/bin/java.exe"';
			}

			$__cmd_jar='"'.$__dir_root.ltrim(__vendor_dir__,'.').'/java/jar/closure-compiler-v20211006.jar"';

			$before_filepath=self::tempfile_savecontent_to_file($sourcecode_content,'js');
			$after_filepath=self::tempfile_savecontent_to_file(cmd_get,'js');

			if(1)
			{//执行cmd
				$__cmd=$__cmd_java.' -jar 2>&1 '.$__cmd_jar;


				$before_filepath_abs=$__dir_root.ltrim($before_filepath,'.');
				$after_filepath_abs=$__dir_root.ltrim($after_filepath,'.');

				$__cmd_args=[];

				$__cmd_args['--js']='"'.$before_filepath_abs.'"';
				$__cmd_args['--js_output_file']='"'.$after_filepath_abs.'"';

				$__cmd_args['--language_in']='ECMASCRIPT_2019';

				$__cmd_args['--language_out']='ECMASCRIPT_2019';

				$__cmd_args['--warning_level']='QUIET';

				$__cmd_args['--compilation_level']='SIMPLE';

				$__cmd_args['--emit_use_strict']='false';//隐藏参数,妈蛋的,自带的帮助里面没有,2021年10月13日12:05:45

				foreach($__cmd_args as $k=>$v)
				{
					$__cmd.=' '.$k.' '.$v;

				}

				$__exec_output=[];
				exec($__cmd,$__exec_output);
			}

			if($__exec_output)
			{

				foreach($__exec_output as &$v)
				{
					$v=string_gbk_to_utf8($v);
				}
				unset($v);
				throw new \Exception(impd($__exec_output,"\n"));

			}
			else
			{
				return fs_file_read($after_filepath);
			}

		}
		else
		{//使用php的丑化引擎,不支持es6,性能差

/*
			require __vendor_dir__.'/phpuglifyjs/parse-js.php';
			require __vendor_dir__.'/phpuglifyjs/process.php';

			$ast=$parse($sourcecode_content);						//parse code and get the initial AST
			$ast=$ast_mangle($ast);						//get a new AST with mangled names
			$ast=$ast_squeeze($ast);						//get an AST with compression optimizations

			$finalcode_content=$strip_lines($gen_code($ast));		// compressed code here

			return $finalcode_content;
*/

		}

	}
//1 skel_modules
	static function skelmodules_packcode($module_list)
	{

		$css_needpack=1;
		$js_needpack=1;

		$module_list=array_unique($module_list);
		sort($module_list);
		$module_list_txt=impd($module_list);

		$temp=__temp_dir__.'/codepack/skelmodules_'.self::dna_gen_from_filepath($module_list_txt);
		$to_filepath_css=$temp.'.css';
		$to_filepath_js=$temp.'.js';

		if(__online_isonline__)
		{
			if(is_file($to_filepath_css))
			{
				$css_needpack=0;
			}
			if(is_file($to_filepath_js))
			{
				$js_needpack=0;
			}
		}

		$__sink=function($codetype,$sourcecode_content_orig,$to_filepath) use ($module_list_txt)
		{

			if(self::codetype_css==$codetype)
			{
				$ext='less';
			}
			else	if(self::codetype_js==$codetype)
			{
				$ext='jsraw';
			}
			else
			{
				R_alert('[error-3129]');
			}

			$temp=self::tempfile_savecontent_to_file($sourcecode_content_orig,$ext);
			$sourcecode_content=self::sourcecode_readcontent_from_file($temp,$ext);

			$new_dna=self::dna_gen_from_content($sourcecode_content);
			$old_dna=self::dna_read_from_file($to_filepath);

			if($new_dna===$old_dna)
			{
			}
			else
			{

				$temp=self::tempfile_savecontent_to_file($sourcecode_content,$ext);
				self::sourcecode_pack_sourcecode_to_file
					(
						$codetype,
						$new_dna,
						$temp,
						$to_filepath,
						$module_list_txt
					);
			}
		};

		if($css_needpack)
		{
			$files=
			[
				__prj_dir__.'/less/prj.config.less',
				__lp_dir__.'/less/lp.function.less',
			];

			foreach($module_list as $v)
			{
				$files[]=__skel_modulecode_dir__.'/'.$v.'/'.$v.'.less';
			}

			foreach($files as &$v)
			{
				$v='require \''.$v.'\';';
			}
			unset($v);

			$__sink(self::codetype_css,'<?php'."\n".impd($files,"\n"),$to_filepath_css,'less');
		}
		if($js_needpack)
		{

			$files=[];

			foreach($module_list as $v)
			{
				$files[]=__skel_modulecode_dir__.'/'.$v.'/'.$v.'.js';
			}

			foreach($files as &$v)
			{
				$v='require \''.$v.'\';';
			}
			unset($v);

			$__sink(self::codetype_js,'<?php'."\n".impd($files,"\n"),$to_filepath_js,'jsraw');

		}

		self::tempfile_clear();

		return [$to_filepath_css,$to_filepath_js];

	}

}
