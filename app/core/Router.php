<?php

namespace app\core;

/**
 * Class Router
 * @package app\core
 */
class Router
{
    protected $raw_routes = [
        /** Route                       => Controller Action */
        /** Main */
        ''                              => ['main', 'index',],
        'rules'                         => ['main', 'rules',],
        'map'                           => ['main', 'map',],
        'donate'                        => ['main', 'donate',],
        'copy'                          => ['main', 'copy',],

        /** Account */
        'login'                         => ['account', 'login',],
        'profile'                       => ['account', 'profile'],
        'logout'                        => ['account', 'logout',],
        'register'                      => ['account', 'register',],
        'account/confirm/{token:.*}'    => ['account', 'confirm',],
        'settings'                      => ['account', 'settings',],

        /** API */
        'api/status'                    => ['api', 'status',],
        'api/link/{token:.*}'           => ['api', 'link',],
        'api/cardSocket'                => ['api', 'cardSocket',],


        /** Админпанель */
        'admin'                         => ['admin', 'dashboard',],
        'admin/login'                   => ['admin', 'login',],
        'admin/logout'                  => ['admin', 'logout',],
        'admin/users'                   => ['admin', 'users',],
        'admin/players'                 => ['admin', 'players',],
        'admin/reports'                 => ['admin', 'reports',],
        'admin/groups'                  => ['admin', 'groups',],
        'admin/player/{id:\d+}/change'  => ['admin', 'changePlayer',]
    ];
    /**
     * Путь Контроллера
     * @var array
     */
    protected $routes = [];
    /**
     * Controller и Action
     * @var array
     */
    protected $params = [];

    /**
     * Router constructor.
     */
    public function __construct()
    {
        foreach ($this->raw_routes as $key => $route) {
            $this->addRoute($key, $route);
        }
    }

    /**
     * @param $route
     * @param $params
     */
    public function addRoute($route, $params)
    {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    /**
     * @return bool
     */
    public function match()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int)$match;
                        }
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     *
     */
    public function run()
    {
        if ($this->match()) {
            $path = 'app\controllers\\' . ucfirst($this->params[0]) . 'Controller';
            if (class_exists($path)) {
                $action = $this->params[1] . 'Action';
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }

}