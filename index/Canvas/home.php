<?php
  // start a session which allow for us to store information as SESSION variables.
  session_start();
  // "require" creates an error message and stops the script. "include" creates an error and continues the script.
  require "../includes/dbh.inc.php";
  if (!$_SESSION['id']){
    echo "<script> {window.alert('Please login first!');} history.back();</script>";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="//db.onlinewebfonts.com/c/8df141f447c5686cf9dbae8dabb1e71a?family=AllRoundGothicW01-Bold" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div id="book">
        <div id="user">
        <?php
                if (isset($_SESSION['id'])) {
                    echo '<form action="../includes/logout.inc.php" method="post">
                    <button type="submit" name="login-submit">Logout</button>
                    </form>';
                }
        ?>
            <img src="icon/user.svg" alt="user_icon">
        </div>
        <div id="title">
            <a href="../index.php">Fableous</a>
        </div>
        <div id="menu">
            <button id="addStory">Add New Story</button>
            <button id="classLib"><a href="library.php">Class Library</a></button>
            <button id="settings">Settings</button>
        </div>
    </div>
    <div id="addStoryMenu">
        <button id="painter"><a href="index.php">painter</a></button>
        <button id="storyTeller"><a href="textStory.php">storyTeller</a></button>
        <button id="back">back</button>
    </div>
</body>
<style>
    a{
        text-decoration: none;
        color:black;
    }
    body {
        font-family: AllRoundGothicW01-Bold, sans-serif;
        display: flex;
        flex-direction: column;
        margin: 0;
        padding: 0;
        user-select: none;
        background-color: #efefef;
    }

    div#book {
        background-image: url("icon/home book.svg");
        background-repeat: no-repeat;
        background-position: center;
        width: 700px;
        height: 670px;
        margin: auto;
        position: absolute;
        right: 0;
        top: 0;
        left: 0;
        bottom: 0;
        padding: 30px;
        box-sizing: border-box;
    }

    div#user {
        width: 85px;
        float: right;
    }

    div#user img {
        cursor: pointer;
        transition: transform 0.2s;
    }

    div#user img:hover {
        transform: scale(1.1);
    }
    div#user img:active {
        transform: scale(1);
    }


    div#title {
        font-size: 7.5em;
        color: whitesmoke;
        text-align: center;
        width: 100%;
        clear: both;
    }

    div#title a {
        text-decoration: none;
        border: 2px solid rgba(0,0,0,0);
        box-sizing: border-box;
        border-radius: 10px;
    }

    div#title a:hover {
        border: 2px solid whitesmoke;
    }

    div#title a:visited {
        color: whitesmoke;
    }

    div#menu {
        width: 80%;
        height: 330px;
        background-color: #F2F2F2;
        margin: 30px auto 0 auto;
        padding: 35px;
        box-sizing: border-box;
        border-radius: 17px;
    }

    div#menu button {
        width: 190px;
        height: 100px;
        border: 0;
        border-radius: 12px;
        background-color: #CEA3C2;
        font-family: AllRoundGothicW01-Bold, sans-serif;
        font-size: 2em;
        position: absolute;
        cursor: pointer;
        transition: transform 0.15s;
    }

    div#menu button:first-of-type {
        margin: 15px auto;
        left: 0;
        right: 0;
    }
    div#menu button:nth-of-type(2) {
        margin: 145px 0 0 15px;
    }
    div#menu button:nth-of-type(3) {
        margin: 145px 0 0 235px;
    }

    div#menu button:hover {
        background-color: #60A6C8;
        color: whitesmoke;
        transform: scale(1.1);
    }
    div#menu button:active {
        background-color: #9F5937;
        color: lightgreen;
        transform: scale(1);
    }

    div#addStoryMenu {
        position: absolute;
        background-color: whitesmoke;
        border-radius: 17px;
        width: 512px;
        height: 330px;
        top: 420px;
        left: 223px;
        display: flex;
        justify-content: center;
        align-items: center;
        transform: scale(0);
        transition: transform 0.2s linear;
    }

    div#addStoryMenu button {
        margin: 10px;
        width: 190px;
        height: 100px;
        border: 0;
        border-radius: 12px;
        background-color: #CEA3C2;
        font-family: AllRoundGothicW01-Bold, sans-serif;
        font-size: 2em;
        cursor: pointer;
        transition: transform 0.2s;
    }

    div#addStoryMenu button:hover {
        background-color: #60A6C8;
        color: whitesmoke;
        transform: scale(1.1);
    }

    div#addStoryMenu button:active {
        background-color: #9F5937;
        color: lightgreen;
        transform: scale(1);
    }

    div#addStoryMenu button#back {
        position: absolute;
        top: 10px;
        left: 10px;
        width: 80px;
        height: 40px;
        font-size: 1.4em;
        background-color: #a6b1bc;
    }
</style>
<script>
    let addStoryMenu = window.document.getElementById("addStoryMenu");
    let back = window.document.getElementById("back");
    let addStory = window.document.getElementById("addStory");

    addStory.onclick = function () {
        addStoryMenu.style.transform = "scale(1)";
    }

    back.onclick = function () {
        addStoryMenu.style.transform = "scale(0)";
    }
</script>
</html>