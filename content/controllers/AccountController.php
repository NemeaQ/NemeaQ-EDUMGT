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

/**
 * Class AccountController
 * @package content\controllers
 */
class AccountController extends Controller
{
    public $routes = [
        /** Route                       => Controller Action */
        /** Account */
        'login' => ['account', 'login',],
        'profile' => ['account', 'profile'],
        'logout' => ['account', 'logout',],
        'register' => ['account', 'register',],
        'account/confirm/{token:.*}' => ['account', 'confirm',],
        'settings' => ['account', 'settings',]
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
            'all' => [],
            'authorize' => ['profile', 'logout', 'settings',],
            'guest' => ['register', 'login', 'recovery', 'confirm', 'reset',],
            'admin' => [],
        ];
        parent::__construct($route);
    }

    /**
     * Регистрация аккаунта
     */
    public function registerAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->validate(['email', 'password'], $_POST)) {
                $this->view->message('error', $this->model->error);
//            } elseif (!$this->model->checkRecaptcha($_POST['g-recaptcha-response'])) {
//                $this->view->message('error', 'Подтвердите что вы не робот');
            } elseif ($this->model->checkEmailExists($_POST['email'])) {
                $this->view->message('error', 'Этот E-mail уже используется');
            } elseif ($_POST["password"] != $_POST["password2"]) {
                $this->view->message('error', 'Пароли не совпадают');
            }
            $this->model->register($_POST);
            $this->view->message('success', 'Регистрация завершена, проверьте почту (и папку спам)');
        }
        $this->view->render('Регистрация | ');
    }

    /**
     * Подтверждение учётной записи
     */
    public function confirmAction()
    {
        if (!$this->model->checkTokenExists($this->route['token'])) {
            $this->view->redirect('https://obsidianorder.ru/login');
        }
        $this->model->activate($this->route['token']);
        $this->view->render('Аккаунт активирован | ');
    }

    /**
     * Вход
     */
    public function loginAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->validate(['email', 'password'], $_POST)) {
                $this->view->message('error', $this->model->error);
            } elseif (!$this->model->checkData($_POST['email'], $_POST['password'])) {
                $this->view->message('error', 'Почта или пароль указаны не верно');
            } elseif ($this->model->checkStatus($_POST['email'])["status"] != 1) {
                $token = $this->model->getToken($_POST['email']);
                $this->model->sendEmailToken($_POST['email'], $token);
                $this->view->message('error', 'Требуется подтверждение учетной записи. Проверьте почту.');
            }

            $this->model->login($_POST['email']);
            $this->view->location('profile');
        } else {
            $this->view->render('Вход | ');
        }
    }

    public function settingsAction()
    {
        $vars = [
            'skill' => ["Нет", "Первая", "Высшая"],
            'post' => $this->model->db->row("SELECT name FROM sn_post")
        ];
        $this->view->render('Настройки | ', $vars);
    }

    /**
     * Профиль
     */
    public function profileAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->validate(['email'], $_POST)) {
                $this->view->message('error', $this->model->error);
            }
            $id = $this->model->checkEmailExists($_POST['email']);
            if ($id and $id != $_SESSION['account']['id']) {
                $this->view->message('error', 'Этот E-mail уже используется');
            }
            if (!empty($_POST['password']) and !$this->model->validate(['password'], $_POST)) {
                $this->view->message('error', $this->model->error);
            }
            $this->model->save($_POST);
            $this->view->message('success', 'Сохранено');
        }
        $this->view->render('Профиль | ');
    }

    /**
     * Выход
     */
    public function logoutAction()
    {
        unset($_SESSION['account']);
        $this->view->redirect('/');
    }

    /**
     * Восстановление пароля
     */
    public function recoveryAction()
    {
        if (!empty($_POST)) {
            if (!$this->model->validate(['email'], $_POST)) {
                $this->view->message('error', $this->model->error);
            } elseif (!$this->model->checkEmailExists($_POST['email'])) {
                $this->view->message('error', 'Пользователь не найден');
            } elseif (!$this->model->checkStatus('email', $_POST['email'])) {
                $this->view->message('error', $this->model->error);
            }
            $this->model->recovery($_POST);
            $this->view->message('success', 'Запрос на восстановление пароля отправлен на E-mail');
        }
        $this->view->render('Восстановление пароля | ');
    }

    /**
     * Сброс пароля
     */
    public function resetAction()
    {
        if (!$this->model->checkTokenExists($this->route['token'])) {
            $this->view->redirect('account/login');
        }
        $password = $this->model->reset($this->route['token']);
        $vars = [
            'password' => $password,
        ];
        $this->view->render('Пароль сброшен | ', $vars);
    }

}
