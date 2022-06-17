<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace _widget_;
class Popupbox
{

	static function popupbox_html(array $__trigger=[],array $__layer=[],array $config=[])
	{

		/*
			config配置

			popupbox_triggertype:mouse,click

			popupbox_aligntype:(pos0,pos1),角点位置对齐

			触发元素和弹出的元素可以分为9个点
			这里指定了触发元素和弹出元素的分别哪个点和哪个点对齐
			点的方位分别是

			*************************************************
			左上(lt)			中上	(ct)			右上(rt)

			左中(lc)			中中	(cc)			右中(rc)

			左下(lb)			中下(cb)			右下(rb)
			*************************************************

			popupbox_alignoffset:(x,y),对齐偏移量

			popupbox_layerfixed:(true),弹出层屏幕固定位置,不随文档滚动

		*/

		if($__layer)
		{

			if(!$__layer['tag'])
			{
				$__layer['tag']='div';
			}

			$__layer['tail'].=' __popupboxlayer__=popupboxlayer';

			$box_inhtml=_x__($__layer['tag'],$__layer['cls'],$__layer['sty'],$__layer['tail'],$__layer['inhtml']);
			$box_inhtml=htmlentity_encode($box_inhtml,0);

			if(1)
			{
				$__trigger['tail'].=' '.\_widget_\Widget::domtail('popupbox',$config).
				' popupbox_layer_html="'.$box_inhtml.'"'
				;
			}

		}

		if(!$__trigger['tag'])
		{
			$__trigger['tag']='div';
		}

		return _x__($__trigger['tag'],$__trigger['cls'],$__trigger['sty'],$__trigger['tail'],$__trigger['inhtml']);

	}

}
