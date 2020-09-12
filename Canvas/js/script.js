
// hide rate and pitch values
document.getElementById("rate").style.display = "none";
document.getElementById("pitch").style.display = "none";


// 获取页面元素，并声明变量
let canvas = document.getElementById("myCanvas");
let ctx = canvas.getContext("2d");

let choose = document.getElementById("choose");
let pencil = document.getElementById("pencil");
let eraser = document.getElementById("eraser");
let fill = document.getElementById("fill");
let clear = document.getElementById("clear");

let rangeValue = document.getElementById("slider");

canvas.width = Math.floor(document.getElementById("canvas-box").offsetWidth - 4);
canvas.height = Math.floor(document.getElementById("canvas-box").offsetHeight - 4);

ctx.lineJoin = "round";
ctx.lineCap = "round";

let painting = false;
let lastPoint = null;
let points = [];

const toolBox = ["choose", "pencil", "fill"];
let chosenTool = toolBox[1];
let stylus = 2;

// 绑定canvas的鼠标点击，鼠标移动，鼠标松开事件
canvas.addEventListener("mousedown", down, false);
canvas.addEventListener("mousemove", move, false);
canvas.addEventListener("mouseup", up, false);
// 上来先把画布全涂白，而不是默认的(0,0,0,0) - 透明黑
initialFill();


/** 鼠标三事件 */

// 定义鼠标的点击事件函数
function down(e) {
    if (chosenTool === toolBox[1]) { // 画笔模式
        painting = true;
        let {x, y} = getPoints(e);
        points.push({x, y});
        lastPoint = {x, y};

        rangeValue.oninput(); // 画之前统一成与此页条设置一样的粗细
        ctx.beginPath();
        ctx.arc(lastPoint.x, lastPoint.y, ctx.lineWidth / 2, 0, Math.PI * 2);
        ctx.fillStyle = ctx.strokeStyle;
        ctx.fill();
        sendMessage(duuid, 4, x, 0, y);
    } else if (chosenTool === toolBox[2]) { // 填充模式
        // pass
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
            rangeValue.oninput(); // 画之前统一成与此页条设置一样的粗细

            // 不同工具的鼠标移动事件
            // if (toolBox["pencil"] === "1") {
            drawLine(lastPoint, controlPoint, endPoint);
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
        fillCanvas(canvas, ctx, x, y, ctx.fillStyle)
    }

}


/** 画笔相关 */

// 获取鼠标的坐标
function getPoints(e) {
    let rect = canvas.getBoundingClientRect();
    return {
        x : e.clientX - rect.left,
        y : e.clientY - rect.top,
    }
}

// 根据坐标画曲线
function drawLine(begin, control, end) {
    ctx.beginPath();
    ctx.moveTo(begin.x, begin.y);
    ctx.quadraticCurveTo(control.x, control.y, end.x, end.y);
    ctx.stroke();
    ctx.closePath();
}

// 鼠标离开canvas事件
canvas.onmouseleave = function () {
    painting = false;
};


/** 填充相关 */

function initialFill() {
    ctx.fillStyle = "#FFFFFF"; // 先用纯白涂满画布
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = "#000000"; // 再把fillStyle改回默认黑
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
    let fillingColor = hexToRGB("#FF0000"); // should be newColor, FF0000 for testing
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


/** 工具箱按钮相关 */

// 点击choose按钮
choose.onclick = function () {
    chosenTool = toolBox[0];
}

// 点击pencil按钮
pencil.onclick = function () {
    ctx.strokeStyle = "#000000";
    stylus = 2;
    chosenTool = toolBox[1]; // pencil
};

// 点击eraser按钮
eraser.onclick = function () {
    ctx.strokeStyle = "#ffffff";
    stylus = 3;
    chosenTool = toolBox[1]; // pencil
};

// 点击fill按钮
fill.onclick = function () {
    chosenTool = toolBox[2];
}


// 点击clear按钮
clear.onclick = function () {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    sendMessage(duuid, 5, 0, 0, 0);
};

rangeValue.oninput = function () {
    ctx.lineWidth = rangeValue.value / 100 * 40;
    if (ctx.lineWidth < 3) {
        ctx.lineWidth = 3;
    }
    sendMessage(duuid, 6, ctx.lineWidth, 0, 0);
};

//'hide rate and pitch' I've move to top of this file to prevent canvas size error :D  -- Berry