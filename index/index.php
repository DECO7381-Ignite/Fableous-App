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
            echo '<p class="login-status">You are logged out!</p>
            <p class="login-status">(For developer: user/password - test/test)</p>';
          }
          else if (isset($_SESSION['id'])) {
            // content for logged in users
            ////echo '<p class="login-status">You are logged in!</p>';
            // echo '<a href="Canvas/index.php">Click here to access canvas</a>';
            echo '<a href="Canvas/index_beta.php">Click here to access canvas</a>';
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
  require "footer.php";
?>
