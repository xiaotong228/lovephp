
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.tablelist=new function()
{

//1 public
	this.tl_getvalue=function(_this)
	{

		var _list=_this.find('[tablelist_role=checkid_checksingle]');

		var data=[];

		_list.each(function()
			{

				var __this=$(this);

				if(__this.is(':checked'))
				{
					data.push(__this.val());
				}

			});

		return data;

	};

	this.tl_ctrlkey_pressed=false;
	this.tl_ctrlkey_init=function()
	{
		_document.on('keydown keyup',function(event)
			{
				__lpwidget__.tablelist.tl_ctrlkey_pressed=event.originalEvent.ctrlKey;
			});

	};

};

_document.on('change','[__tablelist__=tablelist] [tablelist_role=checkid_checkall]',function()
{
	var _this=$(this);
	var _dad=_this.closest('[__tablelist__=tablelist]');
	var _list=_dad.find('[tablelist_role=checkid_checksingle]');

	if(_this.is(':checked'))
	{
		_list.each(
			function()
			{
				if(!this.disabled)
				{
					this.checked=true;
				}
			}
		);
	}
	else
	{
		_list.each(
			function()
			{
				this.checked=false;
			}
		);
	}
	_list.each(function()
	{
		var __this=$(this);
		__this.trigger('change','fromcheckall');
	});

});
_document.on('change','[__tablelist__=tablelist] [tablelist_role=checkid_checksingle]',function(event,cmd)
{

	if(__lpwidget__.tablelist.tl_ctrlkey_init)
	{
		__lpwidget__.tablelist.tl_ctrlkey_init();
		__lpwidget__.tablelist.tl_ctrlkey_init=false;
	}

	var _this=$(this);

	var _this_tr=_this.closest('tr');

	var _widget=_this.closest('[__tablelist__=tablelist]');

	if(_this.is(':checked'))
	{

		_this_tr.attr('tablelist_status','checked');

		if('fromcheckall'==cmd)
		{
		}
		else
		{

			var new_index=_this_tr.index();

			var old_index=_widget.attr('tablelist_lastcheckindex');

			if(__lpwidget__.tablelist.tl_ctrlkey_pressed&&undefined!==old_index)
			{
				old_index=int_intval(old_index);

				var min_index=Math.min(old_index,new_index);
				var max_index=Math.max(old_index,new_index);

				var checkbox_list=_widget.find('[tablelist_role=checkid_checksingle]');

				for(var i=min_index;i<=max_index;i++)
				{
					if(
						i==min_index||
						i==max_index
					)
					{
						continue;
					}

					checkbox_list.eq(i)[0].checked=true;
					checkbox_list.eq(i).closest('tr').attr('tablelist_status','checked');
				}

			}
			else
			{
				_widget.attr('tablelist_lastcheckindex',new_index);
			}

		}

	}
	else
	{
		_this_tr.removeAttr('tablelist_status');
		_widget.removeAttr('tablelist_lastcheckindex');
	}

});




