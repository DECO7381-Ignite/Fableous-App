
// document.body.addEventListener('touchmove', function (e) {
//     e.preventDefault(); //阻止默认的处理方式(阻止下拉滑动的效果)
//   }, {passive: false}); //passive 参数不能省略，用来兼容ios和android

// // hide rate and pitch values
// document.getElementById("rate").style.display = "none";
// document.getElementById("pitch").style.display = "none";

// 获取页面元素，并声明变量
let canvas = document.getElementById("myCanvas");
let ctx = canvas.getContext("2d");

let choose = document.getElementById("choose");
let pencil = document.getElementById("pencil");
let eraser = document.getElementById("eraser");
let fill = document.getElementById("fill");
let rectangle = document.getElementById("rectangle");
let triangle = document.getElementById("triangle");
let circle = document.getElementById("circle");
let clear = document.getElementById("clear");
let adjustSize = document.getElementById("adjust-size");
let colorPanel = document.getElementById("color-pad");
let colorPanelButton = document.getElementById("color-pad-button");
let onOffColorPanel = false;
let theStoryText = "";
var pagesData = new Array();
// var uuju; //数据(双拼),image data

// // input text
let inputTextButton = document.getElementById("text");
inputTextButton.isTexting = false;

let colors = [];
for (let c = 0; c < 12; c++) {
    colors.push(document.getElementById("c" + c));
    colors[c].onclick = function () { // 点击色块
        ctx.fillStyle = window.getComputedStyle(this).backgroundColor; // 改变fillStyle
        ctx.strokeStyle = ctx.fillStyle;
        chosenColor.childNodes[0].style.opacity = "0"; // 隐藏先前选色的✅
        this.childNodes[0].style.opacity = "1"; // 显示当前选色的✅
        chosenColor = this;
        sendMessage(duuid,8,ctx.strokeStyle,0,0); // send 画笔颜色
        document.getElementById("chosen-color").style.backgroundColor = getComputedStyle(colors[c], null)['backgroundColor'];
    }
}
let chosenColor = colors[11]; // 默认选择黑色showHideSMT(colorPanel, "hide", "none");
let rangeValue = document.getElementById("slider");


canvas.width = Math.floor(document.getElementById("canvas-box").offsetWidth - 4);
canvas.height = Math.floor(document.getElementById("canvas-box").offsetHeight - 4);

ctx.lineJoin = "round";
ctx.lineCap = "round";

let painting = false;
let lastPoint = null;
let points = [];
let isDrawingShape = false;
let shapingVar = {"startP": null, "endP":null, "originalImage": null};

const toolBox = ["choose", "pencil", "fill", "shaping"];
let chosenTool = toolBox[0];
let stylus = 2; //联动 send 判断eraser or pencil
let chosenShape = null;

// 绑定canvas的鼠标点击，鼠标移动，鼠标松开事件
canvas.addEventListener("mousedown", down, false);
canvas.addEventListener("mousemove", move, false);
canvas.addEventListener("mouseup", up, false);

// touch event relevant
canvas.addEventListener("touchstart", touchDown, false);
canvas.addEventListener("touchmove", touchMove, false);
canvas.addEventListener("touchend", touchUp, false);

let pointForTouchUp = {"clientX": 0, "clientY": 0};

function touchDown(e) {
    e = e.touches[0]; // get the first touch point event info
    down(e);
}

function touchMove(e) {
    e = e.touches[0]; // get the first touch point event info
    move(e);
    pointForTouchUp = [e.clientX, e.clientY]; // touchEnd event has no position info so we save point info here.
}

function touchUp(e) {
    e = pointForTouchUp; // get point info from last move record
    up(e);
}

// 上来先把画布全涂白，而不是默认的(0,0,0,0) - 透明黑
initialFill();

ctx.lineWidth = 3; // initializing the line width

/* text input */
let textWindow = document.createElement("div");
textWindow.id = "text.window";
textWindow.style.position = "absolute";
textWindow.style.visibility = "hidden";
let textContent = document.createElement("input");
textContent.type = "text";
textContent.id = "text-content";
let confirmText = document.createElement("button");
confirmText.id = "confirm-content";
confirmText.innerText = "confirm";

document.body.appendChild(textWindow);
textWindow.appendChild(textContent);
textWindow.appendChild(confirmText);

/** 鼠标三事件 */

// 定义鼠标的点击事件函数
function down(e) {
    if (chosenTool === toolBox[1]) { // 画笔模式
        painting = true;
        let {x, y} = getPoints(e);
        points.push({x, y});
        lastPoint = {x, y};

        // 画之前统一成与此页条设置一样的粗细, 颜色.
        rangeValue.oninput();
        if (stylus === 2){
            chosenColor.onclick();
        } else if (stylus === 3) {
            ctx.fillStyle = "#ffffff";
        }

        ctx.beginPath();
        ctx.arc(lastPoint.x, lastPoint.y, ctx.lineWidth / 2, 0, Math.PI * 2);
        ctx.fill();
        // send 点击事件
        sendMessage(duuid, 4, x, 0, y);
    } else if (chosenTool === toolBox[2]) { // 填充模式
        // pass
    } else if (chosenTool === toolBox[3]) { // 形状模式
        shapingVar.startP = getPoints(e);
        isDrawingShape = true;
        // 记录初始画布
        shapingVar.originalImage = ctx.getImageData(0, 0, canvas.width, canvas.height);
    }
    if (inputTextButton.isTexting) {
        let tx = e.clientX;
        let ty = e.clientY;
        let {x, y} = getPoints(e);
        textWindow.style.left = tx + "px";
        textWindow.style.top = ty + "px";
        textWindow.style.visibility = "visible";

        confirmText.onclick = function () {
            ctx.textAlign = "left";
            ctx.font = "18px Arial";
            ctx.fillText(textContent.value, x, y);
            sendMessage(duuid,11, x,textContent.value,y);
            theStoryText = theStoryText + ". " + textContent.value;
            textContent.value = "";
            textWindow.style.visibility = "hidden";
        }
    }
}

// 定义鼠标的移动事件的函数
function move(e) {
    if (chosenTool === toolBox[1]) { // 画笔模式
        if (!painting) return;

        let {x, y} = getPoints(e);
        points.push({x, y});

        if (points.length >= 3) {
            //使用拉塞尔函数，使线条更丝滑
            let lastTwoPoints = points.slice(-2);
            let controlPoint = lastTwoPoints[0];
            let endPoint = {
                x: (controlPoint.x + lastTwoPoints[1].x) / 2,
                y: (controlPoint.y + lastTwoPoints[1].y) / 2,
            };
            // 画之前统一成与此页条设置一样的cuxi, yanse.
            rangeValue.oninput();
            if (stylus === 2){
                chosenColor.onclick();
            } else if (stylus === 3) {
                ctx.strokeStyle = "#ffffff";
            }

            // 不同工具的鼠标移动事件
            // if (toolBox["pencil"] === "1") {
            drawLine(lastPoint, controlPoint, endPoint);
            // send 画还是擦
            sendMessage(duuid, stylus, lastPoint, controlPoint, endPoint);
            // } else if (toolBox["eraser"] === "1") {
            //     ctx.save();
            //     ctx.beginPath();
            //     ctx.arc(e.clientX, e.clientY, 5, 0, 2*Math.PI);
            //     ctx.clip();
            //     ctx.clearRect(0,0,canvas.width,canvas.height);
            //     ctx.restore();
            // }
            lastPoint = endPoint;
        }
    } else if (chosenTool === toolBox[2]) { // 填充模式
        // pass
    } else if (chosenTool === toolBox[3]) { // 矩形模式
        if (isDrawingShape) {
            shaping(shapingVar.startP["x"], shapingVar.startP["y"],
                getPoints(e)["x"], getPoints(e)["y"]);
            shapingVar.endP = getPoints(e);
            sendMessage(duuid,9,shapingVar.startP,chosenShape);
        }
    }
}

// 鼠标松开事件
function up(e) {
    if (chosenTool === toolBox[1]) { // 画笔模式
        if (!painting) return;

        let {x, y} = getPoints(e);
        points.push({x, y});

        if (points.length >= 3) {
            let lastTwoPoints = points.slice(-2);
            let controlPoint = lastTwoPoints[0];
            let endpoint = lastTwoPoints[1];
            // drawLine(lastPoint, controlPoint, endpoint); 无用语句
            // sendMessage(duuid, 1, lastPoint,controlPoint,endpoint); 调试用type1
        }
        lastPoint = null;
        painting = false;
        points = [];
    } else if (chosenTool === toolBox[2]) { // 填充模式
        let {x, y} = getPoints(e);
        fillCanvas(canvas, ctx, x, y, ctx.fillStyle);
        // send 填充
        sendMessage(duuid, 7, x, ctx.fillStyle, y);
    } else if (chosenTool === toolBox[3]) { // 矩形模式
        isDrawingShape = false;
        sendMessage(duuid,10,shapingVar.endP,0,0);
    }
}

function updateCanvas(number) {
    pagelists[number].data = canvas.toDataURL();
    pagesData[number].data = canvas.toDataURL();
}

// Change canvas to the page that the Texter chosen
function changeCanvas(number) {
  console.log("Change: " + number);
  let img = new Image();
  img.src = pagesData[number].data;
  img.onload = function () {
      theCanvas.getContext("2d").drawImage(img, 0, 0);
  }
  let n = number + 1;
  $("#page-number>p").html("Page " + n);
}

/** 画笔相关 */
// 获取鼠标的坐标
function getPoints(e) {
    let rect = canvas.getBoundingClientRect();
    return {
        x : Math.round(e.clientX - rect.left),
        y : Math.round(e.clientY - rect.top),
    }
}

// 根据坐标画曲线
function drawLine(begin, control, end) {
    ctx.beginPath();
    ctx.moveTo(begin.x, begin.y);
    ctx.quadraticCurveTo(control.x, control.y, end.x, end.y);
    ctx.stroke();
    ctx.closePath();
    // uuju=ctx.getImageData(0,0,canvas.width,canvas.height); redo研究
}

// 鼠标离开canvas事件
canvas.onmouseleave = function () {
    painting = false;
    // if (isDrawingShape) {
    //     sendMessage(...);
    // }
    isDrawingShape = false;

    // 更新本地储存的canvas数据
    updateCanvas(pageMap.get("currentPage"));
};

/** 填充相关 */

function initialFill() {
    let temp = ctx.fillStyle;
    ctx.fillStyle = "#FFFFFF"; // 先用纯白涂满画布
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = temp; // 再把fillStyle改回去
}

function fillCanvas(canvas, ctx, X, Y, newColor) {
    X = Math.floor(X);
    Y = Math.floor(Y);
    let width = canvas.width;
    let height = canvas.height;

    // 获取所有画布点位信息
    let canvasData = ctx.getImageData(0, 0, width, height);

    // 获取第 Y 行 第 X 列的像素信息
    let i = Y * width + X;
    let colorR = canvasData.data[4 * i];
    let colorG = canvasData.data[4 * i + 1];
    let colorB = canvasData.data[4 * i + 2];

    // 获取填充颜色的RGB数组，如果与目标相同即跳出
    let fillingColor = hexToRGB(newColor);
    if (colorR===fillingColor.R && colorG===fillingColor.G && colorB===fillingColor.B) {
        return;
    }

    // 设置堆栈，堆底默认为起始点
    let stackColumn = [X];
    let stackRow = [Y];
    let c; // column
    let r; // row

    function CheckNewPoint(r, c){
        let n = r * width + c; // 获取点位信息
        let needColorR = canvasData.data[4 * n];
        let needColorG = canvasData.data[4 * n + 1];
        let needColorB = canvasData.data[4 * n + 2];
        // 判断颜色 + 存储种子点: //在判断 颜色 是否是 种子点的颜色
        if( c>=0 && c <= width && r>=0 && r<= height
            && needColorR === colorR && needColorG === colorG && needColorB ===colorB) {
            // 若 符合情况 则将该店改颜色
            canvasData.data[4 * n] = fillingColor.R;
            canvasData.data[4 * n + 1] = fillingColor.G;
            canvasData.data[4 * n + 2] = fillingColor.B;
            // 并压入堆栈
            stackRow.push(r);
            stackColumn.push(c);
        }
    }

    // 非递归种子算法
    while(true){
        if(stackColumn.length <= 0){ // 堆空时跳出
            break;
        }
        c = stackColumn.pop();
        r = stackRow.pop();
        CheckNewPoint(r, c);
        CheckNewPoint(r + 1, c);
        CheckNewPoint(r - 1, c);
        CheckNewPoint(r, c + 1);
        CheckNewPoint(r, c - 1);
        CheckNewPoint(r + 1, c + 1);
        CheckNewPoint(r + 1, c - 1);
        CheckNewPoint(r - 1, c + 1);
        CheckNewPoint(r - 1, c - 1);
        CheckNewPoint(r + 2, c);
        CheckNewPoint(r - 2, c);
        CheckNewPoint(r, c + 2);
        CheckNewPoint(r, c - 2);
        CheckNewPoint(r + 2, c + 2);
        CheckNewPoint(r + 2, c - 2);
        CheckNewPoint(r - 2, c + 2);
        CheckNewPoint(r - 2, c - 2);
    }

    ctx.putImageData(canvasData, 0, 0);
}

/* 转换HEX至RGB，如 "#FFFFFF" 至 {R: 255, G: 255, B: 255} */
function hexToRGB(hex) {
    const shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
    hex = hex.replace(shorthandRegex, function(m, r, g, b) {
        return r + r + g + g + b + b; // 拓展简写的HEX
    });

    let result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        R: parseInt(result[1], 16),
        G: parseInt(result[2], 16),
        B: parseInt(result[3], 16)
    } : null;
}

/** 形状绘制相关 */
function initShaping() {
    initialFill();  // 清空canvas
    ctx.putImageData(shapingVar.originalImage, 0, 0);  // 恢复初始画布
}

function shaping(x1, y1, x2, y2) {
    ctx.save();
    ctx.beginPath();

    self.initShaping();  // 每移动鼠标便清空重画一次矩形，以达到实时预览效果
    if (chosenShape === "rectangle") {
        ctx.strokeRect(x1, y1, x2 - x1, y2 - y1); // 绘制矩形
    } else if (chosenShape === "triangle") {
        ctx.moveTo(Math.round((x1 + x2) / 2), y1);
        ctx.lineTo(x1, y2);
        ctx.lineTo(x2, y2);
        ctx.lineTo(Math.round((x1 + x2) / 2), y1);
        ctx.stroke();
    } else if (chosenShape === "circle") {
        let radius = Math.round(Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2)));
        ctx.arc(x1, y1, radius,0,2 * Math.PI);
        ctx.stroke();
    }

    ctx.restore();
    ctx.closePath();
}


/** 工具箱按钮相关 */
// document.getElementById("undo").onclick=function() {
//     // ctx.putImageData(uuju,0,0); // redo研究
// }

// 点击choose按钮
choose.onclick = function () {
    chosenTool = toolBox[0];
    // turnOffTexting();
    showHideSMT(adjustSize, "hide", "none");
    selectTool($(".toolBox-buttons"), $(this).index());
}

// 点击pencil按钮
pencil.onclick = function () {
    ctx.strokeStyle = ctx.fillStyle;
    stylus = 2;
    chosenTool = toolBox[1]; // pencil
    // turnOffTexting();
    showHideSMT(adjustSize, "show", "block");
    selectTool($(".toolBox-buttons"), $(this).index());
};

// 点击eraser按钮
eraser.onclick = function () {
    ctx.strokeStyle = "#ffffff";
    stylus = 3;
    chosenTool = toolBox[1]; // pencil
    // turnOffTexting();
    showHideSMT(adjustSize, "show", "block");
    selectTool($(".toolBox-buttons"), $(this).index());
};

// 点击fill按钮
fill.onclick = function () {
    chosenTool = toolBox[2];
    chosenColor.onclick();
    showHideSMT(adjustSize, "hide", "none");
    // turnOffTexting();
    selectTool($(".toolBox-buttons"), $(this).index());
}

// 点击rectangle按钮
rectangle.onclick = function () {
    chosenTool = toolBox[3];
    chosenColor.onclick();
    chosenShape = "rectangle";
    // turnOffTexting();
    showHideSMT(adjustSize, "show", "block");
    selectTool($(".toolBox-buttons"), $(this).index());
}

// 点击triangle按钮
triangle.onclick = function () {
    chosenTool = toolBox[3];
    chosenColor.onclick();
    chosenShape = "triangle";
    // turnOffTexting();
    showHideSMT(adjustSize, "show", "block");
    selectTool($(".toolBox-buttons"), $(this).index());
}

// 点击circle按钮
circle.onclick = function () {
    chosenTool = toolBox[3];
    chosenColor.onclick();
    chosenShape = "circle";
    // turnOffTexting();
    showHideSMT(adjustSize, "show", "block");
    selectTool($(".toolBox-buttons"), $(this).index());
}

// 点击clear按钮
clear.onclick = function () {
    initialFill();
    // send clear
    sendMessage(duuid, 5, 0, 0, 0);
    // turnOffTexting();
    showHideSMT(adjustSize, "hide", "none");
    selectTool($(".toolBox-buttons"), $(this).index());
};

// click color panel function
colorPanelButton.onclick = function () {
    if (onOffColorPanel === false) {
      showHideSMT(colorPanel, "show", "flex");
      onOffColorPanel = !onOffColorPanel;
    } else {
      showHideSMT(colorPanel, "hide", "none");
      onOffColorPanel = !onOffColorPanel;
    }
}

// 点击text按钮
inputTextButton.onclick = function () {
    // change to cursor
    chosenTool = toolBox[0];
    selectTool($(".toolBox-buttons"), $(this).index());
    inputTextButton.isTexting = !inputTextButton.isTexting;
    if (!inputTextButton.isTexting) {
        textWindow.style.visibility = "hidden";
    }
}

function turnOffTexting() {
    inputTextButton.isTexting = false;
    textWindow.style.visibility = "hidden";
}

/** 辅助工具相关 */
rangeValue.oninput = function () {
    ctx.lineWidth = Math.round(rangeValue.value / 100 * 40);
    if (ctx.lineWidth < 3) {
        ctx.lineWidth = 3;
    }
    sendMessage(duuid, 6, ctx.lineWidth, 0, 0); // send cuxi
};

function showHideSMT(obj, str1, str2) {
  if (str1 === "show") {
    obj.style.display = str2;
  } else {
    obj.style.display = "none";
  }
}

$(window).on("load", function() {
    selectTool($(".toolBox-buttons"), 0);
});

function selectTool(obj, i) {
    obj.eq(i).css("backgroundColor", "#60A6C8").siblings().css("backgroundColor", "#a6b1bc");
}

let showToolBoxButton = document.getElementById("show-toolBox-button");
let isToolBoxDisplaying = false;
let toolBoxDOM = document.getElementById("toolBox");
showToolBoxButton.onclick = function () {
  if (isToolBoxDisplaying === false) {
    showHideSMT(toolBoxDOM, "show", "flex");
    isToolBoxDisplaying = !isToolBoxDisplaying;
  } else {
    showHideSMT(toolBoxDOM, "hide", "none");
    isToolBoxDisplaying = !isToolBoxDisplaying;
  }
}



//'hide rate and pitch' I've move to top of this file to prevent canvas size error :D  -- Berry

// console.log(); //redo研究
