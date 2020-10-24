# 划啊，划啊，划！

此项目最终解释权归 “东半球南太平洋地区大洋洲大袋鼠国 🇦🇺 澳斯吹利亚昆士兰州东南部大布里斯班地区布里斯班河边圣卢西亚区4072‘UQ’🏊🏻‍  全校大学生游泳比赛-职业组-团体赛冠军 🏆️ ” **Team Ignite** (*Dragonboat CO.*)所有.

##### <div align="right">*引用或git该项目须注明来源*</div>

## 主页面：

[新主页 (注册，登录，导航)](https://s4523761-fableous.uqcloud.net/index/index.php)

[Canvas (Drawing)](https://s4523761-fableous.uqcloud.net/index/Canvas/index.php)

[Canvas (Writing)](https://s4523761-fableous.uqcloud.net/index/Canvas/textStory.php)

### Version 2.5.0 Changelog

为什么是这个版本号，因为我感觉我像一个“250”

<i>0. 版本修正：</i>
+ 主页按设计重做
+ 画画界面笔画粗细显示，redo、undo的实现(满是bug版)
  + 单人画redo、undo，以及一人一笔画redo、undo正常
+ 文字输入界面字体大小调整，文本框换行，无redo，undo
+ 老师界面UI美化
+ 注释精简，汉译英，添加

[Teacher (New)](https://s4523761-fableous.uqcloud.net/index/Canvas/teacher.php)

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
  - 同步多页面(add_page)部分，功能实现有限（仅实现‘新增页面’与‘firstpage同步点击’，未实现newpage同步点击），bug较多

+ Library:
  - 删除‘新增’按钮，增加‘delte’，‘rename’弹窗操作按钮
  - 获取数据库中保存的图片并分组显示
  - ‘delete’，‘rename’按钮可以直接作用于页面和数据库
  - 随机对library中保存的项目赋予随机封面

+ Home:
  - 老主页，将来或与新主页融合（对新主页作调整，或直接‘套娃’）
  
+ Teacher：
  - Class Library： 班级stories
  - Waiting Approval: UNKNOWN
  - Not Approved: UNKNOWN
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


#### bug特别多，但近期没有修复计划。主力研究目前仍在‘多页面’的bug修复与新特性添加。

<div align="right">Oct/24/2020</div>

### 其他页面：

[Library (Stable)](https://s4523761-fableous.uqcloud.net/index/Canvas/library.php)

[Homepage (for student)](https://s4523761-fableous.uqcloud.net/index/Canvas/home.php)

[Teacher (New)](https://s4523761-fableous.uqcloud.net/index/Canvas/teacher.php)
