# 划啊，划啊，划！

此项目最终解释权归 “东半球南太平洋地区大洋洲大袋鼠国 🇦🇺 澳斯吹利亚昆士兰州东南部大布里斯班地区布里斯班河边圣卢西亚区4072‘UQ’🏊🏻‍  全校大学生游泳比赛-职业组-团体赛冠军 🏆️ ” **Team Ignite** (*Dragonboat CO.*)所有.

##### <div align="right">*引用或git该项目须注明来源*</div>

## 主页面：

[新主页 (注册，登录)](https://s4523761-fableous.uqcloud.net/index/index.php)

### Version 2.5.0 Changelog

为什么是这个版本号，因为我感觉我像一个“250”

<i>0. 版本修正：</i>
+ libray界面优化：修复一坨稀饭preview，增加作者显示，字体显示修改，搜索方式优化
+ 老师界面增加approved 和 waitng approval分离，并且可以unapprove
+ 主页按设计重做
+ 画画界面笔画粗细显示，redo、undo的实现(满是bug版)
  + 单人画redo、undo，以及一人一笔画redo、undo正常
+ 文字输入界面字体大小调整，文本框换行，无redo，undo
+ 老师界面UI美化
+ 注释精简，汉译英，添加

### 其他页面 (不登陆一个也上不去)：

[Canvas (Drawing)](https://s4523761-fableous.uqcloud.net/index/Canvas/index.php)

[Canvas (Writing)](https://s4523761-fableous.uqcloud.net/index/Canvas/textStory.php)

[Library](https://s4523761-fableous.uqcloud.net/index/Canvas/library.php)

[Homepage (for student)](https://s4523761-fableous.uqcloud.net/index/Canvas/home.php)

[Teacher](https://s4523761-fableous.uqcloud.net/index/Canvas/teacher.php)

<i>1. 整体修正：</i>
- 部分CSS美化
- 部分代码实现方式重构
- 项目架构重构（套娃）
- 修复部分bug

<i>2. 具体功能（截至目前）与修改：</i>

+ index (新主页):
  - 注册登录功能（测试用户名/密码：test）
  - 各个页面导航功能

+ Canvas:
  - 共享画板 - 画笔，橡皮，填充，矩形，三角，圆，等等
  - 线条粗细，颜色调整
  - 添加文字输入框
  - 把一组图片上传到数据库
  - 同步多页面(add_page)部分

+ Library:
  - 删除‘新增’按钮，增加‘delte’，‘rename’弹窗操作按钮
  - 获取数据库中保存的图片并分组显示
  - ‘delete’，‘rename’按钮可以直接作用于页面和数据库
  - 随机对library中保存的项目赋予随机封面

+ Home:
  - 老主页，已变成学生主页
  
+ Teacher：
  - Class Library： 班级stories，默认all
  - Waiting Approval: 等待approve的
  - Approved: 已经approve的
  - Student: students list
  - Setting: UNAVAILABLE

修复后差不多bug后，会上线Canvas最新稳定版

<i>3. 上一版本：</i>
- 分离writing/drawing
- 登录导航，较完整流程体验: 老师学生不同帐号进不同页面
- 多设备适配，页面大小变化
- 新增老师页面
- library search功能
- teacher页面library页面添加
- 各页面增加回主页按钮：画板和library是右上角图标；teacher是左上角文字
- 修复填充，橡皮颜色同步问题
- 修复fill功能失效
- 修复textinput座标不对问题
- 修改部分readme


#### bug相对减少，但近期没有修复计划。主力目前仍在Presentation部分。

<div align="right">Oct/29/2020</div>
