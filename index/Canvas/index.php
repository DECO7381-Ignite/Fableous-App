<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fabelous</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="main-part">
        <div class="header">
            <div id="temp-1">
              <section class="user"><img src="icon/user.svg" alt="user_icon"></section>
              <section class="status"><p>DRAWING</p></section>
            </div>
            <div id="temp-2">
              <section class="comment-button"><img src="icon/comment.svg" alt="comment icon"></section>
              <section class="home-button"><a style="text-decoration:none;color:black;" href="../index.php"><img src="icon/home.svg" alt="home icon"></a></section>
            </div>
        </div>
        <div id="main-body">
          <div id="main-body-inside">
            <section id="show-toolBox-button">Tool
            </section>
            <div id="toolBox">
              <section id="temp-toolBox">
                <div id="choose" class="toolBox-buttons"><img src="icon/choose.svg" alt="choose icon"></div>
                <div id="pencil" class="toolBox-buttons"><img src="icon/pencil.svg" alt="pencil icon"></div>
                <div id="eraser" class="toolBox-buttons"><img src="icon/eraser.svg" alt="eraser icon"></div>
                <div id="rectangle" class="toolBox-buttons"><img src="icon/rectangle.svg" alt="rectangle icon"></div>
                <div id="triangle" class="toolBox-buttons"><img src="icon/triangle.svg" alt="triangle icon"></div>
                <div id="circle" class="toolBox-buttons"><img src="icon/circle.svg" alt="circle icon"></div>
                <div id="fill" class="toolBox-buttons"><img src="icon/fill.svg" alt="fill icon"></div>
                <div id="color-pad-button" class="toolBox-buttons"><div></div><section id="chosen-color"></section></div>
                <div id="clear" class="toolBox-buttons"><img src="icon/clear.svg" alt="clear icon"></div>
              </section>
            </div>
            <div id="canvas-box">
                <canvas id="myCanvas"></canvas>
            </div>
            <div id="re-un-button">
                <div id="undo"><a onclick="undo()"><img src="icon/undo.svg" alt="undo icon"></a></div>
                <div id="redo"><a onclick="redo()"><img src="icon/redo.svg" alt="redo icon"></a></div>
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
                <div id="line_weight_display"></div>
            </div>
          </div>
        </div>

        <!-- <form>
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
        -->

        <div class="footer">
            <div id="back-button"><p>&lt; Previous Page</p></div>
            <div id="page-number"><p>Page 1</p></div>
            <div id="next-button"><p>Next Page &gt;</p></div>
        </div>
    </div>

    <!-- hidden this part to avoid error

    The sychronize part need the pages both have same function,
    thus, we need to let the pages use the same js file,
    but the DOM elements of the pages are different,
    which would produce errors.
    Thus, we keep the both pages have all the elements to avoid errors,
    and hide them.
    -->
    <section class="hidden-part">
      <div class="main-part">
          <div class="header">
              <div id="temp-1">
                <section class="user"><img src="icon/user.svg" alt="user_icon"></section>
                <section class="status"><p>DRAWING</p></section>
              </div>
              <div id="temp-2">
                <section class="comment-button"><img src="icon/comment.svg" alt="comment icon"></section>
                <section class="home-button"><a style="text-decoration:none;color:black;" href="../index.php"><img src="icon/home.svg" alt="home icon"></a></section>
              </div>
          </div>
          <div id="main-body">
            <div id="main-body-inside">
              <section id="show-toolBox-button">Tool
              </section>
              <div id="toolBox">
                <section id="temp-toolBox">
                  <div id="choose" class="toolBox-buttons"><img src="icon/choose.svg" alt="choose icon"></div>
                  <div id="text" class="toolBox-buttons"><img src="icon/text.svg" alt="text icon"></div>
                  <div id="eraser" class="toolBox-buttons"><img src="icon/eraser.svg" alt="eraser icon"></div>
                  <div id="mic" class="toolBox-buttons"><img src="icon/mic.svg" alt="mic icon"></div>
                  <div id="color-pad-button" class="toolBox-buttons"><section id="chosen-color"></section></div>
                </section>
              </div>

              <div id="canvas-box">
                  <canvas id="myCanvas"></canvas>
              </div>

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

              <div id="pages">
                  <div id="pages-child-01">
                      <div id="page-1" class="page-list"></div>
                  </div>
                  <button id="add-page">+</button>
              </div>
            </div>
          </div>

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
    </section>
    <!-- <script src="js/main.js"></script> -->
    <script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
    </script>
    <script src="js/script.js"></script>
    <script src="js/sync.js"></script>
    <script src="js/addPage.js"></script>
    <script src="js/undo.js"></script>
</body>
</html>
