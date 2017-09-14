<?php

use Swoole\Websocket\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;

$server = new Server("127.0.0.1", 9503);

$server->on("start", function (Server $server) {
    echo "Swoole websocket server is started at ws://127.0.0.1:9503\n";
    // don't define any global variables here
});

// $server->on("handshake", function (Request $request, Response $response) {
//     // you can choose to implement your handshake method
//     // see https://wiki.swoole.com/wiki/page/409.html
// });

$server->on("open", function (Server $server, $request) {
    // echo json_encode($request) . "\n";
    echo "server: handshake success with fd{$request->fd}\n";
});

$server->on("message", function (Server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data}, opcode:{$frame->opcode}, fin:{$frame->finish}\n";
    $server->push($frame->fd, "this is server");
});

$server->on("close", function (Server $server, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();