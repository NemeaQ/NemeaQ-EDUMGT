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

$db = new \application\lib\Db();

$childs = $db->row('SELECT id,sname,fname FROM sn_users JOIN sn_childs on id=uID WHERE class=' . $_SESSION['account']['curators']['class'] . ' ORDER BY sname');

//debug($childs);

?>

<div class="box">
    <h1><?php echo $vars[0]["name"]; ?></h1>
    <h5>Ставим галочку, если ребёнок отсутсвовал на занятиях</h5>
    <form action="/report/save4/" id="report" method="post">
        <?php
        $table = json_decode($vars[0]["data"]);
        $object = '<table class="pure-table">';
        foreach ($table as $row => $columns) {
            $object .= '<tr>';
            foreach ($columns as $column => $value) {
                if ($value[0]) {
                    $object .= '<td';
                    if ($value[2]) {
                        foreach (array_slice($value, 1) as $param => $v) {
                            switch ($v) {
                                case 'h':
                                    $object .= ' bgcolor="#6495ed"';
                                    break;
                                case 'cs2':
                                    $object .= ' colspan=2';
                                    break;
                                case 'cs3':
                                    $object .= ' colspan=3';
                                    break;
                                case 'cs4':
                                    $object .= ' colspan=4';
                                    break;
                                case 'rs2':
                                    $object .= ' rowspan=2';
                                    break;
                                default:
                                    break;
                            }
                        }
                    }
                    $object .= '>' . $value[1] . '</td>';
                } else {
                    $input = '<input type="text" name="' . $column . $row . '">';
                    switch ($value[1]) {
                        case 'num':
                            $input = '<input type="number" name="' . $column . $row . '">';
                            break;
                        case 'rtb':
                            $input = '<textarea name="' . $column . $row . '"></textarea>';
                            break;
                    }
                    $object .= '<td>' . $input . '</td>';
                }
            }
            $object .= '</tr>';
        }


        $table = json_decode(json_encode($table), true);

        $dates = array_slice($table[1], 1);

        $index = 1;
        foreach ($childs as $child => $value) {
            $object .= '<tr>';
            $object .= '<td>' . $index . ". " . $value['sname'] . ' ' . $value['fname'] . '</td>';
            foreach ($dates as $date) {
                $input = '<input type="checkbox" name="' . $value['id'] . '_' . str_replace(".", "_", $date[1]) . '">';
                $object .= '<td>' . $input . '</td>';
            }

            $index++;
            $object .= '</tr>';
        }
        $object .= '</table>';
        echo $object;
        ?>
    </form>
</div>

<script>

    <?php
    if (isset($vars[1])) {

        $str = $vars[1][0]['data'];
        $obj = json_decode($str);
        $array = get_object_vars($obj);

        foreach ($array as $item => $val) {

            echo 'document.getElementsByName("' . $item . '")[0].checked = true;';

        }
    }
    ?>

</script>

<a class="btn btn-green" href="/report/list">Назад</a>
<button class="btn btn-blue" form="report" type="submit">Сохранить</button>
