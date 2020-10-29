###  <div align=center>Fableous quick start guide</div>



#### 1. Online (uq zone):

The homepage of [Fableous](https://s4523761-fableous.uqcloud.net/index/index.php) on the uq zone.



#### 2. Localhost server

Can use MAXPP (or other applications) to start a local apache server and mysql server.



Then import the **fableous.sql** into the mysql server. 

Change all relevant files' database password to **""**(empty):

- index/includes/dbh.inc.php
- index/Canvas/approved.php
- index/Canvas/classlib.php
- index/Canvas/library.php
- index/Canvas/upload.php
- index/Canvas/waitingapproval.php

If there are also some other pages alert error of database, also need to change the pwd to "".



The **root folder** of the webapp is **'index'** folder, ensure it is on the apache document  root folder.



In terms of the websocket server, you can use the default uq zone's one, and **no need** to change any files.

Or install node.js and using npm to install websocket package (ws), then start it as a local server (the default port on localhost is 8080) : 

```bash
npm install ws -g
node server.js
```

You also need to **change ws url** in the file 'index/Canvas/js/sync.js' from uqhost to localhost.

A great guide can follow to install node.js is the official website [Node.js](https://nodejs.org/en/)



Then the website could be access by ['localhost/index/index.php'](localhost/index/index.php). 

In the page, *test accounts/passwords and quick login portal* are on the bottom-right of the page (might need to scroll to the bottom). This is only used for test for developer, and should not appear in the formal product. You can delete it in the 'index/index.php'.

