

#  LOVEPHP

> `LOVEPHP` 是一款专为WEB开发设计的全栈开源框架  
> 运行环境要求:`PHP7/PHP8`,`java`  
> 官网:<a href="http://www.lovephp.com" target=_blank>http://www.lovephp.com</a>  
> 文档:<a href="http://www.lovephp.com/doc" target=_blank>lovephp开发文档</a>  
> B站视频教程:<a href="https://space.bilibili.com/4466712" target=_blank>lovephp全栈框架的个人空间</a>  
> 作者:潇桐(xiaotong228@qq.com)  
> Q群:854617887

# 开箱即用
> 这不是开源世界的一个轮子,这是一辆车,可以直接开的那种,专为全栈开发设计  
> 不同于其他的主流php框架只管后端不管前端的设计,`lovephp`同时提供后端,前端,PC端网页,移动端网页,APP构建全部代码,助力项目开发快速上线

# PC端网页
> 通过自研的`skel`页面管理引擎,可以方便的对pc页面进行可视化编辑自定义模块等操作

# APP开发
> `lovephp`作为一个全栈框架,借助`hbuilder`可以实现打包APP,方便进行项目快速开发上线

# DEMO(PC网页,移动网页,APP,安卓,IOS)
> `lovephp`提供了在线demo,让你可以直观看到运行效果,前后台都是配置好的,不需要额外部署安装  
> <a target=_blank href="http://www.lovephp.com/doc/demo">在线演示,APP下载</a>

# 云空间
> `lovephp`自带了一个在线文件资源管理系统(类似于七牛云存,淘宝图片空间),开箱即用  
> 视频介绍: <a href="https://www.bilibili.com/video/BV1EB4y1r7Ep" target=_blank>lovephp全栈框架-云空间,云盘,在线文件存储管理功能</a>

# 前端组件(widget)
> 提供常用的组件:比如上传文件,设置头像,轮播,树状结构,弹出框,计时器等,不依赖第三方插件,代码统一,配置方便  
> <a target=_blank href="http://lovephp.onlinehost.lovephp.com/example">组件演示</a>

# CODEPACK,打破代码次元壁
> `codepack`是`lovephp`自带的js,css代码打包编译引擎  
> 打破php,js,css代码之间的次元壁,比如你可以用php设置js,css代码里面的变量,控制js,css代码的生成逻辑等等  
> css代码是基于less自动编译生成,自带less解析器  
> js,css代码有自己的组装逻辑,类似于一些前端框架的import那一套,只是本框架用php控制,类似于webpack可以实现自动打包,自动丑化等操作(需要安装java)  
> 前端暴露的js,css代码经过自动编译后都放在/temp/codepack下面,线上模式下直接清空这个文件夹就会自动生成,开发模式下会自行判断是否需要重新生成

# 前后端不分离设计
> 不是当前流行的后端分离设计,`lovephp`是前后端不分离,甚至可以说是紧密结合的设计  
> 前后端,PC/WAP/APP端代码尽量复用

# 路由方式
> php路由部分也是MVC(module,view,controller)模式,只是view这部分的展现方式不同于传统框架  
> 前端页面代码输出没有传统的模板(template)这个概念,也没有了\<if> \<else> \<foreach>之类的写法,直接用php输出html的标签


# 数据库连接查询
> 可以同时连接多个数据库,自动更改数据库表结构,自动同步触发器
> 触发器这个东西实际应用中很麻烦,代码逻辑比较难以统一,作用在很多程序中都被严重低估了,`lovephp`提供了同步触发器的方法,用了都说好,项目代码更规范,逻辑更清晰


# 版权声明
> LOVEPHP的版权归`lovephp.com`所有  
> 采用MIT开源协议:<a href="http://opensource.org/licenses/MIT" target=_blank>http://opensource.org/licenses/MIT</a>

