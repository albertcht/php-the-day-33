<?php

use Swoole\Table;

$table = new Table(1024);
$table->column('id', swoole_table::TYPE_INT, 4);
$table->column('name', swoole_table::TYPE_STRING, 64);
$table->column('num', swoole_table::TYPE_FLOAT);
$table->create();

$s = microtime(true);
$table->set('tianfenghan@qq.com', array('id' => 145, 'name' => 'rango', 'num' => 3.1415));
$table->set('350749960@qq.com', array('id' => 358, 'name' => "Rango1234", 'num' => 3.1415));
$table->set('hello@qq.com', array('id' => 189, 'name' => 'rango3', 'num' => 3.1415));
$table->set('tianfenghan@qq.com', array('id' => 145, 'name' => 'rango', 'num' => 3.1415));
$table->set('350749960@qq.com', array('id' => 358, 'name' => "Rango1234", 'num' => 3.1415));
echo "set 5 rows using: ".((microtime(true) - $s) * 1000)."ms\n";

$s = microtime(true);
$ret1 = $table->get('350749960@qq.com');
$ret2 = $table->get('tianfenghan@qq.com');
$ret3 = $table->get('350749960@qq.com');
$ret4 = $table->get('tianfenghan@qq.com');
$ret5 = $table->get('hello@qq.com');
echo "get 5 rows using: ".((microtime(true) - $s) * 1000)."ms\n";