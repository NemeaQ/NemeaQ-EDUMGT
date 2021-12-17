<?php

namespace content\controllers;

use engine\core\Controller;
use content\libs\SocketServer;

/**
 * Class ApiController
 * @package content\controllers
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

