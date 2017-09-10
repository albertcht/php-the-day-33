<?php

$http = new Swoole\Http\Server("127.0.0.1", 9501);

$http->on("start", function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$data = [
  'code' => 'ok',
  'error' => false,
  'payload' => 'Hello World'
];

$http->on("request", function ($request, $response) use ($data) {
    $response->header("Content-Type", "application/json");
    $response->end(json_encode($data));
});

$http->start();