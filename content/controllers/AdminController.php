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
use engine\libs\Pagination;

/**
 * Class AdminController
 * @package content\controllers
 */
class AdminController extends Controller
{

    public $routes = [
        /** Route                       => Controller Action */
        /** Админпанель */
        'admin' => ['admin', 'dashboard',],
        'admin/login' => ['admin', 'login',],
        'admin/logout' => ['admin', 'logout',],
        'admin/users' => ['admin', 'users',],
        'admin/players' => ['admin', 'players',],
        'admin/reports' => ['admin', 'reports',],
        'admin/groups' => ['admin', 'groups',],
        'admin/player/{id:\d+}/change' => ['admin', 'changePlayer',]
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
            'all' => ['login',],
            'authorize' => [],
            'guest' => [],
            'admin' => [
                //Раздел пользователя
                'dashboard', 'users', 'players', 'groups', 'reports', 'changeUser',
                //Авторизация
                'logout'
            ],
        ];
        parent::__construct($route);
        $this->view->layout = 'admin';
    }

    /**
     * @return void
     */
    public function loginAction()
    {
        if (isset($_SESSION['admin'])) {
            $this->view->redirect('users');
        }
        if (!empty($_POST)) {
            if (!$this->model->loginValidate($_POST)) {
                $this->view->message('error', $this->model->error);
            }
            $_SESSION['admin'] = true;
            $this->view->location('admin');
        }
        $this->view->render('Вход');
    }

    /**
     * @return void
     */
    public function dashboardAction()
    {
        $vars['servers'] = $this->model->getServers();
        $this->view->render('Главная', $vars);
    }

    /**
     * @return void
     */
    public function usersAction()
    {
        if (!empty($_POST)) {
            if ($_POST['type'] == 'ref') {
                $result = $this->model->usersList($_POST['id']);
                if ($result) {
                    $this->view->location('admin/withdraw');
                } else {
                    $this->view->message('error', 'Ошибка обработки запроса');
                }
            } elseif ($_POST['type'] == 'tariff') {
                $result = $this->model->withdrawTariffsComplete($_POST['id']);
                if ($result) {
                    $this->view->location('admin/withdraw');
                } else {
                    $this->view->message('error', 'Ошибка обработки запроса');
                }
            }
        }
        $vars = [
            'listUsers' => $this->model->usersList(),
        ];
        $this->view->render('Список пользователей', $vars);
    }

    /**
     * @return void
     */
    public function playersAction()
    {
        $vars = [
            'listPLayers' => $this->model->playersList(),
        ];
        $this->view->render('Список игроков', $vars);
    }

    /**
     * @return void
     */
    public function groupsAction()
    {
        if (!empty($_POST)) {
            if ($_POST['type'] == 'ref') {
                $result = $this->model->usersList($_POST['id']);
                if ($result) {
                    $this->view->location('admin/withdraw');
                } else {
                    $this->view->message('error', 'Ошибка обработки запроса');
                }
            } elseif ($_POST['type'] == 'tariff') {
                $result = $this->model->withdrawTariffsComplete($_POST['id']);
                if ($result) {
                    $this->view->location('admin/withdraw');
                } else {
                    $this->view->message('error', 'Ошибка обработки запроса');
                }
            }
        }
        $vars = [
            'listUsers' => $this->model->rolesList(),
        ];
        $this->view->render('Список групп', $vars);
    }

    /**
     * @return void
     */
    public function logoutAction()
    {
        unset($_SESSION['admin']);
        $this->view->redirect('login');
    }

    /**
     * @return void
     */
    public function changeUserAction()
    {
        $this->view->render('Измение профиля');
    }
}
