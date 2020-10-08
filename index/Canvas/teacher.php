<?php
  // start a session which allow for us to store information as SESSION variables.
  session_start();
  // "require" creates an error message and stops the script. "include" creates an error and continues the script.
  require "../includes/dbh.inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher</title>
    <link href="//db.onlinewebfonts.com/c/8df141f447c5686cf9dbae8dabb1e71a?family=AllRoundGothicW01-Bold" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="css/teacher.css">
</head>
<body>
    <div id="body-div">
        <section id="teacher-navigation">
            <span><a style="text-decoration:none;color:black;" href="../index.php">FABLEOUS</a></span>
            <ul class="navigation">
                <li class="active">Class Library</li>
                <li>Waiting Approval</li>
                <li>Not Approved</li>
                <li>Students</li>
                <li>Setting</li>
            </ul>
        </section>
        <section id="main-part">
            <div id="main-part-head">
                <div id="notification">1</div>
                <div id="chat">2</div>
                <div id="name">name</div>
                <?php
                if (isset($_SESSION['id'])) {
                    echo '<form action="../includes/logout.inc.php" method="post">
                    <button type="submit" name="login-submit">Logout</button>
                    </form>';
                }
                ?>
                <div id="profile"></div>
            </div>
            <div class="contents">
                <div id="class-library" class="first-3-page">
                    <section id="class-library-head" class="first-3-page-head">
                        <section id="head-1" class="first-3-page-head-1">
                            <span>Class Library</span>
                            <button>Download</button>
                        </section>
                        <section id="head-2" class="first-3-page-head-2">   
                        <button id="filter">F</span>
                            <button id="delete">D</button>
                        </section>
                    </section>
                    <section id="class-library-body" class="first-3-page-body">
                    <embed id="classlib" src="classlib.php" width=100% height=100%>
                    </section>
                </div>
                <div id="waiting-approval" class="first-3-page">
                    <section id="waiting-approval-head" class="first-3-page-head">
                        <section id="head-3" class="first-3-page-head-1">
                            <span>Class Library</span>
                            <button>Download</button>
                        </section>
                        <section id="head-4" class="first-3-page-head-2">
                            <input type="text" value="search..." id="search">
                            <button id="filter">F</span>
                            <button id="delete">D</button>
                        </section>
                    </section>
                    <section id="waiting-approval-body" class="first-3-page-body"><embed id="waitingapproval" src="waitingapproval.php" width=100% height=100%></section>
                </div>
                <div id="not-approved" class="first-3-page">
                    <section id="not-approved-head" class="first-3-page-head">
                        <section id="head-5" class="first-3-page-head-1">
                            <span>Class Library</span>
                            <button>Download</button>
                        </section>
                        <section id="head-6" class="first-3-page-head-2">
                            <input type="text" value="search..." id="search">
                            <button id="filter">F</span>
                        </section>
                    </section>
                    <section id="not-approved-body" class="first-3-page-body">content 3</section>
                </div>
                <div id="students">
                    <section id="students-head">
                        <section id="head-7">
                            <span>Students</span>
                            <button id="add-student-button">Add students</button>
                        </section>
                        <input type="text" value="search..." id="search-student">
                    </section>
                    <section id="students-body">
                        <table id="students-list">
                            <tr>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Attendence</th>
                                <th>Team</th>
                                <th>Dietary</th>
                                <th>Extra</th>
                                <th>action</th>
                            </tr>
                        </table>
                    </section>
                </div>
                <div id="setting">Setting</div>
                <section id="add-student-window">
                    <label>Student Name: <input type="text" id="add-window-name"></label>
                    <label>Student ID: <input type="text" id="add-window-id"></label>
                    <label>Attendence: <input type="text" id="add-window-att"></label>
                    <label>Team: <input type="text" id="add-window-team"></label>
                    <label>Dietary: <input type="text" id="add-window-diet"></label>
                    <label>Extra: <input type="text" id="add-window-extra"></label>
                    <section>
                        <button id="cancel-add">Cancel</button>
                        <button id="ensure-add">Confirm</button>
                    </section>
                </section>
            </div>
        </section>
    </div>
    <script
            src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
    <script>
        $(window).on("load", function() {
            $(".contents>div").eq(0).show().siblings().hide();
            loadStudents();
        });

        $(".navigation>li").click(function() {
            $(this).addClass("active").siblings().removeClass("active");
            var index = $(this).index();
            $(".contents>div").eq(index).show().siblings().hide();
        });
    </script>
    <script src="js/teacher.js"></script>
</body>
</html>