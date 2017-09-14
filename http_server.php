<?php

use Swoole\Http\Server;

$http = new Server("127.0.0.1", 9501);

// you must set task_worker_num before use task worker
// $http->set([
//     'task_worker_num' => 4
// ]);

$http->on("start", function (Server $server) {
    echo "Swoole http server is started at http://127.0.0.1:9501\n";
    // don't define any global variables here
});

$http->on("workerStart", function (Server $server, int $worker_id) {
    echo "worker start id: {$worker_id}\n";
    echo 'taskworker: ' . json_encode($server->taskworker) . "\n";
    // not allowed in osx
    // swoole_set_process_name('process name');
});

$http->on("workerStop", function (Server $server, int $worker_id) {
    // The abnormal stop of worker process will not trigger the event workerstop, for example, fatal error, core dump
});

$http->on("connect", function (Server $server, int $fd, int $from_id) {
    // echo json_encode($server) . "\n";
    global $globalServer;
    $globalServer = $server;
});

$http->on("task", function (Server $server, $task_id, $from_id, $data) {
    // task worker received data
    echo "task received:" . json_encode($data) . "\n";
    return $data;
});

$http->on("finish", function (Server $server, $task_id, $data) {
    // task worker callback
    echo "task finished:" . json_encode($data) . "\n";
});

$http->on("request", function ($request, $response) {
    // echo json_encode($request);
    // forget php magic functions
    // echo json_encode($_GET);

    // task worker demo
    // global $globalServer;
    // $data = [
    //     'code' => 'ok',
    //     'error' => false,
    //     'payload' => 'Hello World'
    // ];
    // $globalServer->task($data);
    $response->header("Content-Type", "text/html");
    $response->end("Hello World!");
});

$http->start();