<?php


namespace app\core;

use app\core\View;

/**
 * Class Controller
 * @package app\core
 * @author Hanriel
 */
abstract class Controller
{

    public $route;
    public $view;
    public $acl;
    /**
     * Конфигурации сайта
     * @var array|mixed
     */
    public $config;

    /**
     * Controller constructor.
     * @param $route
     */
    public function __construct($route)
    {
        $this->config = require 'app/config.php';
        $this->route = $route;
        if (!$this->checkAcl()) {
            View::errorCode(403);
        }
        $this->view = new View($route);
        $this->model = $this->loadModel($route[0]);
    }

    /**
     * @param $name 'Имя модели'
     * @return Model
     */
    public function loadModel($name)
    {
        $path = 'app\models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
        return null;
    }

    /**
     * Cписок контроля доступа
     * @return bool
     */
    public function checkAcl()
    {
        if ($this->isAcl('all')) {
            return true;
        } elseif (isset($_SESSION['account']['id']) and $this->isAcl('authorize')) {
            return true;
        } elseif (!isset($_SESSION['account']['id']) and $this->isAcl('guest')) {
            return true;
        } elseif (isset($_SESSION['admin']) and $this->isAcl('admin')) {
            return true;
        }
        return false;
    }

    /**
     * Cписок контроля доступа
     * @param $key
     * @return bool
     */
    public function isAcl($key)
    {
        return in_array($this->route[1], $this->acl[$key]);
    }

}