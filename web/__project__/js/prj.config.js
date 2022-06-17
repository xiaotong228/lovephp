
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


var __lpconfig__={};

//1 returncode
__lpconfig__.returncode=<?php echo json_encode_1(\Lovephp::returncode_keymap);?>;

//1 skel
__lpconfig__.skel_gridtype_map=<?php echo json_encode_1(\_skel_\Skelcore::griddir_strmap);?>;

//1 vcode
__lpconfig__.vcode_imgvcode_url='/vcode/imgvcode_imgvcode';
__lpconfig__.vcode_smsvcode_url='/vcode/smsvcode_send';

//1 html
__lpconfig__.html_common_ani_time=<?php echo \Prjconfig::html_common_ani_time;?>;
__lpconfig__.html_randomcolors=<?php echo json_encode_1(\Prjconfig::html_randomcolors_get());?>;

__lpconfig__.widget_swiper_triggerswitchratio=0.25;

//1 mobile
__lpconfig__.mobile_page_design_px=<?php echo \Prjconfig::mobile_config['mobile_page_design_px'];?>;
__lpconfig__.mobile_page_ani_time=<?php echo \Prjconfig::mobile_config['mobile_page_ani_time'];?>;


