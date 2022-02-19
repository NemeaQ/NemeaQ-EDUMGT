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
 * Class Admin
 * @package app\models
 */
class Admin extends Model
{
    /**
     * @var Db
     */
    private $db;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->db = new Db;
    }

    public function getServers()
    {
        return $this->db->query('SELECT * FROM too_servers')->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * @param $post
     * @return bool
     */
    public function loginValidate($post)
    {
        if ($this->config['admin_login'] != $post['login'] or $this->config['admin_password'] != $post['password']) {
            $this->error = 'Логин или пароль указан неверно';
            return false;
        }
        return true;
    }

    /**
     * Список пользователей сайта
     * @return array
     */
    public function usersList()
    {
        return $this->db->query('SELECT * FROM too_users ORDER BY id')->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Список игроков сервера из `users`
     * @return array
     */
    public function playersList()
    {
        return $this->db->query('SELECT * FROM users ORDER BY uuid')->fetch_all(MYSQLI_ASSOC);
    }
}
