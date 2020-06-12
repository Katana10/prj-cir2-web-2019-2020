'use strict'

// let websocket;
// let login = prompt("Entrez votre nom d'utilisateur");

// createWebSocket();

// function createWebSocket()
// {
//     websocket = new WebSocket('ws://localhost:12345');

//     $('#chat-send').submit(sendMessage);

//     websocket.onmessage = (event) =>
//     {
//         let textArea;

//         textArea = $('#chat-room');
//         textArea.val(textArea.val() + event.data + '\n');
//         textArea.scrollTop(textArea.prop('scrollHeight'));
//     };
// }

// function sendMessage(event){

//     event.preventDefault();

//     websocket.send(login + " : " + $('#chat-message').val());
//     $('#chat-message').val('');
// }

