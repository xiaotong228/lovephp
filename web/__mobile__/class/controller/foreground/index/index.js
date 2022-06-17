
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


_document.on('click','[pageroute_controller=index][pageroute_action=index] [indexpageframe_role=nav] >*',function(event)
{


	var _this=$(this);

	var index=_this.index();

	var _content=$('[pageroute_controller=index][pageroute_action=index] [indexpageframe_role=viewzone] >*:nth('+index+')');
	_content.attr('indexpageframe_status','active').siblings().removeAttr('indexpageframe_status');
	_this.attr('indexpageframe_status','active').siblings().removeAttr('indexpageframe_status');

	var statusbarstyle=_this.attr('indexpageframe_statusbarstyle');
	if(statusbarstyle)
	{
		_this.closest('[__mobilepage__=mobilepage]').attr('mobilepage_statusbarstyle',statusbarstyle);
		mobile_app_statusbar_setstyle(_this.attr('indexpageframe_statusbarstyle'));
	}

	event.stopPropagation();

});

function indexindex_tab_current()
{
	return $('[indexpageframe_tab][indexpageframe_status=active]').attr('indexpageframe_tab');
}


