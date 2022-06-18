

#  LOVEPHP

<a href="http://www.lovephp.com" target=_blank>www.lovephp.com</a>  
运行环境要求:`PHP7/PHP8`,`java`

# 简介

`LOVEPHP` 是一款专为WEB开发设计的全栈开源框架,版本:1.0  
这不是开源世界众多轮子之一,这是一辆车,可以直接开的那种,所以才叫全栈  
让本该简单的简单,让本该快乐的快乐

# 核心特点

前后端,PC/WAP/APP端代码尽量复用  
没有传统的模板(template)这个概念,也没有了\<if> \<else> \<foreach>之类的写法,直接用php输出html的标签  
通过自研的页面管理框架(skel)实现可视化编辑页面(目前仅限PC端),每个模块可以单独配置,拖动,随意部署  
`LOVEPHP` 不是一个前后端分离的框架,相反是一个前后端紧密结合的框架,里面有大量前后端代码混写  
php路由部分也是MVC模式,只是view这部分的展现方式不同于传统框架  
打破php,js,css代码之间的次元壁,比如你可以用php设置js,css代码里面的变量,控制js,css代码的生成逻辑等等  
css代码是基于less自动编译生成,自带less解析器  
js,css代码有自己的组装逻辑,类似于一些前端框架的import那一套,只是本框架用php控制,类似于webpack可以实现自动打包,自动丑化等操作(需要安装java)  
前端暴露的js,css代码经过自动编译后都放在/temp/codepack下面,线上模式下直接清空这个文件夹就会自动生成,开发模式下会自行判断是否需要重新生成  
提供多种数据库查询方式,预留同时连接多个数据库的示例代码  
提供多种前端用到的widget组件,设计思路是尽量不写js代码,只要按照约定格式写好dom结构就会自动渲染成有交互动作的widget组件,同时在页面元素变化时也会自动渲染  
前后端的配置保持统一,比如上传组件,在前端判断文件大小和扩展名的配置,和后端是一致的

# 文档
<a href="http://www.lovephp.com/doc/v1" target=_blank>查看文档</a>(不断完善中)

# 版权声明
> LOVEPHP的版权归`lovephp.com`所有,作者:潇桐 邮箱: xiaotong228@qq.com  
> 采用MIT开源协议:<a href="http://opensource.org/licenses/MIT" target=_blank>http://opensource.org/licenses/MIT</a>  
> Q群:854617887