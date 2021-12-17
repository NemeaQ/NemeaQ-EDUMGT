<?php

namespace content\models;

use engine\core\Model;
use engine\libs\Db;
use content\libs\PHPMailer;

/**
 * Class Account
 * @package app\models
 */
class Account extends Model
{
    /**
     * @var Db
     */
    private $db;
    public $error = null;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->db = new Db;
    }

    /**
     * Проверка правильности данных
     * @param $input
     * Перечень входных переменных
     * @param $post
     * Входные переменные
     * @return bool
     */
    public function validate($input, $post)
    {
        $rules = [
            'email' => [
                'pattern' => '#^([A-z0-9_.-]{1,20}+)@([A-z0-9_.-]+)\.([A-z\.]{2,10})$#',
                'message' => 'E-mail адрес указан неверно',
            ],
            'login' => [
                'pattern' => '#^[A-z0-9].{3,32}$#',
                'message' => 'Логин указан неверно (разрешены только латинские буквы и цифры от 3 до 32 символов',
            ],
            'password' => [
                'pattern' => '#^[A-z0-9].{6,30}$#',
                'message' => 'Пароль указан неверно (разрешены только латинские буквы и цифры от 6 до 30 символов',
            ],

        ];
        foreach ($input as $val) {
            if (!isset($post[$val]) or !preg_match($rules[$val]['pattern'], $post[$val])) {
                $this->error = $rules[$val]['message'];
                return false;
            }
        }
        return true;
    }

    /**
     * Проверка существования почты (на случай регистрации и замены адресса)
     * @param $email
     * Email текстом
     * @return mixed
     */
    public function checkEmailExists($email)
    {
        return $this->db->queryBind('SELECT id FROM too_users WHERE email = ?', 's', [$email])->fetch_assoc();
    }

    public function checkRecaptcha($responce)
    {
        $params = [
            'secret' => $this->config['captcha_secret_token'],
            'response' => $responce,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        $opt = array(
            CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTFIELDS => $params
        );
        $ch = curl_init();
        curl_setopt_array($ch, $opt);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true)['success'];
    }


    /**
     * Проверка существования ТОКЕНА пользователя
     * @param $token
     * @return mixed
     */
    public function checkTokenExists($token)
    {
        return $this->db->queryBind('SELECT id FROM too_users WHERE token = ?', 's',[$token])->fetch_assoc();
    }

    /**
     * Активировать аккаунт с заданным токеном
     * @param $token
     */
    public function activate($token)
    {
        $this->db->queryBind('UPDATE too_users SET status = 1, token = null WHERE token = ?', 's', [$token]);
    }

    /**
     * Регистрация аккаунта в системе
     * @param $post
     */
    public function register($post)
    {
        $token = $this->createToken();
        $params = ['', $post['email'], password_hash($post['password'], PASSWORD_BCRYPT), $token];

        $this->db->queryBind('INSERT INTO too_users VALUES (? ,?, ?, ?, 1, null, null, null)', 'isss', $params);

        $this->sendEmailToken($post['email'], $token);
    }

    /**
     * Создать токен для чела (длинна токена 30 символов)
     * @return false|string
     */
    public function createToken()
    {
        return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', 32)), 0, 32);
    }

    public function getToken($email)
    {
        return $this->db->queryBind('SELECT token FROM too_users WHERE email=?', 's', [$email])->fetch_row()[0];
    }

    /**
     * Проверка входны данных
     * @param $email
     * @param $password
     * @return bool
     */
    public function checkData($email, $password)
    {
        $hash = $this->db->queryBind('SELECT password FROM too_users WHERE email=?', 's', [$email])->fetch_row();
        return password_verify($password, $hash[0]);
    }

    public function checkStatus($email)
    {
        return $this->db->queryBind('SELECT status FROM too_users WHERE email=?', 's', [$email])->fetch_assoc();
    }

    /**
     * Логин прользователя, добавлени в сессию данных о пользователе
     *
     * @param $email
     */
    public function login($email)
    {
        $data = $this->db->queryBind('SELECT * FROM too_users WHERE email=?', 's', [$email])->fetch_assoc();
        $_SESSION['account'] = $data;
    }

    /**
     * Восстановлене пароля: запрос на отправку письма восстановлени, + генерирование нового токена
     * @param $post
     */
    public function recovery($post)
    {
        $token = $this->createToken();
        $params = [
            'email' => $post['email'],
            'token' => $token,
        ];
        $this->db->query('UPDATE too_users SET token = :token WHERE email = :email', $params);
        mail($post['email'], 'Recovery', 'Confirm: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/account/reset/' . $token);
    }

    /**
     * Сброс пароля на токен
     * @param $token
     * @return false|string
     */
    public function reset($token)
    {
        $new_password = $this->createToken();
        $params = [
            'token' => $token,
            'password' => password_hash($new_password, PASSWORD_BCRYPT),
        ];
        $this->db->query('UPDATE too_users SET status = 1, token = "", password = :password WHERE token = :token', $params);
        return $new_password;
    }

    /**
     * Сохранить данные из профиля
     * @param $post
     */
    public function save($post)
    {
        if (count($_FILES) != 0 && $_FILES['photo']['name'] != '') {
            $fd = new Firedoc();
            $id = $fd->createData($_FILES['photo'], 0);
            $doc_root = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']) . "/uploads";
            foreach (str_split($id) as $item) {
                $doc_root .= '/';
                $doc_root .= $item;
            }

            if (!file_exists(substr($doc_root, 0, -2))) {
                mkdir(substr($doc_root, 0, -2), 0777, true);
            }

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $doc_root)) {
                $post['photo'] = $id;

                $fd->rmData($_SESSION['account']['photo']);
            } else {
                $post['photo'] = $_SESSION['account']['photo'];
            }
        } else {
            $post['photo'] = $_SESSION['account']['photo'];
        }

        $params = [
            'id' => $_SESSION['account']['id'],
            'email' => $post['email'],
            'sname' => $post['sname'],
            'mname' => $post['mname'],
            'fname' => $post['fname'],

            'postID' => $this->db->column("SELECT id FROM sn_post WHERE name='" . $post['postID'] . "'"),
            'experience' => $post['experience'],
            'skill' => $this->db->column("SELECT id FROM sn_skill WHERE name='" . $post['skill'] . "'"),
            'photo' => $post['photo']
        ];
        if (!empty($post['password'])) {
            $params['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
            $sql = ',password = :password';
        } else {
            $sql = '';
        }
        foreach ($params as $key => $val) {
            $_SESSION['account'][$key] = $val;
        }
        $this->db->query('UPDATE too_users SET email = :email, sname = :sname, mname = :mname, fname = :fname' . $sql . ', postID = :postID, experience = :experience, skill = :skill, photo = :photo WHERE id = :id', $params);
    }

    /**
     * Отправка письма подтверждения регистрации
     * @param $email
     * @param $token
     */
    public function sendEmailToken($email, $token)
    {

        $mail = new PHPMailer();
        $mail->setFrom('admin@obsidianorder.ru', 'The Obsidian Order');
        $mail->Subject = 'Подтверждение  регистрации';
        $mail->addAddress($email, '');
        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
        $mail->isHTML(false);
        $mail->Body = <<<EOT
Confirm:  https://obsidianorder.ru/account/confirm/{$token}
EOT;
        $mail->AltBody = 'Confirm: https://obsidianorder.ru/account/confirm/' . $token;

        //This should be the same as the domain of your From address
        $mail->DKIM_domain = 'obsidianorder.ru';
        //See the DKIM_gen_keys.phps script for making a key pair -
        //here we assume you've already done that.
        //Path to your private key:
        $mail->DKIM_private = 'admin_dkim_private.pem';
        //Set this to your own selector
        $mail->DKIM_selector = 'admin';
        //The identity you're signing as - usually your From address
        $mail->DKIM_identity = $mail->From;
        //Suppress listing signed header fields in signature, defaults to true for debugging purpose
        $mail->DKIM_copyHeaderFields = false;
        //Optionally you can add extra headers for signing to meet special requirements
        $mail->DKIM_extraHeaders = ['List-Unsubscribe', 'List-Help'];
    }

}