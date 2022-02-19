<?php
/*
 * MIT License
 *
 * Copyright (c) 2022 NemeaQ
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

use Workerman\Worker;
use app\lib\CardWorker;

error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();

require 'CardWorker.php';

require_once __DIR__ . '/../../vendor/autoload.php';

$wsWorker = new Worker('websocket://0.0.0.0:7777');
$wsWorker->count = 4;

//$cardDorker = new CardWorker();

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

            $cardDorker->date = $arg[1];
            //$cardDorker->connection = $clientConnection;
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

