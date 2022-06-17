
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
		__this.trigger('change');
	});

});
_document.on('change','[__tablelist__=tablelist] [tablelist_role=checkid_checksingle]',function()
{
	var _this=$(this);
	if(_this.is(':checked'))
	{
		_this.closest('tr').attr('tablelist_status','checked');
	}
	else
	{
		_this.closest('tr').removeAttr('tablelist_status');
	}
});

