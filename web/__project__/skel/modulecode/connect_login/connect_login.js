
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


function connectlogin_loginmode_switch(_this,index)
{
	$('[skelmodule_name=connect_login] .mainz [tabshow_role=viewzone] >*').eq(index).find('[__imgvcode__=imgvcode]').click();
}

_document.ready(function()
{
	connectlogin_loginmode_switch(false,0);
});

