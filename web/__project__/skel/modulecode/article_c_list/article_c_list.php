<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/



if($_GET['_order'])
{
	$__search_order=$_GET['_order'];
}
else
{
	$__search_order=array_key_first(\db\Article::order_ordermap);
}

$__page_p=intval($_GET['_p']);
$__page_npp=10;
$__db=\db\Article::db_instance();

$where=db_buildwhere('id|article_title');
$where['article_isdelete']=0;

$__itemlist=$__db->where($where)->orderBy($__search_order)->select_splitpage($__page_p,$__page_npp,$__totalpagenum,$__totalitemnum);

$__splitpagehtml=\_lp_\Splitpage::splitpage_gethtml($__page_p,$__totalpagenum);


echo _module();

	echo _div('mainz');

			if(1)
			{
				echo _div('topcategoryz');
					echo _a__('/','item '.($_GET['article_category']||$_GET['_keyword']?'':'_csel_'),'','','全部资讯');
					foreach(\db\Article::category_namemap as $k=>$v)
					{

						if($_GET['article_category']==$k)
						{
							$cls='_csel_';
						}
						else
						{
							$cls='';
						}
						echo _a__('/?article_category='.$k,'item '.$cls,'','',$v);
					}
					echo _a0__('item rightsearchbtn '.'','','onclick="$(\'#articleindex_searchz_3809\').toggle();" ','&#xf0a3;');
				echo _div_();
			}
			echo _div('searchinputz',
				$_GET['_keyword']?'display:block;':'display:none;',
				'id=articleindex_searchz_3809');
				echo _form('/');
					echo _div('ssz');
						echo _input('_keyword',$_GET['_keyword'],'请输入文章关键字','keyword','');
						echo _button('submit','&#xf0a3;','ssbtn iconfont');
					echo _div_();
				echo _form_();
			echo _div_();

			if($__itemlist)
			{

				echo _div('articlelistz');

					foreach($__itemlist as $item)
					{
						if($_GET['_keyword'])
						{
							$item['article_title']=str_ireplace($_GET['_keyword'],_b__('','','',$_GET['_keyword']),$item['article_title']);
						}

						echo \db\Article::articlebox_list($item);

					}

				echo _div_();

			}
			else
			{
				echo _div('g_emptydatabox','margin-top:20px;');
					echo _b__('','','','没有相关数据');
					echo '<br>'._span__('','','','请尝试输入更准确的关键词并重新搜索');
				echo _div_();
			}

		echo _div_();

		if($__itemlist)
		{
			echo $__splitpagehtml;
		}



echo _module_();

