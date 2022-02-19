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
 * Class ReportController
 * @package application\controllers
 */
class ReportController extends Controller
{
    public $routes = [
        /** Route                       => Controller Action */
        /** Report */
        'reports' => ['report', 'list'],
        'reports/fill/{id:\d+}' => ['report', 'fill'],
        'reports/fill2/{id:\d+}' => ['report', 'fill2'],
        'reports/fill3/{id:\d+}' => ['report', 'fill3'],
        'reports/fill4/{id:\d+}' => ['report', 'fill4'],
        'reports/save' => ['report', 'save'],
        'reports/save2' => ['report', 'save2'],
        'reports/save3' => ['report', 'save3'],
        'reports/save4' => ['report', 'save4'],
        'reports/send' => ['report', 'send'],
        'reports/show/{id:\d+}' => ['report', 'show'],
        'reports/check/{id:\d+}/{fid:\d+}' => ['report', 'check'],
        'reports/access/{id:\d+}' => ['report', 'access'],
        'reports/denied/{id:\d+}' => ['report', 'denied'],
        'reports/unArch/{id:\d+}' => ['report', 'unArch']
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
            'all' => ['public'],
            'authorize' => [
                'list',
                'fill',
                'save',
                'show',
                'send',
                'check',
                'access',
                'denied',
                'unArch',
                'fill2',
                'fill3',
                'fill4',
                'save2',
                'save3',
                'save4',],
            'guest' => [],
            'admin' => [],
        ];
        parent::__construct($route);
    }

    /**
     * Список форм
     */
    public function listAction()
    {

        $users = $this->model->db->row('SELECT id,sname,fname,mname FROM sn_users');
        foreach ($users as $index => $user) {
            $users[$user['id']] = $user['sname'] . ' ' . $user['fname'];
        }

        $vars = [
            'list' => $this->model->loadList(),
            'myList' => $this->model->loadMyList(),
            'myArch' => $this->model->loadArchList(),
            'users' => $users,
        ];

        $this->view->render('Формы', $vars);
    }

    /**
     *
     */
    public function fillAction()
    {
        $form = $this->model->loadForm($this->route['id']);
        $this->view->render('Редактирование формы', $form);
    }

    /**
     *
     */
    public function fill2Action()
    {
        $form = $this->model->loadForm2($this->route['id']);
        $this->view->render('Редактирование формы', $form);
    }

    public function fill3Action()
    {
        $form = $this->model->loadForm3($this->route['id']);
        $form[] = $this->model->db->row('SELECT data FROM sn_formSave WHERE uid=' . $_SESSION['account']['id']);
        $this->view->render('Редактирование формы', $form);
    }

    public function fill4Action()
    {
        $form = $this->model->loadForm3(4);
        //$form[] = $this->model->db->row('SELECT  FROM sn_users WHERE uid='.$_SESSION['account']['id']);

        $values = $this->model->db->row('SELECT data FROM sn_formSave WHERE uid=' . $_SESSION['account']['id'] . ' AND fid=4');


        $form[] = $values;

        $this->view->render('Редактирование формы', $form);
    }

    /**
     *
     */
    public function saveAction()
    {
        if (!empty($_POST)) {
            if (isset($_POST['id'])) {

                $fid = $_POST['id'];
                unset($_POST['id']);

                $id = $this->model->checkDraftExists($fid);
                $keys = NULL;

                foreach ($_POST as $value) {
                    foreach ($value as $item) {
                        $keys .= $item;
                        $keys .= "&&";
                    }
                    $keys = substr($keys, 0, -2);
                    $keys .= "$$";
                }
                $keys = substr($keys, 0, -2);

                if ($id) {
                    $this->model->saveDraft($id, $keys);
                } else {
                    $this->model->createDraft($fid, $keys);
                }

                $this->view->message('success', 'Сохранено');
            }
        }
        $this->view->message('error', 'Ошибка формы');
    }


    /**
     *
     */
    public function save2Action()
    {
        if (!empty($_POST)) {
            if (isset($_POST['id'])) {

                $fid = $_POST['id'];
                unset($_POST['id']);

                $uID = $_SESSION['account']['id'];

                $rawObjectList = $this->model->db->row("SELECT * FROM sn_object");
                $objectList = [];
                foreach ($rawObjectList as $item) {
                    $objectList[$item['name']] = $item['id'];
                }

                foreach ($_POST as $index => $value) {
                    $keys = substr($index, 0, -2);
                    $results[$keys][] = $value;
                }


                foreach ($results as $index => $value) {
                    $tmp = explode('_', $index);
                    $params = [
                        'fid' => $fid,
                        'uid' => $uID,
                        'object' => $objectList[$tmp[0]],
                        'class' => $tmp[1],
                        'quality' => $value[1],
                        'progress' => $value[2],
                        'ch' => $value[0]
                    ];

                    $complete = $this->model->db->query("INSERT INTO sn_drafts2 (fID, uID, object, class, quality, progress, ch)
                                                                    VALUES (:fid, :uid, :object, :class, :quality, :progress, :ch)
                                                                    ON DUPLICATE KEY UPDATE quality=:quality, progress=:progress, ch=:ch", $params);
                }

                $this->view->message('success', 'Сохранено');
            }
        }
        $this->view->message('error', 'Ошибка формы');
    }

    public function save3Action()
    {
        if (!empty($_POST)) {
            $fid = 3;
            $uID = $_SESSION['account']['id'];

            $results = [];
            foreach ($_POST as $index => $value) {
                $results[$index] = $value;
            }

            $params = [
                'fid' => $fid,
                'uid' => $uID,
                'data' => json_encode($results)
            ];

            $complete = $this->model->db->query("INSERT INTO sn_formSave (uid, fid, data)
                                                                VALUES (:uid, :fid, :data)", $params);

            $this->view->reload();
        }
        $this->view->message('error', 'Ошибка формы');
    }

    public function save4Action()
    {
        if (!empty($_POST)) {
            $fid = 4;
            $uID = $_SESSION['account']['id'];
            $results = [];
            foreach ($_POST as $index => $value) {
                $results[$index] = $value;
            }

            $params = [
                'fid' => $fid,
                'uid' => $uID,
                'data' => json_encode($results)
            ];


            $complete = $this->model->db->query("INSERT INTO sn_formSave (uid, fid, data)
                                                                VALUES (:uid, :fid, :data) ON DUPLICATE KEY UPDATE data=:data", $params);

            $this->view->reload();
        }
        $this->view->message('error', 'Ошибка формы');
    }

    /**
     *
     */
    public function showAction()
    {
        $form = $this->model->loadForm($this->route['id']);
        $this->view->render('Просмотр формы', $form);
    }

    /**
     *
     */
    public function accessAction()
    {
        $this->model->toArchiveDraft($this->route['id']);
        $this->model->unLockDraft($this->route['id']);
        $this->view->location('report/list');
    }

    /**
     *
     */
    public function deniedAction()
    {
        $this->model->unLockDraft($this->route['id']);
        $this->view->location('report/list');
    }

    /**
     *
     */
    public function checkAction()
    {
        $form = $this->model->loadReport($this->route['id'], $this->route['fid']);
        $this->view->render('Просмотр формы', $form);
    }

    /**
     *
     */
    public function unArchAction()
    {
        $this->model->unArchiveDraft($this->route['id']);
        $this->view->location('report/list');
    }

    /**
     *
     */
    public function sendAction()
    {
        if (!empty($_POST)) {
            if (isset($_POST['id'])) {
                $id = $this->model->checkDraftExists($_POST['id']);
                if ($id) {
                    $this->model->lockDraft($id);
                    $this->view->location('report/list');
                }
            }
        }
        $this->view->message('error', 'Ошибка формы');
    }

}
