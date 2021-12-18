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

    public $routes = [
        /** Route                       => Controller Action */
        /** API */
        'api/status' => ['api', 'status',],
        'api/link/{token:.*}' => ['api', 'link',],
        'api/cardSocket' => ['api', 'cardSocket',],
    ];

    /**
     * @param mixed $route
     *
     * @return void
     */
    public function __construct() { }

    public function load($route) {
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

