###  <div align=center>Fableous quick start guide</div>


#### 1. Online (uq zone):

The homepage of [Fableous](https://s4523761-fableous.uqcloud.net/index/index.php) demo is on the uq zone. 

https://s4523761-fableous.uqcloud.net/index/index.php

Account/password for the demo:

+ teacher/teacher: for teachers
+ student/student: for students
+ test/test: for developers



#### 2. Localhost server

1. Can use XAMPP (or other applications) to start a local *apache* server and **mysql** database server. XAMPP can download from its official website [Xampp download](https://www.apachefriends.org/download.html)

2. Then import the **fableous.sql** (out of the *'index'* folder) into the the localhost's *mysql* server by phpmyadmin or other methods. 

   If there are some database errors alerted in pages, these pages need to change the password to ""(empty) in the related php code.

3. The **root folder** of the webapp-Fableous is **'index'** folder, ensure it is on the apache *document root* folder. 

   Just copy or move the **index** folder to the *htdocs* on your computer's local server.

4. In terms of the *websocket* server, you should install **node.js** and its package - **ws** (websocket). A great guide can follow to install *node.js* is the official website [Node.js.org](https://nodejs.org/en/)

   Then start **server.js** (out of the *'index'* folder) as a local websocket server (the default port on localhost is 8080) : 

   ```bash
   npm install ws -g // install 'ws' globally by npm, or only for current user without '-g'
   node server.js // start the server
   ```

After that, the website could be access by ['localhost/index/index.php'](localhost/index/index.php). 

In the page, *test accounts/passwords and quick login portal* are on the **bottom-right** of the page (might need to scroll to the bottom). This is only used for test for developer, and should not appear in the formal product. You can delete it in the *'index/index.php'*.