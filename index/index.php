<?php
  // To make sure we don't need to create the header section of the website on multiple pages, we instead create the header HTML markup in a separate file which we then attach to the top of every HTML page on our website. In this way if we need to make a small change to our header we just need to do it in one place. This is a VERY cool feature in PHP!
  require "header.php";
?>

    <main>
      <div class="wrapper-main">
        <section class="section-default">
          <!--
          We can choose whether or not to show ANY content on our pages depending on if we are logged in or not. I talk more about SESSION variables in the login.inc.php file!
          -->
          <?php
          if (!isset($_SESSION['id'])) {         
            echo '
            <div style="float:left; width:60%; margin-right:0">
            <img src="img/home.jpg" style="width:100%">
            </div>
            <div class="header-login" style="text-align:center;float:flex; width:35%; margin-top:9%;">
            <form action="includes/login.inc.php" method="post">
            <h2 style="color:#269bb6">F A B E L O U S</h2><br>
            <p style="color:gray">Welcome back! Please login to your account.</p><br>
            <input type="text" name="mailuid" placeholder="E-mail/Username"><br>
            <input type="password" name="pwd" placeholder="Password"><br> 
            <button type="submit" name="login-submit">Login</button><br>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <p class="login-status">(For developer: user/password - test/test)</p><br>
            <p class="login-status">(For teacher: user/password - teacher/teacher)</p><br>
            <p class="login-status">(For student: user/password - student/student)</p>
            </form>
            
          </div>
          ';
          }
          else if (isset($_SESSION['id']) && $_SESSION['id']==2) {
            // content for logged in users
            ////echo '<p class="login-status">You are logged in!</p>';
            header('Location: Canvas/teacher.php');
            //include('DECO-7381/Canvas/index.php');
            //readfile('DECO-7381/Canvas/index.php');
            // above 2 do not render elements properly
          }
          else if (isset($_SESSION['id']) && $_SESSION['id']==3) {
            // content for logged in users
            ////echo '<p class="login-status">You are logged in!</p>';
            header('Location: Canvas/home.php');
            // echo '<a href="Canvas/home.html">Click here to access home</a>';
            //include('DECO-7381/Canvas/index.php');
            //readfile('DECO-7381/Canvas/index.php');
            // above 2 do not render elements properly
          }
          ?>
        </section>
      </div>
    </main>

<?php
  // And just like we include the header from a separate file, we do the same with the footer.
?>

