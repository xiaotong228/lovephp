
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


function localstorage_set(key,value)
{
	return localStorage.setItem(key,JSON.stringify(value));
}
function localstorage_get(key)
{

	var data=localStorage.getItem(key);

	if(null===data)
	{

	}
	else
	{
		data=JSON.parse(data);
	}
	return data;

}
function localstorage_delete(key)
{
	return localStorage.removeItem(key);
}

