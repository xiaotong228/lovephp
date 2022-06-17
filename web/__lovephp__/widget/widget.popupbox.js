
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


__lpwidget__.popupbox=new function()
{

//1 init
	this.pb_init=function(_dad)
	{

		var _list;

		if(_dad)
		{
			_list=_dad.find_includeself('[__popupbox__=popupbox][popupbox_inited!=yes]');
		}
		else
		{
			_list=$('[__popupbox__=popupbox][popupbox_inited!=yes]');
		}

		if(_list.length)
		{


			if(__lpwidget__.popupbox.pb_regist)
			{
				__lpwidget__.popupbox.pb_regist();
				__lpwidget__.popupbox.pb_regist=false;
			}

			_list.each(function()
				{

					var _widget=$(this);

					var _layer=$(_widget.attr('popupbox_layer_html'));

					var _config=_widget.data_getconfig('popupbox');

					var _popup_id=_widget.attr('popupbox_id');

					if(!_popup_id)
					{
						_popup_id=math_salt_js();
						_widget.attr('popupbox_id',_popup_id);
					}

					var eventtype=false;
					if('mouse'==_config.popupbox_triggertype)
					{
						eventtype='mouseenter';
					}
					else if('click'==_config.popupbox_triggertype)
					{
						eventtype='click';
					}
					else
					{
						console_log_wreckage('18','lovephp/0221/1718');
					}

					const _layershow_show=function()
					{
						__lpwidget__.popupbox.pb_layer_close();
						_widget.attr('popupbox_status','active');

						if(1)
						{//调整位置

							var align_type=_config.popupbox_aligntype.split(',');

							var align_offset=_config.popupbox_alignoffset.split(',');
							var _widget_pos;
							if(_config.popupbox_layerfixed)
							{
								_widget_pos=_widget.dompos_physic();
								_widget_pos.abs_x=_widget_pos.x;
								_widget_pos.abs_y=_widget_pos.y;
								_widget_pos.outer_width=_widget_pos.width;
								_widget_pos.outer_height=_widget_pos.height;

								_layer.css('position','fixed');
							}
							else
							{
								_widget_pos=_widget.dompos_get();
							}


							var _layer_pos=_layer.dompos_get();

							var base_point=_layershow_pos_getbase(_widget_pos,align_type[0]);
							var adjust=_layershow_pos_adjust(_layer_pos,align_type[1]);

							align_offset[0]=int_intval(align_offset[0]);
							align_offset[1]=int_intval(align_offset[1]);

							var pop_point={};
							pop_point.x=base_point.x+adjust.x+align_offset[0];
							pop_point.y=base_point.y+adjust.y+align_offset[1];

							_layer.css(
								{
									'left':pop_point.x+'px',
									'top':pop_point.y+'px',
								});

						}

						_layer.show();

					};


					const _layershow_pos_getbase=function(pos,type)
					{
						var point={};
						type=type.split('');
						if('l'==type[0])
						{
							point.x=pos.abs_x;
						}
						else if('c'==type[0])
						{
							point.x=pos.abs_x+pos.outer_width/2;
						}
						else if('r'==type[0])
						{
							point.x=pos.abs_x+pos.outer_width;
						}
						else{}
						if('t'==type[1])
						{
							point.y=pos.abs_y;
						}
						else if('c'==type[1])
						{
							point.y=pos.abs_y+pos.outer_height/2;
						}
						else if('b'==type[1])
						{
							point.y=pos.abs_y+pos.outer_height;
						}
						return point;
					};

					const _layershow_pos_adjust=function(pos,type)
					{
						var point={};
						type=type.split('');
						if('l'==type[0])
						{
							point.x=0;
						}
						else if('c'==type[0])
						{
							point.x=-pos.outer_width/2;
						}
						else if('r'==type[0])
						{
							point.x=-pos.outer_width;
						}
						else{}
						if('t'==type[1])
						{
							point.y=0;
						}
						else if('c'==type[1])
						{
							point.y=-pos.outer_height/2;
						}
						else if('b'==type[1])
						{
							point.y=-pos.outer_height;
						}
						return point;
					};

					_widget.on(eventtype,function()
					{

						var _widget_currrentstatus=_widget.attr('popupbox_status');

						if(_layer.exist_isexist())
						{
							console_log_wreckage('21','lovephp/0506/2721/已存在');
						}
						else
						{
							_layer.attr('popupboxlayer_triggerid',_popup_id);
							_body.append(_layer);
							console_log_wreckage('19','lovephp/0506/2719/不存在');
						}

						if('click'==_config.popupbox_triggertype)
						{
							if('active'==_widget_currrentstatus)
							{
								__lpwidget__.popupbox.pb_layer_close();
							}
							else
							{

								_layershow_show();

								_document.one('click',__lpwidget__.popupbox.pb_layer_close);

							}

						}
						else if('mouse'==_config.popupbox_triggertype)
						{

							if('active'==_widget_currrentstatus)
							{
								__lpwidget__.popupbox.pb_layer_delayclose_stop();
								return;
							}
							else
							{
								_layershow_show();
							}
						}
						else
						{
							console_log_wreckage('50','lovephp/0506/5550/不对');
						}

					});

					if('mouse'==_config.popupbox_triggertype)
					{
						_widget.on('mouseleave',function()
							{
								console_log_wreckage('53','lovephp/0506/5353/_widget/mouseleave');
								__lpwidget__.popupbox.pb_layer_delayclose_start();
							});
						_layer.on('mouseenter',function()
							{
								console_log_wreckage('06','lovephp/0506/5406/_layer/mouseenter');
								__lpwidget__.popupbox.pb_layer_delayclose_stop();
							});
						_layer.on('mouseleave',function()
							{
								console_log_wreckage('31','lovephp/0506/5431/_layer/mouseleave');
								__lpwidget__.popupbox.pb_layer_delayclose_start();
							});
					}



				});

			_list.attr('popupbox_inited','yes');

		}

	};

	this.pb_deinit=function(_dad)
	{//因为trigger和layer是分开的,需要一个反注册动作清空layer

		var _list;

		if(_dad)
		{
			_list=_dad.find_includeself('[__popupbox__=popupbox]');
		}
		else
		{
			_list=$('[__popupbox__=popupbox]');
		}

		console_log_wreckage('20','lovephp/0506/2420/pb_deinit',_list);

		_list.each(function()
		{

			var _widget=$(this);
			var _popup_id=_widget.attr('popupbox_id');

			if(_popup_id)
			{
				$('[__popupboxlayer__=popupboxlayer][popupboxlayer_triggerid='+_popup_id+']').remove();
			}

		});

	};

	this.pb_regist=function()
	{
		console_log('54','lovephp/0509/1654/pb_regist');
		_document.on('click','[__popupbox__=popupbox],[__popupboxlayer__=popupboxlayer]',function(event)
		{
			console_log('39','lovephp/0509/1939');
			event.stopPropagation();
		});

	};
//1 close
	this.pb_layer_close=function()
	{

		console_log_wreckage('45','lovephp/0506/2545/pb_layer_close');

		$('[__popupboxlayer__=popupboxlayer]').hide();
		$('[__popupbox__=popupbox]').removeAttr('popupbox_status');

		_document.off('click',__lpwidget__.popupbox.pb_layer_close);

		__lpwidget__.popupbox.pb_layer_delayclose_stop();

	};
//1 delayclose
	this.pb_layer_delayclose_timerid=0;
	this.pb_layer_delayclose_start=function()
	{

		console_log_wreckage('11','lovephp/0506/2545/pb_layer_delayclose_start');

		__lpwidget__.popupbox.pb_layer_delayclose_timerid=setTimeout(function()
			{
				__lpwidget__.popupbox.pb_layer_close();
			},10);

	};
	this.pb_layer_delayclose_stop=function()
	{

		clearTimeout(__lpwidget__.popupbox.pb_layer_delayclose_timerid);

	};

};

_document.ready(function()
{

	__lpwidget__.popupbox.pb_init();

	mo_watch_add(function(_dad)
	{
		__lpwidget__.popupbox.pb_init(_dad);
	});

	mo_watch_remove(function(_dad)
	{
		__lpwidget__.popupbox.pb_deinit(_dad);
	});

});

