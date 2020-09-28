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
$sql = "SELECT * FROM library  "; 
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
    $dsql = "DELETE FROM library WHERE pname='$deleteID'"; 
    $conn->query($dsql);
    header("Location:library.php");
}
if (isset($_GET["uid"])) {
    $updateID=$_GET["uid"];
    $uname=$_GET["uname"];
    $usql = "UPDATE library SET pname='$uname' WHERE pname='$updateID'";
    $conn->query($usql);
    header("Location:library.php");
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
    <button id="library" onclick="displayAllBooks()">click here to display all books in the library</button>
    <div id="main-lib">
    <form method="post">
    <label>Search book(s) by author's name</label>
    <input type="text" name="library">
    <input type="submit" name="submit">
        <div id="painting-box">
<!--            <ul id="select-box">-->
<!--                <li>Browse</li>-->
<!--                <li>Rename</li>-->
<!--                <li>Delete</li>-->
<!--            </ul>-->

<script> 
function displayAllBooks() {
    let paintingBox = document.getElementById("painting-box");
    paintingBox.innerHTML = ''; //removes all (pre-existing) children before printing out all existing books
    let storyID = 0;
    let storiesArray = document.getElementsByClassName("stories");
    let libraryImages = null;
    let currentUser = "test2";
    let images = new Map();


    libraryImages = <?php echo $json?>;
    for (let p in libraryImages) {
        if (libraryImages[p].user !== null) {
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
    
    function addStories(storyname) {
        let stories = document.createElement("div");
        let storyTitle = document.createElement("p");

        storyID = storyID + 1;
        stories.className = "stories";
        stories.id = "stories" + storyID.toString();
        paintingBox.appendChild(stories);
        stories.pname = storyname;

        storyTitle.className = "story-name";
        storyTitle.innerHTML = storyname;

        storyTitle.id = "store-title" + storyID.toString();
        stories.appendChild(storyTitle);

        // 设置随机封面背景
        let storiesBG = ["storiesBG1", "storiesBG2", "storiesBG3"];
        let randomBG = "background-image: url('./icon/" + storiesBG[Math.floor(Math.random() * 3)] + ".svg');";
        stories.setAttribute("style", randomBG);

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
                window.location.href="?id="+stories.pname;
            }

            renameButton.onclick = function () {
                inputNewName.style.visibility = "visible";
            }

            confirmRenameButton.onclick = function () {
                let newName = document.getElementById("new-name");
                storyTitle.innerHTML = newName.value;
                inputNewName.style.visibility = "hidden";
                newName.value = "";
                window.location.href="?uid="+stories.pname+"&uname="+storyTitle.innerHTML;
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

}
</script> 

</body>
</html>
<!--test-->

<?php

$con = new PDO("mysql:host=localhost;dbname=fableous", 'root', '');

if (isset($_POST["submit"])) {
    $str = $_POST["library"]; 
    $sth = $con->prepare("SELECT * FROM `library` WHERE user = '$str'");

    $sth->setFetchMode(PDO:: FETCH_OBJ);
    $sth -> execute();

    if($row = $sth->fetch())
    {
        ?>
        <script>
        var val = "<?php echo $row->user ?>"; // get the php variable into js. 

        let paintingBox = document.getElementById("painting-box");
        let storyID = 0;
        let storiesArray = document.getElementsByClassName("stories");
        let libraryImages = null;
        let currentUser = "test"; // ..
        let images = new Map();
    
        
            libraryImages = <?php echo $json?>;
            for (let p in libraryImages) {
                if (libraryImages[p].user === val) { // this line determines the books that will appear
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

        function addStories(storyname) {
        let stories = document.createElement("div");
        let storyTitle = document.createElement("p");

        storyID = storyID + 1;
        stories.className = "stories";
        stories.id = "stories" + storyID.toString();
        paintingBox.appendChild(stories);
        stories.pname = storyname;

        storyTitle.className = "story-name";
        storyTitle.innerHTML = storyname;

        storyTitle.id = "store-title" + storyID.toString();
        stories.appendChild(storyTitle);

        // 设置随机封面背景
        let storiesBG = ["storiesBG1", "storiesBG2", "storiesBG3"];
        let randomBG = "background-image: url('./icon/" + storiesBG[Math.floor(Math.random() * 3)] + ".svg');";
        stories.setAttribute("style", randomBG);

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
                window.location.href="?id="+stories.pname;
            }

            renameButton.onclick = function () {
                inputNewName.style.visibility = "visible";
            }

            confirmRenameButton.onclick = function () {
                let newName = document.getElementById("new-name");
                storyTitle.innerHTML = newName.value;
                inputNewName.style.visibility = "hidden";
                newName.value = "";
                window.location.href="?uid="+stories.pname+"&uname="+storyTitle.innerHTML;
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

   <?php } 
    else{
        echo "This author does not exist.";
    }
}