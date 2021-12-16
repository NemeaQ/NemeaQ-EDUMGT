<?php

use Workerman\Worker;
use app\lib\CardWorker;

error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();

require 'CardWorker.php';

require_once __DIR__.'/../../vendor/autoload.php';

$wsWorker = new Worker('websocket://0.0.0.0:7777');
$wsWorker->count = 4;

$cardDorker = new CardWorker();

$wsWorker->onConnect = function ($connection) {
    echo "New connection\n";
};

$wsWorker->onMessage = function ($connection, $data) use ($wsWorker) {
    foreach ($wsWorker->connections as $clientConnection) {
        $clientConnection->send($data);
        $arg = preg_split('/\s+/', $data);
        switch ($arg[0]) {
            case 'checkSession':

            case 'start':
                $cardDorker = new CardWorker($arg[1], $clientConnection);

                $cardDorker->date = $args[1];
                $cardDorker->connection = $clientConnection;
                $cardDorker->enabled = true;
                $cardDorker->useBaseNow = $arg[2] == "true";
                $cardDorker->start();
                break;
            case 'auth':
                break;
        }

    }
};

$wsWorker->onClose = function ($connection) {
    echo "Connection closed\n";
};

Worker::runAll();

