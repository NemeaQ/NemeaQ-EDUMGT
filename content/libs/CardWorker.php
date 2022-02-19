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

namespace app\lib;

class CardWorker
{
    public $connection;

    private const COOKIE_JAR = '../../cookie.txt';
    private const TOKEN_FILE = '../../token.txt';

    public bool $useBaseNow = false;
    public bool $enabled = false;

    public string $date;
    private array $splitDate;

    function __construct($date, $connect)
    {
        $this->connection = $connect;
        $this->date = $date;
        $this->splitDate = preg_split("/-/", $date);
    }

    public function start()
    {
        if ($this->enabled) {
            $file_token = fopen(self::TOKEN_FILE, "r+") or die("Unable to open token file!");
            if (self::checkTokenExist()) {
                $this->logSock("<span style='color: #f00'>Файл с токеном пустой, получение нового...</span>" . PHP_EOL);
                $token = self::getToken();
                fwrite($file_token, $token, strlen($token));
                $this->logSock("<span style='color: #080'>Токен получен: $token</span>" . PHP_EOL);
            } else {
                $token = fread($file_token, filesize(self::TOKEN_FILE));
                $this->logSock("<span style='color: #080'>Токен найден: " . $token . "</span>" . PHP_EOL);
            }

            fclose($file_token);

            $c2 = curl_init("https://new-pk.first-card.ru/proc/login");
            curl_setopt($c2, CURLOPT_POST, true);
            curl_setopt($c2, CURLOPT_POSTFIELDS, '_token=' . $token . '&contract_user=0020001155&pass_user=24schoolnutr');

            curl_setopt($c2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c2, CURLOPT_COOKIEFILE, self::COOKIE_JAR);
            curl_setopt($c2, CURLOPT_SSL_VERIFYPEER, false);
            $response2 = curl_exec($c2);
            curl_close($c2);

            if ($response2[0] == "{") {
                $this->logSock("<span style='color: #080'>Успешная авторизация</span>" . PHP_EOL);
            } else {
                $this->logSock("<span style='color: #f00'>Ошибка авторизации: '" . $response2 . "'</span>" . PHP_EOL);
            }

            //* GETTING SESSION */
            $ch3 = curl_init("https://new-pk.first-card.ru/pc");
            curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch3, CURLOPT_COOKIEJAR, self::COOKIE_JAR);
            curl_setopt($ch3, CURLOPT_COOKIEFILE, self::COOKIE_JAR);
            curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch3);
            curl_close($ch3);
            $this->logSock("<span style='color: #080'>Сессия получена</span>" . PHP_EOL);


            $c4 = curl_init("https://new-pk.first-card.ru/reports/work-days");
            curl_setopt($c4, CURLOPT_POST, true);
            curl_setopt($c4, CURLOPT_POSTFIELDS, "_token=" . $token . "&class_name=&month=" . $this->splitDate[1] . "&year=" . $this->splitDate[0]);

            curl_setopt($c4, CURLOPT_COOKIEJAR, self::COOKIE_JAR);
            curl_setopt($c4, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($c4, CURLOPT_COOKIEFILE, self::COOKIE_JAR);
            curl_setopt($c4, CURLOPT_SSL_VERIFYPEER, false);
            $response3 = curl_exec($c4);
            curl_close($c4);

            $json = json_decode($response3, true)["return_data"]["data"]["report"];

            $this->logSock("<span style='color: #080'>Получены рабочие дни</span>" . PHP_EOL);

            if ($this->useBaseNow) $smysql = mysqli_connect("10.8.0.1:3305", "root");

            for ($int = 0; $int < 147; $int++) //БЫЛО 147!!!
            {
                if (array_key_exists((1 + $int) . "_data", $json)) {
                    $str = $json[(1 + $int) . "_data"];
                    $linear = $str["learnersCount"];
                    $today = $str["dayOfMonth_" . ($this->splitDate[2][0] == "0" ? $this->splitDate[2][1] : $this->splitDate[2])];

                    if ($linear != $today) {
                        $this->logSock($str["className"] . " - " . $today . "/" . $linear . PHP_EOL);

                        $c5 = curl_init("https://new-pk.first-card.ru/reports/for-ae");
                        curl_setopt($c5, CURLOPT_POST, true);
                        curl_setopt($c5, CURLOPT_POSTFIELDS, "_token=" . $token . "&class_name=" . $str["className"] . "&month=" . $this->splitDate[1] . "&year=" . $this->splitDate[0]);

                        curl_setopt($c5, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($c5, CURLOPT_COOKIEFILE, self::COOKIE_JAR);
                        curl_setopt($c5, CURLOPT_SSL_VERIFYPEER, false);

                        $response4 = curl_exec($c5);
                        curl_close($c5);
                        $json_class = json_decode($response4, true)["return_data"]["data"]["report"];

                        preg_match_all("/user_([0-9]*)/", $response4, $matches_class);

                        $uids = $matches_class[1];

                        for ($j = 0; $j < count($uids); $j++) {
                            $user = $json_class["user_" . $uids[$j]][$this->date];

                            if ($user == null) continue;
                            if ((bool)$user["passages"] || (bool)$user["pays"]) continue;

                            if ($this->useBaseNow) {
                                $sql_query1 = "SELECT ID,CODEKEY FROM `tc-db-main`.personal where EXTID='" . $uids[$j] . "';";
                                $result = mysqli_fetch_all(mysqli_query($smysql, $sql_query1))[0];

                                $sql_query2 = "INSERT INTO `tc-db-log`.logs (LOGTIME,FRAMETS,AREA,LOGDATA,EMPHINT,DEVHINT) VALUES (curtime(),0,0,UNHEX('FE060000020300000000" . bin2hex($result[1]) . "FFFF')," . $result[0] . ",23);";
                                mysqli_query($smysql, $sql_query2);
                            }

                            $this->logSock($json_class["user_" . $uids[$j]]["0"]["2"] . PHP_EOL);
                        }

                    }
                }
            }
        }
    }

    /**
     *  Проверка записан ли токен в файле
     */
    private
    function checkTokenExist(): bool
    {
        return !filesize(self::TOKEN_FILE);
    }

    private
    function checkSession(): bool
    {
        $ch3 = curl_init("https://new-pk.first-card.ru/pc");
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch3, CURLOPT_COOKIEFILE, self::COOKIE_JAR);
        curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
        preg_match("/(Войти)/", curl_exec($ch3), $matches);
        curl_close($ch3);
        return $matches;
    }

    /**
     * Получение токена форм с сайта
     */
    private
    function getToken(): string
    {
        $c = curl_init("https://new-pk.first-card.ru/");
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_COOKIEJAR, self::COOKIE_JAR);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        preg_match("/ue=\"(.*)\"/", curl_exec($c), $matches);
        curl_close($c);
        return $matches[1];
    }

    private function logSock(string $text)
    {
        $this->connection->send($text);
    }

}
