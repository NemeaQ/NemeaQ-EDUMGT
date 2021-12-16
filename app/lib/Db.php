<?php


namespace app\lib;

use mysqli_sql_exception;

/**
 * Class Db
 * @package app\lib
 */
class Db
{
    public function setDb($db)
    {
        $this->db = $db;
    }

    protected $db;

    public function __construct()
    {
        $config = require 'app/config.php';
        try {
            $this->db = mysqli_connect($config['mysql_host'], $config['mysql_user'], $config['mysql_password'], $config['mysql_base'], $config['mysql_port']);
        } catch(mysqli_sql_exception $error){
            debug('<h2>MySQL Error!</h2>');
        }
    }

    public function query($sql)
    {
        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute()) return false;
        return $stmt->get_result();
    }

    public function queryBind($sql, $types = null, $params = null)
    {
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if(!$stmt->execute()) return false;
        return $stmt->get_result();
    }
}