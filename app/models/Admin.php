<?php

namespace app\models;

use app\core\Model;
use app\lib\Db;

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

    public function getServers(){
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