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
 * Class ContingentController
 * @package application\controllers
 */
class ContingentController extends Controller
{

    public $routes = [
        /** Route                       => Controller Action */
        /** Report */
        'cont/list.*' => ['contingent', 'list'],
        'cont/ucl' => ['contingent', 'uploadChildList'],
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
            'authorize' => ['list', 'uploadChildList'],
            'guest' => [],
            'admin' => [],
        ];
        parent::__construct($route);
    }

    /**
     *
     */
    public function listAction()
    {
        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }

        if (isset($_GET['count'])) {
            $per_page = $_GET['count'];
        } else {
            $per_page = 100;
        }

        if (isset($_GET['class'])) {
            $class = 'where class=' . $_GET['class'];
        } else {
            $class = '';
        }

        $no_of_records_per_page = $per_page;
        $offset = ($pageno - 1) * $no_of_records_per_page;

        $total_rows = $this->model->db->column("SELECT COUNT(*) FROM sn_childs");
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $vars = [
            'list' => $this->model->loadList($offset, $no_of_records_per_page, $class),
            'classList' => $this->model->classList(),
        ];

        //$this->model->uploadChildsList();
        $this->view->render('Title', $vars);
    }

    public function uploadChildListAction()
    {
        if (isset($_POST['list'])) {
            $this->model->uploadChildsList($_POST['list']);
        }
        $this->view->render('UCL');
    }

}
