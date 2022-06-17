
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.selectitem=new function()
{

//1 public
	this.si_getvalue=function(_this)
	{

		var data=[];

		var list=_this.find('[selectitem_role=item]');

		list.each(function()
			{
				var __this=$(this);

				if('active'==__this.attr('selectitem_status'))
				{

					var temp=__this.attr('selectitem_value');

					if(!temp)
					{
						temp=__this.index();
					}
					data.push(temp);
				}
			});

		if('multi'==_this.attr('selectitem_mode'))
		{
			return data;
		}
		else
		{
			return data[0];
		}

	};

//1 private
	this.si_render=function(_widget)
	{

		var _input=_widget.find('input');
		if(_input.length)
		{
			var value=__lpwidget__.selectitem.si_getvalue(_widget);
			_input.val(value.toString());
		}

	};
	this.si_select_single=function(_this)
	{

		if('active'==_this.attr('selectitem_status'))
		{
			return;
		}
		_this.attr('selectitem_status','active').siblings('[selectitem_role=item]').removeAttr('selectitem_status');

	};
	this.si_select_multi=function(_this)
	{

		_this.attr_toggle('selectitem_status','active');

	};

};
_document.on('click','[__selectitem__=selectitem][selectitem_mode!=multi] [selectitem_role=item]',function()
{

	var _this=$(this);
	__lpwidget__.selectitem.si_select_single(_this);
	__lpwidget__.selectitem.si_render(_this.closest('[__selectitem__=selectitem]'));
});

_document.on('click','[__selectitem__=selectitem][selectitem_mode=multi] [selectitem_role=item]',function()
{

	var _this=$(this);
	__lpwidget__.selectitem.si_select_multi(_this);
	__lpwidget__.selectitem.si_render(_this.closest('[__selectitem__=selectitem]'));
});


