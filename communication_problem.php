<?php

use Swoole\Http\Server;

$http = new Server("127.0.0.1", 9501);

$http->set([
    'worker_num' => 4
]);

$http->on("start", function ($server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
});

$http->on("workerStart", function (Server $server, int $worker_id) {
    echo "worker start id: {$worker_id}\n";
});

$i = 1;

// https://wiki.swoole.com/wiki/page/498.html
$http->on("request", function ($request, $response) {
    global $i;
    $response->header("Content-Type", "text/html");
    $response->end($i);
    echo $i . "\n";
    $i++;
});

$http->start();