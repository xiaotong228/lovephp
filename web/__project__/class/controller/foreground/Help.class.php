<?php

/*
	LOVEPHP[Web full stack open source framework]
	Copyright:http://lovephp.com
	License:http://opensource.org/licenses/MIT
	Author:Xiaotong<xiaotong228@qq.com>
*/


namespace controller\foreground;

class Help extends super\Superforeground
{

	const aboutus_title='关于我们';
	const service_title='用户协议';
	const privacy_title='隐私政策';

	function aboutus()
	{

		\_skel_\Skelmodule::databridge_databridge('page_inhtml',$this->aboutus_inhtml());
		\_skel_\Skelmodule::databridge_databridge('page_title',self::aboutus_title);
		htmlecho_page_title(self::aboutus_title);

		_skel();

	}
	function terms_service()
	{

		\_skel_\Skelmodule::databridge_databridge('page_inhtml',$this->terms_service_inhtml());
		\_skel_\Skelmodule::databridge_databridge('page_title',self::service_title);
		htmlecho_page_title(self::service_title);

		_skel();

	}
	function terms_privacy()
	{

		\_skel_\Skelmodule::databridge_databridge('page_inhtml',$this->terms_privacy_inhtml());
		\_skel_\Skelmodule::databridge_databridge('page_title',self::service_title);
		htmlecho_page_title(self::privacy_title);

		_skel();

	}

	function terms_service_inhtml()
	{


		$project_name=_b__('','','',\Prjconfig::project_config['project_name']);

$txt='

&emsp;&emsp;欢迎使用'.$project_name.'，在您使用'.$project_name.'提供的各项会员及非会员服务（以下简称“服务”）之前，请务必仔细阅读并透彻理解本协议。

&emsp;&emsp;如您不同意本协议及其更新内容，您可以主动取消'.$project_name.'提供的服务；您一旦使用'.$project_name.'的服务，即视为您已了解并完全同意本协议的各项内容，并成为'.$project_name.'用户（以下简称“用户”）。'.$project_name.'有权在必要时修改用户协议，协议一旦发生变动，将会以网站公告的形式提示修改内容，变动结果将在'.$project_name.'通知之日起生效。如果您不同意所改动的内容，您有权停止使用'.$project_name.'的服务，如果您继续使用'.$project_name.'的各项服务，则视为接受服务条款的变动。用户理解并同意：由于数据行业的特殊性，'.$project_name.'具有保留修改或中断部分或全部服务的权利。

&emsp;&emsp;“'.$project_name.'帐户”是指您通过'.$project_name.'的产品或网站注册的帐户，'.$project_name.'所提供的部分服务需要您在登录您的'.$project_name.'帐户之后使用。除本协议外，'.$project_name.'发布的其他相关的业务规则也是本协议的一部分，请您仔细阅读。

<b>一、服务内容</b>

'.$project_name.'是一个面向互联网用户的,基于地理位置关系的网上交流平台.

<b>二、用户注册及使用规范</b>

&emsp;&emsp;1、'.$project_name.'账号的所有权归'.$project_name.'所有，您完成申请注册手续后，将获得所注册账号的使用权，该使用权仅限于您使用，您无权赠与、借用、租用、转让或售卖您的账号。

&emsp;&emsp;2、用户应当妥善保管账户及密码信息，由于用户自身行为导致的账户或密码的泄露、遗忘等情形或其他原因所带来的损失， '.$project_name.'将尽量配合用户采取积极措施降低相关损失，但因此造成的不利后果由用户自行承担。

&emsp;&emsp;3、您在使用'.$project_name.'时，所发布的信息（包括用户注册名、用户头像等）时，必须遵守国家有关法律规定，并承担一切因自己发布信息不当导致的民事、行政、或刑事法律责任。您在使用'.$project_name.'所发布的消息，不得含有以下内容或用于以下目的：
&emsp;&emsp;违反宪法确定的基本原则的；
&emsp;&emsp;危害国家安全，泄露国家机密，颠覆国家政权，破坏国家统一的；
&emsp;&emsp;损害国家荣誉和利益，攻击党和政府的；
&emsp;&emsp;煽动民族仇恨、民族歧视，破坏民族团结的；
&emsp;&emsp;破坏国家、地区间友好关系的；
&emsp;&emsp;违背中华民族传统美德、社会公德、论理道德、以及社会主义精神文明的；
&emsp;&emsp;破坏国家宗教政策，宣扬邪教和封建迷信的；
&emsp;&emsp;散布谣言或不实消息，扰乱社会秩序，破坏社会稳定的；
&emsp;&emsp;煽动、组织、教唆恐怖活动、非法集会、结社、游行、示威、聚众扰乱社会秩序的；
&emsp;&emsp;散布淫秽、色情、赌博、暴力、恐怖或者教唆犯罪的；
&emsp;&emsp;侮辱或诽谤他人，侵害他人合法权益的；
&emsp;&emsp;侵犯他人肖像权、姓名权、名誉权、隐私权或其他人身权利的；
&emsp;&emsp;以非法民间组织名义活动的；
&emsp;&emsp;侵犯他人著作权等合法权益的；
&emsp;&emsp;侵犯他人商业秘密等合法权益的；
&emsp;&emsp;含有其他违反法律、法规、国家政策及公序良俗的法律、行政法规禁止的其他内容的。

&emsp;&emsp;4、如果您在使用'.$project_name.'所提供的的服务时不能履行和遵守协议中的规定，'.$project_name.'有权删除您发布的相关信息，直到封闭您的账号或/和暂时、永久禁止在'.$project_name.'发布信息的处理，同时保留依法追究您的法律责任的权利，'.$project_name.'保留将系统内的记录有可能作为您违反法律和本协议的证据加以保存与展示的权利。

&emsp;&emsp;5、未经'.$project_name.'许可，任何单位或个人不得通过任何方式（包括但不限于恶意注册'.$project_name.'账号，机器抓取、复制、镜像等方式）不合理地获取'.$project_name.'站内信息、资讯、数据等。

';

		$H.=nl2br(trim($txt));

		return $H;

	}
	function terms_privacy_inhtml()
	{

		$project_name=_b__('','','',\Prjconfig::project_config['project_name']);

$txt='

&emsp;&emsp;'.$project_name.'尊重并非常注意保护所有使用'.$project_name.'服务用户（“您”）的个人信息及隐私。为了给您提供更加准确、更个性化的服务，'.$project_name.'会按照本隐私声明的规定使用和披露您的个人信息。 但'.$project_name.'将以高度的勤勉、审慎的态度对待您的个人信息。除非有法律和政府的强制规定，在事先未征得您许可或者授权的情况下， '.$project_name.'不会将您的信息对外披露或者向第三方提供。'.$project_name.'会不时更新本隐私声明。您在同意'.$project_name.'用户协议之时，即视为您已经同意本隐私声明全部内容。

<b>1. 适用范围</b>

&emsp;&emsp;a) 在您注册'.$project_name.'账户时，您根据'.$project_name.'要求提供的个人或组织注册信息；

&emsp;&emsp;b) 在您使用'.$project_name.'服务，'.$project_name.'自动接收并记录的您的浏览器和计算机上的信息， 包括但不限于您的IP地址、浏览器的类型、使用的语言、访问日期和时间、软硬件特征信息及您需求的网页记录等数据；

&emsp;&emsp;c) '.$project_name.'通过合法途径从商业伙伴处取得的用户个人隐私数据。

<b>2.不适用范围</b>

&emsp;&emsp;a) 您在使用'.$project_name.'提供的服务时，对外公布的信息；

&emsp;&emsp;b) 任何国家官方网站、门户网站及行业性门户网站上的公开信息；

&emsp;&emsp;c) 信用评价、违反法律规定或违反'.$project_name.'规则行为及'.$project_name.'已对您采取的措施。

<b>3. 信息使用</b>

&emsp;&emsp;a) '.$project_name.'不会向任何无关第三方提供、出售、出租、分享或交易您的个人信息，除非事先得到您的许可，或该第三方和'.$project_name.'（含'.$project_name.'关联公司）单独或共同为您提供服务，且在该服务结束后，该第三方将被禁止访问包括其以前能够访问的所有这些资料；

&emsp;&emsp;b) '.$project_name.'亦不允许任何第三方以任何手段收集、编辑、出售或者无偿传播您的个人信息。任何'.$project_name.'用户如从事上述活动，一经发现，'.$project_name.'有权立即终止与该用户的服务协议并追究其法律责任；

&emsp;&emsp;c) 为服务用户的目的，'.$project_name.'可能通过使用您的个人信息，向您提供您感兴趣的信息，包括但不限于向您发出产品和服务信息，或者与'.$project_name.'合作伙伴共享信息以便他们向您发送有关其产品和服务的信息（后者需要您的事先同意）。

<b>4. 信息存储和交换</b>

&emsp;&emsp;'.$project_name.'收集的有关您的信息和资料将保存在'.$project_name.'的服务器上。

<b>5. 信息安全</b>

&emsp;&emsp;a) '.$project_name.'账户均有安全保护功能，请妥善保管您的账户及密码信息。'.$project_name.'将通过向其它服务器备份、对用户密码进行加密等安全措施确保您的信息不丢失，不被滥用和变造。尽管有前述安全措施，但同时也请您注意在信息网络上不存在绝对完善的安全措施；
';


		$H.=nl2br(trim($txt));

		return $H;

	}
	function aboutus_inhtml()
	{

		$project_name=_b__('','','',\Prjconfig::project_config['project_name']);

		$txt='

		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]
		关于我们[error-1737]

		';

		$H.=_div('','text-align:center;');
				$H.=nl2br(trim($txt));
		$H.=_div_();

		return $H;

	}
}
