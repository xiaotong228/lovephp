
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

function hash_get()
{
	return location.hash.substring(1);
}
function hash_set(hash)
{

	if(alp_isalp()||hash_get()==hash)
	{
		return;
	}
	history.pushState(null,null,'#'+hash);//不要用这个:location.hash=hash;实测chrome下,刷新页面后有1.5秒无法触发history,火狐正常

};

function hash_replace(hash)
{//不会触发hashchange

	if(alp_isalp())
	{
		return;
	}

	history.replaceState(null,null,'#'+hash);

};


