
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

function cookie_getcookie(keyname)
{

    var strcookie=document.cookie;//获取cookie字符串

    var arrcookie=strcookie.split("; ");//分割
    //遍历匹配
    for(var i=0;i<arrcookie.length;i++)
	{
        var arr=arrcookie[i].split('=');
        if(arr[0]==keyname)
		{
            return arr[1];
        }
    }
    return '';
}