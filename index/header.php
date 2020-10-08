<?php
  // start a session which allow for us to store information as SESSION variables.
  session_start();
  // "require" creates an error message and stops the script. "include" creates an error and continues the script.
  require "includes/dbh.inc.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="description" content="This is an example of a meta description. This will often show up in search results.">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    <!-- header to include the login form for this tutorial. -->
    <header>
      <nav class="nav-header-main">
        <a class="header-logo" href="index.php">
          <img src="img/logo2.png" alt="mmtuts logo2">
        </a>
        <ul>
          <!-- Placeholder buttons -->
          <?php
          if (isset($_SESSION['id']) && $_SESSION['id']==1) {
            echo '<li><a href="Canvas/home.php">Home</a></li>
            <li><a href="Canvas/library.php">Library</a></li>
            <li><a href="Canvas/index.php">Canvas</a></li>
            <li><a href="Canvas/textStory.php">Writing</a></li>
            <li><a href="Canvas/teacher.php">Teacher</a></li>';
          }
          else if (isset($_SESSION['id']) && $_SESSION['id']==2) {
            echo '<li><a href="Canvas/library.php">Library</a></li>
            <li><a href="Canvas/index.php">Canvas</a></li>
            <li><a href="Canvas/textStory.php">Writing</a></li>
            <li><a href="Canvas/teacher.php">Teacher</a></li>';
          }
          else if (isset($_SESSION['id']) && $_SESSION['id']==3) {
            echo '<li><a href="Canvas/home.php">Home</a></li>
            <li><a href="Canvas/library.php">Library</a></li>
            <li><a href="Canvas/index.php">Canvas</a></li>
            <li><a href="Canvas/textStory.php">Writing</a></li>';
          }
          ?>
          
        </ul>
      </nav>
      <div class="header-login">
        <!--
        HTML login form.
        -->
        <?php
        if (!isset($_SESSION['id'])) {
          echo '<form action="includes/login.inc.php" method="post">
            <input type="text" name="mailuid" placeholder="E-mail/Username">
            <input type="password" name="pwd" placeholder="Password">
            <button type="submit" name="login-submit">Login</button>
          </form>
          <a href="signup.php" class="header-signup">Signup</a>';
        }
        else if (isset($_SESSION['id'])) {
          echo '<form action="includes/logout.inc.php" method="post">
            <button type="submit" name="login-submit">Logout</button>
          </form>';
        }
        ?>
      </div>
    </header>
