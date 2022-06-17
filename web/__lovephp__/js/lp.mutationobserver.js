
/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/

//1 异变观测

var __lpmutationobserver__=
{

	mo_observer:false,

	mo_watchmap_add:[],
	mo_watchmap_remove:[],

};

function mo_watch_add(callback)
{

	if(!__lpmutationobserver__.mo_observer)
	{
		mo_start();
	}

	__lpmutationobserver__.mo_watchmap_add.push
	({
		'watch_callback':callback
	});
}

function mo_watch_remove(callback)
{

	if(!__lpmutationobserver__.mo_observer)
	{
		mo_start();
	}

	__lpmutationobserver__.mo_watchmap_remove.push
	({
		'watch_callback':callback
	});
}

function mo_start()
{

	var ob_target=document.querySelector('body');

	__lpmutationobserver__.mo_observer=new MutationObserver
	(
		function(mutation_list,observer)
		{

			mutation_list.forEach(function(mutation)
			{

				if('childList'==mutation.type)
				{
					mutation.addedNodes.forEach(function(_node)
						{

							_node=$(_node);

							if('div'==_node.tag_tagname_get())
							{//只处理div
								for(let i in __lpmutationobserver__.mo_watchmap_add)
								{
									__lpmutationobserver__.mo_watchmap_add[i].watch_callback(_node);
								}
							}
							else
							{
								console_log_wreckage('29','lovephp/0429/3629/非div不处理');
							}

						});

					mutation.removedNodes.forEach(function(_node)
						{

							_node=$(_node);

							if('div'==_node.tag_tagname_get())
							{//只处理div
								for(let i in __lpmutationobserver__.mo_watchmap_remove)
								{
									__lpmutationobserver__.mo_watchmap_remove[i].watch_callback(_node);
								}
							}
							else
							{
								console_log_wreckage('29','lovephp/0429/3629/非div不处理');
							}

						});
				}
				else if('attributes'==mutation.type)
				{


				}
				else
				{

				}

			});

		}

	);

	__lpmutationobserver__.mo_observer.observe(ob_target,
	{
		childList:true,
		attributes:false,
		subtree:true
	});

}

