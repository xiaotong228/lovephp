
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

__lpwidget__.stickybox=new function()
{

//1 init
	this.stb_init=function()
	{
		var _list=$('[__stickybox__=stickybox][stickybox_inited!=yes]');

		if(_list.length)
		{

			if(__lpwidget__.stickybox.stb_regist)
			{
				__lpwidget__.stickybox.stb_regist();
				__lpwidget__.stickybox.stb_regist=false;
			}

			this.stb_widget_list=_list;

			_list.each(function()
			{

				var _this=$(this);

				var pos=_this.find('[stickybox_role=viewzone]').dompos_get();

				_this.css(
					{
						width:pos.width+'px',
						height:pos.height+'px'
					});
			});

			_list.attr('stickybox_inited','yes');

			__lpwidget__.stickybox.stb_adjust_all();

		}
		else
		{
			this.stb_widget_list=false;
		}

	};

	this.stb_regist=function()
	{

		_document.on('scroll',function(event)
		{
			__lpwidget__.stickybox.stb_adjust_all();
		});

		_window.on('resize',function(event)
		{
			__lpwidget__.stickybox.stb_adjust_all();
		});

	};
//1 pos
	this.stb_widget_list=false;

	this.stb_adjust_all=function()
	{

		if(!this.stb_widget_list)
		{
			return;
		}
		this.stb_widget_list.each(function()
		{
			let _this=$(this);

			var _this_pos=_this.dompos_physic();

			var _viewzone=_this.find('[stickybox_role=viewzone]');

			var _config=_this.data_getconfig('stickybox');

			_config.stickybox_offsety=int_intval(_config.stickybox_offsety);

			var cssobj;

			if(_this_pos.y-_config.stickybox_offsety<0)
			{
				_this.attr('stickybox_status','active');

				cssobj=
				{
					left:_this_pos.x+'px',
					top:_config.stickybox_offsety+'px',
					width:_this_pos.width+'px',
					height:_this_pos.height+'px'
				};
			}
			else
			{
				_this.removeAttr('stickybox_status');
				cssobj=
				{
					left:'',
					top:'',
					width:'',
					height:''
				};
			}

			_viewzone.css(cssobj);

		});

	};

};

_document.ready(function()
{
	__lpwidget__.stickybox.stb_init();
});

