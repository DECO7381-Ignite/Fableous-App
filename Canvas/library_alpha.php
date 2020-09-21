<?php
$servername = "localhost";
$username = "root";
// server
$password = "dbf76fb8c7e45fe1";
// localhost pas
// $password = "";
$dbname = "fableous";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM library WHERE user='max' ";
$result = $conn->query($sql);
$imgs =array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $imgs[]=$row['data'];
    }
} else {
    echo "0 结果";
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Class Library</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="browsing-background"></div>
<div id="picture-box">
    <div id="picture"></div>
    <div id="picture-button">
        <button id="rename-button">rename</button>
        <button id="delete-button">delete</button>
        <button id="close-button">close</button>
    </div>
    <div id="input-new-name">
        <input type="text" id="new-name">
        <div id="rename-button-box">
            <button id="confirm-rename-button">confirm</button>
            <button id="cancel-rename-button">cancel</button>
        </div>
    </div>
</div>
<div class="main-part">
    <div class="header">
        <div class="user"><img src="icon/user.svg" alt="user_icon"></div>
        <div class="status"><p>Class Library</p></div>
        <div class="comment-button"><img src="icon/comment.svg" alt="comment icon"></div>
        <div class="home-button"><img src="icon/home.svg" alt="home icon"></div>
    </div>
    <div id="main-lib">
        <button id="search">Search</button>
        <button id="add-stories">+</button>
        <input type="text" id="user-input">
        <div id="painting-box">
<!--            <ul id="select-box">-->
<!--                <li>Browse</li>-->
<!--                <li>Rename</li>-->
<!--                <li>Delete</li>-->
<!--            </ul>-->
        </div>
    </div>
    <div class="footer">
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
    let add = document.getElementById("add-stories");
    let paintingBox = document.getElementById("painting-box");
    let userInput = document.getElementById("user-input");
    let storyID = 0;
    let storiesArray = document.getElementsByClassName("stories");

    for (let s in storiesArray) {
        let a = storiesArray[s];
        storiesArray[s].onclick = function() {
            storiesArray[s].setAttribute("border", "1px solid green");
        }
        a.onclick = function () {
            if (a.selected === 1) {
                a.selected = 0;
                a.setAttribute("border", "");
            } else {
                a.selected = 1;
                a.setAttribute("border", "1px solid green");
            }
        }
    }

    add.addEventListener("click", addStories, false);

    function addStories(e) {
        let stories = document.createElement("div");
        let storyTitle = document.createElement("p");

        storyID = storyID + 1;
        stories.className = "stories";
        stories.id = "stories" + storyID.toString();
        paintingBox.appendChild(stories);
        stories.setAttribute("position", "relative");
        stories.selected = 0;

        storyTitle.className = "story-name";
        storyTitle.innerHTML = userInput.value;

        storyTitle.id = "store-title" + storyID.toString();
        stories.appendChild(storyTitle);

        stories.onclick = function () {
            let background = document.getElementById("browsing-background");
            let picture = document.getElementById("picture-box");
            background.style.visibility = "visible";
            picture.style.visibility = "visible";

            let closeButton = document.getElementById("close-button");
            let deleteButton = document.getElementById("delete-button");
            let renameButton = document.getElementById("rename-button");
            let confirmRenameButton = document.getElementById("confirm-rename-button");
            let cancelRenameButton = document.getElementById("cancel-rename-button");
            let inputNewName = document.getElementById("input-new-name");

            closeButton.onclick = function () {
                background.style.visibility = "hidden";
                picture.style.visibility = "hidden";
            }

            deleteButton.onclick = function () {
                background.style.visibility = "hidden";
                picture.style.visibility = "hidden";
                stories.parentNode.removeChild(stories);
            }

            renameButton.onclick = function () {
                inputNewName.style.visibility = "visible";
            }

            confirmRenameButton.onclick = function () {
                let newName = document.getElementById("new-name");
                storyTitle.innerHTML = newName.value;
                inputNewName.style.visibility = "hidden";
                newName.value = "";
            }

            cancelRenameButton.onclick = function () {
                inputNewName.style.visibility = "hidden";
            }

        }
    }
</script>
</body>
</html>