// websocket connection & uuid
    var duuid = uuid(8, 16);
    // localhost
    var ws = new WebSocket("ws://localhost:8080");
    // uq server
    // var ws = new WebSocket("wss://s4523761-fableous.uqcloud.net");

// other device to sync
        var cuxi;
        var yanse;
        var x1;
        var y1;
        var z_shape;

        function drawing(x, z, y) {
                ctx.lineWidth = cuxi;
                ctx.strokeStyle = yanse;
                drawLine(x, z, y);
            }
        function click1(x, y) {
                ctx.lineWidth = cuxi; 
                ctx.fillStyle = yanse;
                ctx.beginPath();
                ctx.arc(x, y, ctx.lineWidth / 2, 0, Math.PI * 2);
                ctx.fill();
            }
        function cleaning(x, z, y) {
                ctx.lineWidth = cuxi;
                ctx.strokeStyle = "white";
                drawLine(x, z, y);
            }
        function fillC() {
                ctx.fillStyle=fengg;
                fillCanvas(canvas, ctx, data.x, data.y, fengg);
        }
        function rectangle1(x1, y1, x2, y2,z) {
                ctx.lineWidth = cuxi; 
                ctx.strokeStyle = yanse;
                ctx.save();
                ctx.beginPath();
                chosenShape1=z;

                if (chosenShape1 === "rectangle") {
                    ctx.strokeRect(x1, y1, x2 - x1, y2 - y1); // 绘制矩形
                } else if (chosenShape1 === "triangle") {
                    ctx.moveTo(Math.round((x1 + x2) / 2), y1);
                    ctx.lineTo(x1, y2);
                    ctx.lineTo(x2, y2);
                    ctx.lineTo(Math.round((x1 + x2) / 2), y1);
                    ctx.stroke();
                } else if (chosenShape1 === "circle") {
                    let radius = Math.round(Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2)));
                    ctx.arc(x1, y1, radius,0,2 * Math.PI);
                    ctx.stroke();
                }
            
                ctx.restore();
                ctx.closePath();
        }
        function textInputf(x,y,z) {
            ctx.fillStyle = yanse;
            ctx.textAlign = "left";
            ctx.font = "18px Arial";
            ctx.fillText(z, x, y);
        }
  
        ws.onopen = function(e) {
                console.log('Connection to server successfully');
                sendMessage(duuid, 0, 0, 0, 0);
            }

        function sendMessage(uuid, type, x, z, y) {
                ws.send(JSON.stringify({
                    "uuid": uuid,
                    "type": type,
                    "x": x,
                    "z": z,
                    "y": y
                }));
            }

        ws.onmessage = function(e) {
                var data = JSON.parse(e.data);
                if (data.type === 1) {
                    console.log("responding for debug");
                } else if (data.type === 2) {
                    drawing(data.x, data.z, data.y);
                } else if (data.type === 3) {
                    cleaning(data.x, data.z, data.y);
                } else if (data.type === 4) {
                    click1(data.x, data.y);
                } else if (data.type === 5) {
                    initialFill();
                } else if (data.type === 6) {
                    cuxi = data.x;
                } else if (data.type === 7) {
                    fillCanvas(canvas, ctx, data.x, data.y, data.z);
                } else if (data.type === 8) {
                    yanse = data.x;
                } else if (data.type === 9) {
                    x1=data.x["x"];
                    y1=data.x["y"];
                    z_shape=data.z;
                } else if (data.type === 10) {
                    rectangle1(x1,y1,data.x["x"],data.x["y"],z_shape);
                    z_shape=null;
                } else if (data.type === 11) {
                    textInputf(data.x,data.x,data.z);
                }
            }

        function uuid(len, radix) {
                var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.split('');
                var uuid = [],
                    i;
                radix = radix || chars.length;
                if (len) {
                    // Compact form
                    for (i = 0; i < len; i++) uuid[i] = chars[0 | Math.random() * radix];
                } else {
                    // rfc4122, version 4 form
                    var r;
                    // rfc4122 requires these characters
                    uuid[8] = uuid[13] = uuid[18] = uuid[23] = '-';
                    uuid[14] = '4';
                    // Fill in random data. At i==19 set the high bits of clock sequence as
                    // per rfc4122, sec. 4.1.5
                    for (i = 0; i < 36; i++) {
                        if (!uuid[i]) {
                            r = 0 | Math.random() * 16;
                            uuid[i] = chars[(i == 19) ? (r & 0x3) | 0x8 : r];
                        }
                    }
                }
                return uuid.join('');
            }
