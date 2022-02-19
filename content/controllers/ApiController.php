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
use content\libs\SocketServer;
use content\libs\PHPMailer\PHPMailer;
use content\libs\PHPMailer\SMTP;
use content\libs\PHPMailer\Exception;

/**
 * Class ApiController
 * @package content\controllers
 */
class ApiController extends Controller
{

    public $routes = [
        /** Route                       => Controller Action */
        /** API */
        'api/status' => ['api', 'status',],
        'api/link/{token:.*}' => ['api', 'link',],
        'api/cardSocket' => ['api', 'cardSocket',],
        'api/testmail' => ['api', 'testmail',],
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
            'all' => ['cardSocket', 'testmail'],
            'authorize' => [],
            'guest' => [],
            'admin' => ['status'],
        ];
        parent::__construct($route);
    }

    /**
     * Возвращает статус сервева базы данных
     */
    public function statusAction()
    {

    }

    public function cardSocketAction()
    {

    }

    public function testmailAction()
    {
//Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            //$mail->isSMTP();                                            //Send using SMTP
            //$mail->Host       = 'smtp.timeweb.ru';                     //Set the SMTP server to send through
            //$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            //$mail->Username   = 'user@example.com';                     //SMTP username
            //$mail->Password   = 'secret';                               //SMTP password
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            //$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $mail->CharSet = 'utf-8';
            //Recipients
            $mail->setFrom('desk@perm-school24.ru', 'EDUMGT');
            $mail->addAddress('test-4b826f@test.mailgenius.com');               //Name is optional
            $mail->addReplyTo('desk@perm-school24.ru', 'EDUMGT');
            $mail->addCustomHeader("List-Unsubscribe", '<desk@perm-school24.ru>, <https://desk.perm-school24.ru/email>');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //This should be the same as the domain of your From address
            $mail->DKIM_domain = 'perm-school24.ru';
            //See the DKIM_gen_keys.phps script for making a key pair -
            //here we assume you've already done that.
            //Path to your private key:
            $mail->DKIM_private = 'dkim_private.pem';
            //Set this to your own selector
            $mail->DKIM_selector = '1645249718.school24';
            //Put your private key's passphrase in here if it has one
            //$mail->DKIM_passphrase = '';
            //The identity you're signing as - usually your From address
            $mail->DKIM_identity = $mail->From;
            //Suppress listing signed header fields in signature, defaults to true for debugging purpose
            $mail->DKIM_copyHeaderFields = false;
            //Optionally you can add extra headers for signing to meet special requirements
            $mail->DKIM_extraHeaders = ['List-Unsubscribe'];

            //When you send, the DKIM settings will be used to sign the message

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Подтверждение регистрации';
            $mail->Body = 'Уважаемый <b>Данил Александрович</b>!';
            $mail->AltBody = 'Уважаемый Данил Александрович!';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

}

