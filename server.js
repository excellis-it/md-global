const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const io = require('socket.io')(server, {
    cors: {
        origin: '*',
    },
});

let onlineUsers = {};

io.on('connection', (socket) => {
    console.log('a user connected', socket.id);

    // Handle user connection
    socket.on('userConnected', (userId) => {
        onlineUsers[userId] = socket.id;
        io.sockets.emit('userOnline', userId);
        console.log('User connected:', userId);

        // Emit the updated list of online users
        io.sockets.emit('onlineUsers', Object.keys(onlineUsers));
    });

    // Handle user disconnection
    socket.on('disconnect', () => {
        const userId = Object.keys(onlineUsers).find(key => onlineUsers[key] === socket.id);
        if (userId) {
            delete onlineUsers[userId];
            io.sockets.emit('userOffline', userId);
            console.log('User disconnected:', userId);

            // Emit the updated list of online users
            io.sockets.emit('onlineUsers', Object.keys(onlineUsers));
        }
    });

    // Chat message
    socket.on('chat', (msg) => {
        console.log('message: ' + msg);
        io.sockets.emit('chat', msg);
    });

    // Sent friend request
    socket.on('sentFriendRequest', (msg) => {
        console.log('sentFriendRequest: ' + msg);
        io.sockets.emit('sentFriendRequest', msg);
    });

    // Confirm friend request
    socket.on('confirmFriendRequest', (msg) => {
        console.log('confirmFriendRequest: ' + msg);
        io.sockets.emit('confirmFriendRequest', msg);
    });

    // Reject friend request
    socket.on('rejectFriendRequest', (msg) => {
        console.log('rejectFriendRequest: ' + msg);
        io.sockets.emit('rejectFriendRequest', msg);
    });
    // videoCall
    socket.on('videoCall', (msg) => {
        console.log('videoCall: ' + msg);
        io.sockets.emit('videoCall', msg);
    });
});

server.listen(3000, () => {
    console.log('listening on *:3000');
});
