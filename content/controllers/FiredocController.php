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
 * Class FiredocController
 * @package application\controllers
 */
class FiredocController extends Controller
{

    public $routes = [
        /** Route                       => Controller Action */
        /** Report */
        'files/show/{id:\d+}' => ['firedoc', 'show'],
        'files/dw/{id:\d+}' => ['firedoc', 'download'],
        'files/up' => ['firedoc', 'upload'],
        'files' => ['firedoc', 'list'],
        'files/list/{id:\w+}' => ['firedoc', 'list'],
        'files/createDir' => ['firedoc', 'createDir'],
        'files/del/{id:\d+}' => ['firedoc', 'delete'],
        'files/d/{id:\d+}' => ['firedoc', 'd'],
        'files/sub/{id:\d+}' => ['firedoc', 'sub']
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
            'all' => [
                'show',
                'dw',
                'download',
                'd',
                'sub',
                'list',],
            'authorize' => [
                'upload',
                'del',
                'createDir'],
            'guest' => [],
            'admin' => [],
        ];
        parent::__construct($route);
    }

    /**
     *
     */
    public function showAction()
    {

        $doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']) . "/uploads";

        foreach (str_split($this->route['id']) as $item) {
            $doc_root .= '/';
            $doc_root .= $item;
        }

        if (file_exists($doc_root)) {
            $data = $this->model->data($this->route['id']);

//            header('Content-Description: File Show');

            $mime = '';
            switch ($data['ext']) {
                case 'docx':
                    $mime = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                    break;
                case 'doc':
                    $mime = 'application/msword';
                    break;
                case 'xlsx':
                    $mime = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                    break;
                case 'xls':
                    $mime = 'application/vnd.ms-excel';
                    break;
                case 'jpg':
                    $mime = 'image/jpg';
                    break;
                case 'png':
                    $mime = 'image/png';
                    break;
                default:
                    $mime = "application/" . $data['ext'];
            }

            header('Content-Type: ' . $mime);
//            header('Content-Disposition: attachment; filename="' . $data['name'] . '.' . $data['ext'] . '"');
//            header('Expires: 0');
//            header('Cache-Control: must-revalidate');
//            header('Pragma: public');
            header('Content-Length: ' . filesize($doc_root));
            flush();
            readfile($doc_root);
            exit;

        }

        $this->view->render('Просмотр документа');
    }

    /**
     *
     */
    public function dAction()
    {
        $this->view->layout = 'fd_wiget';
        $list = $this->model->loadDir($this->route['id']);

        $vars = [
            'list' => $list
        ];

        $this->view->render('Каталог: ' . $this->route['id'], $vars);
    }

    /**
     *
     */
    public function downloadAction()
    {

        $doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']) . "/uploads";

        foreach (str_split($this->route['id']) as $item) {
            $doc_root .= '/';
            $doc_root .= $item;
        }

        $data = $this->model->load($this->route['id'])[0];

        if (file_exists($doc_root)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $data['name'] . '.' . $data['ext'] . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($doc_root));
            flush();
            readfile($doc_root);
            exit;
        }
    }

    /**
     *
     */
    public function uploadAction()
    {
        if (count($_FILES) != 0) {
            if (0 < $_FILES["file"]["error"]) {
                echo "Error: " . $_FILES["file"]["error"] . "<br>";
            } else {
                $id = $this->model->createData($_FILES["file"], $_POST["dir"]);
                $doc_root = preg_replace("!${_SERVER["SCRIPT_NAME"]}$!", "", $_SERVER["SCRIPT_FILENAME"]) . "/uploads";
                foreach (str_split($id) as $item) {
                    $doc_root .= "/";
                    $doc_root .= $item;
                }

                if (!file_exists(substr($doc_root, 0, -2))) {
                    mkdir(substr($doc_root, 0, -2), 0777, true);
                }

                if (move_uploaded_file($_FILES["file"]["tmp_name"], $doc_root)) {
                    $params = [
                        "status" => "success",
                        "fileID" => $id,
                        "message" => "Файл успешно загружен"
                    ];
                    exit(json_encode($params));
                } else {
                    echo "Something wrong!";
                }
            }
        } else {
            $this->view->render("Подгрузка");
        }
    }

    /**
     *
     */
    public function deleteAction()
    {

        $doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']) . "/uploads";

        foreach (str_split($this->route['id']) as $item) {
            $doc_root .= '/';
            $doc_root .= $item;
        }

        if (file_exists($doc_root)) {
            unlink($doc_root);
            $this->model->rmData($this->route['id']);
            $this->view->message("success", "Файл успешно удалён");
        }
    }

    /**
     *
     */
    public function createDirAction()
    {
        if (isset($_POST['txt'])) {
            $this->model->createDir($_SESSION["account"]["id"], $_POST['txt'], $_POST['dir'], $_POST['dir'] == 0 ? 1 : 0);

            $this->view->message("success", "Каталог создан");
        } else {
            $this->view->message("error", "Ошибка создания");
        }
    }

    /**
     *
     */
    public function listAction()
    {
        $vars = [
            'list' => isset($this->route['id']) ?
                $this->model->loadDir($this->route['id']) : $this->model->loadList($_SESSION["account"]["id"]),
            'parent' => isset($this->route['id']) ? $this->model->getDirParent($this->route['id']) : ""
        ];

        # Our new data
        $data = array(
            'path' => isset($this->route['id']) ? "C://FTP/CLOUD/" . $this->route['id'] : "C://FTP/CLOUD/"
        );

        # Create a connection
        $url = 'http://net.sch24perm.ru/list.php';
        $ch = curl_init($url);
        # Form data string
        $postString = http_build_query($data, '', '&');
        # Setting our options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Get the response
        $response = curl_exec($ch);
        curl_close($ch);

        $smb = json_decode($response);

        $vars['list']['path'] = 'C://FTP/CLOUD/';
        $vars['list'][] = $smb;

        $this->view->render('Список файлов в каталоге', $vars);
    }

    /**
     *
     */
    public function subAction()
    {
        echo json_encode($this->model->loadDir($this->route['id']));
    }

}
