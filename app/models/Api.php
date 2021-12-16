<?php

namespace app\models;

use app\core\Model;
use app\lib\Db;

/**
 * Class Admin
 * @package app\models
 */
class Api extends Model
{
    /**
     * @var Db
     */
    public $db;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->db = new Db;
    }

    /**
     * @param $token
     * @return bool
     */
    public function checkTokenExists($token)
    {
        //TODO: Что это такое???
        return true;
    }
}