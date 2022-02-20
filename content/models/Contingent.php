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
 * Class Contingent
 * @package application\models
 */
class Contingent extends Model
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

        return $this->db->row("SELECT `name`,`ext` FROM fd_files where id=:id", $params)[0];
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
     * @param $child
     * @param $class
     */
    public function createData($child, $class)
    {
        $params = [
            'sname' => $child[0],
            'fname' => $child[1],
            'mname' => $child[2],
            'bdate' => $child[3],
            'class' => $class
        ];

        $this->db->query('INSERT INTO sn_childs VALUES (default, :sname, :fname, :mname, :bdate, :class)', $params);
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
     * @return mixed
     */
    public function editData($id, $parent)
    {
        if (!empty($post['password'])) {
            $params['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
            $sql = ',password = :password';
        } else {
            $sql = '';
        }

        $params = [
            'id' => $id,
            'name' => $info->getBasename("." . $info->getExtension()),
            'ext' => $info->getExtension(),
            'size' => $file['size'],
            'par' => isset($parent) ? $parent : $_SESSION["account"]["id"],
        ];

        $result = $this->db->query('UPDATE fd_files SET pub_name=:pubname', $params);
        return $id;
    }

    /**
     * @param $offset
     * @param $limit
     * @param $class
     * @return array
     */
    public function loadList($offset, $limit, $class)
    {
        $list = $this->db->row('SELECT sn_users.sname, sn_users.fname, sn_users.mname, sn_childs.birth, sn_class.name
                                        FROM sn_users
                                        JOIN sn_userRoles ON sn_users.id=sn_userRoles.uID
                                        JOIN sn_childs ON sn_users.id=sn_childs.uID
                                        JOIN sn_class ON sn_childs.class=sn_class.id
                                        WHERE sn_userRoles.role=4
                                        ORDER BY sname');
        return $list;
    }

    /**
     * @param $class
     * @return array
     */
    public function loadClass($class)
    {

        $list = $this->db->row(
            'SELECT sn_childs.sname, sn_childs.fname, sn_childs.mname, sn_class.name, sn_childs.birth FROM sn_childs JOIN sn_class ON sn_childs.class=sn_class.id ' . $class . ' ORDER BY name,sname');
        return $list;
    }

    /**
     * @return array
     */
    public function classList()
    {
        $list = $this->db->row('SELECT * FROM sn_class ORDER BY name');

        return $list;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getClassName($id)
    {
        $list = $this->db->column('SELECT name FROM sn_class WHERE id=' . $id);

        return $list;
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
            $list2[$index]['photo'] = $tmpData[0]['photo'];
        }

        return ['dir' => $list, 'file' => $list2];
    }

    public function uploadChildsList($string)
    {

        $byStrings = explode(PHP_EOL, $string);

        foreach ($byStrings as $str) {
            $sub = explode("	", $str);
            if (count($sub) == 5) {
                $this->createChild($sub[0], $sub[1], $sub[2], $sub[3], $sub[4]);
            }
        }


        //$this->createChild('Асадулина', 'Софья', 'Глебовна', '01.01.2020', '8 "В"');

    }

    public function createChild($surname, $first_name, $mname, $birthdate, $className)
    {
        $password = $this->genChildFirstPassword();
        $id = $this->db->column("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA='sch24perm_snet' AND TABLE_NAME='sn_users'");

        /**
         * Создание аккаунта в sn_users
         */
        $params = [
            'id' => "s" . $id,
            'password' => sha1($password),
            'sname' => $surname,
            'fname' => $first_name,
            'mname' => $mname
        ];

        $this->db->query('INSERT INTO sn_users VALUES ("", "STUD@SCH24PERM.RU", :id, :password, "", "", :mname, :fname,"","", :sname)', $params);

        /**
         * Присвоение роли
         */

        $paramsRole = [
            'id' => $id
        ];

        $this->db->query('INSERT INTO sn_userRoles VALUES (:id, 4, NOW())', $paramsRole);

        /**
         * Создание карточки ученика
         */
        $class = $this->db->column("SELECT id FROM sn_class WHERE name='" . $className . "'");

        $paramsChild = [
            'id' => $id,
            'birth' => $birthdate,
            'class' => $class,
            'password' => $password
        ];

        $this->db->query('INSERT INTO sn_childs VALUES (:id, :birth, :class, 1, :password)', $paramsChild);
    }

    public function genChildFirstPassword()
    {
        return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', 8)), 0, 8);
    }

}
