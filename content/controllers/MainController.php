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

namespace content\controllers;

use engine\core\Controller;
use engine\core\Model;

/**
 * Class MainController
 * @package content\controllers
 */
class MainController extends Controller
{
    public $routes = [
        /** Route                       => Controller Action */
        '' => ['main', 'index',],
        'rules' => ['main', 'rules',],
        'map' => ['main', 'map',],
        'donate' => ['main', 'donate',],
        'copy' => ['main', 'copy',],
    ];

    /**
     * @param mixed $route
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function load($route)
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
        if (isset($_SESSION['account']['id'])) {
            $this->view->render('Главная | ');
        } else {
            //$this->route = ['account', 'login'];
            $this->view->path = "account/login";
            $this->view->layout = "login";
            $this->view->render('Главная | ');
        }

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

