<?php

use app\lib\WebSocketServer;
use app\lib\CardWorker;

error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();

require 'WebSocketServer.php';
require 'CardWorker.php';

$server = new WebSocketServer('192.168.0.2', 7777);
// максимальное время работы 100 секунд, выводить сообщения в консоль
$server->settings(100, true);

// эта функция вызывается, когда получено сообщение от клиента
$server->handler = function($connect, $data) {
    $arg = preg_split('/\s+/', $data);
    $this->response($this->connect, $arg);
    switch ($arg[0]) {
        case 'start':
            $cardDorker = new CardWorker($arg[1], $connect);

            $cardDorker->enabled = true;
            $cardDorker->useBaseNow = $arg[2] == "true";
            $cardDorker->start();
            break;
        case 'auth':
            break;
    }
};

$server->startServer();