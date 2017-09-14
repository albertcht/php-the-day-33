<?php

use Swoole\Async;

// you can configure your async settings here.
Async::set([
    'aio_mode' => SWOOLE_AIO_BASE,
    'thread_num' => 2,
]);

Async::readfile(__DIR__ . "/file.txt", function ($filename, $content) {
     echo "$filename: $content\n";
});

// If the aio mode setted by swoole_async_set is SWOOLE_AIO_LINUX, the method can't support append content to the end of file and must set the value of $fileContent to integer multiples of 4096.
Async::writeFile(__DIR__ . "/file.log", "test\n", function ($filename) {
    echo "wirte ok.\n";
}, $append = false);

Async::read(__DIR__ . "/file.txt", function ($filename, $content) {
    echo "file: $filename\ncontent-length: " . strlen($content) . "\nContent: $content\n";
    if (empty($content)) {
        echo "file is end.\n";
        return false;
    } else {
        return true;
    }
}, 4);

 // If the aio mode setted by swoole_async_set is SWOOLE_AIO_LINUX, the method can't support append content to the end of file and must set the value of $content and $offset to integer multiples of 512. Otherwise the call of this method will fail and set the error code to EINVAL.
for ($i = 0; $i < 10; $i++) {
    Async::write(__DIR__ . "/file.log", "A\n", -1, function ($file, $writen) {
        echo "write $file [$writen]\n";
        //return true: write contine. return false: close the file.
        return true;
    });
}