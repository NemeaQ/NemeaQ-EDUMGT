<?php

namespace app\controllers;

use app\core\Controller;
use app\lib\Pagination;

/**
 * Class AdminController
 */
class AdminController extends Controller
{
    /**
     * @param mixed $route
     *
     * @return void
     */
    public function __construct($route)
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
            if (!$this->model->loginValidate($_POST)){
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