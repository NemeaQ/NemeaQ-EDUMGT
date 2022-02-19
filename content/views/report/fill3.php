<div class="box">
    <h1><?php echo $vars[0]["name"]; ?></h1>
    <form action="/report/save3/" id="report" method="post">
        <?php
        $table = json_decode($vars[0]["data"]);
        $object = '<table class="pure-table pure-table-horizontal">';
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


        $object .= '</table>';

        echo $object;
        ?>
    </form>
</div>


<?php
if (isset($vars[1])) {
    //print_r($vars[1]);
    foreach ($vars[1] as $val) {
        //print_r($val);
        $str = $val['data'];
        $obj = json_decode($str);
        $array = get_object_vars($obj);
        echo $array['B1'] . " - " . $array['B2'] . " тема для корректировки; Часов: " . $array['B3'] . "/" . $array['B4'] . "; Тема: " . $array['B5'] . "<br>";
    }
}


?>

<a class="btn btn-green" href="/report/list">Назад</a>
<button class="btn btn-blue" form="report" type="submit">Отправить</button>
