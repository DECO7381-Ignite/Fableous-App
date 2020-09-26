<?php
$servername = "localhost";
$username = "root";
// server
//$password = "dbf76fb8c7e45fe1";
// localhost pas
 $password = "";
$dbname = "fableous";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM library WHERE user='max' ";
$result = $conn->query($sql);
$libraryData =array();
$json = '';

class libraryPhotos {
    public $pid;
    public $pname;
    public $user;
    public $imageData;
}

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $library_pictures = new libraryPhotos();
        $library_pictures -> pid = $row['pid'];
        $library_pictures -> pname = $row['pname'];
        $library_pictures -> user = $row['user'];
        $library_pictures -> imageData = $row['data'];
        $libraryData[]=$library_pictures;
    }
    $json = json_encode($libraryData);
} else {
    echo "0 result";
}

if (isset($_GET["id"])) {
    $deleteID=$_GET["id"];
    $dsql = "DELETE FROM library WHERE pid='$deleteID' "; 
    $conn->query($dsql);
    header("Location:library_beta.php");
}
if (isset($_GET["uid"])) {
    $updateID=$_GET["uid"];
    $uname=$_GET["uname"];
    $usql = "UPDATE library SET pname='$uname' WHERE pid='$updateID'"; 
    $conn->query($usql);
    header("Location:library_beta.php");
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
    <div id="picture">
    </div>
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
    let paintingBox = document.getElementById("painting-box");
    let storyID = 0;
    let storiesArray = document.getElementsByClassName("stories");
    let libraryImages = null;
    let currentUser = "max";
    let images = new Map();

    window.onload = function () {
        libraryImages = <?php echo $json?>;
        for (let p in libraryImages) {
            if (libraryImages[p].user === "max") {
                let tempPname = libraryImages[p].pname;
                let arr = [];

                if (images.get(tempPname)) {
                    arr = images.get(tempPname);
                }

                arr.push(libraryImages[p]);

                images.set(tempPname, arr);
            }
        }

        for (let key of images.keys()) {
            addStories(key);
        }
    }

    function addStories(storyname) {
        let stories = document.createElement("div");
        let storyTitle = document.createElement("p");

        storyID = storyID + 1;
        stories.className = "stories";
        stories.id = "stories" + storyID.toString();
        paintingBox.appendChild(stories);
        stories.setAttribute("position", "relative");
        stories.pname = storyname;
        stories.pid=images.get(storyname)[0].pid;

        storyTitle.className = "story-name";
        storyTitle.innerHTML = storyname;

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
                inputNewName.style.visibility = "hidden";
            }

            deleteButton.onclick = function () {
                background.style.visibility = "hidden";
                picture.style.visibility = "hidden";
                stories.parentNode.removeChild(stories);
                inputNewName.style.visibility = "hidden";
                window.location.href="?id="+stories.pid;
            }

            renameButton.onclick = function () {
                inputNewName.style.visibility = "visible";
            }

            confirmRenameButton.onclick = function () {
                let newName = document.getElementById("new-name");
                storyTitle.innerHTML = newName.value;
                inputNewName.style.visibility = "hidden";
                newName.value = "";
                window.location.href="?uid="+stories.pid+"&uname="+storyTitle.innerHTML;
            }

            cancelRenameButton.onclick = function () {
                inputNewName.style.visibility = "hidden";
            }

            // 读取img并分组放到library

            let arr = images.get(storyname);

            let pictures = document.getElementById("picture");
            pictures.innerHTML="";
            for (let i in arr) {
                let libImage = new Image();
                libImage.src = arr[i].imageData;

                let aDiv = document.createElement("div");
                aDiv.style.width = "580px";
                aDiv.style.height = "440px";
                aDiv.style.margin = "5px";
                let libCanvas = document.createElement("canvas");
                libCanvas.className = "library-canvas";
                libCanvas.style.width = "580px";
                libCanvas.style.height = "440px";

                pictures.appendChild(aDiv);
                aDiv.appendChild(libCanvas);

                libImage.onload = function () {
                    libCanvas.getContext("2d").drawImage(libImage, 0, 0, libCanvas.width, libCanvas.height);
                }
            }
        }
    }
</script>
</body>
</html>
<!--test-->
