<?php

namespace app\controllers;

use app\core\Controller;
use app\lib\SocketServer;

/**
 * Class ApiController
 * @package app\controllers
 */
class ApiController extends Controller
{
    /**
     * @param mixed $route
     *
     * @return void
     */
    public function __construct($route)
    {
        $this->acl = [
            'all' => ['cardSocket'],
            'authorize' => [],
            'guest' => [],
            'admin' => ['status'],
        ];
        parent::__construct($route);
    }

    /**
     * Возвращает статус сервева базы данных
     */
    public function statusAction()
    {

    }

    public function cardSocketAction(){
        
    }
}

