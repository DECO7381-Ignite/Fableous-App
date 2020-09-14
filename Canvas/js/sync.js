// websocket connection & uuid
    var duuid = uuid(8, 16);
    var ws = new WebSocket("ws://localhost:8080");
    // uq server
    // var ws = new WebSocket("wss://s4523761-fableous.uqcloud.net");

// other device to sync
        var cuxi;
        var yanse;

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
