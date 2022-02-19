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

namespace content\models;

use engine\core\Model;
use engine\libs\Db;

/**
 * Class Firedoc
 * @package application\models
 */
class Firedoc extends Model
{

    /**
     * @var Db
     */
    public $db;

    /**
     * @param $id
     * @return array
     */
    public function load($id)
    {
        $params = [
            'id' => $id,
        ];

        return $this->db->row('SELECT `name`,`ext` FROM fd_files where id=:id', $params);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function data($id)
    {
        $params = [
            'id' => $id,
        ];

        return $this->db->row('SELECT `name`,`ext` FROM fd_files where id=:id', $params)[0];
    }

    /**
     * @param $id
     * @return bool
     */
    public function isUniqueData($id)
    {
        return $this->db->column("SELECT count(*) FROM fd_files WHERE id=" . $id) == 0;
    }

    /**
     * @param $file
     * @param $parent
     * @return int
     */
    public function createData($file, $parent)
    {
        $id = mt_rand(100000, 999999);

        while (!$this->isUniqueData($id)) {
            $id = mt_rand(100000, 999999);
        }

        $info = new SplFileInfo($file['name']);

        $params = [
            'id' => $id,
            'name' => $info->getBasename("." . $info->getExtension()),
            'ext' => $info->getExtension(),
            'size' => $file['size'],
            'par' => isset($parent) ? $parent : $_SESSION["account"]["id"],
            'pub_name' => $file['name'],
            'author' => $_SESSION["account"]["id"],
            'root' => isset($parent) ? 1 : 0
        ];

        $this->db->query('INSERT INTO fd_files VALUES (:id, :par, :ext,:size,CURRENT_TIMESTAMP,"","",:pub_name,:name,:author,:root)', $params);
        return $id;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getDirParent($id)
    {
        $params = [
            'id' => $id,
        ];

        return $this->db->queryBind('SELECT parent FROM fd_directories WHERE id=:id AND root=0', $params);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function rmData($id)
    {
        $params = [
            'id' => $id,
        ];

        $this->db->query('DELETE FROM fd_files WHERE id = :id', $params);
        return $id;
    }

    /**
     * @param $id
     * @param $parent
     */
    public function editData($id, $parent)
    {
//        if (!empty($post['password'])) {
//            $params['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
//            $sql = ',password = :password';
//        } else {
//            $sql = '';
//        }
//
//        $params = [
//            'id' => $id,
//            'name' => $info->getBasename("." . $info->getExtension()),
//            'ext' => $info->getExtension(),
//            'size' => $file['size'],
//            'par' => isset($parent) ? $parent : $_SESSION["account"]["id"],
//        ];
//
//        $result = $this->db->query('UPDATE fd_files SET pub_name=:pubname', $params);
//        return $id;
    }

    /**
     * @param $auth
     * @param $txt
     * @param $dir
     * @param $root
     */
    public function createDir($auth, $txt, $dir, $root)
    {
        $params = [
            'root' => $root,
            'parent' => $dir,
            'txt' => $txt,
            'author' => $auth
        ];

        $this->db->query('INSERT INTO fd_directories VALUES (null,:root, :parent, curdate(), :txt, :author)', $params);
    }

    /**
     * @param $id
     * @return array
     */
    public function loadDir($id)
    {
        $params = [
            'id' => $id,
        ];

        $list = $this->db->row('SELECT * FROM fd_directories WHERE parent IN (:id, 0) AND root=0', $params);
        $list2 = $this->db->row('SELECT * FROM fd_files WHERE parent=:id', $params);

        foreach ($list as $index => $item) {
            $tmpData = $this->db->row('SELECT fname,sname,photo FROM sn_users WHERE id=' . $item['author'], $params);
            $list[$index]['author'] = $tmpData[0]['fname'] . " " . $tmpData[0]['sname'];
            $list[$index]['photo'] = $tmpData[0]['photo'];
        }

        foreach ($list2 as $index => $item) {
            $tmpData = $this->db->row('SELECT fname,sname,photo FROM sn_users WHERE id=' . $item['author'], $params);
            $list2[$index]['author'] = $tmpData[0]['fname'] . " " . $tmpData[0]['sname'];
            $list2[$index]['photo'] =
                $tmpData[0]['photo'];
        }

        return ['dir' => $list, 'file' => $list2];
    }

    /**
     * @param $id
     * @return array
     */
    public function loadList($id)
    {
        $params = [
            'id' => $id,
        ];

        $list = $this->db->queryBind('SELECT * FROM fd_directories WHERE parent IN (:id, 0) AND root=1', $params);
        $list2 = $this->db->queryBind('SELECT * FROM fd_files WHERE parent=:id AND root=1', $params);

        foreach ($list as $index => $item) {
            $tmpData = $this->db->queryBind('SELECT fname,sname,photo FROM sn_users WHERE id=' . $item['author'], $params);
            $list[$index]['author'] = $tmpData[0]['fname'] . " " . $tmpData[0]['sname'];
            $list[$index]['photo'] = $tmpData[0]['photo'];
        }

        foreach ($list2 as $index => $item) {
            $tmpData = $this->db->row('SELECT fname,sname,photo FROM sn_users WHERE id=' . $item['author'], $params);
            $list2[$index]['author'] = $tmpData[0]['fname'] . " " . $tmpData[0]['sname'];
            $list2[$index]['photo'] = $tmpData[0]['photo'];
        }

        return ['dir' => $list, 'file' => $list2];
    }

}