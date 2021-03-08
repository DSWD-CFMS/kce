var socket  = require('socket.io'),
   express = require('express'),
    https   = require('https'),
    http    = require('http'),
    logger  = require('winston'),
    port    = 3011,
    users = {};

logger.remove(logger.transports.Console);
logger.add(logger.transports.Console, { colorize: true, timestamp: true } );
logger.info(' Currently listening on port ' + port);

var app = express();
var http_server = http.createServer(app).listen(port); 

function emitNewEvent(http_server){

    var io = socket.listen(http_server);

    io.sockets.on('connection', function (socket){
        var user_id;
        // Update_User_Array();
        
        socket.on("Signed_In", function(data){
            console.log("Signed_In");
            console.log(data);
            console.log("Signed_In");
        });

        socket.on("New_User", function(data, callback){
            user_id = data;
            if(data in users){
                callback(false);
            }else{
                callback(true);
                socket.nickname = data;
                users[socket.nickname] = socket;
                Update_User_Array();
            }
        });

        // socket.on("DAC_Updates", function(data, callback){console.log(data[0].id);
            
        //     // io.emit("DAC_Updates", {event: data, nick: socket.nickname});
        //     if(Object.keys(users).includes(data[0]['id'].toString()) == true){
        //         // if true e-fire ang event para ma recieve dayun sa online nga user nga recepient
        //         users[data[0]['id']].emit('DAC_Updates', {event: data, nick: socket.nickname});
        //     }else{};
        // });


        function Update_User_Array(){
            io.sockets.emit('usernames', Object.keys(users));
            console.log(Object.keys(users));
        }

        socket.on('disconnect', function(data){
            console.log('Signed Out');
            if(!socket.nickname) return;
            delete users[socket.nickname];
            Update_User_Array();
        });

    });

}
emitNewEvent(http_server);
