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
 * Class Report
 * @package application\models
 */
class Report extends Model
{
    /**
     * @var Db
     */
    public $db;

    /**
     * @return array
     */
    public function loadList()
    {
        $access = $this->db->query('SELECT accTests FROM sn_users WHERE id = :uId', ['uId' => $_SESSION['account']['id'],]);
        $list = $this->db->query('SELECT id,name,startDate,endDate FROM sn_report WHERE id IN (' . $access . ')');

        foreach ($list as $i => $value) {
            $id = $this->checkDraftExists($value['id']);
            if ($id) {
                $res = $this->db->row('SELECT lastDate,`lock`,arch FROM sn_drafts WHERE id=' . $id)[0];
                if ($res['lock'])
                    $list[$i]['status'] = 'Подтверждён';
                else {
                    if ($res['arch'])
                        $list[$i]['status'] = 'Принят';
                    else
                        $list[$i]['status'] = 'В заполнении';
                }
                $list[$i]['ldate'] = $res['lastDate'];
            } else {
                $list[$i]['status'] = 'Не заполнен';
            }
        }

        return $list;
    }

    /**
     * @return array
     */
    public function loadMyList()
    {
        $params = [
            'user' => $_SESSION['account']['id'],
        ];

        $list = $this->db->row('select sn_drafts.*,sn_report.name,sn_users.login from sn_report INNER JOIN sn_drafts ON sn_report.id=sn_drafts.fid JOIN sn_users ON sn_users.id=sn_drafts.uid where sn_report.author=:user AND sn_drafts.lock=1', $params);

        return $list;
    }

    /**
     * @return array
     */
    public function loadArchList()
    {
        $params = [
            'user' => $_SESSION['account']['id'],
        ];

        $list = $this->db->row('select sn_drafts.*,sn_report.name,sn_users.login,sn_users.sname,sn_users.fname from sn_report INNER JOIN sn_drafts ON sn_report.id=sn_drafts.fid JOIN sn_users ON sn_users.id=sn_drafts.uid where sn_report.author=:user AND sn_drafts.arch=1', $params);

        return $list;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function checkDraftExists($id)
    {
        $params = [
            'id' => $id,
            'user' => $_SESSION['account']['id'],
        ];
        return $this->db->column('SELECT id FROM sn_drafts WHERE fId = :id AND uId = :user', $params);
    }

    /**
     * @param $id
     * @param $key
     */
    public function saveDraft($id, $key)
    {
        $params = [
            'key' => $key,
            'date' => date("Y-m-d H:i:s"),
            'id' => $id,
        ];
        $this->db->query('UPDATE sn_drafts set `keys`=:key,lastDate=:date where id=:id', $params);
    }

    /**
     * @param $id
     * @param $key
     */
    public function createDraft($id, $key)
    {
        $params = [
            'id' => $id,
            'user' => $_SESSION['account']['id'],
            'key' => $key,
            'date' => date("Y-m-d H:i:s"),
        ];
        $this->db->query('INSERT sn_drafts (fId,uId,`keys`, lastDate) VALUES (:id,:user,:key,:date)', $params);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getDraft($id)
    {
        $params = [
            'id' => $id,
        ];

        return $this->db->column('SELECT `keys` FROM sn_drafts where id=:id', $params);
    }

    /**
     * @param $id
     * @return array
     */
    public function getDraftStatus($id)
    {
        $params = [
            'id' => $id,
        ];

        return $this->db->row('SELECT `lock`,arch FROM sn_drafts where id=:id', $params);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function lockDraft($id)
    {
        $params = [
            'id' => $id,
        ];

        return $this->db->column('UPDATE sn_drafts SET `lock`=TRUE WHERE id=:id', $params);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function unLockDraft($id)
    {
        $params = [
            'id' => $id,
        ];

        return $this->db->column('UPDATE sn_drafts SET `lock`=FALSE WHERE id=:id', $params);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function toArchiveDraft($id)
    {
        $params = [
            'id' => $id,
        ];

        return $this->db->column('UPDATE sn_drafts SET `arch`=TRUE WHERE id=:id', $params);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function unArchiveDraft($id)
    {
        $params = [
            'id' => $id,
        ];

        return $this->db->column('UPDATE sn_drafts SET `arch`=FALSE WHERE id=:id', $params);
    }

    /**
     * @param $id
     * @return array
     */
    public function loadForm($id)
    {
        $form = $this->db->row("SELECT name,author,tasks,checkSum FROM sn_report where id=" . $id);
        $tasks = null;
        $status = 'Не заполнен';

        foreach (explode("$", $form[0]["tasks"]) as $i => $value) {
            $task = [
                "text" => $value
            ];

            if ($value[0] === '{') {
                $var = $this->db->row("SELECT name FROM sn_" . explode("%", $value)[1]);
                $task["variants"] = $var;
            }

            $tasks[] = $task;
        }

        if ($this->checkDraftExists($id)) {
            $ke = explode("$$", $this->getDraft($this->checkDraftExists($id)));

            foreach ($ke as $i => $value) {
                $tasks[$i]["value"] = explode("&&", $value);
            }

            $res = $this->db->row('SELECT lastDate,`lock`,arch FROM sn_drafts WHERE id=' . $this->checkDraftExists($id))[0];
            if ($res['lock'])
                $status = 'Подтверждён';
            else {
                if ($res['arch'])
                    $status = 'Принят';
                else
                    $status = 'В заполнении';
            }

        } else {
            $tasks[0]["value"] = 5;
        }

        $summ = explode("|", $form[0]['checkSum']);
        $valSum = [];

        foreach ($summ as $i => $value) {
            $valSum[$i] = explode("&&", $value);
        }


        $vars = [
            'id' => $id,
            'name' => $form[0]['name'],
            'tasks' => $tasks,
            'author' => $form[0]['author'],
            'status' => $status,
            'value' => $valSum,
        ];

        return $vars;
    }


    /**
     * @param $id
     * @return array
     */
    public function loadForm2($id)
    {
        $rawClasses = $this->db->row("SELECT class, object FROM sn_teacherClasses where uID=" . $_SESSION['account']['id']);
        $tasks = null;
        $status = 'Не заполнен';

        $rawClassList = $this->db->row("SELECT * FROM sn_class");
        $classList = [];
        foreach ($rawClassList as $item) {
            $classList[$item['id']] = [$item['name'], $item['count']];
        }

        $rawObjectList = $this->db->row("SELECT * FROM sn_object");
        $objectList = [];
        foreach ($rawObjectList as $item) {
            $objectList[$item['id']] = $item['name'];
        }

        $params = [
            'fid' => $id,
            'uid' => $_SESSION['account']['id']
        ];
        $rawDraftsList = $this->db->row("SELECT * FROM sn_drafts2 WHERE fID=:fid AND uID=:uid", $params);
        $draftsList = [];
        foreach ($rawDraftsList as $item) {
            $draftsList[$item['object']][$item['class']] = $item;
        }

        $sortedClasses = [];

        foreach ($rawClasses as $index => $value) {
            $class = [];
            $class[] = $value['class'];
            $class[] = $classList[$value['class']][0];

            if (isset($draftsList[$value['object']][$value['class']]['quality'])) {
                $class[] = $draftsList[$value['object']][$value['class']]['ch'];
                $class[] = $draftsList[$value['object']][$value['class']]['quality'];
                $class[] = $draftsList[$value['object']][$value['class']]['progress'];
            } else {
                $class[] = $classList[$value['class']][1];
                $class[] = 0;
                $class[] = 0;
            }
            $sortedClasses[$objectList[$value['object']]][] = $class;
        }

        $classes = $sortedClasses;

        $vars = [
            'id' => $id,
            'name' => "Отчёт по предмету",
            'classes' => $classes,
            'status' => $status,
        ];

        return $vars;
    }

    public function loadForm3($id)
    {
        return $this->db->row("SELECT name,data FROM sn_forms where id=" . $id);
    }

    /**
     * @param $id
     * @param $fid
     * @return array
     */
    public function loadReport($id, $fid)
    {
        $form = $this->db->row("SELECT name,author,tasks FROM sn_report where id=" . $fid);
        $tasks = null;

        foreach (explode("$", $form[0]["tasks"]) as $i => $value) {
            $task = [
                "text" => $value
            ];

            if ($value[0] === '{') {
                $var = $this->db->row("SELECT name FROM sn_" . explode("%", $value)[1]);
                $task["variants"] = $var;
            }

            $tasks[] = $task;
        }

        $ke = explode("$$", $this->getDraft($id));

        foreach ($ke as $i => $value) {
            $tasks[$i]["value"] = explode("&&", $value);
        }

        $vars = [
            'id' => $id,
            'name' => $form[0]['name'],
            'tasks' => $tasks,
            'author' => $form[0]['author'],
            'status' => $this->getDraftStatus($id)[0],
        ];

        return $vars;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return 'text';
    }

}
