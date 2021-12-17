<?php

namespace content\controllers;

use engine\core\Controller;
use engine\core\Model;

/**
 * Class MainController
 * @package content\controllers
 */
class MainController extends Controller
{
    /**
     * @param mixed $route
     *
     * @return void
     */
    public function __construct($route)
    {
        $this->acl = [
            'all' => ['index', 'rules', 'copy', 'map', 'donate'],
            'authorize' => [],
            'guest' => [],
            'admin' => [],
        ];
        parent::__construct($route);
    }

    /**
     *
     */
    public function indexAction()
    {
        $this->view->render('Главная | ');
    }

    /**
     *
     */
    public function copyAction()
    {
        $this->view->render('Пользовательское соглашение и согласие на обработку персональных данных | ');
    }

    public function showAction()
    {
        $this->view->render('Просмотр страницы | ');
    }

    public function rulesAction()
    {
        $this->view->render('Правила | ');
    }

    public function mapAction()
    {
        $this->view->render('Карта | ');
    }

    public function donateAction()
    {
        $this->view->render('Донат | ');
    }
}

