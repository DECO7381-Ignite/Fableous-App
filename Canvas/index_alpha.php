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
$sql = "SELECT pname, user, data FROM library WHERE pid=0 ";
$result = $conn->query($sql);
$img =array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $img[]=$row['data'];
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fableous</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="main-part">
        <div class="header">
            <div class="user"><img src="icon/user.svg" alt="user_icon"></div>
            <div class="status"><p>DRAWING</p></div>
            <div class="comment-button"><img src="icon/comment.svg" alt="comment icon"></div>
            <div class="home-button"><img src="icon/home.svg" alt="home icon"></div>
        </div>
        <div id="main-body">
            <div id="toolBox">
                <div id="choose" class="toolBox-buttons"><img src="icon/choose.svg" alt="choose icon"></div>
                <div id="pencil" class="toolBox-buttons"><img src="icon/pencil.svg" alt="pencil icon"></div>
                <div id="eraser" class="toolBox-buttons"><img src="icon/eraser.svg" alt="eraser icon"></div>
                <div id="rectangle" class="toolBox-buttons"><img src="icon/rectangle.svg" alt="rectangle icon"></div>
                <div id="triangle" class="toolBox-buttons"><img src="icon/triangle.svg" alt="triangle icon"></div>
                <div id="circle" class="toolBox-buttons"><img src="icon/circle.svg" alt="circle icon"></div>
                <div id="fill" class="toolBox-buttons"><img src="icon/fill.svg" alt="fill icon"></div>
                <div id="clear" class="toolBox-buttons"><img src="icon/clear.svg" alt="clear icon"></div>
            </div>
            <div id="canvas-box">
                <canvas id="myCanvas"></canvas>
            </div>
            <div id="additional-toolbar">
                <div id="re-un-button">
                    <div id="undo"><img src="icon/undo.svg" alt="undo icon"></div>
                    <div id="redo"><img src="icon/redo.svg" alt="redo icon"></div>
                </div>
                <div id="color-pad">
                    <div id="c0" class="colors"><img src="icon/tick.svg" alt="tick icon"></div>
                    <div id="c1" class="colors"><img src="icon/tick.svg" alt="tick icon"></div>
                    <div id="c2" class="colors"><img src="icon/tick.svg" alt="tick icon"></div>
                    <div id="c3" class="colors"><img src="icon/tick.svg" alt="tick icon"></div>
                    <div id="c4" class="colors"><img src="icon/tick.svg" alt="tick icon"></div>
                    <div id="c5" class="colors"><img src="icon/tick.svg" alt="tick icon"></div>
                    <div id="c6" class="colors"><img src="icon/tick.svg" alt="tick icon"></div>
                    <div id="c7" class="colors"><img src="icon/tick.svg" alt="tick icon"></div>
                    <div id="c8" class="colors"><img src="icon/tick.svg" alt="tick icon"></div>
                    <div id="c9" class="colors"><img src="icon/tick.svg" alt="tick icon"></div>
                    <div id="c10" class="colors"><img src="icon/tick.svg" alt="tick icon"></div>
                    <div id="c11" class="colors"><img src="icon/tickWhite.svg" alt="tick icon"></div>
                </div>
                <div id="adjust-size">
                    <label for="slider"></label><input type="range" min = "1" max = "100" value="5" id="slider">
                </div>
            </div>
        </div>

        <form>
            <div class="form-group">
            
                <input
                  type="range"
                  id="rate"
                  class="custom-range"
                  min="0.5"
                  max="2"
                  value="1"
                  step="0.1"
                />
            </div>

            <div class="form-group">
            
                <input
                  type="range"
                  id="pitch"
                  class="custom-range"
                  min="0"
                  max="2"
                  value="1"
                  step="0.1"
                />
            </div>

            <div class="form-group">
                <select id="voice-select" class="form-control form-control-lg"></select>
            </div>

            <div class="form-group">
                <textarea
                  name=""
                  id="text-input"
                  class="form-control form-control-lg"
                  placeholder="Type your story text here..."
                ></textarea>
            </div>

            <button class="btn btn-light btn-lg btn-block">Read aloud story text</button>
        </form>
        <button id="save-picture-button" onclick=savePicture()>SUBMIT</button>
        <input type="submit" value="TEST(JDNB from cloud)" onclick=gett()>

        <div class="footer">
            <div id="back-button"><p>&lt; Previous Page</p></div>
            <div id="page-number"><p>Page 1</p></div>
            <div id="next-button"><p>Next Page &gt;</p></div>
        </div>
    </div>
    <!-- upload function -->
    <div id="black-background"></div>
    <div id="save-picture-window">
        <form id="save-picture-form" action="upload.php" method="POST">
            <label>Picture name:
                <input type="text" name="pname">
            </label>
            <label>Your name:
                <input type="text" name="user">
            </label>
            <div>
                <input id="ensure-save-picture-button" type="submit" value="SAVE" onclick=savedata()>
                <button id="cancel-save-picture" onclick="return cancelSave()">CANCEL</button>
            </div>
            <input style="display:none" id="pdata" type="text" name="data">
        </form>
    </div>
    <script>
    let mycanvas=document.getElementById("myCanvas");
    let data = null;
    let myimage = new Image();

    function savedata() {
        data=mycanvas.toDataURL();
        document.getElementById("pdata").value=data;
    }

    function gett() {  
        myimage.src="<?php echo $img[0] ?>";
        mycanvas.width = myimage.width;
        mycanvas.height = myimage.height;
        mycanvas.getContext("2d").drawImage(myimage, 0, 0);
    }

    function savePicture() {
        let blackBackground = document.getElementById("black-background");
        let savePictureWindow = document.getElementById("save-picture-window");
        blackBackground.style.visibility = "visible";
        savePictureWindow.style.visibility = "visible";
    }

    function cancelSave() {
        let blackBackground = document.getElementById("black-background");
        let savePictureWindow = document.getElementById("save-picture-window");
        blackBackground.style.visibility = "hidden";
        savePictureWindow.style.visibility = "hidden";
        return false;
    }
    </script>
    <script src="js/main.js"></script>
    <script src="js/script.js"></script>
    <script src="js/sync.js"></script>
</body>
</html>