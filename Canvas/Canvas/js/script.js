/* https://juejin.im/post/6844903692747948039 */

//获取页面元素，并声明变量
let canvas = document.getElementById("myCanvas");
let eraser = document.getElementById("eraser");
let clear = document.getElementById("clear");
let pencil = document.getElementById("pencil");
let ctx = canvas.getContext("2d");
let rangeValue = document.getElementById("slider");

canvas.width = document.getElementById("canvas-box").offsetWidth;
canvas.height = document.getElementById("canvas-box").offsetHeight;

ctx.lineJoin = "round";
ctx.lineCap = "round";

let painting = false;
let lastPoint = null;
let points = [];

var toolBox = {"pencil" : "1", "eraser" : "0"};
var stylus = 2;
//绑定canvas的鼠标点击，鼠标移动，鼠标松开事件
canvas.addEventListener("mousedown", down, false);
canvas.addEventListener("mousemove", move, false);
canvas.addEventListener("mouseup", up, false);

//定义鼠标的点击事件函数
function down(e) {
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
}

//定义鼠标的移动事件的函数
function move(e) {
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

        //不同工具的鼠标移动事件
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
}

//鼠标松开事件
function up(e) {
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
}

//获取鼠标的坐标
function getPoints(e) {
    let rect = canvas.getBoundingClientRect();
    return {
        x : e.clientX - rect.left,
        y : e.clientY - rect.top,
    }
}

//根据坐标画曲线
function drawLine(begin, control, end) {
    ctx.beginPath();
    ctx.moveTo(begin.x, begin.y);
    ctx.quadraticCurveTo(control.x, control.y, end.x, end.y);
    ctx.stroke();
    ctx.closePath();
}

//鼠标离开canvas事件
canvas.onmouseleave = function () {
    painting = false;
};

//点击pencil按钮
pencil.onclick = function () {
    ctx.strokeStyle = "#000000";
    stylus = 2;
};

//点击eraser按钮
eraser.onclick = function () {
    ctx.strokeStyle = "#ffffff";
    stylus = 3;
};

//点击clear按钮
clear.onclick = function () {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    sendMessage(duuid, 5, 0, 0, 0);
};

rangeValue.oninput = function () {
    ctx.lineWidth = rangeValue.value / 100 * 30;
    console.log(ctx.lineWidth);
    sendMessage(duuid, 6, ctx.lineWidth, 0, 0);
};